<?php
class UsersController {
	private $UsersModel;
	public function __construct(UsersModel $UsersModel) {
		$this->UsersModel = $UsersModel;
	}
	
	/* --------------------for ADMIN---------------------- */
	
	/**
	 * upadate user
	 */
	public function Update() {
		if (isset ( $_POST ['submit'] )) {
			// set variables
			$uid = ( int ) $_POST ['uid'];
			$name = $_POST ['name'];
			$username = $_POST ['username'];
			$email = $_POST ['email'];
			// $is_admin = $_POST ['is_admin'];
			$password = System::Hash ( $_POST ['password'] );
			// the user info
			// validation
			$error = array ();
			// check the password
			if ($password != $this->UsersModel->Get_By_ID ( $uid ) ['password'])
				$error [] = "Please ckeck the correct password";
				// name check
			if (strlen ( $name ) < 5)
				$error [] = "name length must be more than 5 letters";
			if (! filter_var ( $email, FILTER_VALIDATE_EMAIL ))
				$error [] = "Please keep you E-mail such as\" example@info.com\"";
				
				// username check
			if (strlen ( $username ) < 4)
				$error [] = "username length must be more than 4 letters";
				/* -----chech errors---- */
			if (count ( $error ) == 0) {
				
				// set user info in array $data
				$data = array (
						'name' => $name,
						'username' => $username,
						'email' => $email 
				);
				// 'is_admin' => $is_admin
				
				// sort the user in db
				// update the data to the database
				if ($this->UsersModel->Update ( $uid, $data )) {
					// update the user info session
					$_SESSION ["username"] = $username;
					$_SESSION ["name"] = $name;
					// Draw successful templates
					System::Get ( 'tpl' )->assign ( 'message', 'User INFO Updated' );
					System::Get ( 'tpl' )->draw ( 'success' );
				} else // cant update
{
					System::Get ( 'tpl' )->assign ( 'message', 'ERRORS' );
					System::Get ( 'tpl' )->draw ( 'error' );
				}
			} else { // there are errors
				System::Get ( 'tpl' )->assign ( 'message', $error );
				System::Get ( 'tpl' )->draw ( 'back' );
			}
		} else {
			$uid = 0; // init
			if (isset ( $_GET ['uid'] ) && ( int ) $_GET ['uid'] > 0) {
				$uid = ( int ) $_GET ['uid'];
				// get user from db
				$user = $this->UsersModel->Get_By_ID ( $uid );
				if (count ( $user ) > 0) {
					// if user found
					System::Get ( 'tpl' )->assign ( $user );
					System::Get ( 'tpl' )->draw ( 'updateuser' );
				} else {
					// article not found
					System::Get ( 'tpl' )->assign ( 'message', 'Id Not Found' );
					System::Get ( 'tpl' )->draw ( '404' );
				}
			} else {
				// no id
				System::Get ( 'tpl' )->assign ( 'message', 'Invalid Id' );
				System::Get ( 'tpl' )->draw ( '404' );
			}
		}
	}
	
	/**
	 * delete user
	 */
	public function Delete() {
		$uid = 0; // init
		
		if (isset ( $_GET ['uid'] ) && ( int ) $_GET ['uid'] > 0) {
			
			$uid = ( int ) $_GET ['uid'];
			
			$this->UsersModel->Delete ( $uid );
			if (System::Get ( 'db' )->AffectedRows () > 0) {
				System::Get ( 'tpl' )->assign ( 'message', 'User Deleted' );
				System::Get ( 'tpl' )->draw ( 'success' );
			} else {
				System::Get ( 'tpl' )->assign ( 'message', "NOT FOUND" );
				System::Get ( 'tpl' )->draw ( '404' );
			}
		} else {
			System::Get ( 'tpl' )->assign ( 'message', 'You are lost !' );
			System::Get ( 'tpl' )->draw ( '404' );
		}
	}
	
	/**
	 * log in function
	 */
	public function login() {
		// assign init value for nothing
		System::Get ( 'tpl' )->assign ( "message", "" );
		
		// checking form submit
		if (isset ( $_POST ['submit'] )) {
			
			// varibles
			$username = $_POST ['username'];
			$password = $_POST ['password'];
			
			// validation
			$error = array ();
			if (strlen ( $username ) <= 0)
				$error [] = "check Username or the email";
			if (strlen ( $password ) <= 0)
				$error [] = "check Password";
				
				// check errors
			if (count ( $error ) == 0) {
				// check in model db if True
				if ($this->UsersModel->Login ( $username, $password )) {
					
					$userdata = $this->UsersModel->GetUserInfo ();
					
					// set user sessions
					$_SESSION ["is_admin"] = $userdata ['is_admin'];
					$_SESSION ["username"] = $userdata ['username'];
					$_SESSION ["name"] = $userdata ['name'];
					$_SESSION ["uid"] = $userdata ['uid'];
					
					// var_dump($_SESSION);
					if ($_SESSION ['is_admin'] == 1) {
						
						System::RedirectTo ( 'index.php' );
					} else {
						
						System::Get ( 'tpl' )->assign ( "message", array (
								0 => "you can't continue because you are not admin user" 
						) );
						System::Get ( 'tpl' )->draw ( "login" );
					}
				} 				

				// user not in db
				else {
					
					System::Get ( 'tpl' )->assign ( "message", array (
							0 => 'User not found' 
					) );
					System::Get ( 'tpl' )->draw ( "login" );
				}
			}  // there are errors in submited username or password
else {
				System::Get ( 'tpl' )->assign ( "message", $error );
				System::Get ( 'tpl' )->draw ( "login" );
			}
		}  // nothing happened else
else {
			System::Get ( 'tpl' )->draw ( "login" );
		}
	}
	
	/**
	 * function to reset the password
	 * in which multi sub options
	 * start optimizing the url with emailed for the user email
	 * the Use $_GET To Catch the values of the user
	 */
	// then draw the temp with value to set hid
	/*
	 * if the user submit new password with submitted good values
	 * it reset
	 */
	public function reset_by_mail() {
		if (isset ( $_POST ['submit'] ) && isset ( $_POST ['uid'] )) {
			// set values
			$uid = ( int ) $_POST ['uid'];
			$temp = $_POST ['temp'];
			$new_password = $_POST ['password'];
			$re_password = $_POST ['re_password'];
			// get the user info dy the submitted $uid
			$user_info = $this->UsersModel->Get_By_ID ( $uid );
			if (count ( $user_info ) == 0 || $temp != $user_info ['temp']) // there is user info
{
				// bad $_post
				System::Get ( 'tpl' )->assign ( 'message', '<a href="home">Expired LINK</a>' );
				System::Get ( 'tpl' )->draw ( 'error' );
			}
			// check the passwords
			if ($new_password != $re_password)
				$errors [] = "please keep the passwords matched";
				// count the errors
			if (count ( $errors ) == 0) // no errors
{
				// set array for the new data
				$data = array (
						'password' => System::Hash ( $new_password ),
						'temp' => System::Hash ( "dkajskjdhal;klklklkjdhklasdjlhasjlkglashj" . date ( 'l jS \of F Y h:i:s A' ) . $new_password . date ( 'l jS \of F Y h:i:s A' ) . date ( 'l jS \of F Y h:i:s A' ) . $new_password . date ( 'l jS \of F Y h:i:s A' ) ) 
				);
				// update the new data
				if ($this->UsersModel->Update ( $uid, $data )) {
					System::RedirectTo ( '../../admin' ); // the password updated location to log in
				} else // the model db return false so the an error
{
					System::Get ( 'tpl' )->assign ( 'message', '<a href="home">Can\'t Update</a>' );
					System::Get ( 'tpl' )->draw ( 'error' );
				}
			} else // there are errors whemn checking values
{
				echo ($errors [0]);
			}
		}  /*
		   * her the is a url from the main
		   * the url in the mail has the temp value of the user
		   * and the usr id
		   */
		// the the value in the url
		else if (isset ( $_GET ['user_temp'] ) && isset ( $_GET ['user_id'] )) {
			// set the values
			$uid = ( int ) $_GET ['user_id'];
			$temp = $_GET ['user_temp'];
			/*
			 * get the user info by its uid
			 * the start check and cmp
			 */
			$user_info = $this->UsersModel->Get_By_ID ( $uid ); // array of user info
			                                                    // check recieved info with the user info
			if (count ( $user_info ) == 0 || $temp != $user_info ['temp']) { // bad $_GET
				echo '<a href="../../home"> Expired LINK</a>';
			} else { // no errors in the url
				System::Get ( 'tpl' )->assign ( $user_info ); // assign the user value to be set in the temp
				System::Get ( 'tpl' )->draw ( 'reset_password_by_email' );
			}
		} 

		/**
		 * Nothing sumitted for $_POST NOR $_GET in the url
		 * so it bad to submit event
		 */
		else {
			System::RedirectTo ( '../home' );
		}
	}
	public function check_email_create_temp() {
		if (isset ( $_POST ['by_mail'] )) // the user will recieve a link to be able to reset his password
{
			// get variables
			$email_or_username = $_POST ['email_or_username'];
			// get the info
			$user_info = $this->UsersModel->Get_By_email_or_password ( $email_or_username );
			if (count ( $user_info ) > 0 && $user_info != FALSE) {
				// create mail and temp value
				// create temp value
				$temp = System::Hash ( "dkajskjdhal;klklklkjdhklasdjlhasjlkglashj" . date ( 'l jS \of F Y h:i:s A' ) . date ( 'l jS \of F Y h:i:s A' ) . date ( 'l jS \of F Y h:i:s A' ) . '$new_password' . date ( 'l jS \of F Y h:i:s A' ) );
				$uid = $user_info ['uid'];
				// set the temp value to the db
				// create array to send to the db
				$data = array (
						'temp' => "$temp" 
				);
				// update the temp of the user
				if ($this->UsersModel->Update ( $uid, $data )) // if the temp saved
{
					// start create and send the link to reset the pasworrds
					// the mail content
					$to = $user_info ['email'];
					$subject = "Reset your password";
					$from = 'INFO@Coming.pass';
					$message = 'Use this link to reset your password http://';
					$message .= $_SERVER ['HTTP_HOST'] . '/admin/';
					$message .= '/forgetpassword_mailing.php' . '?user_id=' . $uid . '&user_temp=' . $temp;
					$headers = 'From: Reset Password ' . 'INFO@RESET.PASS';
					// the email order
					mail ( $to, $subject, $message, $headers );
					echo 'please check you e-mail inbox' . $to . 'we just sent you a link';
					echo '  <a href="../"> Home</a>';
				} else { // error to update the temp
					System::Get ( 'tpl' )->assign ( 'message', array (
							'Sorry can\'t reset the passwordNow' 
					) );
					System::Get ( 'tpl' )->draw ( 'submit_email' );
				}
			} else {
				// Not Found
				System::Get ( 'tpl' )->assign ( 'message', array (
						'Sorry Not found' 
				) );
				System::Get ( 'tpl' )->draw ( 'submit_email' );
			}
		} else if (isset ( $_POST ['by_security_question'] )) // reset by the security Quesionns
{
			$this->reset_by_security_question ();
		} 

		else if (isset ( $_POST ['reset'] )) {
			$uid = ( int ) $_POST ['uid'];
			$answer1 = System::Hash ( $_POST ['answer1'] );
			$answer2 = System::Hash ( $_POST ['answer2'] );
			$user_info = $this->UsersModel->Get_By_ID ( $uid );
			// start check the user answer from the form with the Database
			if (count ( $user_info ) > 0 && $user_info != FALSE) {
				$errors = array (); // init
				                    // check the answers
				if ($user_info ['a1'] != $answer1 || $user_info ['a2'] != $answer2)
					$errors [] = "the is a wrong anser please try again";
					// check the new password
				if ($_POST ['password'] != $_POST ['re_password'])
					$errors [] = "please keep the passwords matched";
					// password length check
				if (strlen ( $_POST ['password'] ) < 8) {
					$errors [] = "the password must be at least 8 letters";
				}
				
				// count the errors
				if (count ( $errors ) == 0) // there no any errors or bad info
{
					// init the variable which will update
					$password = System::Hash ( $_POST ['password'] );
					
					// the data array to send it to the model to update
					$data = array (
							'password' => "$password" 
					);
					if ($this->UsersModel->Update ( $uid, $data ))
						echo "the password updated successfully";
					else
						echo "Sorry Can't reset the password";
				} else // there are errors
{
					// Not Found
					System::Get ( 'tpl' )->assign ( 'message', $errors );
					System::Get ( 'tpl' )->draw ( 'submit_email' );
				}
			} else {
				// Not Found
				System::Get ( 'tpl' )->assign ( 'message', array (
						'Sorry Not found' 
				) );
				System::Get ( 'tpl' )->draw ( 'submit_email' );
			}
		} else {
			System::Get ( 'tpl' )->draw ( 'submit_email' );
		}
	}
	
	/**
	 * the form of the question and the answer of the user
	 * tiny function to improve
	 */
	public function reset_by_security_question() {
		// get variables
		$email_or_username = $_POST ['email_or_username'];
		// get the info which have the question
		$user_info = $this->UsersModel->Get_By_email_or_password ( $email_or_username );
		if (count ( $user_info ) > 0 && $user_info != FALSE) {
			// submit the questions
			System::Get ( 'tpl' )->assign ( 'question1', $user_info ['q1'] );
			System::Get ( 'tpl' )->assign ( 'question2', $user_info ['q2'] );
			system::Get ( 'tpl' )->assign ( 'uid', $user_info ['uid'] );
			System::Get ( 'tpl' )->draw ( 'security_questions' );
		} else {
			// Not Found
			System::Get ( 'tpl' )->assign ( 'message', array (
					'Sorry Not found' 
			) );
			System::Get ( 'tpl' )->draw ( 'submit_email' );
		}
	}
	/**
	 * update the security questions
	 */
	public function updatesecurity() {
		if (isset ( $_POST ['submit'] ) && isset ( $_POST ['uid'] ) && ( int ) $_POST ['uid'] != 0) {
			// variables
			$question1 = $_POST ['q1'];
			$question2 = $_POST ['q2'];
			// for old answers
			$old_answer1 = System::Hash ( $_POST ['old_a1'] );
			$old_answer2 = System::Hash ( $_POST ['old_a2'] );
			// for new answers
			$answer1 = System::Hash ( $_POST ['a1'] );
			$answer2 = System::Hash ( $_POST ['a2'] );
			$password = System::Hash ( $_POST ['password'] );
			$uid = ( int ) $_POST ['uid'];
			// get user info
			$userinfo = $this->UsersModel->Get_By_ID ( $uid );
			// validiation errors
			$errors = array (); // init
			                    // check password
			if ($password != $userinfo ['password'])
				$errors [] = "check the password please";
				// check old answers
			if ($old_answer1 != $userinfo ['a1'])
				$errors [] = "check the old answer of question 1";
			if ($old_answer2 != $userinfo ['a2'])
				$errors [] = "check the old answer of question 2";
			if (strlen ( $answer1 ) < 5)
				$errors [] = "please keep the anser of question 1 more than 4 litters";
			if (strlen ( $answer2 ) < 5)
				$errors [] = "please keep the anser of question 2 more than 4 litters";
				// check errors
			if (count ( $errors ) == 0) {
				// set array to submit as line in data base tabel
				$data = array (
						'q1' => $question1,
						'q2' => $question2,
						'a1' => $answer1,
						'a2' => $answer2 
				);
				// send the array to the DB and check
				if ($this->UsersModel->Update ( $uid, $data )) {
					System::Get ( 'tpl' )->assign ( 'message', ' updated Successfully' ); // message to show in the success temp
					System::Get ( 'tpl' )->draw ( 'success' );
				} else {
					System::Get ( 'tpl' )->assign ( 'message', 'can\'t update' );
					System::Get ( 'tpl' )->draw ( 'error' );
				}
			} else { // there are some errors
				System::Get ( 'tpl' )->assign ( 'message', $errors );
				System::Get ( 'tpl' )->draw ( 'back' );
			}
		}  // no $_POST but there is $_GET can be processed
else if (isset ( $_GET ['uid'] ) && ( int ) $_GET ['uid'] != 0) {
			$uid = ( int ) $_GET ['uid'];
			$userinfo = array (); // init
			$userinfo = $this->UsersModel->Get_By_ID ( $uid ); // get the user info with its uid
			                                                   // check if the user found
			if (count ( $userinfo ) > 0 && $userinfo != FALSE) { // get old data
				System::Get ( 'tpl' )->assign ( $userinfo ); // assign the user info tho show in the temp
				System::Get ( 'tpl' )->draw ( 'updatesecurity' );
			} else { // No user not found in the db with the same $uid
				System::Get ( 'tpl' )->assign ( 'message', 'Not Found' );
				System::Get ( 'tpl' )->draw ( 'error' );
			}
		} else { // no valid link to process
			System::Get ( 'tpl' )->assign ( 'message', 'Not found' );
			System::Get ( 'tpl' )->draw ( 'error' );
		}
	}
	
	/**
	 * this fnction to reset the admin password
	 */
	public function Reset_password() {
		if (isset ( $_POST ["submit"] ) && isset ( $_POST ["uid"] ) && ( int ) $_POST ["uid"] > 0) {
			// variables
			$uid = ( int ) $_POST ["uid"]; // init
			                               // get the old password in hash
			$old_password_from_user = System::Hash ( $_POST ["old_password"] );
			// var_dump($old_password_from_user);
			// the new password
			$new_password = System::Hash ( $_POST ["new_password"] );
			$re_password = System::Hash ( $_POST ["re_password"] );
			// var_dump($new_password);
			// check the data base
			System::Get ( 'db' )->Execute ( "SELECT * FROM `users` WHERE `users`.`uid`='$uid'" );
			if (System::Get ( 'db' )->AffectedRows ())
				$userinfo_from_db = System::Get ( 'db' )->GetRows ();
				// var_dump($userinfo_from_db[0]["password"]);
				// validation
			$error = array ();
			// check old password
			if ($old_password_from_user != $userinfo_from_db [0] ["password"])
				$error [] = "check the past password";
			if ($new_password != $re_password)
				$error [] = "Keep the two password the same values ";
				// password length check
			if (strlen ( $new_password ) < 8) {
				$error [] = "the password must be at least 8 letters";
			}
			if (count ( $error ) == 0) { // set the update in data base
				if ($this->UsersModel->Reset_password ( $uid, $new_password )) { // if the update done show success message
					System::Get ( 'tpl' )->assign ( 'message', "password update" );
					System::Get ( 'tpl' )->draw ( "success" );
				} else // can't update the password in database
{
					System::Get ( 'tpl' )->assign ( 'message', "can't reset password" );
					System::Get ( 'tpl' )->draw ( '404' );
				}
			} else { // show the errors when the user reset the passwird
				System::Get ( 'tpl' )->assign ( 'message', $error ); // show the error
				System::Get ( 'tpl' )->draw ( 'back' );
			}
		} else {
			System::Get ( 'tpl' )->draw ( 'reset_passowrd' ); // draw the template of the reset form
		}
	}
}