<ul>    
    @if($workspaces)
        <li 
            class="hover:text-blue-700 @if($workspaceId == null) text-blue-700  @endif text-sm font-bold leading-relaxed pl-3 cursor-pointer" 
            onclick="window.Livewire.dispatch('workspace-selected', { id: null } )" > 
            All workspaces
        </li>

        @foreach($workspaces as $workspace)
        <li 
            class="
            flex justify-between gap-2
            hover:text-blue-700 @if($workspaceId == $workspace->id) text-blue-700 font-bold  @endif text-sm leading-relaxed pl-3 cursor-pointer" 
            wire:key="{{$workspace->id}}"> 
            <span onclick="window.Livewire.dispatch('workspace-selected', { id: {{ $workspace->id }} } )">{{$workspace->name}}</span> 
            <span 
                onclick="editWorkspace({{ $workspace->id }} )"
                class="text-blue-500 text-sm inline-block cursor-pointer"
            >
            edit
        </span>
        </li>
        @endforeach
    @else
        <li class="hover:text-blue-700 text-sm leading-relaxed pl-3 cursor-pointer" >
            no workspaces found
        </li>
    @endif
</ul>
