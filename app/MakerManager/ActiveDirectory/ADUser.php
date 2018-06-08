<?php

namespace MakerManager\ActiveDirectory;

use Adldap\Adldap;
use Adldap\AdldapInterface;
use App\Badge;
use App\User;

class ADUser
{
    /**
     * @var Adldap
     */
    protected $ldap;
    /**
     * @var User
     */
    protected $eloquentUser;

    /**
     * @var
     */
    protected $adUser;

    public function __construct(User $user, AdldapInterface $adldap)
    {
        $this->ldap = $adldap;
        $this->eloquentUser = $user;
        $this->adUser = $this->eloquentUser->ldap;
    }

    public function create()
    {
        // Check existence of user first
        if($this->exists()) {
            return $this->update();
        }

        $user = $this->ldap->make()->user([
            'cn' => $this->eloquentUser->first_name . ' ' . $this->eloquentUser->last_name,
            'description' => $this->eloquentUser->whmcs_user_id,
            'change_password' => 0,
            'enabled' => 0,
            'display_name' => $this->eloquentUser->first_name . ' ' . $this->eloquentUser->last_name,
            'firstname' => $this->eloquentUser->first_name,
            'surname' => $this->eloquentUser->last_name,
            'email' => $this->eloquentUser->email,
            'address_street' => $this->eloquentUser->address_1 . ' ' . $this->eloquentUser->address_2,
            'address_city' => $this->eloquentUser->city,
            'address_state' => $this->eloquentUser->state,
            'address_code' => $this->eloquentUser->zip,
            'telephone' => $this->eloquentUser->phone,
            'container' => array('Members'),
            'username' => $this->eloquentUser->username,
            'logon_name' => $this->eloquentUser->username . "@dms.local",
            'password' => str_random(10) // this should be set with changePassword() next
        ]);

        if ( ! $user->save()) {
            \Log::error('Failed to add user to ActiveDirectory');
        }

        return $user;
    }

    public function update()
    {
        if($this->exists() === false) {
            throw new \Exception("User does not exist.");
        }

        $this->adUser->fill([
            'description' => $this->eloquentUser->whmcs_user_id,
            'display_name' => $this->eloquentUser->first_name . ' ' . $this->eloquentUser->last_name,
            'firstname' => $this->eloquentUser->first_name,
            'surname' => $this->eloquentUser->last_name,
            'email' => $this->eloquentUser->email,
            'address_street' => $this->eloquentUser->address_1 . ' ' . $this->eloquentUser->address_2,
            'address_city' => $this->eloquentUser->city,
            'address_state' => $this->eloquentUser->state,
            'address_code' => $this->eloquentUser->zip,
            'telephone' => $this->eloquentUser->phone,
        ]);

        return $this->adUser->save();
    }

    /**
     * Determine if user exists in ActiveDirectory
     * @return bool
     */
    public function exists() : bool
    {
        $user = $this->ldap->search()->find($this->eloquentUser->fullName());
        if(is_null($user)) {
            return false;
        }

        return $user->exists;
    }

    public function changePassword($newPassword)
    {
        if($this->exists() === false) {
            throw new \Exception("User does not exist.");
        }

        return $this->adUser->setPassword($newPassword)->save();
    }

    public function addBadge(Badge $badge)
    {
        if($this->exists() === false) {
            throw new \Exception("User does not exist.");
        }

        return $this->adUser->setAttribute('employee_id', $badge->number)->save();
    }

    public function enable()
    {
        if($this->exists() === false) {
            throw new \Exception("User does not exist.");
        }

        return $this->adUser->setAttribute('enabled', true)->save();
    }

    public function disable()
    {
        if($this->exists() === false) {
            throw new \Exception("User does not exist.");
        }

        return $this->adUser->setAttribute('enabled', true)->save();
    }

    public function getGroups()
    {

    }

    public function addGroup($groupName)
    {
        $group = $this->ldap->search()->groups()->where([
            'cn' => $groupName
        ])->first();

        return $group->addMember($this->eloquentUser->ldap);
    }

    public function removeGroup($groupName)
    {
        $group = $this->ldap->search()->groups()->where([
            'cn' => $groupName
        ])->first();

        return $group->removeMember($this->eloquentUser->ldap);
    }

}