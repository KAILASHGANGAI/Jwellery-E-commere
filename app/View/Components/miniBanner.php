<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class miniBanner extends Component
{
    /**
     * Create a new component instance.
     */
    public $title;
    public $subTitle;
    public $link;
    public $image;
    public function __construct( $title, $subTitle, $link, $image)
    {
        $this->title = $title;
        $this->subTitle = $subTitle;
        $this->link = $link;
        $this->image = $image;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.mini-banner');
    }
}
