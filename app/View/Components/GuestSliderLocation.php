<?php

namespace App\View\Components;

use App\Models\GoogleMaps;
use Illuminate\Database\Eloquent\Collection;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class GuestSliderLocation extends Component
{
    protected $googleMaps;
    public $googleMapsLocation;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->googleMaps = new GoogleMaps();
        $this->googleMapsLocation = $this->googleMaps->fetchAllRecords()->toArray()[0];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.guest-slider-location')
            ->with('googleMapsLocation', $this->googleMapsLocation);
    }
}
