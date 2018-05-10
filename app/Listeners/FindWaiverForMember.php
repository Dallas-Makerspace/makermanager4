<?php

namespace App\Listeners;

use App\Events\Whmcs\ClientAdd;
use App\SmartwaiverData;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class FindWaiverForMember
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
     * @param  ClientAdd  $event
     * @return void
     */
    public function handle(ClientAdd $event)
    {
        $email = $event->payload['email'];
        
        $user = User::where('email', $email)->first();
        if(is_null($user)) {
            return true;
        }
        
        $waiver = SmartwaiverData::where('email', $email)->first();
        if(is_null($waiver)) {
            return true;
        }
        
        $user->waiver_id = $waiver->waiverId;
        $user->save();
    }
}
