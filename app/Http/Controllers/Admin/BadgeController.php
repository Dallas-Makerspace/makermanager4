<?php

namespace App\Http\Controllers\Admin;

use App\Badge;
use App\BadgeHistory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use MakerManager\BadgeService;
use Yajra\DataTables\DataTables;

class BadgeController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.badge.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'number' => 'required'
        ]);

        $b = new Badge();
        $b->user_id = 0;
        $b->description = 'Badge assigned by user.id=' . auth()->user()->id;
        $b->whmcs_user_id = 0;
        $b->whmcs_service_id = 0;
        $b->whmcs_addon_id = 0;
        $b->number = $request->get('number');
        $b->status = 'active';

        try {
            $b->save();

            $badgeService = new BadgeService($b);
            $badgeService->activate();
        } catch(\Exception $e) {
            return redirect()->back()->withErrors($e);
        }

        $history = new BadgeHistory();
        $history->badge_id = $b->id;
        $history->badge_number = $b->number;
        $history->modified_by = auth()->user()->id;
        $history->changed_to = 'active';
        $history->save();

        return redirect('/admin/badges/' . $b->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Badge  $badge
     * @return \Illuminate\Http\Response
     */
    public function show(Badge $badge)
    {
        return view('admin.badge.show')->with('badge', $badge);
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
