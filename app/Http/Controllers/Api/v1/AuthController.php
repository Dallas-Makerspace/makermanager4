<?php
namespace App\Http\Controllers\Api\v1;

use App\SmartwaiverHook;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function postCheckCredentials(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $login = \Auth::attempt([
            'username' => $request->get('username'),
            'password' => $request->get('password'),
        ]);

        return response()->json(['status' => $login]);
    }

}