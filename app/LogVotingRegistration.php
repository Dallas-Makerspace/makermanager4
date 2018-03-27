<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogVotingRegistration extends Model
{
    protected $table = "log_voting_registrations";

    protected $fillable = [
        'id',
        'user_id',
        'change',
        'ip'
    ];
}
