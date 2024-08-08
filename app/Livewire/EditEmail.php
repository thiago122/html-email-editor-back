<?php

namespace App\Livewire;

use Livewire\Attributes\Validate;
use Livewire\Attributes\On; 
use Livewire\Component;
use App\Models\Email;
use App\Models\Workspace;

class EditEmail extends Component
{
    #[Validate('required')]
    public $id_ = '';

    #[Validate('required')]
    public $name = '';

    #[Validate('required')]
    public $workspace_id = '';

    public $workspaces = [];
    
    
    public function render()
    {
        $this->getWorkspaces();
        return view('livewire.edit-email');
    }
    
    #[On('workspace-created')]
    public function getWorkspaces()
    {
        $user = auth()->user();
        $this->workspaces = Workspace::where('user_id', $user->id)->get();
    }

    #[\Livewire\Attributes\On('email-edit')]
    public function edit($rowId): void
    {
        $email = Email::find($rowId);
        $this->id_ = $email->id;
        $this->name = $email->name;
        $this->workspace_id = $email->workspace_id;
        // $this->js('alert('.$rowId.')');
    }

    public function save()
    {

        $this->validate();
        $user = auth()->user();

        Email::where('id', $this->id_)
            ->update([
                'name' => $this->name,
                'last_updated_by' => $user->id,
                'workspace_id' => $this->workspace_id,
            ]);

        $this->id_ = '';
        $this->name = '';
        $this->workspace_id = '';

        $this->dispatch('email-updated');

    }

}
