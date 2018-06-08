<?php

namespace App\Listeners\Whmcs;

use App\Badge;
use App\Events\Whmcs\AddonActivation;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateAddon
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  AddonActivation  $event
     * @return void
     */
    public function handle(AddonActivation $event)
    {
        $payload = $event->payload;

        $badge = new Badge();
        $badge->whmcs_user_id = $payload['userid'];
        $badge->whmcs_service_id = $payload['serviceid'];
        $badge->whmcs_addon_id = $payload['addonid'];
        $badge->status = Badge::STATUS_UNASSIGNED;

        $badge->save();
    }
}
