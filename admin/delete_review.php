<?php

include_once"../globals.php";
require_once(CONTROLLERS.'ReviewsController.php');
require_once(MODELS.'ReviewsModel.php');

$model = new ReviewsModel();
$controller = new ReviewsController($model);

$controller->DeleteReview();

