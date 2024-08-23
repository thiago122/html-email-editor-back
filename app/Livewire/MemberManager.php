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

    public function render()
    {
        return view('livewire.member-manager');
    }

    public function find()
    {
        if(empty( $this->emailToFind)){
            return false;
        }

        $users = User::where('email', 'like', $this->emailToFind.'%')
                ->where('id', '!=', auth()->id())
               ->orderBy('name')
               ->take(10)
               ->get();

        if(empty($users)){
            return false;
        }

        $users->map(function($member) {
            $member->initials = $this->getInitials($member);
        });
        $this->users = $users;
    }

    public function store($idUser )
    {

        DB::table('workspace_user')->insert([
            'user_id' => $idUser,
            'workspace_id' => $this->workspace->id
        ]);

        $this->list($this->workspace->id);
        $this->users = [];
        $this->emailToFind = '';
    }

    public function destroy($idUser )
    {

        $deleted = DB::table('workspace_user')
            ->where('user_id', '=', $idUser)
            ->where('workspace_id', '=', $this->workspace->id)
            ->delete();

        $this->list($this->workspace->id);
        $this->users = [];
        $this->emailToFind = '';
    }

    #[On('workspace-manage-members')]
    public function list($id)
    {
        $this->workspace = '';
        $this->members = [];
        $this->users = [];
        $this->emailToFind = '';

        $this->workspace = Workspace::find($id);
        $this->owner = User::find($this->workspace->user_id);
        $this->owner->initials = $this->getInitials($this->owner);
        
        $members = User::query()
                ->select([
                    'users.id',
                    'users.name',
                    'users.email',
                ])  
                ->join('workspace_user', function ($workspace) {
                    $workspace->on('workspace_user.user_id', '=', 'users.id');
                })
                ->where('workspace_user.workspace_id', '=', $id)->get();

        if(empty($members)){
            return false;
        }

        $members->map(function($member) {
            $member->initials = $this->getInitials($member);
        });

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
