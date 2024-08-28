<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use App\Models\Workspace;
use Livewire\Attributes\On;

use function PHPSTORM_META\map;
use Illuminate\Support\Facades\DB;

class MemberManager extends Component
{
    public $owner = '';
    public $members = [];
    public $workspace = '';
    public $users = [];
    public $emailToFind;
    public $date;

    public function render()
    {
        return view('livewire.member-manager');
    }
    
    #[On('add-user-to-workspace')] // quando seleciona o usuário para adicionar no workspace
    public function store($id)
    {
        $this->workspace->users()->attach($id);
        $this->list($this->workspace->id);
        $this->dispatch('user-added-to-workspace'); 
    }

    public function destroy($idUser )
    {
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
