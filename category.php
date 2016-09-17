<?php
require_once('globals.php');
require_once(MODELS.'CategoriesModel.php');
require_once(CONTROLLERS.'CategoriesController.php');
require_once(MODELS.'BooksModel.php');
$book= new BooksModel();
$model = new CategoriesModel();
$controller = new CategoriesController($model);

$controller->GetCategoryInfo($book);

