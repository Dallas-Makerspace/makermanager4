<?php

namespace App\Listeners\Whmcs;

use Adldap\Adldap;
use App\Badge;
use App\Events\Whmcs\AfterModuleUnsuspend;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use MakerManager\ActiveDirectory\ADUser;

class UnsuspendMember
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
     * @param  AfterModuleUnsuspend  $event
     * @return void
     */
    public function handle(AfterModuleUnsuspend $event)
    {
        $payload = $event->payload;

        $user = User::where('whmcs_user_id', $payload['userid'])->first();
        if(!is_null($user)) {
            try {
                $user->bindLdapUser();

                $adUser = new ADUser($user, $this->adldap);
                $adUser->enable();
            } catch(\Exception $e) {
                // Allow this to log and continue, so we can remove the badge.
                \Log::error("WHMCS UnsuspendMember: Failed to activate user in ActiveDirectory.", ['user_id' => $user->id]);
            }
        }

        // Future
        // Try to get most recent badge to reactivate it.
    }
}
