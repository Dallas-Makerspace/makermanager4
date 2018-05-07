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
        ],
        'App\Events\Whmcs\AddonCancelled' => [
            // 'App\Listeners\SuspendMember', - This uses a different payload
        ],
        'App\Events\Whmcs\ClientAdd' => [
            'App\Listeners\AddMember',
        ],
        'App\Events\Whmcs\ClientChangePassword' => [
            'App\Listeners\ChangeMemberPassword',
        ],
        'App\Events\Whmcs\ClientEdit' => [
        ],
        'App\Events\Whmcs\InvoicePaid' => [
        ],
        'App\Events\Whmcs\AfterModuleCreate' => [
        ],
        'App\Events\Whmcs\AfterModuleSuspend' => [
            'App\Listeners\SuspendMember',
        ],
        'App\Events\Whmcs\AfterModuleTerminate' => [
            'App\Listeners\SuspendMember',
        ],
        'App\Events\Whmcs\AfterModuleUnsuspend' => [
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
