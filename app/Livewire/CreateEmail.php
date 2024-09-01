<?php

namespace App\Livewire;

use Livewire\Attributes\Validate;
use Livewire\Attributes\On; 
use Livewire\Component;
use App\Models\Email;
use App\Models\Workspace;
use WireUi\Traits\WireUiActions;

class CreateEmail extends Component
{

    use WireUiActions;

    #[Validate('required')]
    public $name = '';

    #[Validate('required')]
    public $workspace_id = '';

    public $workspaces = [];
    
    #[On('workspace-created')]
    public function render()
    {
        $this->getData();
        return view('livewire.create-email');
    }

    public function getData()
    {
        $user = auth()->user();
        $this->workspaces = Workspace::where('user_id', $user->id)->get();
    }

    public function save()
    {
        $this->validate();
        $user = auth()->user();
        Email::create([
            'name' => $this->name,
            'created_by' => $user->id,
            'last_updated_by' => $user->id,
            'workspace_id' => $this->workspace_id,
        ]);

        $this->name = '';
        $this->workspace_id = '';

        $this->dispatch('email-created'); 
    }

    #[On('email-delete')]
    public function destroy($id)
    {
        
        $email = Email::find($id);

        if(!$email){
            $this->notification()->send([
                'icon' => 'error',
                'title' => 'E-mail not found',
            ]);
            return false;
        }

        $workspace = Workspace::find($email->workspace_id);
        
        if(!$workspace){
            $this->notification()->send([
                'icon' => 'error',
                'title' => 'Workspace not found!',
                'description' => 'Workspace not found! ' . $email->workspace_id ,
            ]);
            return false;
        }

        // // verifica se o usuário pertence
        $userInWorkspace =  $workspace->users()->where('user_id', auth()->user()->id )->first();

        // não estiver como admin
        if( !$userInWorkspace || !auth()->user()->id ){

            $this->notification()->send([
                'icon' => 'error',
                'title' => 'Can not remove ',
                'description' => 'You are not a member',
            ]);

            return  false;
        }

        // // verifica se o usuário é admin
        if( $userInWorkspace->pivot->role != 'WS:ADMIN' ){

            $this->notification()->send([
                'icon' => 'error',
                'title' => 'Can not remove!',
                'description' => 'Only workspace admins can remove',
            ]);

            return '';
        }
        $email = $email->delete();
        $this->dispatch('email-deleted');
    }

}
