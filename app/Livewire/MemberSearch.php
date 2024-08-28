<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Workspace;
use App\Models\User;

class MemberSearch extends Component
{
    public $workspaceId = '';
    public $users = [];
    public $emailToFind;
    public $notFound = false;

    public function render()
    {
        return view('livewire.member-search');
    }

    #[On('workspace-manage-members')] // quando seleciona o workspace para editar
    public function list($id){
        $this->workspaceId = $id;
    }

    #[On('user-added-to-workspace')] // quando seleciona o workspace para editar
    public function cleanData(){
        $this->users = [];
    }

    public function find()
    {
        $this->notFound = false;
        if(empty( $this->emailToFind) || empty($this->workspaceId) ){
            return false;
        }

        $workspace = Workspace::find($this->workspaceId);

        if( !$workspace ){
            return false;
        }

        $pluck = $workspace->users()->get()->pluck('id');

        $users = User::where('email', 'like', $this->emailToFind.'%')
                ->whereNotIn ('id', $pluck->all())
               ->orderBy('name')
               ->take(10)
               ->get();

        $users->map(function($member) {
            $member->initials = $this->getInitials($member);
        });
        $this->users = $users;

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
