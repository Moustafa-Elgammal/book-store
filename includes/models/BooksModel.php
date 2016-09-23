<?php

class BooksModel {
    private $table_name ;

    public function __construct(){
        $this->table_name = PREFIX."books";
    }

    /**
     * get all books
     * @param string $extra [optional WHERE statement]
     * @return array 2D of the books || or Empty
     */
    public function GetAllBooks($extra = '')
    {
        $books = array(); //init

        $query = sprintf("SELECT `$this->table_name`.*,users.uid,users.name,book_store_categories.category_id,book_store_categories.category_title FROM `$this->table_name` LEFT JOIN book_store_categories ON book_category_id = category_id LEFT JOIN users ON book_author_id = users.uid
                           %s  ORDER BY `book_store_books`.`book_id` DESC", $extra); // query
        //echo $query;
        System::Get('db')->Execute($query); //execute the query
        if (System::Get('db')->AffectedRows()) { //
            $books = System::Get('db')->GetRows();
            return $books;
        }
        return $books;
    }

    /**
     * get a book by  id
     * @param $id
     * @return array of the book data or empty
     */
    public function GetById($id){
        $id = (int)$id; // init
        $book = $this->GetAllBooks("WHERE book_id = $id"); //execute
        return !empty($book)? $book[0]: []; // return
    }

    /**
     * get all book of the current Author logged in
     * @return array
     */
    public function GetAuthorBooks(){
        $id = (int)$_SESSION['uid']; //init
        $book = $this->GetAllBooks("WHERE `$this->table_name`.`book_author_id` = $id"); // execute
        return !empty($book)? $book: []; //return
    }
    /**
     * Delete a book by it's id
     * @param $book_id
     * @return bool true when delete,else false
     */
    public function DeleteBook($book_id){
        $id = (int)$book_id; //init
        System::Get('db')->Delete($this->table_name,"WHERE book_id = $id"); // delete
        $x = System::Get('db')->AffectedRows(); //check
        return count($x) ? true:false; //confirm
    }

    /**
     * @param $data
     * @return bool true if added |else false
     */
    public function AddNewBook($data){
        System::Get('db')->Insert($this->table_name,$data); // add
        $x = System::Get('db')->AffectedRows(); //check
        return $x? true:false;  //confirm
    }

    public function UpdateBook($id,$data){
        $id = (int) $id; //init
        System::Get('db')->Update($this->table_name,$data,"WHERE book_id = '$id'"); //update
        $x = System::Get('db')->AffectedRows(); //check
        return $x? true:false;  //confirm
    }

    /**
     * this method for return an array with all book in the same category
     * @param $id category id
     * @return array of the books or empty of nothing
     */
    public function GetByCatId($id){
        $id = (int)$id;
        $book = $this->GetAllBooks("WHERE book_category_id = $id");
        return !empty($book)? $book: array();
    }

    /**
     * get author book
     * @param $id
     * @return array
     */
    public function GetByAuthorId($id){
        $id = (int)$id; //init
        $book = $this->GetAllBooks("WHERE `$this->table_name`.`book_author_id` = $id"); // execute
        return !empty($book)? $book: []; //return
    }

}