<?php

namespace App\View\Components;

use Illuminate\View\Component;

class loader extends Component
{

    public $loaderId;
    public $minHeight;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($loaderId,$minHeight)
    {
        $this->loaderId = $loaderId;
        $this->minHeight = $minHeight;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.loader');
    }
}
