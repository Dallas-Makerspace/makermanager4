<?php

namespace MakerManager;


use App\User;
use Carbon\Carbon;

class VotingEligibility
{
    public $user;

    /**
     * If user is not eligible to vote, why?
     *
     * @var array
     */
    protected $reasons = [];

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function check()
    {
        return $this->checkBillPayment() && $this->checkNotAnAddon();
    }

    /**
     * WHMCS Requirements are:
     *  - if monthly ($50,$40,$30)
     *    - if last invoices before current day paid == true
     *    - if less than 3 invoices paid, check first invoice `datepaid` and calculate 90 days == true
     *  - if yearly
     *    - if last two invoices before current day paid == true
     *    - if less than two, check invoice `datepaid` and calculate 90 days == true
     */
    public function checkBillPayment(): bool
    {
        $invoices = \DB::connection('whmcs')
            ->table('tblinvoices')
            ->join('tblinvoiceitems', 'tblinvoices.id', '=', 'tblinvoiceitems.invoiceid')
            ->where('tblinvoices.userid', $this->user->whmcs_user_id)
            ->where('tblinvoices.duedate', '<', date('Y-m-d'))
            ->orderBy('tblinvoices.date', 'desc')
            ->get();

        $paid = 0;

        // quick check for older yearly
        $daysPaid = 0;
        $lastDatePaid = new Carbon();
        foreach($invoices as $invoice) {
            if($invoice->datepaid instanceof Carbon && $lastDatePaid->diffInDays(new Carbon($invoice->datepaid)) > 34) {
                // if any gap in billing reset their paid days
                $daysPaid = 0;
            } else {
                $daysPaid += (new Carbon)->diffInDays(new Carbon($invoice->datepaid));
            }
            $lastDatePaid = new Carbon($invoice->datepaid);

            // echo "{$daysPaid} {$lastDatePaid} <br>";

            if($daysPaid > 90) {
                return true;
            }

        }
        // If we get to the end of invoices without having greater than 90 days they're not paid up
        return false;
    }

    /**
     * Ensures member is not an addon
     *
     * If user_id is not null, they are not a primary account
     */
    public function checkNotAnAddon(): bool
    {
        return $this->user->user_id == null;
    }

    public function getDaysPaid() : int
    {
        $invoices = \DB::connection('whmcs')
            ->table('tblinvoices')
            ->join('tblinvoiceitems', 'tblinvoices.id', '=', 'tblinvoiceitems.invoiceid')
            ->where('tblinvoices.userid', $this->user->whmcs_user_id)
            ->where('tblinvoices.duedate', '<', date('Y-m-d'))
            ->orderBy('tblinvoices.date', 'desc')
            ->get();

        $paid = 0;

        // quick check for older yearly
        $daysPaid = 0;
        $lastDatePaid = new Carbon();
        foreach($invoices as $invoice) {
            $thisDatePaid = new Carbon($invoice->datepaid);
            if($lastDatePaid->diffInDays($thisDatePaid) > 34) {
                // if any gap in billing reset their paid days
                $daysPaid = 0;
            } else {
                $daysPaid += $lastDatePaid->diffInDays($thisDatePaid);
            }
            // For debugging
            // echo "{$thisDatePaid} - {$lastDatePaid} = {$lastDatePaid->diffInDays($thisDatePaid)} <br>";
            $lastDatePaid = $thisDatePaid;
        }

        return $daysPaid;
    }


}