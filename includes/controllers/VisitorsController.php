<?php


class VisitorsController {
    private $booksModel;
    public function __construct(BooksModel $model){

        $this->booksModel = $model;

    }

    public function drawHome(){
        $books = $this->booksModel->GetAllBooks();
        System::Get('tpl')->assign('books',$books);
        System::Get('tpl')->draw('header');
        System::Get('tpl')->draw('home');
        System::Get('tpl')->draw('footer');
    }
} 