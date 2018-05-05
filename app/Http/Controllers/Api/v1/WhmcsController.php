<?php
namespace App\Http\Controllers\Api\v1;

use App\WhmcsHook;
use Illuminate\Http\Request;

class WhmcsController extends Controller
{

    public function postProcessHook(Request $request)
    {
        $request->validate([
            'hook' => 'required',
            'payload' => 'required'
        ]);

        $payload = unserialize(base64_decode($request->get('payload')));

        $hook = new WhmcsHook();
        $hook->hook = $request->get('hook');
        $hook->payload = $payload;
        $hook->save();

        return response('', 200);
    }

}