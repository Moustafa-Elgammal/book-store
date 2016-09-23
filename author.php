<?php
require_once('globals.php');
require_once(MODELS.'BooksModel.php');
require_once(CONTROLLERS.'UsersController.php');
require_once(MODELS.'UsersModel.php');
$book= new BooksModel();
$model = new UsersModel();
$controller = new UsersController($model);

$controller->GetAuthor($book);

