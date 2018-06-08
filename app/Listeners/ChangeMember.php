<?php

namespace App\Listeners;

use Adldap\Adldap;
use App\Events\Whmcs\ClientEdit;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use MakerManager\ActiveDirectory\ADUser;

class ChangeMember
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
     * @param  ClientEdit  $event
     * @return void
     */
    public function handle(ClientEdit $event)
    {
        $payload = $event->payload;

        $user = User::where('whmcs_user_id', $payload['userid'])->first();

        $importMap = [
            'firstname' => 'first_name',
            'lastname' => 'last_name',
            'email' => 'email',
            'phonenumber' => 'phone',
            'address1' => 'address_1',
            'address2' => 'address_2',
            'city' => 'city',
            'state' => 'state',
            'postcode' => 'zip'
        ];
        $newData = [];

        foreach ($importMap as $search => $assign) {
            if (!empty($payload[$search])) {
                $newData[$assign] = $payload[$search];
            }
        }

        $user->fill($newData);
        $user->save();

        $adUser = new ADUser($user, $this->adldap);
        $adUser->update();

        return true;
    }
}
