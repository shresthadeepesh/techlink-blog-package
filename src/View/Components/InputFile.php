<?php


namespace Techlink\Blog\View\Components;

use Illuminate\View\Component;

class InputFile extends Component
{
    private $name, $label;

    public function __construct($name, $label)
    {
        $this->name = $name;
        $this->label = $label;
    }

    /**
     * @inheritDoc
     */
    public function render()
    {
        return view('blog::components.input-file', [
            'name' => $this->name,
            'label' => $this->label,
        ]);
    }
}