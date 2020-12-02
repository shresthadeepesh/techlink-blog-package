<?php


namespace Techlink\Blog\View\Components;

use Illuminate\View\Component;

class InputText extends Component
{
    private $name, $label, $value, $placeholder, $type;

    public function __construct($name, $label, $value, $placeholder, $type = 'text')
    {
        $this->type = $type;
        $this->name = $name;
        $this->label = $label;
        $this->value = $value ? $value : old($this->name);
        $this->placeholder = $placeholder;
    }

    /**
     * @inheritDoc
     */
    public function render()
    {
        return view('blog::components.input-text', [
            'type' => $this->type,
            'name' => $this->name,
            'label' => $this->label,
            'value' => $this->value,
            'placeholder' => $this->placeholder
        ]);
    }
}