<?php

namespace App\View\Components\inputs;

use Illuminate\View\Component;

class document_code extends Component
{

    public $formType;
    public $prefix;
    public $formatLength;
    public $commonDifference;
    public $numberFieldId;
    public $codeFieldId;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($formType,$prefix,$formatLength,$commonDifference,$numberFieldId,$codeFieldId)
    {
        $this->formType = $formType;
        $this->prefix = $prefix;
        $this->formatLength = $formatLength;
        $this->commonDifference = $commonDifference;
        $this->numberFieldId = $numberFieldId;
        $this->codeFieldId = $codeFieldId;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.inputs.document_code');
    }
}
