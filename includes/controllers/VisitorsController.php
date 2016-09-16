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

    public function drawBookInfo(){
        if(isset($_GET['id']) && (int)$_GET['id'] ){
            $id = (int)$_GET['id'];

            $book = $this->booksModel->GetById($id);

            if(!empty($book)){
                System::Get('tpl')->assign($book);
                System::Get('tpl')->draw('header');
                System::Get('tpl')->draw('book');
                System::Get('tpl')->draw('footer');
            } else{
                $this->drawHome();
            }
        }else{
            $this->drawHome();
        }
    }
} 