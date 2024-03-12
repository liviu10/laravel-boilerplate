<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Resource;
use App\Models\General;

class Navbar extends Component
{
    protected $menuItemModel;
    protected $generalSettingsModel;
    public $menuItems;
    public $generalSettings;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->generalSettingsModel = new General();
        $this->menuItemModel = new Resource();
        $this->generalSettings = $this->getGeneralSettings();
        $this->menuItems = $this->getMenuItems();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $results = [
            'generalSettings' => $this->generalSettings,
            'menuItems'       => $this->menuItems,
        ];
        return view('components.navbar')->with('results', $results);
    }

    private function getGeneralSettings()
    {
        $generalSettingsFilter = [
            'type'  => 'Page',
            'label' => 'home_page'
        ];
        $items = $this->generalSettingsModel->fetchAllRecords($generalSettingsFilter)->toArray();
        return $items;
    }

    /**
     * Get menu items from the database based on specified filters.
     * @return array The array of menu items.
     */
    private function getMenuItems(): array
    {
        $itemFilter = [
            'type'          => 'Menu',
            'requires_auth' => 0,
        ];
        $items = $this->menuItemModel->fetchAllRecords($itemFilter)->toArray();
        return $items;
    }
}
