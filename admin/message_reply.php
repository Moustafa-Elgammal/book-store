<?php
require_once ('../globals.php');
Is_Admin();
require_once (MODELS.'NotifyModel.php');
require_once (CONTROLLERS.'NotifyController.php');
//model object
$NotifyModel = new NotifyModel();
//conroller object
$controller = new NotifyController($NotifyModel);
//replay message 
$controller->message_reply();