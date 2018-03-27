<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogVotingMail extends Model
{
    protected $table = 'log_voting_mails';

    protected $fillable = [
        'id',
        'user_id',
        'lob_id',
        'expected_delivery_date'
    ];
}
