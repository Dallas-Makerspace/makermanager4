<?php
/**
 * Application Controller Class with Rest Extentions
 * @package App\Controller\Api\AppController
 */

namespace App\Controller\Api;

use App\User;
use App\MakerManager\ActiveDirectory\ADUser as ADUser;

use App\Controller\Api\AppController;

/**
 * Extends AppController to provide Membership Collection
 */

class MebershipsController extends AppController
{
    public $paginate = [
        'page' => 1,
        'limit' => 5,
        'maxLimit' => 15,
        'sortWhitelist' => [
            'id', 'name'
        ]
    ];
    
    public $data = ADUser(auth()->user(), app('adldap'))->getGroups();
    
}
