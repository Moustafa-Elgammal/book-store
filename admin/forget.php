<?php
require_once('../globals.php');
require_once (CONTROLLERS.'UsersController.php');
require_once (MODELS.'UsersModel.php');
die('<h1 align="center">Not supported @ localhost</h1><p align="center"><a href="../../">home</a></p>');
$UsersModel=new UsersModel();

$Controller = new UsersController($UsersModel);

// the method of reset the password by the email
$Controller->check_email_create_temp();