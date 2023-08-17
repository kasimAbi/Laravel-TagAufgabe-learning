<div>
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
                            <x-table.cell wire:click="addUserToTag('{{ $tag->id }}')">{{ $tag->name }}</x-table.cell>
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
        <x-modal.dialog wire:model.defer="showAddUserModal" class="h-full">
            <x-slot name="title">Einen User dem Tag hinzufügen</x-slot>

            <x-slot name="content">
                <select wire:model="selectedUserId" wire:change="updateSelectedUser()">
                    <option value="">User wählen</option>
                    @foreach ($this->users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </x-slot>

            <x-slot name="footer">
                <x-button wire:click="cancel()" class="bg-blue-500 hover:bg-blue-600">Zurück</x-button>
                <x-button wire:click="confirmAddUser()">Hinzufügen</x-button>
            </x-slot>
        </x-modal.dialog>
    </div>
</div>
