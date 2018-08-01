<?php

namespace App\Events\Organisation;

use App\Events\EndpointHit;
use App\Models\Audit;
use App\Models\Organisation;
use Illuminate\Http\Request;

class OrganisationDeleted extends EndpointHit
{
    /**
     * Create a new event instance.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Organisation $organisation
     */
    public function __construct(Request $request, Organisation $organisation)
    {
        parent::__construct($request);

        $this->action = Audit::ACTION_DELETE;
        $this->description = "Deleted organisation [{$organisation->id}]";
    }
}