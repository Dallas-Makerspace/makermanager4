<?php

namespace App\Listeners;

use App\Events\WaiverSigned;
use App\SmartwaiverData;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Smartwaiver\Smartwaiver;

class InsertWaiver
{
    /**
     * @var Smartwaiver
     */
    public $smartWaiver;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Smartwaiver $smartwaiver)
    {
        $this->smartWaiver = $smartwaiver;
    }

    /**
     * Handle the event.
     *
     * @param  WaiverSigned $event
     * @return bool
     * @throws \Smartwaiver\Exceptions\SmartwaiverSDKException
     */
    public function handle(WaiverSigned $event)
    {
        $hook = $event->hook;

        $waiver = $this->smartWaiver->getWaiver($hook->unique_id);

        $record = new SmartwaiverData();
        $record->waiverId = $waiver->waiverId;
        $record->firstName = $waiver->firstName;
        $record->lastName = $waiver->lastName;
        $record->email = $waiver->email;
        $record->birthDate = $waiver->dob;
        $record->dateCompleted = $waiver->createdOn;
        $record->waiverStatus = "Completed At Kiosk";
        $record->documentTitle = $waiver->title;
        $record->checkinCount = 1;
        $record->referralType = $waiver->customWaiverFields[0]->value;
        $record->referralSource = $waiver->customWaiverFields[1]->value;
        $record->requestedWaiverEmail = true;
        $record->guardianFirstName = '';
        $record->guardianLastName = '';

        if ($record->save() === false) {
            return false;
        }

        $event->hook->processed_at = new \DateTime();
        $event->hook->save();

        return true;
    }
}
