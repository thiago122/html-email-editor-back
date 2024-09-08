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
use WireUi\Traits\WireUiActions;

final class EmailTable extends PowerGridComponent
{
    use WithExport;
    use WireUiActions;

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

        $userWrokspacesId = $this->getUserWorkspacesIds();

        if(!empty($this->workspaceIds) && !in_array($this->workspaceIds, $userWrokspacesId)){
            $this->notification()->send([
                'icon' => 'error',
                'title' => 'Can not list workspace!',
                'description' => 'You are not a member',
            ]);
            return $query = Email::query()->where('emails.id',0000);
        }

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
            $ids = $userWrokspacesId;
        }

        $query->whereIn('workspaces.id' , $ids );
        
        return $query;
    }

    private function getUserWorkspacesIds()
    {
            $user = auth()->user();
            $workspaces = $user->workspaces()->where('user_workspace.user_id', $user->id )->get();
            $workspacesIds = $workspaces->pluck('id');

            return  array_merge($workspacesIds->all() );        
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
            // Column::make('Created at', 'created_at')->sortable()->searchable(),
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

        $editIcon = '
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
            </svg>
        ';

        $deleteIcon = '
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
            </svg>
        ';

        return [
            Button::add('edit')
                ->slot($editIcon)
                ->id()
                ->class('text-primary-500')
                ->dispatch('email-edit', ['rowId' => $row->id]),
            Button::add('delete')
                ->slot($deleteIcon)
                ->id()
                ->class('text-red-500')
                ->dispatch('email-delete', ['id' => $row->id])
                ->confirm('confirm delete?')
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
