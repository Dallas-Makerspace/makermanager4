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

    protected $dates = [
        'created',
        'modified',
        'voting_enabled_at'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'phone',
        'email',
        'address_1',
        'address_2',
        'city',
        'state',
        'zip',
        'password',
        'whmcs_user_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

//    public function isAdmin()
//    {
//        if(is_null($this->ldap)) {
//            $this->bindLdapUser();
//        }
//
//        return $this->ldap->inGroup("MakerManager Admins");
//    }

    public function bindLdapUser()
    {
        $ldapUser = app('adldap')->search()->where('samaccountname', '=', $this->username)->first();

        $this->setLdapUser($ldapUser);
    }

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

    public function family()
    {
        return $this->hasMany(User::class);
    }

    public function unusedFamilyBadges()
    {
        return Badge::where('whmcs_user_id', $this->whmcs_user_id)->whereNull('user_id')->get();
    }

    public function getLdapGroupsByParent()
    {
        if(is_null($this->ldap)) {
            $this->bindLdapUser();
        }

        return $this->ldap->getGroups();

        $categories = [];
        $groups = $this->ldap->getGroups();
        foreach(collect($groups) as $group) {
            $dn = explode(',', $group->getDistinguishedName());

            $parsedDn = [];
            foreach($dn as $toParse) {
                $e = explode('=', $toParse);
                $parsedDn[$e[0]] = $e[1];
            }
            dd($parsedDn);
            $categories = collect($dn)->keyBy(function($item) {

            });
            if(empty($categories)) {
                // ???
            }
            dd($categories);

            $d = $categories->slice(1, -2);

            echo($d->toJson());
        }
        exit;
    }
  
    public function votingRegistrationLogs()
    {
        return $this->hasMany(LogVotingRegistration::class);
    }
}
