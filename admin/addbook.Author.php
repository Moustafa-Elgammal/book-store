<?php
require_once("../globals.php");
Is_Author();
require_once(CONTROLLERS.'BooksController.php');
require_once(MODELS.'BooksModel.php');

$model = new BooksModel();
$controller = new BooksControllers($model);

$controller->AddBook();