<?php
require_once("../globals.php");
Is_Admin();
Author();

require_once(CONTROLLERS.'CategoriesController.php');
require_once(MODELS.'CategoriesModel.php');

$model = new CategoriesModel();
$controller = new CategoriesController($model);

$controller->UpdateCategory();
