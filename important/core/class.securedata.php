<?php

/**
 * Object to secure data
 *
 * Validate using ValidateData object, and secure data depending on the desired method.
 *
 * @author  Gareth Stones <gareth@rezolabs.com>
 * @license GNU Lesser General Public License
 */

class SecureData
{
	/**
	 * Data value to secure and validate
	 *
	 * @var    string
	 * @access private
	 */
	
	private $value = null;
	
	/**
	 * Has been validated or not
	 * Stores line number and file which called the last method of toX()
	 *
	 * TODO Throw exception if it hasn't, and it's being returned as a value?
	 *
	 * $this->valid['method'] = (string); (XHTML, SQL etc)
	 * $this->valid['file'] = (string); (__FILE__)
	 *
	 * @var    array
	 * @access private
	 */
	
	private $valid = array();
	
	/**
	 * @access public
	 * @return boolean
	 * @param string $value data value to validate, and secure
	 * @param string $type type of input we are dealing with, for validation
	 */
	
	public function __construct ($value) {
	   
	   $this->valid['method'] = null;
	   $this->valid['file'] = null;
		
		if (!is_string($value))// || !is_int($value))
			throw new Exception ('Invalid data type for SecureData value.');
		
		//if (empty($value))
		   //throw new Exception ('SecureData value cannot be empty.');
		
		$this->value = $value;
		
		return true;
	}
	
	/**
	 * Use __call magic method to validate data
	 */
	
	/*
	TODO test this method, also check if call_user_func or something alike can accept wild cards (ctype_* for example)
	
	public function __call ($method, array $params) {
	   
	   if (function_exists($method) === false || is_callable($method) === false)
	      return false;
	   
	   $allow = array ('is_email', 'is_url', 'ctype_alnum', 'ctype_alpha', 'ctype_cntrl', 'ctype_digit', 'ctype_graph', 'ctype_lower', 'ctype_print', 'ctype_punct', 'ctype_space', 'ctype_upper', 'ctype_xdigit', 'grep_match');
	   
	   if (in_array($method, $allow) === false)
	      return false;
	   
	   call_user_func(array($this, $method), $params);
	}*/
	
	public function __call ($method, array $params) {
	   
	   if (function_exists($method) == false)
	      return false;
	   
	   // use $temp incase it was valid before this point
	   // OR should it be revalidated, since we're using a different validation method?
	   $temp = $this->valid;
	   
	   $this->valid['method'] = 'custom';
	   $this->valid['file'] = __FILE__;
		
		// filter_var() since PHP 5.x
		if (substr($method, 0, 2) === 'is') {
			switch ($method) {
				case 'is_email':
					return filter_var($this->value, FILTER_VALIDATE_EMAIL);
				break;
				case 'is_url':
					return filter_var($this->value, FILTER_VALIDATE_URL);
				break;
				default:
					trigger_error ("$method SecureData method not yet implemented.", E_USER_WARNING);
				break;
			}
		}
		
		else if (substr($method, 0, 6) === 'ctype_') {
			if (is_callable($method)) // TODO check if function exists
				return $method($this->value);
		}
		
		else if ($method === 'preg_match')
			return preg_match($params[0], $this->value, $params[2], $params[3], $params[4]);
		
		// about to return false, is not valid!
		$this->valid['method'] = $temp['method'];
		$this->valid['file'] = $temp['file'];
		
		unset($temp);
		
		return false;
	}
	
	/**
	 * Convert input value into different types of valid data
	 *
	 * @access public
	 * @return $this->value generic
	 */
	
	public function toSQL () {
	   
		/*$data = $this->value;
		
		if (ini_get('magic_quotes_gpc'))
			$data = stripslashes($data);*/
		
		// TODO update for PDO
		throw new Exception ('toSQL not implemented yet.');
	}
	
	public function toXHTML () {
      
      $this->valid['method'] = 'XHTML';
      $this->valid['file'] = __FILE__;
      
      // TODO update for any charset (multi lang support)
		return htmlentities($this->value, ENT_QUOTES);
	}
	
	/**
	 * Plan the hashing system
	 */
	
	private function toPassword ($time) {
		
		return md5(sha1(md5($this->value)) . sha1($this->salt($time)));
	}
	
	private function toSalt ($time) {
	   
		return md5(md5($time) . sha1($time) . $this->value);
	}
	
	public function toHash () {
	   
		$time = time();
		$salt = $this->toSalt($time);
		$password = $this->toPassword($time);
		
		return array (
						'password' => $password,
						'salt' => $salt,
						'time' => $time
					 );
	}
	
	public function toInteger () {
	   
	   return (int) $this->value;
	}
	
	/**
	 * If current SecureData object value is valid or not
	 *
	 * TODO idea, prehaps check the file and line in which we're calling this on. if it changes, it must be re-validated
	 *
	 * @access public
	 * @return boolean
	 */
	
	public function isValid () {
		
		return $this->valid;
	}
}

?>
