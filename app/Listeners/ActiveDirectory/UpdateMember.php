<?php

namespace App\Listeners\ActiveDirectory;

use App\Events\AfterModuleTerminate;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateMember
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
    public function handle(AfterModuleTerminate $event)
    {
        $adUser = new ADUser($event->user, $this->ad);
    }
}
