<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Workspace;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;

class EditWorkspace extends Component
{
    #[Validate('required')]
    public string $name = 'lalala';

    public string $id = '';

    public function render()
    {
        return view('livewire.edit-workspace');
    }

    #[On('workspace-edit')]
    public function edit($id): void
    {
        $workspace = Workspace::find($id);
        $this->name = $workspace->name;
        $this->id = $workspace->id;
    }

    public function save(): void
    {
        $this->validate();
        $workspace = Workspace::find($this->id)            
                    ->update([
                        'name' => $this->name
                    ]);

        $this->dispatch('workspace-updated');
    }

}
