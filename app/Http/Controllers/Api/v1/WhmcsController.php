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

        $hook = new WhmcsHook();
        $hook->hook = $request->get('hook');
        $hook->payload = $request->get('payload');
        $hook->save();

        return response('', 200);
    }

}