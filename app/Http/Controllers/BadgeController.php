<?php

namespace App\Http\Controllers;

use App\Badge;
use App\BadgeHistory;
use Illuminate\Http\Request;
use MakerManager\BadgeService;

class BadgeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $badge = auth()->user()->badge;
        $familyBadges = [];

        return view('badge.index')
            ->with('badge', $badge);
    }

    public function postEnable(Request $request)
    {
        $request->validate([
            'badge_number' => 'required|alphanum'
        ]);

        if(Badge::where('number', $request->get('badge_number'))->first() !== null) {
            return redirect('/badges');
        }

        $badgeNumber = str_pad($request->get('badge_number'), 10, 0, STR_PAD_LEFT);

        // binary 24 bits long
        // take first octet turn that into decimal
        // take next 16 into decimal
        // remove 0's from both
        // concat

        $badge = new Badge();
        $badge->number = $badgeNumber;
        $badge->status = 'active';

        $badge->whmcs_user_id = 0;
        $badge->whmcs_service_id = 0;
        $badge->whmcs_addon_id = 0;

        // SELECT * FROM tblhosting WHERE domainstatus = 'active' AND userid = $user->whmcs_user_id

        auth()->user()->badge()->save($badge);

        $badge->activate();

        return redirect('/');
    }

    public function postDisable(Request $request)
    {
        $request->validate([
            'badge_id' => 'required|exists:badges,id',
            'reason_id' => 'required|numeric'
        ]);

        $reasons = [
            0 => 'Disabled by admin',
            1 => 'Lost',
            2 => 'Damaged',
            3 => 'Other'
        ];

        $badge = Badge::find($request->get('badge_id'));

        // The primary member can disable addons badges
        $badge->deactivate($reasons[$request->get('reason_id')]);

        return redirect('/');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Badge  $badge
     * @return \Illuminate\Http\Response
     */
    public function show(Badge $badge)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Badge  $badge
     * @return \Illuminate\Http\Response
     */
    public function edit(Badge $badge)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Badge  $badge
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Badge $badge)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Badge  $badge
     * @return \Illuminate\Http\Response
     */
    public function destroy(Badge $badge)
    {
        //
    }
}
