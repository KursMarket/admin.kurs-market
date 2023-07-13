<?php

namespace App\Widgets;

use App\Models\Menu;
use Arrilot\Widgets\AbstractWidget;

class SidebarWidget extends AbstractWidget
{
    protected $config = [];

    public function run()
    {
        $this->config['menus'] = $this->getMenus();

        return view('widgets.sidebar_widget', [
            'config' => $this->config,
        ]);
    }

    private function getMenus(): array
    {
        $menus = [];
        $results = Menu::where('parent', 0)->orderBy('sort_order')->get()->toArray();

        if ($results) {
            foreach ($results as $result) {
                $children = Menu::query()
                    ->select(['id', 'title', 'path', 'icon'])
                    ->where('parent', $result['id'])
                    ->get()
                    ->toArray();

                $menus[] = [
                    'id' => $result['id'],
                    'title' => $result['title'],
                    'path' => $result['path'],
                    'icon' => $result['icon'],
                    'children' => $children
                ];
            }
        }

        return $menus;
    }
}
