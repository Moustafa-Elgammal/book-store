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
            $reviews = array();

            $book = $this->booksModel->GetById($id);
            System::Get('db')->Execute("SELECT book_store_books_reviews.*,users.uid,users.name,book_store_books.book_id,book_store_books.book_title FROM `book_store_books_reviews` LEFT JOIN users on review_user_id = users.uid LEFT JOIN book_store_books ON review_book_id = book_store_books.book_id where review_book_id = $id");
            $reviews = System::Get('db')->AffectedRows()?System::Get('db')->GetRows():[];

            if(!empty($book)){
                System::Get('tpl')->assign($book);
                System::Get('tpl')->assign('reviews',$reviews);
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