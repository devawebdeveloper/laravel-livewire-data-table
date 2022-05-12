
<div class="py-1 bg-white rounded-md shadow">
    <div class="w-full bg-white rounded-md shadow">

        <div class="flex items-center px-4 py-2">
            <div class="w-4/12">
                <h1 class="uppercase">Data Table - {{ $table }}</h1>
            </div>
            <div class="w-full">
                <input wire:model='search' type="text" class="w-full px-4 py-1 bg-white border border-gray-300 rounded-full" placeholder="Search in {{ implode(',', $columns) }} ...">
            </div>
        </div>



        {{-- secont row -------- add new - columns customization - per_page --}}

        <div class="flex flex-wrap items-center justify-between py-1 border-t border-b border-gray-200" >
            <div class="flex gap-2 px-4">
                <x-btui-smodal title="Add New">
                    <x-slot name="trigger">
                        <x-btui-button size="sm">Add New</x-btui-button>
                    </x-slot>

                    @if(count($addNew) > 0)
                    @livewire($addNew['component'],$addNew['params'])
                    @else
                    <div class="p-4 text-sm bg-red-400">No! Livewire Component Not found!</div>
                    @endif

                </x-btui-smodal>
                <div wire:click='$set("colbox", {{ !$colbox }})' class="flex items-center justify-start gap-2 px-2 bg-gray-100 rounded-md cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                    </svg>
                    <p class="">Columns</p>
                </div>
            </div>

            <div class="flex items-center justify-end gap-2 px-4">

                <label for="perPage" class="text-sm ">Results Per Page:</label>
                <div class="w-16 py-1">
                    <select wire:model='per_page' class="w-full px-3 py-1 text-xs border border-gray-300 rounded">
                        <option value="0" class="">Select..</option>
                        <option value="5" class="">5</option>
                        <option value="15" class="">15</option>
                        <option value="25" class="">25</option>
                        <option value="50" class="">50</option>
                        <option value="100" class="">100</option>
                    </select>
                </div>

            </div>

        </div>



        {{-- customizing columns -----------area start ---------- --}}
        @if($colbox)
        <div class="bg-gray-100">
        @livewire('dt-customize-columns', ['table' => $table_name,'columns' => $columns_all, 'selectedColumns' => $columns, 'detailCols' => $selectedCols], key('customizeColumns-'.time()))
        </div>
        @endif

    {{-- filterable area -------------------------------------------- --}}
    <div class="w-full p-2 shadow-sm">
        <div class="flex flex-wrap gap-1">
            @foreach($columns as $col)
            @if($selectedCols[$col]['filterable'])
            <div class="w-3/12 bg-gray-100 rounded p-2">

                <label class="capitalize">{{ $selectedCols[$col]['label'] }}</label>
                <x-btui-select size="sm"
                    :options="$selectedCols[$col]['filterable_options']"
                    wire:model="filters.{{$col}}" />

            </div>
            @endif
            @endforeach
        </div>
    </div>

    {{-- table area ------------------------------------------------- --}}

    @if($data->count() > 0)
    <div class="w-full pb-4 overflow-x-auto">
        <table class="w-full bg-white rounded-md shadow-sm">
            <thead>
            <tr class="border-b divide-x bg-gray-50 ">
                @foreach ($columns as $col)

                <th wire:key='col-{{ $col }}' class="px-4 py-2 text-sm font-semibold uppercase ">


                    <div class="flex flex-wrap items-center justify-between gap-2">
                        <div>
                            {{ $selectedCols[$col]['label'] }}
                        </div>
                        <div class="">

                            @if($selectedCols[$col]['sortable'])

                            <span wire:click='sort("{{ $col }}")' class="">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 cursor-pointer hover:text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                </svg>
                            </span>

                            @endif

                        </div>
                    </div>

                </th>

                @endforeach
            </tr>
            </thead>

            <tbody class="divide-y">

            @foreach ($this->getData() as $d)

            <tr wire:key='data-{{ $d->id }}' class="cursor-pointer hover:bg-gray-50">

                @foreach ($columns as $col)

                <td wire:key='data-{{ $d->id }}-{{ $col }}' id="cell" class="px-4 py-2 text-sm {{ in_array($col, $lowercase) ? '' : 'capitalize' }} ">

                    <x-dt-inline-edit>
                        <div class="">
                            @if(method_exists(new $this->model(), 'onViewFilter'))
                            {{ (new $this->model())->onViewFilter($col,$d[$col]) }}
                            @else
                            {{ $d[$col] }}
                            @endif
                        </div>

                        @if($selectedCols[$col]['editable'])
                        @slot('trigger')
                        <div wire:key='edit-{{ $col }}-{{ $d->id }}' id="edit" onclick="toggleEditBox('editbox-{{ $d->id }}-{{ $col }}')" class="pl-4 transition-all duration-300 hover:text-gray-800">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500 hover:text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                        </div>
                        @endslot
                        @endif

                        @slot('form')
                        <div class="flex items-center justify-start gap-2 ">

                            <div class="w-48">

                                @if($selectedCols[$col]['editable'])

                                @isset($cols['editable'][$col])

                                @if($cols['editable'][$col]['inputtype'] == 'text' )
                                    <x-btui-input id="editable-content-{{ $d['id'] }}-{{ $col }}" value="{{ $d[$col] }}" size="sm" />
                                @elseif($cols['editable'][$col]['inputtype'] == 'select')
                                    <x-btui-select size="sm" :options="$cols['editable'][$col]['options']" id="editable-content-{{ $d['id'] }}-{{ $col }}" value="{{ $d[$col] }}" />
                                @else
                                    <textarea rows="1" class="w-full px-2 border border-gray-300 rounded" id="editable-content-{{ $d['id'] }}-{{ $col }}">{{ $d[$col] }}</textarea>
                                @endif

                                @else
                                    <textarea rows="1" class="w-full px-2 border border-gray-300 rounded" id="editable-content-{{ $d['id'] }}-{{ $col }}">{{ $d[$col] }}</textarea>
                                @endisset

                                @endif

                            </div>

                            <x-btui-button onclick="saveContent('{{ $d->id }}', '{{ $col }}')" size='sm'>
                                Save
                            </x-btui-button>
                        </div>
                        @endslot
                    </x-dt-inline-edit>

                </td>

                @endforeach

                {{-- delete - options ----------------------------- --}}
                <td class="pr-1 bg-gray-100">

                    <x-inline-edit  form-width="w-64">
                        @slot('trigger')
                        <div class="text-red-700 hover:text-red-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                              </svg>
                        </div>
                        @endslot
                        @slot('form')
                            <div class="">
                                <p class="mb-1 border-b"> Are you sure to delete? </p>
                                <x-btui-button wire:click='deleteData({{ $d->id }})' size="sm" color="light-red">Delete</x-btui-button>
                            </div>
                        @endslot
                    </x-inline-edit>

                </td>
            </tr>
            @endforeach
            </tbody>

        </table>
    </div>
    @else
    <div class="p-4 m-2 text-center">
        No results!
    </div>
    @endif

<div class="px-4 py-2 rounded-md bg-gray-50">
    {{ $data->links() }}
</div>



</div>

</div>
<style>
    #cell #edit {
        opacity: 0;
    }

    #cell:hover #edit {
        opacity: 1;
    }

</style>
<script>
    function toggleEditBox(id) {

        el = document.querySelector('#' + id);
        var dis = el.style.display;
        el.style.display = (dis == 'block') ? 'none' : 'block';


        var scr = screen.width;
        var offs = el.parentNode.parentNode.offsetLeft;

        if ((scr / 2) > (scr - offs)) {
            el.style.right = 0;
        }
        //console.log(el.parentNode.parentNode.offsetLeft)
        //console.log((scr/2),(scr-offs));
    }

    function saveContent(id, col) {

        var content = document.getElementById('editable-content-' + id + '-' + col);
        @this.saveContent(id, col, content.value);

    }

</script>
