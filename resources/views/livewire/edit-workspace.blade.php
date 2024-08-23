<div>
    <form wire:submit="save">
        <x-input
            class="mb-2"
            label="Workspace name"
            placeholder="name"
            corner="Ex: My client"
            wire:model="name"
        />

        <div class="flex justify-end">
            <x-button type="submit" wire:loading.remove outline primary label="Save" />
            <x-button type="button" label="Loading..." wire:loading />                
        </div>

    </form>
</div>
