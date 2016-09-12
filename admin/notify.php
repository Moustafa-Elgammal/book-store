<?php
require_once ("../globals.php");
Is_Admin();

if (isset($_POST['submit']) && ( $_POST['table'] == 'contacts' || $_POST['table'] == 'messages'))
{
	$subject=$_POST['subject']; //the subject from form
	$content=$_POST['content']; //the mail content from the form
	//extra text to sent with the mail
	$content.="Thank you,Keep us in touch @ this URL -> ".$_SERVER ['HTTP_HOST'].'/message.php';
	//the website URL in the header
	$headers=$_SERVER ['HTTP_HOST'];
	$table=$_POST['table'];
	System::Get('db')->Execute("SELECT `name`, `email` FROM `$table`"); // SQL ORDER
	$contacts=System::Get('db')->GetRows(); // THE Rows in array
		
	foreach ($contacts as $contact)
	{
		$name=$contact['name'];   // the user name
		$email=$contact['email']; // the user email 	
		/**
		 * the mail fun 
		 * @param $email the contact mail
		 * @param $subject  which the site owner type it
		 * @param $content  the mail text
		 * @param $headers and $name of the contuct 
		 */	
		mail($email, $subject, $content,$headers.' : '.$name);
	}
	// show successfull order
	System::Get('tpl')->assign('message','all mails have been Sent successfully.....');
	System::Get('tpl')->draw('success');
}
else
{
	System::RedirectTo("index.php");
}