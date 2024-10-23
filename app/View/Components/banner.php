<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class banner extends Component
{
    public $title;

    public $image;
    public $subTitle;
    /**
     * Create a new component instance.
     */
    public function __construct($title , $image , $subTitle )
    {
        $this->title = $title;
        $this->image = $image;
        $this->subTitle = $subTitle;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.banner');
    }
}
