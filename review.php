<?php

include_once"globals.php";
require_once(CONTROLLERS.'UsersMetaController.php');
require_once(MODELS.'UsersMetaModel.php');

$booksmodel = new UsersMetaModel();
$controller = new UsersMetaController($booksmodel);

$controller->addReview();