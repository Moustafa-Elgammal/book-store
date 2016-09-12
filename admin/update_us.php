<?php
require_once ("../globals.php");
Is_Admin();
require_once (CONTROLLERS.'AboutController.php');
require_once (MODELS.'AboutModel.php');

$AboutModel = new AboutModel();

$Controller = new AboutController($AboutModel);
$Controller ->update_site_info();
