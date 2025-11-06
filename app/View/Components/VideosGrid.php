<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class VideosGrid extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public $videos, public $channel = null)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.videos-grid', [
            'videos' => $this->videos,
			'channel' => $this->channel
        ]);
    }
}
