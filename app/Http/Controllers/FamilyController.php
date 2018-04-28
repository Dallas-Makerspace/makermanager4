<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateFamilyRequest;
use App\User;
use Illuminate\Http\Request;
use MakerManager\ActiveDirectory\ADUser;

class FamilyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('family.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateFamilyRequest $request)
    {
        $family = new User();
        $user = auth()->user();

        $family->first_name = $request->get('first_name');
        $family->last_name = $request->get('last_name');
        $family->phone = $request->get('phone');
        $family->email = $request->get('email');
        $family->username = mb_strtolower($request->get('username'));
        $family->address_1 = $user->address_1;
        $family->address_2 = $user->address_2;
        $family->city = $user->city;
        $family->state = $user->state;
        $family->zip = $user->zip;
        $family->user_id = $user->id;
        $family->whmcs_user_id = $user->whmcs_user_id;
        $family->ad_active = false;
        $family->is_admin = false;

        auth()->user()->family()->save($family);

        event(new MemberCreated);

        return redirect('/family/' . $user->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $user->bindLdapUser();

        return view('user.homepage')->with('user', $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
