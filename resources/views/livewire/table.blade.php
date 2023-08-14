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
                        <x-table.cell wire:model="addTag">Add Tag</x-table.cell>
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

    <x-modal.dialog>
        <x-slot name="title">Tag hinzufügen</x-slot>

        <x-slot name="content">Test</x-slot>

        <x-slot name="footer">Hallo</x-slot>
    </x-modal.dialog>

</div>
