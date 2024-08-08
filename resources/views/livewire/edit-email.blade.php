<div>
    <form wire:submit="save">

        <div class="grid grid-cols-1">
            <div class="mb-3">
                <x-input label="Email name" placeholder="name" wire:model="name"/>
            </div>
            <div class="mb-3">
                <x-native-select
                    label="workspace"
                    placeholder="Select one status"
                    wire:model="workspace_id"
                >
                        <option value="" > </option>
                        @foreach($workspaces as $workspace)
                            <option value="{{$workspace->id}}" wire:key="{{$workspace->id}}"> {{$workspace->name}}</option>
                        @endforeach
                </x-native-select>
                <div>
                    @error('workspace_id') <span class="text-sm text-negative-600 mt-2">{{ $message }}</span> @enderror 
                </div>
            </div>
        </div>
        <div class="flex justify-end">
            <x-button type="submit" wire:loading.remove outline primary label="update" />
            <x-button type="button" label="Loading..." wire:loading />
        </div>

    </form>
</div>
