<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use App\User;
use Smartwaiver\Smartwaiver;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getUserPage()
    {
        $user = auth()->user();

        return redirect('/users/' . $user->id);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ( ! auth()->user()->is_admin ) {
            return $this->getUserPage();
        }

        $users = User::paginate(30);

        return view('user.index')
            ->with('users', $users);
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function anyData()
    {
        return Datatables::of(User::query())
            ->addColumn('action', function ($user) {
                return '<a href="/users/' . $user->id . '" class="btn btn-sm btn-primary">Edit</a>';
            })
            ->setRowClass(function ($user) {
                return $user->ad_active ? '' : 'table-danger';
            })
            ->make(true);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $this->authorize('view', $user);

        $user->bindLdapUser();

        return view('user.show')->with('user', $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);

        $user->bindLdapUser();

        return view('user.edit')->with('user', $user);
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
        $this->authorize('update', $user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->authorize('destroy', $user);
    }

    public function getWaiver()
    {
        return view('waiver');
    }

    public function postWaiver(Smartwaiver $waiverApi)
    {
        $user = auth()->user();
        if (!is_null($user->waiver_id)) {
            return redirect('/')->with('success', 'Waiver already signed.');
        }

        // search for waiver
        $syncSearch = $waiverApi->search("", "", "", $user->first_name, $user->last_name);
        $results = $waiverApi->searchResultByGuid($syncSearch->guid, 0);

        foreach ($results as $result) {
            if ($result->email === $user->email) {
                $user->waiver_id = $result->waiverId;
                $user->save();

                return redirect()->to('/')->with('success', 'Successfully found waiver!');
            }
        }

        return redirect()->to('/waiver')->withErrors(['No waivers found for you...']);
    }


}
