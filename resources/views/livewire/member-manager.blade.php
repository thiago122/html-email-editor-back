<div>
    <div class="grid grid-cols-2 gap-5">
        <div>
            @empty(!$owner)
            <div class="flex items-center gap-4 mb-4">
                <div class="relative inline-flex items-center justify-center w-10 h-10 overflow-hidden bg-yellow-100 rounded-full dark:bg-gray-600">
                    <span class="font-bold text-gray-600 dark:text-gray-300">{{$owner->initials}}</span>
                </div>
                <div class="font-medium dark:text-white">
                    <div>{{$owner->name}}</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">Creator</div>
                </div>
            </div>
            @endempty

            <hr class="py-3" >

            @empty(!$members)
                @foreach($members as $member)
                <div class="flex items-center gap-4 mb-4">
                    <div class="relative inline-flex items-center justify-center w-10 h-10 overflow-hidden bg-blue-100 rounded-full dark:bg-gray-600">
                        <span class="font-medium text-gray-600 dark:text-gray-300">{{$member->initials}}</span>
                    </div>
                    <div class="font-medium dark:text-white">
                        <div>
                            <span class="inline-block text-bold mr-5 ">{{$member->name}}</span>
                            <span class="text-sm text-red-500 cursor-pointer" wire:click="destroy({{$member->id}})" wire:confirm="Are you sure you want to delete?"> delete</span>
                        </div> 
                        <div class="text-sm text-gray-500 dark:text-gray-400"></div>
                    </div>
                </div>
                @endforeach
            @endempty
        </div>
    
        <livewire:member-search></livewire:member-search>
    </div>

</div>
