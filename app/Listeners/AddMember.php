<?php

namespace App\Listeners;

use Adldap\Adldap;
use App\Events\Whmcs\ClientAdd;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use MakerManager\ActiveDirectory\ADUser;

class AddMember
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
     * @param  ClientAdd  $event
     * @return void
     */
    public function handle(ClientAdd $event)
    {
        $payload = $event->payload;

        $user = User::firstOrNew(['whmcs_user_id' => $payload['userid']]);

        $user->first_name = $payload['firstname'];
        $user->last_name = $payload['lastname'];
        $user->username = strtolower($payload['customfields'][2]);
        $user->email = $payload['email'];
        $user->phone = $payload['phonenumber'];
        $user->address_1 = $payload['address1'];
        $user->address_2 = $payload['address2'];
        $user->city = $payload['city'];
        $user->state = $payload['state'];
        $user->zip = $payload['postcode'];
        $user->whmcs_user_id = $payload['userid'];

        $created = $user->save();
        if($created === false) {
            \Log::error("Error creating user in MakerManager.");

            return false;
        }

        $adUser = new ADUser($user, $this->adldap);
        $adUser->create();

        $adUser->changePassword($payload['password']);

        return true;
    }
}
