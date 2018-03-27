<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogUserVisit extends Model
{
    protected $table = 'log_user_visits';

    protected $fillable = [
        'source',
        'source_id',
        'card_number',
        'source_name',
        'status',
        'door',
        'created_at',
    ];
}
