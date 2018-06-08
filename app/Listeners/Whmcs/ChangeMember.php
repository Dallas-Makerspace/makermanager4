<?php

namespace App\Listeners\Whmcs;

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
        if(is_null($user)) {
            \Log::error("WHMCS ChangeMember: Could not find user.", ['user_id' => $user->id]);
            return false;
        }
        $user->bindLdapUser();

        $whmcsMap = [
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
        $updatedData = [];

        foreach ($whmcsMap as $search => $assign) {
            if (!empty($payload[$search])) {
                $updatedData[$assign] = $payload[$search];
            }
        }

        $user->fill($updatedData);
        $user->save();


        try {
            $adUser = new ADUser($user, $this->adldap);
            $adUser->update();
        } catch(\Exception $e) {
            \Log::error("WHMCS ChangeMember: Could not update attributes in ActiveDirectory", ['user_id' => $user->id]);
            return false;
        }

    }
}
