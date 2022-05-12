<?php

namespace Devaweb\LivewireDataTable;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Devaweb\LivewireDataTable\View\Components\accordion;
use Devaweb\LivewireDataTable\View\Components\inlineEdit;
use Devaweb\LivewireDataTable\Livewire\DataTable;
use Devaweb\LivewireDataTable\Livewire\CustomizeColumns;
use Devaweb\LivewireDataTable\Livewire\ColumnsDetails;
use Livewire\Livewire;

class LivewireDataTableServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //views
        $this->loadViewsFrom(__DIR__."/views", "livewire-data-table");

        //blade components
        Blade::component('dt-accordion', accordion::class);
        Blade::component('dt-inline-edit', inlineEdit::class);

        //livewire components
        Livewire::component('livewire-data-table', DataTable::class);
        Livewire::component('dt-customize-columns', CustomizeColumns::class);
        Livewire::component('dt-columns-details', ColumnsDetails::class);

    }
}
