<?php

namespace Devaweb\LivewireDataTable\Traits;

use Illuminate\Support\Facades\Cache;

trait ColumnsCache {

    public $ckeys;

    public function initCache($table, $getCache = false)
    {
        $this->ckeys = [
            'columns' => $table.'-dataTable-columns',
            'selectedCols' => $table.'-dataTable-selected-columns',
        ];

        if($getCache) return $this->getAllCache();
    }

    /**
     * Get cache and set into variables
     *
     * @return bool
     */
    public function getAllCache(): bool
    {
        //not exist
        $ex = [];

        foreach($this->ckeys as $key => $value) {
            //dd(Cache::get($value), $value, 'one');
            if(Cache::has($value)) {
                $this->{$key} = Cache::get($value);

            } else {
                array_push($ex, $key);
            }

        }
        //dd($ex);
        return (count($ex) == 0) ? true : false;
    }

    /**
     * Update Cache - core function
     *
     * @param string $key
     * @param mixed  $data
     *
     * @return void
     */
    public function updateCache($key, $data)
    {
        if(Cache::has($key)) {
            Cache::forget($key);
        }

        Cache::rememberForever($key, function () use ($data) {
            return $data;
        });

        return Cache::get($key);
    }

    /**
     * update columns array to cache and return it!
     *
     * @param array $data
     * @return mixed
     */
    public function upCols(array $data)
    {
        return $this->updateCache($this->ckeys['columns'], $data);
    }

    /**
     * update Selected columns details array to cache and return it!
     *
     * @param array $data
     * @return mixed
     */
    public function upSelectedCols(array $data)
    {
        return $this->updateCache($this->ckeys['selectedCols'], $data);
    }

    /**
     * get Columns from cache
     *
     * @param String $key
     * @return array
     */
    public function getCache(String $key): array
    {
        if(Cache::has($key)) {
            return Cache::get($key);
        } else {
            //dd(Cache::get($key));
            return [];
        }
    }


}

