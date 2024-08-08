<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }} {{ auth()->check() }}
        </h2>
    </x-slot>
 
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-wrap items-center justify-end gap-4 mb-4">
                <x-button flat info label="Workspaces" />
                <x-button info label="Create new" right-icon="plus" onclick="$openModal('create-email-modal')"/>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg mb-5">
                <div class="p-4 text-gray-900 dark:text-gray-100">
                    <livewire:email-table></livewire:email-table>
                </div>
            </div>
        </div>
    </div>

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

    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('email-created', (event) => {

                // close modal
                $closeModal('create-email-modal');

                // send notification
                $wireui.notify({
                    icon: 'success',
                    title: 'E-mail created!',
                    description: 'The list wil be reloaded',
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

            Livewire.on('email-edit', (event) => {
                // open modal
                $openModal('edit-email-modal');
            });
            
        })
    </script>


</x-app-layout>
