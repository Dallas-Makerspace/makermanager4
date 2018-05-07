<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SmartwaiverData extends Model
{
    protected $table = "smartwaiver_data";

    protected $primaryKey = "waiverId";

    public $timestamps = false;
}
