<div>
    <div class="grid grid-cols-2">
        <div>
            @empty(!$owner)
            <div class="flex items-center gap-4 mb-4">
                <div class="relative inline-flex items-center justify-center w-10 h-10 overflow-hidden bg-yellow-100 rounded-full dark:bg-gray-600">
                    <span class="font-bold text-gray-600 dark:text-gray-300">{{$owner->initials}}</span>
                </div>
                <div class="font-medium dark:text-white">
                    <div>{{$owner->name}}</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">Owner</div>
                </div>
            </div>
            @endempty

            @empty(!$owner)
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
                        <div class="text-sm text-gray-500 dark:text-gray-400">editor</div>
                    </div>
                </div>
                @endforeach
            @endempty
        </div>


        <div>
            <x-input
                class="mb-2"
                label="Find users to add"
                placeholder="E-mail"
                wire:model.live="emailToFind"
                wire:keyup="find"
            />

            @foreach($users as $user)
            <div class="flex items-center gap-4 mb-4">
                <div class="relative inline-flex items-center justify-center w-10 h-10 overflow-hidden bg-blue-100 rounded-full dark:bg-gray-600">
                    <span class="font-bold text-gray-600 dark:text-gray-300">{{$user->initials}}</span>
                </div>
                <div class="font-medium dark:text-white">
                    <div>
                        <span class="inline-block text-bold mr-5 ">{{$user->name}}</span> 
                        <span class="text-sm text-red-500 cursor-pointer" wire:click="store({{$user->id}})"> add to workspace</span>
                    </div> 
                    <div class="text-sm text-gray-500 dark:text-gray-400">{{$user->email}}</div>
                </div>
            </div>
            @endforeach
        </div>

    </div>

</div>
