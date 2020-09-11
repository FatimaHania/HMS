<?php

namespace App\View\Components\Inputs;

use Illuminate\View\Component;

class Image extends Component
{

    public $name;
    public $class;
    public $picture;
    public $height;
    public $width;
    public $defaultImage;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name , $class , $picture , $height , $width , $defaultImage)
    {
        
        $this->name = $name;
        $this->class = $class;
        $this->picture = $picture;
        $this->height = $height;
        $this->width = $width;
        $this->defaultImage = $defaultImage;


    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.inputs.image');
    }
}
