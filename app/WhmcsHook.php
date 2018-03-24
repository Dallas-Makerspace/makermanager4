<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WhmcsHook extends Model
{
    protected $table = "whmcs_hooks";

    protected $casts = [
        'payload' => 'array'
    ];
}
