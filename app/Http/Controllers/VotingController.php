<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use MakerManager\ActiveDirectory\ADUser;
use MakerManager\VotingEligibility;

class VotingController extends Controller
{
    public function getIndex(Request $request)
    {
        $user = auth()->user();
        $hasVotingRights = $user->ldap->inGroup('Voting Members');

        $hasVotingRights = false;
        if (!$hasVotingRights) {
            $votingEligibility = new VotingEligibility($user);

            return view('voting.requirements')->with('votingEligibility', $votingEligibility);
        }

        return view('voting.index')->with(['hasVotingRights' => $hasVotingRights]);
    }

    public function postEnable(Request $request)
    {
        $user = auth()->user();
        $adUser = new ADUser($user, app('adldap'));

        $votingEligibility = new VotingEligibility($user);
        if($votingEligibility == false) {
            return redirect()->to('/voting')->withErrors(['You do not meet the requirements to register to vote.']);
        }

        try {
            $adUser->addGroup("Voting Members");
        } catch(\Exception $e) {
            return redirect()->back()->withErrors(['There was an error adding you to the Voting Members group.']);
        }

        return redirect('/voting');
    }

    public function postDisable(Request $request)
    {
        $user = auth()->user();
        $adUser = new ADUser($user, app('adldap'));

        try {
            $adUser->removeGroup("Voting Members");
        } catch(\Exception $e) {
            return redirect()->back()->withErrors(['There was an error removing you from the Voting Members group.']);
        }

        return redirect('/voting');
    }
}
