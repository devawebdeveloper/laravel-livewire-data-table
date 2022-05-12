<?php

namespace Devaweb\LivewireDataTable\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Devaweb\LivewireDataTable\Traits\ColumnsCache;
use Devaweb\LivewireDataTable\Traits\InitColumns;

class DataTable extends Component
{

    /**
     * Plugable functions list - Must be placed in DB Model Class
     *
     *  1.hiddenColumns(): array
     *  2.ovViewFilter($column,$value): mixed
     *  3.ovSaveFilter($column,$value): mixed
     *
     */



    use WithPagination, ColumnsCache, InitColumns;

    //event listeners
    protected $listeners = [
        'refresh' => 'reload',
    ];

    public $per_page;

    public $model;

    public $table;

    public $dbCols;

    public $columns;

    public $sortable;

    public $searchable;

    public $lowercase;

    public $excluded;

    /**
     * $editable = [
     *  'name' => [
     *       'inputtype' => 'text' | 'select',
     *       'options' => ['one','two','thre'],
     *     ]
     * ]
     */
    public $editable;

    public $editableCols;

    /**
     * Component for new record
     * [
     *  'component' => 'name',
     *  'params'    => []
     * ]
     *
     * @var array
     */
    public $addNew;

    //dom --------------------------------------
    public $colbox = false;
    public $colDetailbox = [];
    //form ------------------------------------
    public $search = '';
    public $editableContent = '';

    //sorting
    public $sortCol = 'id';
    public $sortDirection = 'desc';

    //selected columns all configs
    public $selectedCols = [];

    //cache keys
    public $cacheKeys = [];

    //filterable
    public $filterable = [];

    public $filters = [];

    public function mount(
        $model,
        $columns = [],
        $sortable = [],
        $searchable = [],
        $lowercase = [],
        $editable = [],
        $filterable = [],
        $perPage = 15,
        $addNew = []
    ){

        //$this->table = (new $this->model())->getTable();


        $this->model = $model;
        //$this->columns = $columns;
        //$this->sortable = $sortable;
        //$this->searchable = $searchable;
        $this->lowercase = $lowercase;
        //$this->editable = $editable;
        //$this->filterable = $filterable;
        $this->per_page = $perPage;
        $this->addNew = $addNew;

        //$this->editableCols = array_keys($this->editable);
        //$this->getExcludedColumns();
        //$this->getAllColumns();
        //initCache


        $this->cols['selected'] = $columns;
        $this->cols['editable'] = $editable;
        $this->cols['filterable'] = $filterable;
        $this->cols['searchable'] = $searchable;
        $this->cols['sortable'] = $sortable;

        //get table_name and columns name and hidden columns
        //prepare columns
        $this->initCols($this->model, function($column){
            $this->filters[$column] = '';
        });

        //if chache does not exists then default value will set!
        if (!$this->initCache($this->table_name, true)) {

            $this->columns = $this->cols['selected'];
            $this->selectedCols = $this->final_cols;

        };

    }


    public function reload()
    {
        $this->colbox = true;
        //dd($this->ckeys);

        $cscols = $this->getCache($this->ckeys['selectedCols']);
        $ccols = $this->getCache($this->ckeys['columns']);

        $this->selectedCols = (empty($cscols)) ? $this->selectedCols : $cscols;
        $this->columns = (empty($ccols)) ? $this->columns : $ccols;
    }

    public function dbModal()
    {
        return new $this->modal();
    }

    /**
     * Get Data from db
     *
     * @return object
     */
    public function getData()
    {
        $db = $this->model::query();


            foreach ($this->columns as $col) {

                if($this->search != '') {
                    if($this->selectedCols[$col]['searchable']) {
                        $db->orWhere($col, 'LIKE', '%'.$this->search.'%');
                    }
                }

                if($this->filters[$col] != '' ){
                    if($this->selectedCols[$col]['filterable']) {
                        $db->where($col, $this->filters[$col]);
                    }
                }

            }



        //dd($db->get(), $this->filterable);
        return $db->orderBy($this->sortCol, $this->sortDirection)
                ->paginate($this->per_page);

    }


    /**
     * Sort column data
     *
     * @param string $col
     *
     * @return void
     */
    public function sort($col)
    {
        $this->sortCol = $col;
        $this->sortDirection = ($this->sortDirection == 'desc') ? 'asc' : 'desc';
    }

    /**
     * Save Content to db
     *
     * @param int    $rowid
     * @param string $col
     * @param mixed  $content
     *
     * @return void
     */
    public function saveContent($rowid, $col, $content)
    {
        $obj = new $this->model();

        if(method_exists($obj, 'onSaveFilter')){
            $content = $obj->onSaveFilter($col, $content);
        }

        $this->model::query()
            ->where('id', $rowid)
            ->update([$col => $content]);

        $this->dispatchBrowserEvent('inlineedit');

    }

    public function deleteData($rid)
    {
        $this->model::find($rid)->delete();
        $this->dispatchBrowserEvent('toast', ['msg' => 'Deleted successfully!']);
        //$this->emitSelf('refresh');
    }

    //render
    public function render()
    {
        $data = $this->getData();
        return view('livewire-data-table::livewire.data-table', compact('data'));
    }
}
