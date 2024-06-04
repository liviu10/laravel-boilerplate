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
        $records = $this->googleMaps->fetchAllRecords();

        if ($records instanceof Collection && $records->isNotEmpty()) {
            $this->googleMapsLocation = $records->toArray()[0]['address'];
        } else {
            $this->googleMapsLocation = 'Bucuresti';
        }
        $this->googleMapsLocation = str_replace(' ', '+', $this->googleMapsLocation);
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
