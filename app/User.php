<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Adldap\Laravel\Traits\HasLdapUser;

class User extends Authenticatable
{
    use Notifiable;
    use HasLdapUser;

    public $remember_token = false;
    public $timestamps = false;


    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'created';

    /**
     * The name of the "updated at" column.
     *
     * @var string
     */
    const UPDATED_AT = 'modified';



    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function fullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Get the primary badge for a user.
     *
     * Although the user can technically have multiple badges, the system is only setup for one.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function badge()
    {
        return $this->hasOne(Badge::class);
    }
}
