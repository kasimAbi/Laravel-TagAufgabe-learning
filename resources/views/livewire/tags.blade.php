<div>
    <div class="py-4 space-y-5">
        <x-table>
            <x-slot name="head">
                <x-table.heading>Tag_ID</x-table.heading>
                <x-table.heading>Taggable_ID</x-table.heading>
            </x-slot>

            <x-slot name="body">
                @foreach($tags as $tag)
                    <x-table.row  wire:loading.class="opacity-50">
                        <x-table.cell>{{ $tag->name }}</x-table.cell>
                        <x-table.cell>
                            @if(isset($tag->users))
                                {{ Illuminate\Support\Arr::join($tag->users->toArray(), ', ') }}
                            @endif
                        </x-table.cell>
                    </x-table.row>
                @endforeach
            </x-slot>
        </x-table>

        $users->Links()
    </div>
</div>
