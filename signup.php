<?php
require_once"globals.php";

require_once(MODELS.'UsersModel.php');
require_once(CONTROLLERS.'UsersController.php');

$model = new UsersModel();
$controller = new UsersController($model);

$controller->SignUp();