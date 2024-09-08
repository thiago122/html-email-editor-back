<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Workspace;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use WireUi\Traits\WireUiActions;

class EditWorkspace extends Component
{

    use WireUiActions; 

    #[Validate('required')]
    public string $name = 'lalala';
    public string $id = '';

    public function render()
    {
        return view('livewire.edit-workspace');
    }

    #[On('workspace-edit')]
    public function edit($id)
    {

        $workspace = Workspace::find($id);

        // // verifica se o usuário pertence
        $userInWorkspace =  $workspace->users()->where('user_id', auth()->user()->id )->first();

        // não estiver no workspace
        if( !$userInWorkspace || !auth()->user()->id ){

            $this->notification()->send([
                'icon' => 'error',
                'title' => 'Can not edit ',
                'description' => 'You are not a member',
            ]);

            return  false;
        }

        // // verifica se o usuário é admin
        if( $userInWorkspace->pivot->role != 'WS:ADMIN' ){

            $this->notification()->send([
                'icon' => 'error',
                'title' => 'Can not edit!',
                'description' => 'Only workspace admins can edit',
            ]);

            return false;
        }

        $this->name = $workspace->name;
        $this->id = $workspace->id;
    }

    public function save()
    {

        $this->validate();
        $workspace = Workspace::find($this->id);

        // verifica se o usuário pode adicionar membros neste workspace
        $userInWorkspace =  $workspace->users()->where('user_id', auth()->user()->id )->first();

        // estive como admin
        if( !$userInWorkspace || $userInWorkspace->pivot->role !== 'WS:ADMIN' ){

            $this->notification()->send([
                'icon' => 'error',
                'title' => 'Can not edit!',
                'description' => 'Only workspace admins can edit',
            ]);

            return  false;
        }


        $workspace->update([
                        'name' => $this->name
                    ]);

        $this->dispatch('workspace-updated');
    }

}
