<?php
require_once ('../globals.php');
Is_Admin();
Author();
require_once (CONTROLLERS.'AboutController.php');
require_once (MODELS.'AboutModel.php');

$AboutModel = new AboutModel();

$Controller = new AboutController($AboutModel);

$Controller ->Show_About_By_mid();