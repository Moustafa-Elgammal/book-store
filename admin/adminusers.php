<?php

require_once('../globals.php');
Is_Admin();
Author();
require_once (CONTROLLERS.'UsersController.php');
require_once (MODELS.'UsersModel.php');

$UsersModel=new UsersModel();

$Controller = new UsersController($UsersModel);



$Controller->ShowAdminUsers();