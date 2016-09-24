<?php
include_once"globals.php";

isset($_SESSION['uid'])?:System::RedirectTo('admin/login.php');

require_once(CONTROLLERS.'UsersMetaController.php');
require_once(MODELS.'UsersMetaModel.php');

$model = new UsersMetaModel();
$controller = new UsersMetaController($model);

$controller->UserProfile();

