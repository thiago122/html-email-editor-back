<x-app-layout>

    <x-slot name="header">
        <h2 class="flex justify-between font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <!-- {{ __('Dashboard') }} {{ auth()->check() }} -->
            <x-button info label="New E-mail" right-icon="plus" onclick="$openModal('create-email-modal')"/>
        </h2>
    </x-slot>

    <div class="flex px-4 sm:px-6 lg:px-8">
        <aside class="grow-0 basis-64 flex-shrink-0 ">
            <div class="py-12">
                <div class="flex justify-between bg-white px-3 py-2 mb-3 rounded-md border border-gray-200 font-semibold text-sm text-gray-800 leading-tight" >
                    Workspaces
                    <span 
                        onclick="$openModal('create-workspaces-modal')"
                        class="bg-slate-100 hover:bg-slate-200 rounded-md inline-block px-2 cursor-pointer">
                        new
                    </span>
                </div>
                <livewire:list-workspace></livewire:list-workspace>
            </div>
        </aside>
        <main class="grow ">
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg mb-5">
                        <div class="p-4 text-gray-900 dark:text-gray-100">
                            <livewire:email-table></livewire:email-table>
                        </div>
                    </div>
                </div>
            </div>
        </main> 
    </div><!-- /layout side -->
    
   <!-- modal update e-mail -->
   <x-modal name="edit-email-modal">
        <div class="min-w-full" x-data="{ open: false }">
            <x-card title="Edit e-mail">
                <livewire:edit-email></livewire:edit-email>
                <x-button  @click="open = !open" flat label="Create workspace" />
                <div class="border-t border-gray-200 pt-4 mt-4" x-show="open">
                    <livewire:create-workspace></livewire:create-workspace>
                </div>
            </x-card>
        </div>
    </x-modal>

   <!-- modal criar e-mail -->
    <x-modal name="create-email-modal">
        <div class="min-w-full" x-data="{ open: false }">
            <x-card title="Create new e-mail">
                <livewire:create-email></livewire:create-email>
                <x-button  @click="open = !open" flat label="Create workspace" />
                <div class="border-t border-gray-200 pt-4 mt-4" x-show="open">
                    <livewire:create-workspace></livewire:create-workspace>
                </div>
            </x-card>
        </div>
    </x-modal>

    <x-modal name="create-workspaces-modal" width="sm:max-w-5xl">
        <div class="min-w-full" x-data="{ open: false }">
            <x-card title="Workspaces">
                <livewire:create-workspace></livewire:create-workspace>
            </x-card>
        </div>
    </x-modal>

    <x-modal name="manage-workspaces-modal" width="sm:max-w-5xl">
        <div class="min-w-full" x-data="{ open: false }">
            <x-card title="Manage workspace">
               
                <livewire:edit-workspace></livewire:edit-workspace>
                
                <h3 class="font-bold">Members</h3>
                <hr class="my-3">

                <livewire:member-manager></livewire:member-manager>

            </x-card>
        </div>
    </x-modal>

    <script>
        document.addEventListener('livewire:initialized', () => {

            Livewire.on('email-deleted', (event) => {

                // send notification
                $wireui.notify({
                    icon: 'success',
                    title: 'E-mail deleted!',
                    description: 'The list will be reloaded',
                })

                Livewire.dispatch('pg:eventRefresh-EmailTable');

            });

            Livewire.on('email-created', (event) => {

                // close modal
                $closeModal('create-email-modal');

                // send notification
                $wireui.notify({
                    icon: 'success',
                    title: 'E-mail created!',
                    description: 'The list will be reloaded',
                })

                Livewire.dispatch('pg:eventRefresh-EmailTable');

            });

            Livewire.on('email-updated', (event) => {

                // close modal
                $closeModal('edit-email-modal');

                // send notification
                $wireui.notify({
                    icon: 'success',
                    title: 'E-mail updated!',
                    description: 'The list wil be reloaded',
                })

                Livewire.dispatch('pg:eventRefresh-EmailTable');

            });

            Livewire.on('workspace-created', (event) => {
                // close modal
                $closeModal('create-workspaces-modal');
            });

            Livewire.on('workspace-edit', (event) => {
                
            });

            Livewire.on('email-edit', (event) => {
                // open modal
                $openModal('edit-email-modal');
            });

            
        })

        function editWorkspace(id){
            console.log(id)
            window.Livewire.dispatch('workspace-edit', { id: id } )
            window.Livewire.dispatch('workspace-manage-members', { id: id } )
            // open modal
            $openModal('manage-workspaces-modal');
        }
    </script>


</x-app-layout>
