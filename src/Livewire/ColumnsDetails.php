<?php

namespace Devaweb\LivewireDataTable\Livewire;

use Livewire\Component;
use Devaweb\LivewireDataTable\Traits\ColumnsCache;


class ColumnsDetails extends Component
{

    use ColumnsCache;

    public $col, $detailCols, $table;

    public function mount(
        String $table,
        String $col,
        array $detailCols
        ): void
    {
        $this->table = $table;
        $this->col = $col;
        $this->detailCols = $detailCols;

        $this->initCache($this->table);

    }

    public function updatedDetailCols()
    {
        $this->upSelectedCols($this->detailCols);
        //$this->emitTo('data-table', 'refresh');
    }

    public function render()
    {
        return view('livewire-data-table::livewire.columns-details');
    }
}
