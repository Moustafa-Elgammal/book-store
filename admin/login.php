<?php

require_once('../globals.php');

require_once (CONTROLLERS.'UsersController.php');
require_once (MODELS.'UsersModel.php');

//object from UsersModel
$UsersModel=new UsersModel();

//object from UsersController
$Controller = new UsersController($UsersModel);



if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1 )
{
$Controller->login();
}
else
{
	System::RedirectTo('index.php');
}