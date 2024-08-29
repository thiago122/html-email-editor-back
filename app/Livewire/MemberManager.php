<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use App\Models\Workspace;
use Livewire\Attributes\On;

use WireUi\Traits\WireUiActions;

class MemberManager extends Component
{
    public $owner = '';
    public $members = [];
    public $workspace = '';
    public $users = [];
    public $emailToFind;
    public $date;
    public $teste;

    use WireUiActions;

    public function render()
    {
        return view('livewire.member-manager');
    }
    
    #[On('add-user-to-workspace')] // quando seleciona o usuário para adicionar no workspace
    public function store($id)
    {

        // verifica se o usuário pode adicionar membros neste workspace
        $userInWorkspace =  $this->workspace->users()->where('user_id', auth()->user()->id )->first();

        // se ele for criador ou estive como dono
        if( !$userInWorkspace || $userInWorkspace->pivot->role !== 'WS:ADMIN' ){

            $this->notification()->send([
                'icon' => 'error',
                'title' => 'Can not add member!',
                'description' => 'Only workspace admins can add other members',
            ]);

            return '';
        }

        $this->workspace->users()->attach($id, ['role'=>'EDITOR']);
        $this->list($this->workspace->id);
        $this->dispatch('user-added-to-workspace'); 
    }

    public function destroy($idUser )
    {

        // verifica se o usuário pode adicionar membros neste workspace
        $userInWorkspace =  $this->workspace->users()->where('user_id', auth()->user()->id )->first();

        // dd($userInWorkspace->pivot->role);

        // estive como admin
        if( !$userInWorkspace || $userInWorkspace->pivot->role !== 'WS:ADMIN' ){

            $this->notification()->send([
                'icon' => 'error',
                'title' => 'Can not remove member!',
                'description' => 'Only workspace admins can add other members',
            ]);

            return  false;
        }

        // verifica se o usuário pode adicionar membros neste workspace
        $user =  $this->workspace->users()->where('user_id', $idUser )->first();

        if( $user->pivot->role == 'WS:ADMIN' ){

            $this->notification()->send([
                'icon' => 'error',
                'title' => 'Can not remove member!',
                'description' => 'Workspace admins can not be removed',
            ]);

            return '';
        }

        $this->workspace->users()->detach($idUser);
        $this->list($this->workspace->id);
    }

    #[On('workspace-manage-members')]
    public function list($id)
    {
        $this->workspace = '';
        $this->members = [];
        $this->workspace = Workspace::find($id);

        $this->owner = User::find($this->workspace->user_id);
        $this->owner->initials = $this->getInitials($this->owner);
        
        $members = $this->workspace->users()->get();

        if(empty($members)){
            return false;
        }

        $members->map(function($member) {
            $member->initials = $this->getInitials($member);
        });

        $this->date = date('Y-m-d H:i:s');
        $this->members = $members;

    }

    private function getInitials($member){
        $initials = '';
        $names = explode(' ', $member->name);
        $initials .= substr($names[0], 0, 1);
        if(isset($names[1])){
            $initials .= substr($names[1], 0, 1);
        }
        return $initials;
    }

}
