<?php

namespace App\Events\Location;

use App\Events\EndpointHit;
use App\Models\Audit;
use Illuminate\Http\Request;

class LocationsListed extends EndpointHit
{
    /**
     * Create a new event instance.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);

        $this->action = Audit::ACTION_READ;
        $this->description = 'Viewed all locations';
    }
}