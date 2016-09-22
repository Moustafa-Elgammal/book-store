<?php
require_once"../globals.php";
Is_Admin();
Author();
require_once(MODELS."/CategoriesModel.php");
require_once(CONTROLLERS."/CategoriesController.php");

$model = new CategoriesModel();
$controller = new CategoriesController($model);

$controller->AllCategories();