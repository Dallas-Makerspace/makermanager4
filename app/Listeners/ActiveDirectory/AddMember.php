<?php

namespace App\Listeners\ActiveDirectory;

use App\Events\MemberAdded;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use MakerManager\ActiveDirectory\ADUser;

class AddMember
{
    /**
     * The ActiveDirectory instance
     * @var \Adldap
     */
    private $ad;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(\Adldap\Adldap $ad)
    {
        $this->ad = $ad;
    }

    /**
     * Handle the event.
     *
     * @param  MemberAdded  $event
     * @return void
     */
    public function handle(MemberAdded $event)
    {
        $adUser = new ADUser($event->user, $this->ad);

        $adUser->create();
    }
}
