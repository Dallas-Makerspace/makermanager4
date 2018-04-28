<?php
namespace App\Http\Controllers\Api\v1;

use App\SmartwaiverHook;
use Illuminate\Http\Request;

class SmartwaiverController extends Controller
{

    public function postProcessHook(Request $request)
    {
        $request->validate([
            'unique_id' => 'required',
            'event' => 'required',
            'credential' => 'required'
        ]);

        // Verify credentials
        $privateKey = config('services.smartwaiver.private_key');

        $expected = md5($privateKey . $request->get('unique_id'));
        if($expected !== $request->get('credential')) {
            return response('Not authorized.', 401);
        }

        $hook = new SmartwaiverHook();
        $hook->hook = $request->get('event');
        $hook->unique_id = $request->get('unique_id');
        $hook->save();

        return response('', 200);
    }

}