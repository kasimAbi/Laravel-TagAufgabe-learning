<div>
    <div style="padding: 50px;" class="w-full">
        <!-- Wenn etwas erfolgreich hinzugefügt wurde, wird die Nachricht mit dem Key "success" angezeigt -->
        @if(isset($message["success"]))
            <div class="alert alert-success pb-10">
                {{ $message["success"] }}
            </div>
        @endif

        <div class="py-4 space-y-5">
            <x-table>
                <x-slot name="head">
                    <x-table.heading sortable>Tag_ID</x-table.heading>
                    <x-table.heading sortable>Taggable_ID</x-table.heading>
                    <x-table.heading><button wire:click="addTag()" class="text-lg">+</button></x-table.heading>
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
                            <x-table.cell></x-table.cell>
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
                <select wire:model="selectedUserId">
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

        <!-- Dialogfenster öffnet: modal/dialog -> modal. .defer sorgt für weniger Abfragen. -->
        <x-modal.dialog wire:model.defer="showAddTagModal" class="h-full">
            <x-slot name="title">Tag erstellen</x-slot>


                <form method="POST" wire:submit.prevent="confirmAddTag">
                    <!-- Sicherheitsmaßnahme um vor csrf-Angriffen zu schützen -->
                    @csrf
                    <x-slot name="content">
                        <div>
                            <label for="name">Name:</label>
                            <input type="text" wire:model="name" required>
                            @error("name") <p>gib einen Tag ein</p> @enderror
                        </div>
                    </x-slot>
                    <x-slot name="footer">
                        <x-button wire:click="cancelAddTag()" class="bg-blue-500 hover:bg-blue-600">Zurück</x-button>
                        <x-button wire:click="confirmAddTag()">Hinzufügen</x-button>
                    </x-slot>
                </form>
                <x-input wire:model="addTagName" placeholder="hallo"></x-input>



        </x-modal.dialog>
    </div>
</div>
