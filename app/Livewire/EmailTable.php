<?php

namespace App\Livewire;

use App\Models\Email;
use App\Models\Workspace;
use Livewire\Attributes\On;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

final class EmailTable extends PowerGridComponent
{
    use WithExport;

    public string $tableName = 'EmailTable';
    public string $sortField = 'id'; 
    public string $sortDirection = 'desc';
    public $workspaceIds = null;

    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    #[On('workspace-selected')]
    public function selectWorkspace($id = null){
        $this->workspaceIds = $id;
    }

    public function datasource(): Builder
    {
        $query = Email::query()
            ->join('workspaces', function ($workspace) {
                $workspace->on('emails.workspace_id', '=', 'workspaces.id');
            })
            ->join('users as creator', function ($users) {
                $users->on('emails.created_by', '=', 'creator.id');
            })
            ->join('users as updater', function ($users) {
                $users->on('emails.last_updated_by', '=', 'updater.id');
            })
            ->select([
                'emails.id',
                'emails.name',
                'emails.created_at',
                'creator.name as user_creator',
                'updater.name as user_updater',
                'workspaces.name as workspaces_name',
                'workspaces.id as w_id',
            ]);

        if($this->workspaceIds){
            $ids = [$this->workspaceIds];
        }else{
            $ids = $this->getUserWorkspacesIds();
        }

        $query->whereIn('workspaces.id' , $ids );
        
        return $query;
    }

    private function getUserWorkspacesIds()
    {
            $userid = auth()->id();
            // workspaces que sou dono
            $workspaces = Workspace::where('user_id', $userid)->get();
            $workspacesIds = $workspaces->pluck('id');

            // workspaces que participo
            $workspacesMember = DB::table('user_workspace')
                ->where('user_id', '=', $userid)
                ->get();
            
            $workspacesMemberIds = $workspacesMember->pluck('workspace_id');

            return  array_merge($workspacesIds->all(),$workspacesMemberIds->all() );        
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function columns(): array
    {
        return [
            Column::make('E-mail name', 'name'),
            Column::make('Workspace', 'workspaces_name')->sortable(),
            Column::make('Created by', 'user_creator')->sortable(),
            Column::make('Upadated by', 'user_updater')->sortable(),
            Column::make('Created at', 'created_at')->sortable()->searchable(),
            Column::action('Action')
        ];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
        ->add('name', function ($email) {
            return '<a href="'.route('email.edit', $email->id).'" target="_blank" class="text-primary-600 text-bold">'.$email->name.'</a>';
        })
        ->add('Workspace')
        ->add('Created by')
        ->add('Upadated by')
        ->add('Created by');

    }

    public function filters(): array
    {
        return [
        ];
    }

    public function actions(Email $row): array
    {
        return [
            Button::add('edit')
                ->slot('Edit')
                ->id()
                ->class('text-primary-500')
                ->dispatch('email-edit', ['rowId' => $row->id])
        ];
    }

    /*
    public function actionRules($row): array
    {
       return [
            // Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($row) => $row->id === 1)
                ->hide(),
        ];
    }
    */
}
