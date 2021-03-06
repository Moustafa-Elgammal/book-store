<?php
/**
 * Created by PhpStorm.
 * User: music
 * Date: 9/11/2016
 * Time: 10:41 AM
 */

class UsersMetaModel {
    private $table_name ;

    public function __construct(){
        $this->table_name = PREFIX."users_meta";
    }

    /**
     * get all books
     * @param string $extra [optional WHERE statement]
     * @return array 2D of the books || or Empty
     */
    public function GetAllMeta($extra = '')
    {
        $books = array(); //init

        $query = sprintf("SELECT %s.*,book_store_books.book_id,book_store_books.book_title FROM %s  LEFT JOIN book_store_books ON meta_book_id = book_id  %s", $this->table_name,$this->table_name, $extra); // query
        //echo $query;
        System::Get('db')->Execute($query); //execute the query
        if (System::Get('db')->AffectedRows()) { //
            $books = System::Get('db')->GetRows();
            return $books;
        }
        return $books;
    }

    /**
     * get a meta by  id
     * @param $id
     * @return array of the review data or empty
     */
    public function GetById($id){
        $id = (int)$id;

        $book = $this->GetAllMeta("WHERE meta_id = $id");
        return $book[0];
    }



    /**
     * get meta of one user
     * @param $id
     * @return array
     */
    public function GetByUserID($id){
        $id = (int)$id; // init
        $user_meta = $this->GetAllMeta("WHERE meta_user_id = $id"); // order
        return $user_meta; // return data
    }

    public function GetByMetaType($user_id,$meta_type){
        $user_id = (int)$user_id; // init
        $meta_type = (int) $meta_type;
        $user_meta = $this->GetAllMeta("WHERE (meta_user_id = $user_id AND meta_type = $meta_type)"); // order
        return $user_meta; // return data
    }


    /**
     * Delete a review by it's id
     * @param $id
     * @return bool true when delete,else false
     */
    public function DeleteMeta($id){
        $id = (int)$id; //init
        System::Get('db')->Delete($this->table_name,"WHERE meta_id = $id"); // delete
        $x = System::Get('db')->AffectedRows(); //check
        return $x ? true:false; //confirm
    }

    /**
     * @param $data
     * @return bool true if added |else false
     */
    public function AddNewMeta($data){
        System::Get('db')->Insert($this->table_name,$data); // add
        $x = System::Get('db')->AffectedRows(); //check
        return $x? true:false;  //confirm
    }

    /**
     * update a meta
     * @param $id
     * @param $data
     * @return bool
     */
    public function UpdateMeta($id,$data){
        $id = (int) $id; //init
        System::Get('db')->Update($this->table_name,$data,"WHERE meta_id = '$id'"); //update
        $x = System::Get('db')->AffectedRows(); //check
        return count($x)?1:0;  //confirm
    }

    public function CheckExist($book,$user,$type){
        $query = sprintf('WHERE `meta_book_id`=%d AND`meta_user_id`=%d
                         AND `meta_type` = %d',$book,$user,$type);
        $x = $this->GetAllMeta($query);
        return count($x)?1:0;  //confirm
    }


} 