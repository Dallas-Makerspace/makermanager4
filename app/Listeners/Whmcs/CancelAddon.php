<?php

namespace App\Listeners\Whmcs;

use Adldap\Adldap;
use App\Badge;
use App\Events\Whmcs\AddonCancelled;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use MakerManager\ActiveDirectory\ADUser;

class CancelAddon
{
    public $adldap;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Adldap $adldap)
    {
        $this->adldap = $adldap;
    }

    /**
     * Handle the event.
     *
     * @param  AddonCancelled  $event
     * @return void
     */
    public function handle(AddonCancelled $event)
    {
        $payload = $event->payload;

        $badge = Badge::where('whmcs_service_id', $payload['serviceid'])
            ->where('whmcs_addon_id', $payload['addonid'])
            ->first();

        if(is_null($badge) || is_null($badge->user_id)) {
            // This is fine, means addon did not have a badge yet
        }

        $user = $badge->user;
        if(!is_null($user)) {
            try {
                $user->bindLdapUser();

                $adUser = new ADUser($user, $this->adldap);
                $adUser->disable();
            } catch(\Exception $e) {
                // Allow this to log and continue, so we can remove the badge.
                \Log::error("WHMCS CancelAddon: Failed to deactivate addon user in ActiveDirectory.", ['user_id' => $user->id, 'badge_id' => $badge->id]);
            }
        }

        $badge->deactivate();
    }
}
