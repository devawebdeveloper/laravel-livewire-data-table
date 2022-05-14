<div>
    <div class="" wire:loading>
        <x-btui-loader loading="true" />
    </div>
    @php
        $checkbox = 'border rounded border-gray-400';
    @endphp
    <div class="flex items-center justify-start px-2 divide-x">
        <div class="flex items-center justify-start gap-1 pr-2">
            <label for="search-label-{{ $col }}" class="pr-2">Label</label>
            <x-btui-input id="search-lebel-{{ $col }}" size="sm" wire:model='detailCols.{{ $col }}.label' />
        </div>
        <div class="flex items-center justify-start gap-1 px-2">
            <input id="search-check-{{ $col }}" wire:model='detailCols.{{ $col }}.searchable' type="checkbox" class="{{ $checkbox }}">
            <label for="search-check-{{ $col }}" class="pt-1">Searchable</label>
        </div>
        <div class="flex items-center justify-start gap-1 px-2">
            <input id="sort-check-{{ $col }}" wire:model='detailCols.{{ $col }}.sortable' type="checkbox" class="{{ $checkbox }}">
            <label for="sort-check-{{ $col }}" class="pt-1">Sortable</label>
        </div>
        <div class="flex items-center justify-start gap-1 px-2">
            <input id="edit-check-{{ $col }}" wire:model='detailCols.{{ $col }}.editable' type="checkbox" class="{{ $checkbox }}">
            <label for="edit-check-{{ $col }}" class="pt-1">Editable</label>
        </div>

        <div class="flex items-center justify-start gap-1 px-2">
            <input id="filter-check-{{ $col }}" wire:model='detailCols.{{ $col }}.filterable' type="checkbox" class="{{ $checkbox }}">
            <label for="filter-check-{{ $col }}" class="pt-1">Filterable</label>
        </div>

    </div>

    <div class="flex w-full gap-2 my-2 text-sm">

        @if($detailCols[$col]['editable'])
        <div class="w-6/12 p-2 border ">
            <h2 class="text-gray-500">Editable Options</h2>
            <div class="flex items-center py-1">
                <label for="" class="w-6/12">Input Type</label>
                <div class="w-6/12">
                    <x-btui-select size="sm" wire:model="detailCols.{{$col}}.editable-options.inputtype" :options="['text','textarea','select']" />
                </div>
            </div>

            @if($detailCols[$col]['editable-options']['inputtype'] == 'select')
            <div class="flex items-center my-1">
                <label for="" class="w-6/12">Options
                <br/> <span class="text-xs text-gray-500">(options must be seperated by comma (,))</span>
                </label>
                <div class="w-6/12">
                    <x-btui-input wire:model="detailCols.{{$col}}.editable-options.params" size="sm" />
                </div>
            </div>
            @endif

        </div>
        @endif

        @if($detailCols[$col]['filterable'])
        <div class="w-6/12 p-2 border rounded">
            <h2 class="mb-2 text-gray-500">Filterable Options</h2>
            <div class="flex items-center my-1">
                <label for="" class="w-4/12 pr-2">Options
                <br/> <span class="text-xs text-gray-500">(options must be seperated by comma (,))</span>
                </label>
                <div class="w-8/12">
                    <textarea wire:model="detailCols.{{$col}}.filterable_options" class="w-full border rounded border-gray-200"></textarea>
                </div>
            </div>
        </div>

        @endif

    </div>
</div>
