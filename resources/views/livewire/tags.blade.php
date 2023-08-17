<x-app-layout>
    <div style="padding: 50px;" class="w-full">
        <div class="py-4 space-y-5">
            <x-table>
                <x-slot name="head">
                    <x-table.heading sortable>Tag_ID</x-table.heading>
                    <x-table.heading sortable>Taggable_ID</x-table.heading>
                </x-slot>

                <x-slot name="body">
                    @foreach($tags as $tag)
                        <x-table.row  wire:loading.class="opacity-50">
                            <x-table.cell wire:click="addUserToTag('{{ $tag->name }}')">{{ $tag->name }}</x-table.cell>
                            <x-table.cell>
                                @if(isset($tag->users))
                                    {{ Illuminate\Support\Arr::join($tag->users->pluck("name")->toArray(), ', ') }}
                                @endif
                            </x-table.cell>
                        </x-table.row>
                    @endforeach
                </x-slot>
            </x-table>

            {{ $tags->Links() }}
        </div>

        <!-- Dialogfenster öffnet: modal/dialog -> modal. .defer sorgt für weniger Abfragen. -->
        <x-modal.dialog wire:model.defer="showAddUserModal">
            <x-slot name="title">Einen User dem Tag hinzufügen</x-slot>

            <x-slot name="content">
                <x-dropdown>
                    <x-slot name="trigger">
                        <button class="right-0 border-gray-200 border-2 p-2">{{ $selectedUser->name ?? "Select a User" }}</button>
                    </x-slot>

                    <x-slot name="content">
                        <ul class="scroll-auto scroll-m-0">
                            @foreach ($this->users as $user)
                                <li><button wire:click="updateSelectedUser('{{ $user->name }}')">{{ $user->name }}</button></li>
                            @endforeach
                        </ul>
                    </x-slot>
                </x-dropdown>
            </x-slot>

            <x-slot name="footer">
                <x-button class="bg-blue-500 hover:bg-blue-600">Zurück</x-button>
                <x-button wire:click="confirmAddUser()">Hinzufügen</x-button>
            </x-slot>
        </x-modal.dialog>
    </div>
</x-app-layout>
