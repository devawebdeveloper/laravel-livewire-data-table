<?php

namespace Devaweb\LivewireDataTable\Livewire;

use Livewire\Component;
use Devaweb\LivewireDataTable\Traits\ColumnsCache;

class CustomizeColumns extends Component
{

    use ColumnsCache;

    public $table;
    //all columns names only
    public $columns = [];
    //selected columns from cache
    public $seCols = [];
    //unselected columns
    public $uCols = [];
    //full columns with details
    public $detailCols = [];

    //event listeners
    protected $listeners = [
        'refresh' => '$refresh',
        'savedetailseCols' => 'getColumnsDetails'
    ];

    public function mount(
        string $table,
        array $columns,
        array $selectedColumns,
        array $detailCols
        ): void
    {
        $this->table = $table;
        $this->columns = $columns;
        $this->seCols = $selectedColumns;
        $this->detailCols = $detailCols;

        //initcache
        $this->initCache($this->table);
    }

    /**
     * Add column to columns array
     *
     * @param string $col
     *
     * @return void
     */
    public function addCol($col)
    {
        if(!in_array($col, $this->seCols)) {
            array_push($this->seCols, $col);
        }

        $this->saveCols();
    }

    /**
     * Remove column from columns array
     *
     * @param string $col
     *
     * @return void
     */
    public function removeCol($col)
    {
        if(in_array($col, $this->seCols)) {
            unset($this->seCols[array_search($col, $this->seCols)]);
        }

        $this->saveCols();
    }

    /**
     * Move the column up or down
     *
     * @param string $dir
     * @param string $col
     *
     * @return void
     */
    public function moveCol($dir, $col)
    {
        //dd($dir,$col);
        //$this->dispatchBrowserEvent('toast', ['msg' => 'Moving..']);
        $index = array_search($col, $this->seCols);

        $c = count($this->seCols);
        $newIndex = ($dir == 'up') ? $index - 1 : $index + 1;

        //dd($index, $newIndex, count($this->seCols), $this->seCols);

        $co = array_splice($this->seCols, $index, 1);
        array_splice($this->seCols, $newIndex, 0, $co);

        $this->saveCols();
        //dd($this->seCols);

    }

    /**
     * Save Column to Cache
     *
     * @return void
     */
    public function saveCols()
    {
        $this->upCols($this->seCols);
        //$this->emitTo('data-table', 'refresh');
    }

    public function refresh()
    {
        $this->emitTo('livewire-data-table', 'refresh');
    }

    /**
     * get Columns details from child component - ColumnsDetails
     *
     * @param array $detailCols
     * @return void
     */
    public function getColumnsDetails(array $detailCols): void
    {
        $this->detailCols = $detailCols;
    }

    public function render()
    {
        return view('livewire-data-table::livewire.customize-columns');
    }
}
