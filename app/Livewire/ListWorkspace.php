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
    public function render()
    {
        $user = auth()->user();
        $this->workspaces = Workspace::where('user_id', $user->id)->get();
        return view('livewire.list-workspace');
    }

    #[On('workspace-selected')]
    public function selectWorkspace($id = null){
        $this->workspaceId = $id;
    }

}
