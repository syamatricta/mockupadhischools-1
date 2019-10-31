<?php
 restore_error_handler();
//if ( !defined('XCART_START') ) { header("Location: ../../"); die("Access denied"); }

# --------------------------------------------------------------------------
# xvbIntegration - X-Cart + vBulletin Integration
# X-Cart Mods, X-Cart Addons: http://www.websitecm.com/
# --------------------------------------------------------------------------
# FILE: class.vbreg.php
# Original class file by Alex Matulich.
# Modified and improved by Jon Peters for x-cart specific integration.
#
# This software file is provided for reference only.
# In no event shall authors be liable for any damages whatsoever from any
# cause of action of any kind, including, but not limited to, business
# interruption or lost information, arising out of the use of this software.
# Software is provided "as is" and possibly with faults.  You assume all
# liability, financial or otherwise, associated your use of the software.
#
# Note: File does not perform user deletions as integration is performed on
# an x-cart where user deletions are not permitted.  Admin deletions are
# manually performed in both x-cart and vbulletin seperately.
# --------------------------------------------------------------------------

# ----------------------------------------------------------------------
# CONFIG
# ----------------------------------------------------------------------

// Specify Forum Path
//echo "ajay";exit;
define('FORUMPATH', $site_basepath.'forums');
//define('FORUMPATH', '/home/anusha/public_html/adhischools_forum/trunk/forums');

///Users/crystaltip_v2/forums - Server
// Default vbulletin user group
define('REGISTERED_USERGROUP', 2);

# ----------------------------------------------------------------------
# END CONFIG
# ----------------------------------------------------------------------

// Specify executing script name to vbulletin
define('THIS_SCRIPT', __FILE__);

// Get current path name to change back to upon completion
$cwd = getcwd();
//echo $cwd;
// Change to forum path for vbseo includes

chdir(FORUMPATH);

//echo getcwd();
// Include necessary vbulletin files
require_once('includes/init.php');
require_once('includes/class_dm.php');
require_once('includes/class_dm_user.php');
require_once('includes/functions.php');
require_once('includes/functions_login.php');

# ----------------------------------------------------------------------
# FUNCTION: xvbUserInfo
#
# Purpose:
# 	Queries user information using a username
#
# Parameters:
#	$in_username - The username for which to retrieve information
#
# Returns:
#	Empty if no user is found
#	Otherwise returns an array of user information
#
# ----------------------------------------------------------------------
function xvbUserInfo(&$in_username)
{
	global $vbulletin;
	 $userid = $vbulletin->db->query_first_slave("SELECT userid FROM " . TABLE_PREFIX . "user WHERE email='" . mysql_real_escape_string($in_username) . "'");

	if (!$userid) return $userid;

	return fetch_userinfo($userid['userid'], 0, 0);
}


# ----------------------------------------------------------------------
# CLASS: xvbIntegration
#
# Updates the vbulletin database as changes to x-cart database are made.
# ----------------------------------------------------------------------
class xvbIntegration extends vB_DataManager_User {
	var $userdm;

	// Constructor
	function xvbIntegration()
	{   
		global $vbulletin;
		$this->userdm =& datamanager_init('User', $vbulletin, ERRTYPE_ARRAY);
	}

	# ----------------------------------------------------------------------
	# FUNCTION: xvbRegister
	#
	# Purpose:
	# 	Creates a vbulletin entry for the user and logs user into forum
	#
	# Parameters:
	#	$in_userdata - Array of user data for which to register
	#	  using vb specific keys: username, password, email
	#	$in_remember - Pass a persistent login variable from
	#	  x-cart registration.
	#	$in_login - Specify if the user should be logged in or not
	#	  upon registration.  TRUE or FALSE.
	#
	# ----------------------------------------------------------------------
	function xvbRegister(&$in_userdata,$in_remember='',$in_login=TRUE)
	{
		global $vbulletin;
//echo "sdf".$userfield['lastname'];
		if ($in_remember == "Y" OR $in_remember === TRUE) { $in_remember = TRUE; }
		else { $in_remember = FALSE; }

           
		foreach($in_userdata as $key => $value)
			$this->userdm->set($key, $value);
                       // print_r($key);
                   //     print_r($value);
//                        print_r($userfield);
		$this->userdm->set('usergroupid', REGISTERED_USERGROUP);
               // $fieldvariable = array('field5' => "fieldvalue");
                //$userdata->set_userfields($fieldvariable, true, 'admin');
		// Set default configuration values
		$this->userdm->set_bitfield('options', 'adminemail', 1);
		$this->userdm->set_bitfield('options', 'showsignatures', 1);
		$this->userdm->set_bitfield('options', 'showavatars', 1);
		$this->userdm->set_bitfield('options', 'showimages', 1);
		$this->userdm->set_bitfield('options', 'showemail', 0);
                 //$fieldvariable = array('field5' => $userfield['firstname'],'field6'=>$userfield['lastname']);
                // print_r($fieldvariable);
                //$this->userdm->set('field5',$userfield['firstname']);
               // $this->userdm->set('field6',$userfield['lastname']);
              //$customfields =  $this->userdm->set_userfields($fieldvariable, true, 'register');
               //  $fieldvariable2 = array('field6' => $userfield['lastname']);
             //  $customfields2 = $this->userdm->set_userfields($fieldvariable2, true, 'register');
                //$this->userdm->set_userfields($vbulletin->GPC['userfield'], true, 'register');
              

               // die('fdsf');
		// If there are no errors then save and log user in
		if (empty($this->userdm->errors)) {
			  
			$vbulletin->userinfo['userid'] = $this->userdm->save();
			if ($in_login === TRUE) {
				$this->xvbLogin($in_userdata['username'],$in_remember);
			}
		}
	}

	# ----------------------------------------------------------------------
	# FUNCTION: xvbUpdate
	#
	# Purpose:
	# 	Updates user information
	#
	# Parameters:
	#	$in_userdata - Array of user data for which to update
	#	  using vb specific keys: username, password, email
	#
	# ----------------------------------------------------------------------
	function xvbUpdate(&$in_userdata)
	{
		global $vbulletin;
		
		if ($existing_user = xvbUserInfo($in_userdata['email'])) {
                 
			$this->userdm->set_existing($existing_user);
			foreach($in_userdata as $key => $value)
				$this->userdm->set($key, $value);

			// If no errors, save data and update password cookie
			if (empty($this->userdm->errors)) {
				$vbulletin->userinfo['userid'] = $this->userdm->save();
				if (isset($in_userdata['password']))
					vbsetcookie('password',md5($vbulletin->userinfo['password'].COOKIE_SALT),false, true, true);
			}
		}
	}

	# ----------------------------------------------------------------------
	# FUNCTION: xvbLogin
	#
	# Purpose:
	# 	Logs the user into vbulletin
	#
	# Parameters:
	#	$in_username - The username of the user to login
	#	$in_remember - Pass a persistent login variable from
	#	  x-cart registration.
	#
	# ----------------------------------------------------------------------
	function xvbLogin($in_username,$in_remember='')
	{
		global $vbulletin;
//echo "ffff".$in_remember;
		if ($in_remember == "Y" OR $in_remember === TRUE) { $in_remember = TRUE; }
		else { $in_remember = FALSE; }

		$vbulletin->userinfo = xvbUserInfo($in_username);

		vbsetcookie('userid', $vbulletin->userinfo['userid'],$in_remember, true, true);
                
		vbsetcookie('password',md5($vbulletin->userinfo['password'].COOKIE_SALT),$in_remember, true, true);
		process_new_login('', 1, '');
	}

	# ----------------------------------------------------------------------
	# FUNCTION: xvbLogout
	#
	# Purpose:
	# 	Logs the user out of vbulletin
	#
	#
	# ----------------------------------------------------------------------
	function xvbLogout()
	{
		process_logout();
	}
        function xvbForceLogout($userid)
	{
            global $vbulletin;


		$vbulletin->userinfo = xvbUserInfo($userid);
		process_forcelogout();
	}
	
    function xvbUserMail($in_username)
	{
		global $vbulletin;
		 $username = $vbulletin->db->query_first_slave("SELECT username,email FROM " . TABLE_PREFIX . "user WHERE userid='" . mysql_real_escape_string($in_username) . "'");
		return $username;

	}

	function vb_update_password(){
        	require_once $this->config->item ('site_basepath').'system/application/libraries/vbintegration.php';
        	$this->vbulletin = new xvbIntegration();
        	$vbInsert['username'] = 'admin';
        	$vbInsert['email'] = 'kartik@adhischools.com';
			$vbInsert['password'] = 'rain1234';
        	$this->vbulletin->xvbUpdate($vbInsert);
        }
}

// Change back to the previously executing directory
chdir($cwd);
?>