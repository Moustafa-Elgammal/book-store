<?php
class System {
	// objects array
	private static $Objects = array ();
	
	/**
	 * Store
	 * 
	 * @param unknown $index        	
	 * @param unknown $value        	
	 */
	public static function Store($index, $value) {
		self::$Objects [$index] = $value;
	}
	
	/**
	 * Get
	 * 
	 * @param unknown $index        	
	 * @return multitype:
	 */
	public static function Get($index) {
		return self::$Objects [$index];
	}
	// hashing password solted
	public static function Hash($password) {
		$password = sha1 ( md5 ( sha1 ( "%^*&^%*&^*GHFDFGfggf54hf5g4h6fg87h4f65g4h5f4h6fg87" . $password ) . md5 ( "you will kill my @#!$@#%$#%@^%&%^*&*^%$%^&#$%#$%#$%$%#" ) . sha1 ( "you will kill my @#!$@#%$#%@^%&%^*&*^%$%^&#$%#$%#$%$%#" ) ) ) . sha1 ( $password . "#%^#$^%^" );
		return $password;
	}
	
	/**
	 * to redirect user in admin cp
	 * 
	 * @param $location which
	 *        	go to
	 */
	public static function RedirectTo($location) {
		// when header isn't set it redirect to $location
		if (! headers_sent ()) {
			header ( "Location:$location" );
			exit ();
		} else {
			$red = '<script type="text/javascript">';
			$red .= 'window.location.href="' . $location . '";';
			$red .= '</script>';
			echo $red;
			
			/* -------------- HTML meta refresh--------- */
			$meta = '<noscript>';
			$meta .= '<meta-http-equiv="refresh" content="0;url=' . $location . '"/>';
			$meta .= '</noscript>';
			
			echo $meta;
			exit ();
		}
	}
	
	public static function SQL_SAVE($query){
		$variable =$query;
		return $variable; 
	}
}