<?php

namespace Devaweb\LivewireDataTable\View\Components;

use Illuminate\View\Component;

class inlineEdit extends Component
{

    public $formStyle;

    public $formWidth;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($formStyle = '', $formWidth = 'w-48')
    {
        $this->formStyle = $formStyle;
        $this->formWidth = $formWidth;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('livewire-data-table::components.inline-edit');
    }
}
