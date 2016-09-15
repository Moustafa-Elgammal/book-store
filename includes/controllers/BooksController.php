<?php
/**
 * Created by PhpStorm.
 * User: tone
 * Date: 15/09/2016
 * Time: 05:37 م
 */

class BooksControllers {

    private $booksModel;

    /**
     * @param CategoriesModel $model
     */
    public function __construct(BooksModel $model){
        $this->booksModel = $model;
    }

    public function AddBook(){

        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){

            //check title
            if(!isset($_POST['title'])||  strlen($_POST['title']) < 4){
                die(json_encode(array(
                    'status' => 0,
                    "msg"    => "The title must be more than 4 letters"
                )));
            }

            //check content
            if(!isset($_POST['content'])||  strlen($_POST['content']) < 15){
                die(json_encode(array(
                    'status' => 0,
                    "msg"    => "The description must be more than 15 letters"
                )));
            }
            //check content
            if(!isset($_POST['category'])||  (int)$_POST['category'] <= 0){
                die(json_encode(array(
                    'status' => 0,
                    "msg"    => "Please select valid category"
                )));
            }

            if(!isset($_POST['pdf'])||  !file_exists($_POST['pdf'])){
                die(json_encode(array(
                    'status' => 0,
                    "msg"    => "Please upload valid file"
                )));
            }



            $data = array(
                'book_file' => $_POST['pdf'],
                'book_title' => $_POST['title'],
                'book_content' => $_POST['content'],
                'book_category_id' => $_POST['category'],
                'book_author_id' => $_SESSION['uid'],
                'book_cost' => 0
            );

            $x = $this->booksModel->AddNewBook($data);

            if ($x)
                die(json_encode(array(
                    'status' => 1,
                    "msg"    => "New Book Added successfully"
                )));

            else
                die(json_encode(array(
                    'status' => 0,
                    "msg"    => "Error to add the book"
                )));

        }else{
            System::Get('tpl')->draw('addbook');
        }

    }

    /**
     * get all books
     */
    public function AllBooks(){
        $cats = $this->booksModel->GetAllBooks();
        System::Get('tpl')->assign('categories',$cats);
        System::Get('tpl')->draw('allbooks');
    }

    /**
     * delete Book
     */
    public function deleteBook(){
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){

            if(!isset($_POST['id']) || !(int)$_POST['id'] )
                die(json_encode(array(
                    'status' => 0
                )));
            $id = (int)$_POST['id'];
            $x = $this->booksModel->DeleteBook($id);
            if($x)
                die(json_encode(array(
                    'status' => 1
                )));
            else
                die(json_encode(array(
                    'status' => 1
                )));
        }else{
            die(json_encode(array(
                'status' => 0,
            )));
        }
    }

} 