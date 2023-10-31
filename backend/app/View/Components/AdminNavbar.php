<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Resource;

class AdminNavbar extends Component
{
    protected $modelName;
    public $resources;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->modelName = new Resource();
        $filter = [ 'type' => 'Menu' ];
        $this->resources = $this->modelName->fetchAllRecords($filter);

        // dd($this->resources);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin-navbar')->with('resources', $this->resources);
    }
}
