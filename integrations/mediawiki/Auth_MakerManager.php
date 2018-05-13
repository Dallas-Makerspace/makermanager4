<?php


define("MM4_URL", "https://makermanager.dallasmakerspace.org/");
define("MM4_USERNAME", "");
define("MM4_PASSWORD", "");

/**
 * This file makes MediaWiki use MakerManager for authentication.
 *
 * This project was forked from
 * https://github.com/Digitalroot/MediaWiki_PHPBB_Auth
 *
 * Below is the original license.
 */


    /**
     * This file makes MediaWiki use a phpbb user database to
     * authenticate with. This forces users to have a PHPBB account
     * in order to log into the wiki. This can also force the user to
     * be in a group called Wiki.
     *
     * With 3.0.x release this code was rewritten to make better use of
     * objects and php5. Requires MediaWiki 1.11.x, PHPBB3 and PHP5.
     *
     * This program is free software; you can redistribute it and/or modify
     * it under the terms of the GNU General Public License as published by
     * the Free Software Foundation; either version 2 of the License, or
     * (at your option) any later version.
     *
     * This program is distributed in the hope that it will be useful,
     * but WITHOUT ANY WARRANTY; without even the implied warranty of
     * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
     * GNU General Public License for more details.
     *
     * You should have received a copy of the GNU General Public License along
     * with this program; if not, write to the Free Software Foundation, Inc.,
     * 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
     * http://www.gnu.org/copyleft/gpl.html
     *
     * @package MediaWiki
     * @subpackage Auth_makerManager
     * @author Nicholas Dunnaway
     * @copyright 2004-2016 Digitalroot Technologies
     * @license http://www.gnu.org/copyleft/gpl.html
     * @link https://github.com/Digitalroot/MediaWiki_PHPBB_Auth
     * @link http://digitalroot.net/
     *
     */

// error_reporting(E_ALL); // Debug

// First check if class and interface has already been defined.
if (!class_exists('AuthPlugin') || !interface_exists('iAuthPlugin'))
{
    /**
     * Auth Plug-in
     *
     */
    require_once './includes/AuthPlugin.php';

    /**
     * Auth Plug-in Interface
     *
     */
    require_once './extensions/Auth_MakerManager/iAuthPlugin.php';

}

// First check if the PasswordHash class has already been defined.
if (!class_exists('PasswordHash'))
{
    /**
     * PasswordHash Class
     *
     * Portable PHP password hashing framework.
     *
     * Written by Solar Designer <solar at openwall.com> in 2004-2006
     * and placed in the public domain.
     *
     * The homepage URL for this framework is:
     *      http://www.openwall.com/phpass/
     *
     */
    require_once './extensions/Auth_MakerManager/PasswordHash.php';
}

/**
 * Handles the Authentication with the PHPBB database.
 *
 */
class Auth_MakerManager extends AuthPlugin implements iAuthPlugin
{

    /**
     * This turns on and off printing of debug information to the screen.
     *
     * @var bool
     */
    private $_debug = false;

    /**
     * Message user sees when logging in.
     *
     * @var string
     */
    private $_LoginMessage;

    /**
     * MakerManager URL.
     *
     * @var string
     */
    private $_MakerManager_Url;

    /**
     * MakerManager Key.
     *
     * @var string
     */
    private $_MakerManager_Key;

    /**
     * UserID of our current user.
     *
     * @var int
     */
    private $_UserID;

    /**
     * Constructor
     *
     * @param array $aConfig
     */

    function __construct($aConfig)
    {
        // Read config
        $this->_MakerManager_Key    = $aConfig['MakerManager_Key'];
        $this->_MakerManager_Url   = $aConfig['MakerManager_Url'];
        $this->_LoginMessage    = $aConfig['LoginMessage'];

        // Set some MediaWiki Values
        // This requires a user be logged into the wiki to make changes.
        $GLOBALS['wgGroupPermissions']['*']['edit'] = false;

        // Specify who may create new accounts:
        $GLOBALS['wgGroupPermissions']['*']['createaccount'] = false;
        $GLOBALS['wgGroupPermissions']['*']['autocreateaccount'] = true;

        // Load Hooks
        $GLOBALS['wgHooks']['UserLoginForm'][]      = array($this, 'onUserLoginForm', false);
        $GLOBALS['wgHooks']['UserLoginComplete'][]  = $this;
        $GLOBALS['wgHooks']['UserLogout'][]         = $this;
    }


    /**
     * Allows the printing of the object.
     *
     */
    public function __toString()
    {
        echo '<pre>';
        print_r($this);
        echo '</pre>';
    }


    /**
     * Add a user to the external authentication database.
     * Return true if successful.
     *
     * NOTE: We are not allowed to add users to MakerManager from the
     * wiki so this always returns false.
     *
     * @param User $user - only the name should be assumed valid at this point
     * @param string $password
     * @param string $email
     * @param string $realname
     * @return bool
     * @access public
     */
    public function addUser( $user, $password, $email='', $realname='' )
    {
        return false;
    }


    /**
     * Can users change their passwords?
     *
     * @return bool
     */
    public function allowPasswordChange()
    {
        return false;
    }


    /**
     * Check if a username+password pair is a valid login.
     * The name will be normalized to MediaWiki's requirements, so
     * you might need to munge it (for instance, for lowercase initial
     * letters).
     *
     * @param string $username
     * @param string $password
     * @return bool
     * @access public
     * @todo Check if the password is being changed when it contains a slash or an escape char.
     */
    public function authenticate($username, $password)
    {
        $ch = curl_init();

        $request = json_encode([
            'username' => $username,
            'password' => $password
        ]);

        curl_setopt_array($ch, [
            CURLOPT_URL => MM4_URL . 'api/v1/auth/check-credentials',
            CURLOPT_USERPWD => MM4_USERNAME . ":" . MM4_PASSWORD,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => [
                "Accept: application/json",
                'Content-Type: application/json',
                'Content-Length: ' . strlen($request)
            ],
            CURLOPT_POSTFIELDS => $request
        ]);

        $output = curl_exec($ch);

        // close curl resource to free up system resources
        curl_close($ch);

        $data = json_decode($output);
        if( ! isset($data['status']) || $data['status'] !== true) {
            return false;
        }

        return true;
    }


    /**
     * Return true if the wiki should create a new local account automatically
     * when asked to login a user who doesn't exist locally but does in the
     * external auth database.
     *
     * If you don't automatically create accounts, you must still create
     * accounts in some way. It's not possible to authenticate without
     * a local account.
     *
     * This is just a question, and shouldn't perform any actions.
     *
     * NOTE: I have set this to true to allow the wiki to create accounts.
     *       Without an accout in the wiki database a user will never be
     *       able to login and use the wiki. I think the password does not
     *       matter as long as authenticate() returns true.
     *
     * @return bool
     * @access public
     */
    public function autoCreate()
    {
        return true;
    }


    /**
     * Check to see if external accounts can be created.
     * Return true if external accounts can be created.
     *
     * NOTE: We are not allowed to add users to phpBB from the
     * wiki so this always returns false.
     *
     * @return bool
     * @access public
     */
    public function canCreateAccounts()
    {
        return false;
    }

    /**
     * This turns on debugging
     *
     */
    public function EnableDebug()
    {
        $this->_debug = true;
        return;
    }


    /**
     * If you want to munge the case of an account name before the final
     * check, now is your chance.
     *
     * @return string
     */
    public function getCanonicalName( $username )
    {
        return $username;
    }


    /**
     * When creating a user account, optionally fill in preferences and such.
     * For instance, you might pull the email address or real name from the
     * external user database.
     *
     * The User object is passed by reference so it can be modified; don't
     * forget the & on your function declaration.
     *
     * NOTE: This gets the email address from PHPBB for the wiki account.
     *
     * @param User $user
     * @param $autocreate bool True if user is being autocreated on login
     * @access public
     */
    public function initUser( &$user, $autocreate=false )
    {

    }


    /**
     * Modify options in the login template.
     *
     * NOTE: Turned off some Template stuff here. Anyone who knows where
     * to find all the template options please let me know. I was only able
     * to find a few.
     *
     * @param UserLoginTemplate $template
     * @param $type String:  'signup' or 'login' (added in 1.16).
     * @access public
     */
    public function modifyUITemplate( &$template, &$type )
    {
        if ($type == 'login')
        {
            $template->set('usedomain',   false); // We do not want a domain name.
            $template->set('create',      true); // Remove option to create new accounts from the wiki.
            $template->set('useemail',    false); // Disable the mail new password box.
        }
    }


    /**
     * This prints an error when a MySQL error is found.
     *
     * @param string $message
     * @access public
     */
    private function mySQLError( $message )
    {
        throw new Exception('MySQL error: ' . $message . '<br /><br />');
    }


    /**
     * This is the hook that runs when a user logs in. This is where the
     * code to auto log-in a user to phpBB should go.
     *
     * Note: Right now it does nothing,
     *
     * @param object $user
     * @return bool
     */
    public function onUserLoginComplete(&$user)
    {
        // @ToDo: Add code here to auto log into the forum.
        return true;
    }


    /**
     * Here we add some text to the login screen telling the user
     * they need a phpBB account to login to the wiki.
     *
     * Note: This is a hook.
     *
     * @param string $errorMessage
     * @param object $template
     * @return bool
     */
    public function onUserLoginForm($errorMessage = false, $template)
    {
        $template->data['link'] = $this->_LoginMessage;

        // If there is an error message display it.
        if ($errorMessage)
        {
            $template->data['message'] = $errorMessage;
            $template->data['messagetype'] = 'error';
        }
        return true;
    }


    /**
     * This is the Hook that gets called when a user logs out.
     *
     * @param object $user
     */
    public function onUserLogout(&$user)
    {
        // User logs out of the wiki we want to log them out of the form too.
        if (!isset($this->_SessionTB))
        {
            return true; // If the value is not set just return true and move on.
        }
        return true;
        // @todo: Add code here to delete the session.
    }


    /**
     * Set the domain this plugin is supposed to use when authenticating.
     *
     * NOTE: We do not use this.
     *
     * @param string $domain
     * @access public
     */
    public function setDomain( $domain )
    {
        $this->domain = $domain;
    }


    /**
     * Set the given password in the authentication database.
     * As a special case, the password may be set to null to request
     * locking the password to an unusable value, with the expectation
     * that it will be set later through a mail reset or other method.
     *
     * Return true if successful.
     *
     * NOTE: We only allow the user to change their password via phpBB.
     *
     * @param $user User object.
     * @param $password String: password.
     * @return bool
     * @access public
     */
    public function setPassword( $user, $password )
    {
        return true;
    }


    /**
     * Return true to prevent logins that don't authenticate here from being
     * checked against the local database's password fields.
     *
     * This is just a question, and shouldn't perform any actions.
     *
     * Note: This forces a user to pass Authentication with the above
     *       function authenticate(). So if a user changes their PHPBB
     *       password, their old one will not work to log into the wiki.
     *       Wiki does not have a way to update it's password when PHPBB
     *       does. This however does not matter.
     *
     * @return bool
     * @access public
     */
    public function strict()
    {
        return true;
    }


    /**
     * Update user information in the external authentication database.
     * Return true if successful.
     *
     * @param $user User object.
     * @return bool
     * @access public
     */
    public function updateExternalDB( $user )
    {
        return true;
    }


    /**
     * When a user logs in, optionally fill in preferences and such.
     * For instance, you might pull the email address or real name from the
     * external user database.
     *
     * The User object is passed by reference so it can be modified; don't
     * forget the & on your function declaration.
     *
     * NOTE: Not useing right now.
     *
     * @param User $user
     * @access public
     * @return bool
     */
    public function updateUser( &$user )
    {
        return true;
    }


    /**
     * Check whether there exists a user account with the given name.
     * The name will be normalized to MediaWiki's requirements, so
     * you might need to munge it (for instance, for lowercase initial
     * letters).
     *
     * NOTE: MediaWiki checks its database for the username. If it has
     *       no record of the username it then asks. "Is this really a
     *       valid username?" If not then MediaWiki fails Authentication.
     *
     * @param string $username
     * @return bool
     * @access public
     */
    public function userExists($username)
    {
        return true;
    }




    /**
     * Check to see if the specific domain is a valid domain.
     *
     * @param string $domain
     * @return bool
     * @access public
     */
    public function validDomain( $domain )
    {
        return true;
    }
}
