<?php

namespace App\Livewire;

use Livewire\Attributes\Validate; 
use Livewire\Component;
use App\Models\Workspace;

class CreateWorkspace extends Component
{


    #[Validate('required|min:2|max:80')]
    public $name = '';

    public function render()
    {
        return view('livewire.create-workspace');
    }

    public function save()
    {
        $this->validate();
        $user = auth()->user();

        $workspace = Workspace::create([
            'name'    => $this->name,
            'user_id' => $user->id
        ]);

        $workspace->users()->attach(auth()->id(),['role'=>'WS:ADMIN']);

        $this->name = '';

        $this->dispatch('workspace-created'); 
    }
}
