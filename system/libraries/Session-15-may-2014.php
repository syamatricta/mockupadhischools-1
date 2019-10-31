<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2009, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Session Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Sessions
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/libraries/sessions.html
 */
class CI_Session {

	var $sess_encrypt_cookie		= FALSE;
	var $sess_use_database			= FALSE;
	var $sess_table_name			= '';
	var $sess_expiration			= 7200;
	var $sess_match_ip				= FALSE;
	var $sess_match_useragent		= TRUE;
	var $sess_cookie_name			= 'ci_session';
	var $cookie_prefix				= '';
	var $cookie_path				= '';
	var $cookie_domain				= '';
	var $sess_time_to_update		= 300;
	var $encryption_key				= '';
	var $flashdata_key 				= 'flash';
	var $time_reference				= 'time';
	var $gc_probability				= 5;
	var $userdata					= array();
	var $CI;
	var $now;

	/**
	 * Session Constructor
	 *
	 * The constructor runs the session routines automatically
	 * whenever the class is instantiated.
	 */
	function CI_Session($params = array())
	{
		log_message('debug', "Session Class Initialized");

		// Set the super object to a local variable for use throughout the class
		$this->CI =& get_instance();

		// Set all the session preferences, which can either be set
		// manually via the $params array above or via the config file
		foreach (array('sess_encrypt_cookie', 'sess_use_database', 'sess_table_name', 'sess_expiration', 'sess_match_ip', 'sess_match_useragent', 'sess_cookie_name', 'cookie_path', 'cookie_domain', 'sess_time_to_update', 'time_reference', 'cookie_prefix', 'encryption_key') as $key)
		{
			$this->$key = (isset($params[$key])) ? $params[$key] : $this->CI->config->item($key);
		}

		// Load the string helper so we can use the strip_slashes() function
		$this->CI->load->helper('string');

		// Do we need encryption? If so, load the encryption class
		if ($this->sess_encrypt_cookie == TRUE)
		{
			$this->CI->load->library('encrypt');
		}

		// Are we using a database?  If so, load it
		if ($this->sess_use_database === TRUE AND $this->sess_table_name != '')
		{
			$this->CI->load->database();
		}

		// Set the "now" time.  Can either be GMT or server time, based on the
		// config prefs.  We use this to set the "last activity" time
		$this->now = $this->_get_time();

		// Set the session length. If the session expiration is
		// set to zero we'll set the expiration two years from now.
	/*	if ($this->sess_expiration == 0)
		{
			$this->sess_expiration = (60*60*24*365*2);
		}*/
		 
		// Set the session length. If the session expiration is
        // set to zero we'll set the expiration two years from now.
        if ($this->sess_expiration == 0)
        {
            $this->sess_expiration = (60*60*24*365*2);
            $this->sess_delete_after_browser_close = false;
        }
        elseif($this->sess_expiration == -1)
        {
            $this->sess_expiration = 60*60*24;
            $this->sess_delete_after_browser_close = true;
        } 
		
		// Set the cookie name
		$this->sess_cookie_name = $this->cookie_prefix.$this->sess_cookie_name;

		// Run the Session routine. If a session doesn't exist we'll
		// create a new one.  If it does, we'll update it.
		if ( ! $this->sess_read())
		{
			$this->sess_create();
		}
		else
		{                    
                    if(!(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')){
			$this->sess_update();
                    }
		}

		// Delete 'old' flashdata (from last request)
	   	$this->_flashdata_sweep();

		// Mark all new flashdata as old (data will be deleted before next request)
	   	$this->_flashdata_mark();

		// Delete expired sessions if necessary
		$this->_sess_gc();

		log_message('debug', "Session routines successfully run");
	}

	// --------------------------------------------------------------------

	/**
	 * Fetch the current session data if it exists
	 *
	 * @access	public
	 * @return	bool
	 */
	/**
 * Fetch the current session data if it exists
 *
 * @return  bool
 */
public function sess_read()
{
  // Fetch the cookie
  $session = $this->CI->input->cookie($this->sess_cookie_name);
 
  // No cookie?  Goodbye cruel world!...
  if ($session === NULL)
  {
    log_message('debug', 'A session cookie was not found.');
    return FALSE;
  }
 
  // Decrypt the cookie data
  if ($this->sess_encrypt_cookie === TRUE)
  {
    $session = $this->CI->encrypt->decode($session);
  }
  else
  {
    // encryption was not used, so we need to check the md5 hash
    $hash  = substr($session, strlen($session)-32); // get last 32 chars
    $session = substr($session, 0, strlen($session)-32);
 
    // Does the md5 hash match?  This is to prevent manipulation of session data in userspace
    if ($hash !==  md5($session.$this->encryption_key))
    {
      log_message('error', 'The session cookie data did not match what was expected. This could be a possible hacking attempt.');
      $this->sess_destroy();
      return FALSE;
    }
  }
 
  // Unserialize the session array
  $session = $this->_unserialize($session);
 
  // Is the session data we unserialized an array with the correct format?
  if ( ! is_array($session) OR ! isset($session['session_id'], $session['ip_address'], $session['user_agent'], $session['last_activity']))
  {
    $this->sess_destroy();
    return FALSE;
  }
 
  // Is the session current?
  if (($session['last_activity'] + $this->sess_expiration) < $this->now)
  {
    $this->sess_destroy();
    return FALSE;
  }
 
  // Does the IP match?
  if ($this->sess_match_ip === TRUE && $session['ip_address'] !== $this->CI->input->ip_address())
  {
    $this->sess_destroy();
    return FALSE;
  }
 
  // Does the User Agent Match?
  if ($this->sess_match_useragent === TRUE && trim($session['user_agent']) !== trim(substr($this->CI->input->user_agent(), 0, 120)))
  {
    $this->sess_destroy();
    return FALSE;
  }
 
  // Is there a corresponding session in the DB?
  if ($this->sess_use_database === TRUE)
  {
    /*
     * begin old_session_id_changes
     *
     * Search both session_id and old_session_id fields for the
     * incoming session id.
     *
     * used to be:
     * $this->CI->db->where('session_id', $session['session_id']);
     *
     * Manually create the OR condition because it causes the least
     * disturbance to existing code.
     *
     * Store the session id from the cookie so that we can see if we
     * came in through the old session id later.
     */
    $this->CI->db->where( '(session_id = ' . $this->CI->db->escape($session['session_id']) . ' OR old_session_id = ' . $this->CI->db->escape($session['session_id']) . ')' );
    $this->cookie_session_id = $session['session_id'];
    /*
     * end old_session_id_changes
     */
 
    if ($this->sess_match_ip === TRUE)
    {
      $this->CI->db->where('ip_address', $session['ip_address']);
    }
 
    if ($this->sess_match_useragent === TRUE)
    {
      $this->CI->db->where('user_agent', $session['user_agent']);
    }
 
    $query = $this->CI->db->limit(1)->get($this->sess_table_name);
 
    // No result?  Kill it!
    if ($query->num_rows() === 0)
    {
      $this->sess_destroy();
      return FALSE;
    }
 
    // Is there custom data?  If so, add it to the main session array
    $row = $query->row();
    if ( ! empty($row->user_data))
    {
      $custom_data = $this->_unserialize($row->user_data);
 
      if (is_array($custom_data))
      {
        foreach ($custom_data as $key => $val)
        {
          $session[$key] = $val;
        }
      }
    }
 
    /*
     * begin old_session_id_changes
     *
     * Pull the session_id from the database to populate the curent
     * session id because the old one is stale.
     *
     * Pull the old_session_id from the database so that we can
     * compare the current (cookie) session id against it later.
     */
    $session['session_id'] = $row->session_id;
    $session['old_session_id'] = $row->old_session_id;
    /*
     * end old_session_id_changes
     */
  }
 
  // Session is valid!
  $this->userdata = $session;
  unset($session);
 
  return TRUE;
}

	// --------------------------------------------------------------------

	/**
	 * Write the session data
	 *
	 * @access	public
	 * @return	void
	 */
	public function sess_write()
{
  // Are we saving custom data to the DB?  If not, all we do is update the cookie
  if ($this->sess_use_database === FALSE)
  {
    $this->_set_cookie();
    return;
  }
 
  // set the custom userdata, the session data we will set in a second
  $custom_userdata = $this->userdata;
  $cookie_userdata = array();
 
  // Before continuing, we need to determine if there is any custom data to deal with.
  // Let's determine this by removing the default indexes to see if there's anything left in the array
  // and set the session data while we're at it
  foreach (array('session_id','ip_address','user_agent','last_activity') as $val)
  {
    unset($custom_userdata[$val]);
    $cookie_userdata[$val] = $this->userdata[$val];
  }
 
  /*
   * begin old_session_id_changes
   *
   * old_session_id has its own field, but it doesn't need to go into
   * a cookie because we'll always retrieve it from the database.
   */
  unset($custom_userdata['old_session_id']);
  /*
   * end old_session_id_changes
   */
 
  // Did we find any custom data?  If not, we turn the empty array into a string
  // since there's no reason to serialize and store an empty array in the DB
  if (count($custom_userdata) === 0)
  {
    $custom_userdata = '';
  }
  else
  {
    // Serialize the custom data array so we can store it
    $custom_userdata = $this->_serialize($custom_userdata);
  }
 
  // Run the update query
  $this->CI->db->where('session_id', $this->userdata['session_id']);
  $this->CI->db->update($this->sess_table_name, array('last_activity' => $this->userdata['last_activity'], 'user_data' => $custom_userdata));
 
  // Write the cookie.  Notice that we manually pass the cookie data array to the
  // _set_cookie() function. Normally that function will store $this->userdata, but
  // in this case that array contains custom data, which we do not want in the cookie.
  $this->_set_cookie($cookie_userdata);
}
 

	// --------------------------------------------------------------------

	/**
	 * Create a new session
	 *
	 * @access	public
	 * @return	void
	 */
	function sess_create()
	{
		$sessid = '';
		while (strlen($sessid) < 32)
		{
			$sessid .= mt_rand(0, mt_getrandmax());
		}

		// To make the session ID even more secure we'll combine it with the user's IP
		$sessid .= $this->CI->input->ip_address();

		$this->userdata = array(
							'session_id' 	=> md5(uniqid($sessid, TRUE)),
							'ip_address' 	=> $this->CI->input->ip_address(),
							'user_agent' 	=> substr($this->CI->input->user_agent(), 0, 50),
							'last_activity'	=> $this->now
							);


		// Save the data to the DB if needed
		if ($this->sess_use_database === TRUE)
		{
			$this->CI->db->query($this->CI->db->insert_string($this->sess_table_name, $this->userdata));
		}

		// Write the cookie
		$this->_set_cookie();
	}

	// --------------------------------------------------------------------

	/**
	 * Update an existing session
	 *
	 * @access	public
	 * @return	void
	 */
	public function sess_update()
{
  // We only update the session every five minutes by default
  if (($this->userdata['last_activity'] + $this->sess_time_to_update) >= $this->now)
  {
    return;
  }
 
  // _set_cookie() will handle this for us if we aren't using database sessions
  // by pushing all userdata to the cookie.
  $cookie_data = NULL;
 
  /*
   * begin old_session_id_changes
   *
   * Don't need to regenerate the session if we came in by indexing to
   * the old_session_id), but send out the cookie anyway to make sure
   * that the client has a copy of the new cookie.
   *
   * Do an isset check first in case we're not using the database to
   * store extra data.  The old_session_id field only exists in the
   * database.
   */
  if ((isset($this->userdata['old_session_id'])) &&
      ($this->cookie_session_id === $this->userdata['old_session_id']))
  {
    // set cookie explicitly to only have our session data
    $cookie_data = array();
    foreach (array('session_id','ip_address','user_agent','last_activity') as $val)
    {
      $cookie_data[$val] = $this->userdata[$val];
    }
 
    $this->_set_cookie($cookie_data);
    return;
  }
  /*
   * end old_session_id_changes
   */
 
  // Save the old session id so we know which record to
  // update in the database if we need it
  $old_sessid = $this->userdata['session_id'];
  $new_sessid = '';
  do
  {
    $new_sessid .= mt_rand(0, mt_getrandmax());
  }
  while (strlen($new_sessid) < 32);
 
  // To make the session ID even more secure we'll combine it with the user's IP
  $new_sessid .= $this->CI->input->ip_address();
 
  // Turn it into a hash and update the session data array
  $this->userdata['session_id'] = $new_sessid = md5(uniqid($new_sessid, TRUE));
  $this->userdata['last_activity'] = $this->now;
 
  // Update the session ID and last_activity field in the DB if needed
  if ($this->sess_use_database === TRUE)
  {
    // set cookie explicitly to only have our session data
    $cookie_data = array();
    foreach (array('session_id','ip_address','user_agent','last_activity') as $val)
    {
      $cookie_data[$val] = $this->userdata[$val];
    }
 
    /*
     * begin old_session_id_changes
     *
     * Save the old session id into the old_session_id field so that
     * we can reference it later.
     *
     * Rewrite the cookie's session id if there are zero affected rows
     * because that means that another request changed the database
     * under the current request.  In this case, we want to return a
     * value consistent with the previous request.  Reread immediately
     * after the update call here to minimize timing problems.  This
     * should be in a transaction for databases that support them.
     *
     * Also rewrite the userdata so that future calls to sess_write
     * will output the correct cookie data.
     *
     * used to be:
     * $this->CI->db->query($this->CI->db->update_string($this->sess_table_name, array('last_activity' => $this->now, 'session_id' => $new_sessid), array('session_id' => $old_sessid)));
     */
    $this->CI->db->query($this->CI->db->update_string($this->sess_table_name, array('last_activity' => $this->now, 'session_id' => $new_sessid, 'old_session_id' => $old_sessid), array('session_id' => $old_sessid)));
 
    if ($this->CI->db->affected_rows() === 0)
    {
      $this->CI->db->where('old_session_id', $this->cookie_session_id);
      $query = $this->CI->db->get($this->sess_table_name);
 
      // We've lost track of the session if there are no results, so
      // don't set a cookie and just return.
      if ($query->num_rows() == 0)
      {
        return;
      }
 
      $row = $query->row();
      foreach (array('session_id','ip_address','user_agent','last_activity') as $val)
      {
        $this->userdata[$val] = $row->$val;
        $cookie_data[$val] = $this->userdata[$val];
      }
 
      // Set the request session id to the old session id so that we
      // won't try to regenerate the cookie again on this request --
      // just in case sess_update is ever called again (which it
      // shouldn't be).
      $this->cookie_session_id = $this->userdata['old_session_id'];
    }
    /*
     * end old_session_id_changes
     */
  }
 
  // Write the cookie
  $this->_set_cookie($cookie_data);
} 

	// --------------------------------------------------------------------

	/**
	 * Destroy the current session
	 *
	 * @access	public
	 * @return	void
	 */
	function sess_destroy()
	{
		
		// for tracking session expiry in a log
		$this->_log_session_expiry();
		
		// Kill the session DB row
		if ($this->sess_use_database === TRUE AND isset($this->userdata['session_id']))
		{
			
			$this->CI->db->where('session_id', $this->userdata['session_id']);
			$this->CI->db->delete($this->sess_table_name);
		}

		// Kill the cookie
		setcookie(
					$this->sess_cookie_name,
					addslashes(serialize(array())),
					($this->now - 31500000),
					$this->cookie_path,
					$this->cookie_domain,
					0
				);
	}
	
	/**
	 * function for keeping the log of the session expiry...
	 * not codeigniters package function wrote for tracking some errors
	 *
	 */
	
	
	function _log_session_expiry (){
		
		if(isset($this->userdata['session_id'])){
			$this->CI->db->where('session_id', $this->userdata['session_id']);
			$query = $this->CI->db->get($this->sess_table_name);
			
			$row = $query->row();
			if (isset($row->user_data) AND $row->user_data != '')
			{
				$custom_data = $this->_unserialize($row->user_data);
	
				if (is_array($custom_data))
				{
					foreach ($custom_data as $key => $val)
					{
						$session[$key] = $val;
					}
				}
			}
			if(isset($session['USERID'])){
				$msg	=	"session expired for userid ".$session['USERID'];
				//common_log_message('end',$msg,'expiry');
			}
		}
		
	}
	
	

	

	// --------------------------------------------------------------------

	/**
	 * Fetch a specific item from the session array
	 *
	 * @access	public
	 * @param	string
	 * @return	string
	 */
	function userdata($item)
	{
		return ( ! isset($this->userdata[$item])) ? FALSE : $this->userdata[$item];
	}

	// --------------------------------------------------------------------

	/**
	 * Fetch all session data
	 *
	 * @access	public
	 * @return	mixed
	 */
	function all_userdata()
	{
		return ( ! isset($this->userdata)) ? FALSE : $this->userdata;
	}

	// --------------------------------------------------------------------

	/**
	 * Add or change data in the "userdata" array
	 *
	 * @access	public
	 * @param	mixed
	 * @param	string
	 * @return	void
	 */
	function set_userdata($newdata = array(), $newval = '')
	{
		if (is_string($newdata))
		{
			$newdata = array($newdata => $newval);
		}

		if (count($newdata) > 0)
		{
			foreach ($newdata as $key => $val)
			{
				$this->userdata[$key] = $val;
			}
		}

		$this->sess_write();
	}

	// --------------------------------------------------------------------

	/**
	 * Delete a session variable from the "userdata" array
	 *
	 * @access	array
	 * @return	void
	 */
	function unset_userdata($newdata = array())
	{
		if (is_string($newdata))
		{
			$newdata = array($newdata => '');
		}

		if (count($newdata) > 0)
		{
			foreach ($newdata as $key => $val)
			{
				unset($this->userdata[$key]);
			}
		}

		$this->sess_write();
	}

	// ------------------------------------------------------------------------

	/**
	 * Add or change flashdata, only available
	 * until the next request
	 *
	 * @access	public
	 * @param	mixed
	 * @param	string
	 * @return	void
	 */
	function set_flashdata($newdata = array(), $newval = '')
	{
		if (is_string($newdata))
		{
			$newdata = array($newdata => $newval);
		}

		if (count($newdata) > 0)
		{
			foreach ($newdata as $key => $val)
			{
				$flashdata_key = $this->flashdata_key.':new:'.$key;
				$this->set_userdata($flashdata_key, $val);
			}
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Keeps existing flashdata available to next request.
	 *
	 * @access	public
	 * @param	string
	 * @return	void
	 */
	function keep_flashdata($key)
	{
		// 'old' flashdata gets removed.  Here we mark all
		// flashdata as 'new' to preserve it from _flashdata_sweep()
		// Note the function will return FALSE if the $key
		// provided cannot be found
		$old_flashdata_key = $this->flashdata_key.':old:'.$key;
		$value = $this->userdata($old_flashdata_key);

		$new_flashdata_key = $this->flashdata_key.':new:'.$key;
		$this->set_userdata($new_flashdata_key, $value);
	}

	// ------------------------------------------------------------------------

	/**
	 * Fetch a specific flashdata item from the session array
	 *
	 * @access	public
	 * @param	string
	 * @return	string
	 */
	function flashdata($key)
	{
		$flashdata_key = $this->flashdata_key.':old:'.$key;
		return $this->userdata($flashdata_key);
	}

	// ------------------------------------------------------------------------

	/**
	 * Identifies flashdata as 'old' for removal
	 * when _flashdata_sweep() runs.
	 *
	 * @access	private
	 * @return	void
	 */
	function _flashdata_mark()
	{
		$userdata = $this->all_userdata();
		foreach ($userdata as $name => $value)
		{
			$parts = explode(':new:', $name);
			if (is_array($parts) && count($parts) === 2)
			{
				$new_name = $this->flashdata_key.':old:'.$parts[1];
				$this->set_userdata($new_name, $value);
				$this->unset_userdata($name);
			}
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Removes all flashdata marked as 'old'
	 *
	 * @access	private
	 * @return	void
	 */

	function _flashdata_sweep()
	{
		$userdata = $this->all_userdata();
		foreach ($userdata as $key => $value)
		{
			if (strpos($key, ':old:'))
			{
				$this->unset_userdata($key);
			}
		}

	}

	// --------------------------------------------------------------------

	/**
	 * Get the "now" time
	 *
	 * @access	private
	 * @return	string
	 */
	function _get_time()
	{
		if (strtolower($this->time_reference) == 'gmt')
		{
			$now = time();
			$time = mktime(gmdate("H", $now), gmdate("i", $now), gmdate("s", $now), gmdate("m", $now), gmdate("d", $now), gmdate("Y", $now));
		}
		else
		{
			$time = time();
		}

		return $time;
	}

	// --------------------------------------------------------------------

	/**
	 * Write the session cookie
	 *
	 * @access	public
	 * @return	void
	 */
	function _set_cookie($cookie_data = NULL)
	{
		if (is_null($cookie_data))
		{
			$cookie_data = $this->userdata;
		}

		// Serialize the userdata for the cookie
		$cookie_data = $this->_serialize($cookie_data);

		if ($this->sess_encrypt_cookie == TRUE)
		{
			$cookie_data = $this->CI->encrypt->encode($cookie_data);
		}
		else
		{
			// if encryption is not used, we provide an md5 hash to prevent userside tampering
			$cookie_data = $cookie_data.md5($cookie_data.$this->encryption_key);
		}

		// Set the cookie
		setcookie(
					$this->sess_cookie_name,
					$cookie_data,
					($this->CI->config->item('sess_expiration') == -1) ? 0 : ($this->sess_expiration + time()),
					
					$this->cookie_path,
					$this->cookie_domain,
					0
				);
	}

	// --------------------------------------------------------------------

	/**
	 * Serialize an array
	 *
	 * This function first converts any slashes found in the array to a temporary
	 * marker, so when it gets unserialized the slashes will be preserved
	 *
	 * @access	private
	 * @param	array
	 * @return	string
	 */
	function _serialize($data)
	{
		if (is_array($data))
		{
			foreach ($data as $key => $val)
			{
				$data[$key] = str_replace('\\', '{{slash}}', $val);
			}
		}
		else
		{
			$data = str_replace('\\', '{{slash}}', $data);
		}

		return serialize($data);
	}

	// --------------------------------------------------------------------

	/**
	 * Unserialize
	 *
	 * This function unserializes a data string, then converts any
	 * temporary slash markers back to actual slashes
	 *
	 * @access	private
	 * @param	array
	 * @return	string
	 */
	function _unserialize($data)
	{
		$data = @unserialize(strip_slashes($data));

		if (is_array($data))
		{
			foreach ($data as $key => $val)
			{
				$data[$key] = str_replace('{{slash}}', '\\', $val);
			}

			return $data;
		}

		return str_replace('{{slash}}', '\\', $data);
	}

	// --------------------------------------------------------------------

	/**
	 * Garbage collection
	 *
	 * This deletes expired session rows from database
	 * if the probability percentage is met
	 *
	 * @access	public
	 * @return	void
	 */
	function _sess_gc()
	{
		if ($this->sess_use_database != TRUE)
		{
			return;
		}

		srand(time());
		if ((rand() % 100) < $this->gc_probability)
		{
			$expire = $this->now - $this->sess_expiration;

			$this->CI->db->where("last_activity < {$expire}");
			$this->CI->db->delete($this->sess_table_name);

			log_message('debug', 'Session garbage collection performed.');
		}
	}


}
// END Session Class

/* End of file Session.php */
/* Location: ./system/libraries/Session.php */