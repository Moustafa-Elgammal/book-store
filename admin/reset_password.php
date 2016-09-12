<?php

require_once('../globals.php');
Is_Admin();
require_once (CONTROLLERS.'UsersController.php');
require_once (MODELS.'UsersModel.php');

$UsersModel=new UsersModel(); //object from Users Model class

$Controller = new UsersController($UsersModel); //ogject from Users Controller Class



$Controller->Reset_password();