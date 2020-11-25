<?php

namespace App\View\Components\modals;

use Illuminate\View\Component;

class basic extends Component
{

    public $modalId;
    public $modalSize;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($modalId, $modalSize = "")
    {
        
        $this->modalId = $modalId;
        $this->modalSize = $modalSize;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.modals.basic');
    }
}
