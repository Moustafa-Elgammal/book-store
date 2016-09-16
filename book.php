<?php

include_once"globals.php";
require_once(CONTROLLERS.'VisitorsController.php');
require_once(MODELS.'BooksModel.php');

$booksmodel = new BooksModel();
$controller = new VisitorsController($booksmodel);

$controller->drawBookInfo();