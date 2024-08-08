<?php

namespace App\Livewire;

use Livewire\Attributes\Validate;
use Livewire\Attributes\On; 
use Livewire\Component;
use App\Models\Email;
use App\Models\Workspace;

class CreateEmail extends Component
{
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

}
