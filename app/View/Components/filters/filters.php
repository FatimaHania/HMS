<?php

namespace App\View\Components\filters;

use Illuminate\View\Component;

class filters extends Component
{

    public $filterId;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($filterId)
    {
        
        $this->filterId = $filterId;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.filters.filters');
    }
}
