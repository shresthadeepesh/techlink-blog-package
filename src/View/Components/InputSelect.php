<?php


namespace Techlink\Blog\View\Components;

use Illuminate\Support\Str;
use Illuminate\View\Component;

class InputSelect extends Component
{
    private $name, $label, $selected, $options, $multiple, $errorName;

    public function __construct($name, $label, $options, $value, $multiple = false)
    {
        $this->name = $name;
        $this->label = $label;
        $this->options = $options;
        //extracting the name without [] for multiple select by replacing using str_replace
        $this->errorName = $multiple ? Str::replaceFirst('[]', '', $name) : $name;
        //if the selected data are available then plucking it's modelKey
        $this->selected = old($this->errorName) ?? $value;
        $this->multiple = $multiple;
    }

    /**
     * @inheritDoc
     */
    public function render()
    {
        return view('blog::components.input-select', [
            'name' => $this->name,
            'label' => $this->label,
            'selected' => $this->selected,
            'options' => $this->options,
            'multiple' => $this->multiple,
            'errorName' => $this->errorName
        ]);
    }
}