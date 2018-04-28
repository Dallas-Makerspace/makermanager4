<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class LogisticsController extends Controller
{
    public function getBinAudit()
    {
        return view('logistics.bin-audit');
    }

    public function postBinAudit(Request $request)
    {
        $request->validate([
            'scan' => 'required',
        ]);

        $exploded = explode(',', $request->get('scan'));

        $data = [
            'w' => $exploded[0],
            'rfid' => $exploded[1],
            'phone' => $exploded[2],
            'email' => $exploded[3],
            'username' => $exploded[4],
        ];

        $user = User::where('email', $data['email'])->first();
        if(is_null($user)) {
            return redirect('/logistics/bin-audit')->withErrors(['This person is not a member.']);
        }

        $request->session()->flash('success', 'This person is a member.');

        return redirect('/logistics/bin-audit');

    }
}
