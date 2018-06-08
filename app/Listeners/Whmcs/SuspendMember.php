<?php

namespace App\Listeners\Whmcs;

use Adldap\Adldap;
use App\Badge;
use App\Events\Whmcs\AfterModuleSuspend;
use App\Events\Whmcs\AfterModuleTerminate;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use MakerManager\ActiveDirectory\ADUser;

class SuspendMember
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
     * @param  AfterModuleSuspend  $event
     * @return void
     */
    public function handle(AfterModuleSuspend $event)
    {
        $payload = $event->payload;

        $badges = Badge::where('whmcs_service_id', $payload['serviceid'])
            ->get();

        if(is_null($badges) || empty($badges)) {
            // This is fine, means member did not have any badges
        }

        $user = User::where('whmcs_user_id', $payload['userid'])->first();
        if(!is_null($user)) {
            try {
                $user->bindLdapUser();

                $adUser = new ADUser($user, $this->adldap);
                $adUser->disable();
            } catch(\Exception $e) {
                // Allow this to log and continue, so we can remove the badge.
                \Log::error("WHMCS SuspendMember: Failed to deactivate user in ActiveDirectory.", ['user_id' => $user->id, 'badge_id' => $badge->id]);
            }
        }

        foreach($badges as $badge) {
            $badge->deactivate();
        }

    }
}
