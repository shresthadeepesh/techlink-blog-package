<?php


namespace Techlink\Blog\View\Components;

use Illuminate\View\Component;

class ModelTable extends Component
{
    public $title, $description, $models, $type, $fillables;

    public function __construct($title, $description, $models, $type, $fillables)
    {
        $this->title = $title;
        $this->description = $description;
        $this->models = $models;
        $this->type = $type;
        $this->fillables = $fillables;
    }

    /**
     * @inheritDoc
     */
    public function render()
    {
        return view('blog::components.table');
    }
}