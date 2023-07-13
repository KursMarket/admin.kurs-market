<?php

namespace App\Widgets;

use App\Models\Menu;
use Arrilot\Widgets\AbstractWidget;

class SearchBarWidget extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    public function run()
    {
        return view('widgets.search_bar_widget', [
            'config' => $this->config,
        ]);
    }
}
