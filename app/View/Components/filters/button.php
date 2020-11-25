<?php

namespace App\View\Components\filters;

use Illuminate\View\Component;

class button extends Component
{

    public $filterId;
    public $buttonId;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($filterId, $buttonId)
    {
        
        $this->filterId = $filterId;
        $this->buttonId = $buttonId;


    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.filters.button');
    }
}
