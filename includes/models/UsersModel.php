<?php
class UsersModel {
	// init
	private $UserInfo;
	
	/**
	 * get all user from db
	 * 
	 * @param string $extra        	
	 * @return boolean $users else FALSE
	 */
	public function Get($extra = "") {
		$users = array (); // init
		                   
		// get all users from db
		System::Get ( 'db' )->Execute ( "SELECT*FROM `users` {$extra}" );
		
		// get users if there are;
		if (System::Get ( 'db' )->AffectedRows ()) {
			$users = System::Get ( 'db' )->GetRows ();
			return $users;
		} else {
			return FALSE;
		}
	}
	
	/**
	 * Get one User info by
	 * 
	 * @param user $uid        	
	 * @return Ambigous <>|boolean the user if it is found
	 */
	public function Get_By_ID($uid) {
		$uid = ( int ) $uid;
		$user = $this->Get ( "WHERE `users`.`uid`=('$uid')" );
		if (count ( $user ) > 0) {
			return $user [0];
		}
		return FALSE;
	}
	
	/**
	 * check the user info with its email or user name
	 */
	// if user sent an email or a password value it available
	public function Get_By_email_or_password($email_or_username) {
		$email_or_username = System::SQL_SAVE($email_or_username);
		$user = $this->Get ( "WHERE `users`.`email`='($email_or_username') OR `users`.`username`=('$email_or_username')" );
		if (count ( $user ) > 0) {
			if ($user [0] ['password'] == $password)
				return $user [0];
			return false;
		}
		return FALSE;
	}
	
	/**
	 * update user
	 * 
	 * @param
	 *        	$id
	 * @param $data info
	 *        	array
	 * @return boolean true if update
	 */
	public function Update($uid, $data) {
		$data = System::SQL_SAVE($data);
		if (System::Get ( 'db' )->Update ( "users", $data, "WHERE `users`.`uid`=('$uid')" )) {
			return TRUE;
		}
		return FALSE;
	}
	
	/**
	 * reset user password by
	 * 
	 * @param
	 *        	$id
	 * @param $password new
	 *        	user password
	 * @return boolean TRUE if reset
	 */
	public function Reset_password($uid, $password) {
		if (System::Get ( 'db' )->Update ( "users", array (
				'password' => $password 
		), "WHERE `users`.`uid`=('$uid')" ))
			return TRUE;
		
		return FALSE;
	}
	/**
	 * Login user by
	 * 
	 * @param
	 *        	$username
	 * @param
	 *        	$password
	 * @return boolean TRUE if user found
	 */
	public function Login($email_or_username, $password) {
		$email_or_username = System::SQL_SAVE($email_or_username);
		$password = System::Hash ( $password );
		
		if ($this->Get ( "WHERE `users`.`email`=('$email_or_username') OR `users`.`username`=('$email_or_username') AND `password`=('$password')" ) && $password) {
			$user = $this->Get ( "WHERE `users`.`email`=('$email_or_username') OR `users`.`username`=('$email_or_username') AND `password`=('$password')" );
			$this->UserInfo = $user [0];
			if ($user [0] ['password'] == $password)
				return TRUE;
			return false;
		} else {
			return FALSE;
		}
	}
	
	/**
	 *
	 * @return the User Info
	 */
	public function GetUserInfo() {
		return $this->UserInfo;
	}
}