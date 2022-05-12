<?php

namespace Devaweb\LivewireDataTable\View\Components;

use Illuminate\View\Component;

class accordion extends Component
{

    public $isOpen = false;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(bool $isOpen = false)
    {
        $this->isOpen = $isOpen;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('livewire-data-table::components.accordion');
    }
}
