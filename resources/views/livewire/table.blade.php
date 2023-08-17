<div style="padding: 50px;">
    <div>
        <div class="w-1/4">
            <x-input.text placeholder="Search..." wire:model="searchbar" />
        </div>
    </div>

    <div class="py-4 space-y-5">
        <x-table>
            <x-slot name="head">
                <x-table.heading sortable>ID</x-table.heading>
                <x-table.heading sortable>Name</x-table.heading>
                <x-table.heading sortable>E-Mail</x-table.heading>
                <x-table.heading sortable>Actions</x-table.heading>
            </x-slot>

            <x-slot name="body">
                @forelse($users as $user)
                    <x-table.row  wire:loading.class="opacity-50">
                        <x-table.cell>{{ $user->id }}</x-table.cell>
                        <x-table.cell>{{ $user->name }}</x-table.cell>
                        <x-table.cell>{{ $user->email }}</x-table.cell>
                        <x-table.cell><button wire:click="addTag('{{ $user->id }}')">Add Tag</button></x-table.cell>
                    </x-table.row>

                    @empty
                    <x-table.row>
                        <x-table.cell colspan="3">
                            <div class="flex justify-center items-center text-gray-500">
                                Die Suche war ohne Erfolg.
                            </div>
                        </x-table.cell>
                    </x-table.row>
                @endforelse
            </x-slot>
        </x-table>

        {{ $users->Links() }}
    </div>

    <!-- Dialogfenster öffnet: modal/dialog -> modal. .defer sorgt für weniger Abfragen. -->
    <x-modal.dialog wire:model.defer="showAddTagModal">
        <x-slot name="title">Tag hinzufügen</x-slot>

        <x-slot name="content">
            <x-dropdown>
                <x-slot name="trigger">
                    <button class="right-0 border-gray-200 border-2 p-2">{{ $selectedTag->name ?? "Select Tag" }}</button>
                </x-slot>

                <x-slot name="content">
                    <ul class="scroll-auto scroll-m-0">
                        @foreach ($this->tags as $tag)
                            <li><button wire:click="updateSelectedTag('{{$tag->id}}')">{{ $tag->name }}</button></li>
                        @endforeach
                    </ul>
                </x-slot>
            </x-dropdown>
        </x-slot>

        <x-slot name="footer">
            <x-button class="bg-blue-500 hover:bg-blue-600">Zurück</x-button>
            <x-button wire:click="confirmAddTag()">Hinzufügen</x-button>
        </x-slot>
    </x-modal.dialog>
</div>
