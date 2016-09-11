<?php

class ReviewsModel {
    private $table_name ;

    public function __construct(){
        $this->table_name = PREFIX."books_reviews";
    }

    /**
     * get all books
     * @param string $extra [optional WHERE statement]
     * @return array 2D of the books || or Empty
     */
    public function GetAllReviews($extra = '')
    {
        $books = array(); //init

        $query = sprintf("SELECT * FROM %s %s", $this->table_name, $extra); // query
        //echo $query;
        System::Get('db')->Execute($query); //execute the query
        if (System::Get('db')->AffectedRows()) { //
            $books = System::Get('db')->GetRows();
            return $books;
        }
        return $books;
    }

    /**
     * get a review by  id
     * @param $id
     * @return array of the review data or empty
     */
    public function GetById($id){
        $id = (int)$id;

        $book = $this->GetAllReviews("WHERE review_id = $id");
        return $book[0];
    }

    /**
     * get reviews of one book
     * @param $id
     * @return array
     */
    public function GetByBookID($id){
         $id = (int)$id; // init
        $bokks_reviews = $this->GetAllReviews("WHERE review_book_id = $id"); // order
        return $bokks_reviews; // return data
    }

    /**
     * get reviews of one user
     * @param $id
     * @return array
     */
    public function GetByUserID($id){
        $id = (int)$id; // init
        $bokks_reviews = $this->GetAllReviews("WHERE review_user_id = $id"); // order
        return $bokks_reviews; // return data
    }


    /**
     * Delete a review by it's id
     * @param $id
     * @return bool true when delete,else false
     */
    public function DeleteReview($id){
        $id = (int)$id; //init
        System::Get('db')->Delete($this->table_name,"WHERE review_id = $id"); // delete
        $x = System::Get('db')->AffectedRows(); //check
        return $x ? true:false; //confirm
    }

    /**
     * @param $data
     * @return bool true if added |else false
     */
    public function AddNewReview($data){
        System::Get('db')->Insert($this->table_name,$data); // add
        $x = System::Get('db')->AffectedRows(); //check
        return $x? true:false;  //confirm
    }

    public function UpdateReview($id,$data){
        $id = (int) $id; //init
        System::Get('db')->Update($this->table_name,$data,"WHERE review_id = '$id'"); //update
        $x = System::Get('db')->AffectedRows(); //check
        return $x? true:false;  //confirm
    }




}