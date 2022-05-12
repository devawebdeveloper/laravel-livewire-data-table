<div class="p-4">
    <div class="flex justify-between pb-2">
        <div>
            <h3>Customize Columns</h3>
        </div>

        <div class="">
            <x-btui-button color="light-blue" wire:click='refresh' size="sm">Save</x-btui-button>
        </div>
    </div>

    <div class="flex rounded">
        <div class="w-9/12 py-2 px-2 bg-gray-200 ">
            <div class="">
                <p>Columns
                    <span class="bg-gray-100 px-2 rounded text-sm" wire:loading>...</span>
                </p>
            </div>
            <div class="">


                @foreach($seCols as $col)

                <div wire:key="{{ $col.time() }}-col" class="w-full my-1">

                    <x-dt-accordion >
                        @slot('title')
                        {{$col}}
                        @endslot
                        @slot('options')
                        <div class="flex items-center justify-end gap-2">

                            @if((count($seCols) - 1) != array_search($col, $seCols))
                            <div wire:click="moveCol('down','{{ $col }}')" class="bg-gray-200 rounded cursor-pointer hover:bg-gray-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            @endif

                            @if(array_search($col, $seCols) != 0 )
                            <div wire:click="moveCol('up','{{ $col }}')" class="bg-gray-200 rounded cursor-pointer hover:bg-gray-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            @endif

                            @if(count($seCols) != 1)
                            <div id="remove" wire:click="removeCol('{{ $col }}')" class="text-red-500 bg-gray-100 rounded cursor-pointer hover:bg-gray-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            @endif


                        </div>
                        @endslot

                        <!-- Columns details ------------------------------>
                        <div>
                            @livewire('dt-columns-details', ['table' => $table, 'col' => $col, 'detailCols' => $detailCols], key('detailCols-'.time()))
                        </div>
                    </x-dt-accordion>
                </div>

                @endforeach
            </div>
        </div>
        <div class="w-3/12 py-2 border-l bg-gray-100">
            <div class="px-2 text-sm">
                <p>Unadded Columns</p>
            </div>
            <div class="divide-y rounded shadow-sm">
                @foreach($columns as $col)
                    @if(!in_array($col, $seCols))
                        <div wire:key="{{ $col.time() }}-ucol" class="w-full flex justify-between capitalize bg-white py-2 px-2">
                            <div class="text-sm">{{$col}}</div>
                            <div class="bg-gray-100 cursor-pointer" wire:click="addCol('{{ $col }}')">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
