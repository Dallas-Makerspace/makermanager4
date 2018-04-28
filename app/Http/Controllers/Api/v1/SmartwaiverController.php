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


        $hook = new SmartwaiverHook();
        $hook->hook = $request->get('event');
        $hook->unique_id = $request->get('unique_id');
        $hook->save();

        return response('', 200);
    }

}