<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Smartwaiver\Smartwaiver;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getHome()
    {
        $user = auth()->user();

        return view('user.homepage')->with('user', $user);
    }

    public function getWaiver()
    {
        return view('waiver');
    }

    public function postWaiver(Smartwaiver $waiverApi)
    {
        $user = auth()->user();
        if( ! is_null($user->waiver_id)) {
            return redirect('/')->with('success', 'Waiver already signed.');
        }

        // search for waiver
        $syncSearch = $waiverApi->search("", "","",$user->first_name,$user->last_name);
        $results = $waiverApi->searchResultByGuid($syncSearch->guid, 0);

        foreach($results as $result) {
            if($result->email === $user->email) {
                $user->waiver_id = $result->waiverId;
                $user->save();

                return redirect()->to('/')->with('success', 'Successfully found waiver!');
            }
        }

        return redirect()->to('/waiver')->withErrors(['No waivers found for you...']);
    }


}
