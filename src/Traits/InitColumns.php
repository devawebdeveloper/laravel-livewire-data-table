<?php

namespace Devaweb\LivewireDataTable\Traits;

use Illuminate\Support\Facades\Schema;

trait InitColumns {

    public $cols = [
        'selected' => [],
        'excluded' => [],
        'editable' => [],
        'filterable' => [],
        'searchable' => [],
        'sortable' => []
    ];

    public $table_name;

    public $columns_all;

    public $per_page;

    public $final_cols;

    public $m;

    //set values to variables
    //From Model
    //currently not in use
    public function initCols($model, $callback = null)
    {
        $this->m = $model;
        //get excluded columns
        $this->getExcludedCols();
        //get all columns with out exlueded columns
        $this->getTableNameColumnsList();
        //prepare columns
        $this->prepareCols($callback);

        //dd($this->final_cols);
        //dd($this->columns_all, $this->cols['excluded']);

    }

    /**
     * Get Table name and columns list
     *
     * @return void
     */
    public function getTableNameColumnsList()
    {
        //table name
        $this->table_name = (new $this->m())->getTable();
        //columns list
        $this->getAllCols();
    }

    /**
     * Get all columns name with out hidden cols
     *
     * @return void
     */
    public function getAllCols(): void
    {
        //all columns from table
        $dbcols = Schema::getColumnListing($this->table_name);
        //
        $newSet = [];
        //remove hiddencolumns
        foreach($dbcols as $c) {
            if(!in_array($c, $this->cols['excluded'])) {
                array_push($newSet, $c);
            }
        }
        //set columns
        $this->columns_all = $newSet;

    }

    /**
     * ----------------------------------------------------------
     * Get Exclude columns from Model method called hiddenColumns
     *
     * $model->hiddenColumns():array
     *
     * @return void
     */
    public function getExcludedCols()
    {
        $m = new $this->m();
        $this->cols['excluded'] = (method_exists($m,'hiddenColumns')) ? $m->hiddenColumns() : [];
    }


    //prepare columns with details in single array
    public function prepareCols($callback = null)
    {

        //get excluded columns
        //$this->getExcludedColumns();

        foreach($this->columns_all as $col) {
            if(!in_array($col, $this->cols['excluded'])) {

                $this->final_cols[$col] = $this->columnData(
                    //col name
                    $col,
                    //label
                    '',
                    //searchable
                    in_array($col,$this->cols['searchable']),
                    //sortable
                    in_array($col,$this->cols['sortable']),
                    //editable options
                    (isset($this->cols['editable'][$col]) ? $this->cols['editable'][$col] : null),
                    //filterable options
                    (isset($this->cols['filterable'][$col]) ? $this->cols['filterable'][$col] : null)

                );

                //callback function
                if(!is_null($callback)) {
                    $callback($col);
                }

            }
        }
    }



    /**
     * -----------------------------------
     * set column details data
     *
     * @param String $col
     * @param string $label
     * @param boolean $searchable
     * @param boolean $sortable
     * @param string|null $editableOpts
     * @param string|null $filterableOpts
     * @return array
     */
    public function columnData(
        String $col,
        String $label = '',
        bool   $searchable = false,
        bool   $sortable = false,
        string $editableOpts = null,
        string $filterableOpts = null
    ): array {

        $editable = (is_null($editableOpts)) ? false : true;
        $filterable = (is_null($filterableOpts)) ? false : true;

        $ed_opt = [
            'inputtype' => 'text',
            'params' => []
        ];

        //editable options
        if(!is_null($editableOpts)) {
            $ed = explode('|', $editableOpts);
            $ed_opt = [
                'inputtype' => $ed[0],
                'params' => explode(',', $ed[1])
            ];
        }

        return [
            'name' => $col,
            'label' => ($label == '') ? $col : $label,
            'searchable' => $searchable,
            'sortable' => $sortable,
            'editable' => $editable,
            'editable-options' => $ed_opt,
            'filterable' => $filterable,
            'filterable_options' => (is_null($filterableOpts))
                                    ? [] : explode(',', $filterableOpts)
        ];

    }


    //--------------------------------------------------------------------------------

    public function getColumnsFromModel()
    {

        $model = new $this->model();

        $suffix = array_keys($this->cols);

        foreach($suffix as $s) {

            $this->cols[$s] = (isset($model->{'datatable_columns_'.$s}))
                        ? $model->{'datatable_columns_'.$s}
                        : $this->defaultValues($s);

        }

        $this->per_page = (isset($model->datatable_data_per_page))
                            ? $model->datatable_data_per_page
                            : 15 ;
    }

    //Default options for columns
    public function defaultValues($var)
    {
        switch($var) {
            case 'selected':
                return array_splice($this->columns_all, 3);
                break;
            case 'excluded':
                return ['created_at', 'updated_at'];
                break;
            default:
                return [];
        }
    }

}