<?php
require_once ('../globals.php');
Is_Admin();
$up = new uploader();
if (isset($_POST['submit']))
{
	// vatiables
	$site_name = $_POST ['site_name'];
	$about = $_POST ['about'];
	$welcome = $_POST ['welcome'];
	$facebook = $_POST ['facebook'];
	$twitter = $_POST ['twitter'];
	$coming_date=$_POST['coming_date'];
	
	//choose if update image or not
	if($_POST['select']=="new")
	{
		
	    //give it FILES array with input name
	    $up->Upload_Init($_FILES['file']);
	
	    //Set Upload directory >>if not found it will be created
	    $up->Upload_Set_dir('../uploads');
	
	    //set allowed mime type
	    $up->Upload_Set_Type(array('image/jpg','image/jpeg','image/png','image/gif'));
	
	    //set allowed extensions
	    $up->Upload_Set_Ext(array('jpg','jpeg','gif','png'));
	
	    //Process uploading
	   if( $up->Upload()) //file uploaded
	   {		
			$image_url=$up->Upload_Get_File_Info()['path'];
			unlink("../".$_POST['old_image']);
	   }
	   else // no file to upload
	   {
	   		$image_url=$_POST['old_image'];
	   }
		
	}
	else 
	{
		$image_url=$_POST['select'];
	}
	//validation
	$errors=array(); //init
	if(strlen($site_name)==0) //check name if iss sets
		$errors[]="It's important to set the web sitename";
	//if (filter_var($coming_date,FILTER_VALIDATE_REGEXP))
	if (count($errors) == 0)
	{
		//set the info in array to submit to tne database
		$data=array(
				'site_name' => $site_name,
				'about' => $about,
				'welcome' => $welcome,
				'coming_date' => $coming_date,
				'facebook' => $facebook,
				'twitter' => $twitter,
				'image_url' => $image_url
		);
		
		//submit the new datainfo inthe data base
		if(System::Get('db')->Update("site_info",$data,"WHERE `site_info`.`id`='1'"))
		{
			System::Get('tpl')->assign('message',"Done.....!");
			System::Get('tpl')->draw('success');
		}
		else  //can't add to database
		{
			System::Get('tpl')->assign('message','<h5 style="color: red">Please check your text befor each Epson
				type a "\"</h5>');
			System::Get('tpl')->draw('error');
		}
	}
	else //there are errors to show
	{
		System::Get('tpl')->assign('message',$errors);
		System::Get('tpl')->draw('back');
	}
}
else 
{
	$site_info=array(); //init
	System::Get ( 'db' )->Execute ( "select*FROM `site_info` WHERE `id`='1'" );
	if (System::Get ( 'db' )->AffectedRows ())
		$site_info = System::Get ( 'db' )->GetRows ();
	
	if(count($site_info) > 0)
	{
		System::Get('tpl')->assign($site_info);
		System::Get('tpl')->draw('site_info');
	}
}