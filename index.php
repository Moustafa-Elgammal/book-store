<?php

include_once"globals.php";


require_once(MODELS.'/BooksModel.php');


$books = new BooksModel();

var_dump($books->GetById(1));