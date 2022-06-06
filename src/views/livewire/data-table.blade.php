
<div class="py-1 bg-white rounded-md shadow">
    <div class="w-full bg-white rounded-md shadow">

        <div class="flex flex-wrap items-center px-4 py-2">
            <div class="w-full md:w-3/12">
                <h1 class="uppercase">
                    {{ $table_name }}
                    <span class="xs:hidden"> - Data Table</span> <br>
                </h1>
            </div>
            <div class="w-full md:w-9/12">
                <input wire:model='search' type="text" class="w-full px-4 py-1 bg-white border border-gray-300 rounded-full" placeholder="Search in {{ implode(',', $cols['searchable']) }} ...">
            </div>
        </div>



        {{-- secont row -------- add new - columns customization - per_page --}}

        <div class="flex flex-wrap items-center justify-between border-t py-1" >
            <div class="flex gap-2 px-2">
                @if (count($addNew) > 0)
                <x-btui-smodal title="Add New">
                    <x-slot name="trigger">
                        <x-btui-button size="sm">Add New</x-btui-button>
                    </x-slot>

                    @if(count($addNew) > 0 && $addNew['component'] != '' && count($addNew['params']) > 0)
                    @livewire($addNew['component'],$addNew['params'])
                    @else
                    <div class="p-4 text-sm bg-red-400">No! Livewire Component Not found!</div>
                    @endif

                </x-btui-smodal>
                @endif
                @if ($customize)
                <div wire:click='$set("colbox", {{ !$colbox }})'
                    class="flex items-center justify-start gap-2 px-2 pt-1 bg-gray-100 rounded-t-md cursor-pointer
                        {{ ($colbox) ? 'pb-3 -mb-2' : 'rounded-b-md pb-1' }}
                    ">

                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                      </svg>
                    <p class="text-sm">Customize Table</p>

                    @if ($colbox)
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd" />
                      </svg>
                    @else
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                      </svg>
                    @endif

                </div>
                @endif

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
    <div class="w-full shadow-sm border-t border-gray-200 bg-gray-200">
        <div class="flex flex-grow gap-2 overflow-x-auto">

            @php
                //dd($selectedCols)
            @endphp

            @foreach($columns as $col)
            @if($selectedCols[$col]['filterable'])
            <div class="w-full sm:w-5/12 lg:w-3/12 xl:w-2/12 p-2">

                <label class="capitalize text-sm">{{ $selectedCols[$col]['label'] }}</label>
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
    <div class="w-full overflow-x-auto">
        <table class="w-full bg-white rounded-md shadow-inner z-50">
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

                <th></th>
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

                            <div style="width:80%;min-width:200px;">

                                @if($selectedCols[$col]['editable'])

                                    @if($selectedCols[$col]['editable-options']['inputtype'] == 'text' )

                                        <x-btui-input id="editable-content-{{ $d['id'] }}-{{ $col }}"
                                            value="{{ $d[$col] }}" size="sm" />

                                    @elseif($selectedCols[$col]['editable-options']['inputtype'] == 'select')

                                        <x-btui-select size="sm" :options="$selectedCols[$col]['editable-options']['params']"
                                            id="editable-content-{{ $d['id'] }}-{{ $col }}" value="{{ $d[$col] }}" />

                                    @else

                                        <textarea rows="1" class="w-full px-2 border border-gray-300 rounded"
                                            id="editable-content-{{ $d['id'] }}-{{ $col }}">{{ $d[$col] }}</textarea>

                                    @endif


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
                <td class="pr-1 bg-gray-100 min-w-min">

                    <x-dt-inline-edit  form-width="w-64">
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
                    </x-dt-inline-edit>

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
