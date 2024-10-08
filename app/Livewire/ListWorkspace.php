<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Workspace;
use Livewire\Attributes\On;

class ListWorkspace extends Component
{
    public $workspaces = [];
    public $workspaceId = null;
    
    #[On('workspace-created')]
    #[On('workspace-updated')]
    public function render()
    {
        $user = auth()->user();
        $this->workspaces = $user->workspaces()->where('user_workspace.user_id', $user->id )->get();
        
        return view('livewire.list-workspace');
    }

    #[On('workspace-selected')]
    public function selectWorkspace($id = null){
        $this->workspaceId = $id;
    }

}
