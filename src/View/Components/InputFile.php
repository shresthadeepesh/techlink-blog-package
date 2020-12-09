<?php


namespace Techlink\Blog\View\Components;

use Illuminate\View\Component;

class InputFile extends Component
{
    private $name, $label, $value;

    public function __construct($name, $label, $value)
    {
        $this->name = $name;
        $this->label = $label;
        $this->value = $value;
    }

    /**
     * @inheritDoc
     */
    public function render()
    {
        return view('blog::components.input-file', [
            'name' => $this->name,
            'label' => $this->label,
            'value' => $this->value
        ]);
    }
}