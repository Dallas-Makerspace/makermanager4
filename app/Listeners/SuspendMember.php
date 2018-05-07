<?php

namespace App\Listeners;

use Adldap\Adldap;
use App\Events\Whmcs\ClientAdd;
use App\Events\Whmcs\Hook;
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
     * @param  Hook  $event
     * @return void
     */
    public function handle(Hook $event)
    {
        $payload = $event->payload;

        $user = User::where('whmcs_user_id', $payload['params']['userid']);

        $user->badge->deactivate();

        $adUser = new ADUser($user, $this->adldap);
        $adUser->disable();

        return true;
    }
}
