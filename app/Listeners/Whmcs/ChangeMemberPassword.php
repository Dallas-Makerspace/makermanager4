<?php

namespace App\Listeners\Whmcs;

use Adldap\Adldap;
use App\Events\Whmcs\ClientChangePassword;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use MakerManager\ActiveDirectory\ADUser;

class ChangeMemberPassword
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
     * @param  ClientChangePassword  $event
     * @return void
     */
    public function handle(ClientChangePassword $event)
    {
        $payload = $event->payload;

        $user = User::where('whmcs_user_id', $payload['userid'])->first();
        if(is_null($user)) {
            \Log::error("WHMCS ChangeMemberPassword: Could not find user.", ['user_id' => $user->id]);
            return false;
        }
        $user->bindLdapUser();

        try {
            $adUser = new ADUser($user, $this->adldap);
            $adUser->changePassword($payload['password']);
        } catch(\Exception $e) {
            \Log::error("WHMCS ChangeMemberPassword: Could not change password in ActiveDirectory", ['user_id' => $user->id]);
            return false;
        }

    }
}
