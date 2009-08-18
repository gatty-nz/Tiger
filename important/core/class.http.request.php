<?php

/**
 * HTTP Request controller
 *
 * @author  Gareth Stones <gareth@rezolabs.com>
 * @license GNU Lesser General Public License
 */

class HTTPRequest {
	
	/**
	 * GET, POST and COOKIE storage
	 */
	
	private $get = array();
	private $post = array();
	private $coookie = array();
	private $server = array();
	
	// if user is accessing HTTPS or not
	//private $isSecure = false;
	
	final public function __construct () {}
	
	final private function __clone () {}
	
	/**
	 * Set header information for GET and POST
	 *
	 * @access public
	 * @param  $_GET, $_POST, $_COOKIE HTTP header information
	 */
	
	public function setHeader (array $_GET, array $_POST, array $_COOKIE, array $_SERVER) {
		
		// is the super global $_GET etc over writting function params?
	   
	   if ($_GET) {
		   foreach ($_GET as $key => $value) {
		      if (!empty($key) && !empty($value))
			      $this->get[$key] = new SecureData ((string) $value);
			}
		}
		
		if ($_POST) {
		   foreach ($_POST as $key => $value)
		      if (!empty($key) && !empty($value))
			      $this->post[$key] = new SecureData ((string) $value);
		}
		
		if ($_COOKIE) {
		   foreach ($_COOKIE as $key => $value)
		      if (!empty($key) && !empty($value))
		   	   $this->cookie[$key] = new SecureData ((string) $value);
		}
		
		if ($_SERVER) {
   		foreach ($_SERVER as $key => $value)
		      if (!empty($key) && !empty($value)) {
			      $this->server[$key] = new SecureData ((string) $value);
               //echo '<p>$this->server[' . $key . '] = \'' . $this->server[$key]->toXHTML() . '\';</p>';
            }
		}
		
		//$this->isSecure = (in_array('HTTPS', $_SERVER) && !empty($_SERVER['HTTPS']));
		
      unset($_GET);
      unset($_POST);
      unset($_COOKIE);
      unset($_SERVER);
      unset($_ENV);
      unset($_FILES);
      unset($_SESSION);
      unset($_REQUEST);
      unset($_GLOBALS);
      unset($GLOBALS);
	}
	
	/**
	 * Retrieve header information for GET and POST
	 *
	 * @access public
	 * @param  $key   key index for $this->get, $this->post array's
	 */
	
	public function methodGet ($key) {
		
      //if (!in_array($key, $this->get))
      if (!isset($this->get[$key]))
         return false;
         //throw new Exception ('Key not found in array.');
      
      // FIXME need to update the method of validation
		//if ($this->get[$key]->isValid() !== true)
			//trigger_error ('Using unsanitised raw data.', E_USER_WARNING);
		
		return $this->get[$key];
	}
	
	public function methodPost ($key) {
		
      if (!in_array($key, $this->post))
         return false;
         //throw new Exception ('Key not found in array');
      
		if ($this->post[$key]->isValid() !== true)
			trigger_error ('Using unsanitised raw data.', E_USER_WARNING);
		
		return $this->post[$key];
	}
	
	public function methodCookie ($key) {
		
      if (!in_array($key, $this->cookie))
         throw new Exception ('Key not found in array');
      
		if ($this->cookie[$key]->isValid() !== true)
			trigger_error ('Using unsanitised raw data.', E_USER_WARNING);
		
		return $this->cookie[$key];
	}
	
	public function methodServer ($key) {
      
      //if (!in_array($key, $this->server))
         //throw new Exception ('Key not found in array');
      
      return $this->server[$key];
	}
	
	// if we're using HTTPS or not
	
	public function isSecure () {
      
		return (in_array('HTTPS', $this->server) && !empty($this->server['HTTPS']));
	}
	
	// different $_SERVER settings
	
	public function getDocumentRoot () {
		
		return ($this->server['DOCUMENT_ROOT'] === null) ? new SecureData('/var/www/hosting/tiger/www/') : $this->server['DOCUMENT_ROOT'];
	}
	
	/**
	 * Get HTTP hostname
	 *
	 * Returns 'localhost' when running in CLI
	 *
	 * @return SecureData hostname
	 */
	
	public function getHostname () {
		
		return ($this->server['HTTP_HOST'] === null) ? new SecureData('localhost') : $this->server['HTTP_HOST'];
	}
	
	/**
	 * Get client IP address
	 *
	 * @return SecureData client IP
	 */
	
	public function getClientIP () {
		
		return $this->server['REMOTE_ADDR'];
	}
}

?>
