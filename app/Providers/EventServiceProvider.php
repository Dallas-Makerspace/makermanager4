<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        /**
         * Whmcs Events
         */
        'App\Events\Whmcs\AddonActivation' => [
            'App\Listeners\Whmcs\CreateAddon'
        ],
        'App\Events\Whmcs\AddonCancelled' => [
            'App\Listeners\Whmcs\CancelAddon'
        ],
        'App\Events\Whmcs\ClientAdd' => [
//            'App\Listeners\AddMember',
//            'App\Listeners\FindWaiverForMember',
            'App\Listeners\Whmcs\CreateMember'
        ],
        'App\Events\Whmcs\ClientChangePassword' => [
            'App\Listeners\Whmcs\ChangeMemberPassword'
        ],
        'App\Events\Whmcs\ClientEdit' => [
            'App\Listeners\Whmcs\ChangeMember'
        ],
        'App\Events\Whmcs\InvoicePaid' => [
//            'App\Listeners\Whmcs\InvoicePaid'
        ],
        'App\Events\Whmcs\AfterModuleCreate' => [
            // Don't need to do anything with this now
//            'App\Listeners\Whmcs\AfterModuleCreate'
        ],
        'App\Events\Whmcs\AfterModuleSuspend' => [
            'App\Listeners\Whmcs\SuspendMember'
        ],
        'App\Events\Whmcs\AfterModuleTerminate' => [
            'App\Listeners\Whmcs\SuspendMember'
        ],
        'App\Events\Whmcs\AfterModuleUnsuspend' => [
            'App\Listeners\Whmcs\UnsuspendMember'
        ],

        /**
         * SmartWaiver Events
         */
        'App\Events\WaiverSigned' => [
            'App\Listeners\InsertWaiver'
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
