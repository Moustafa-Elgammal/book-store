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
     * get a meta by  id
     * @param $id
     * @return array of the review data or empty
     */
    public function GetById($id){
        $id = (int)$id;

        $book = $this->GetAllReviews("WHERE meta_id = $id");
        return $book[0];
    }



    /**
     * get meta of one user
     * @param $id
     * @return array
     */
    public function GetByUserID($id){
        $id = (int)$id; // init
        $user_meta = $this->GetAllReviews("WHERE meta_user_id = $id"); // order
        return $user_meta; // return data
    }

    public function GetByMetaType($user_id,$meta_type){
        $user_id = (int)$user_id; // init
        $meta_type = (int) $meta_type;
        $user_meta = $this->GetAllReviews("WHERE (meta_user_id = $user_id AND meta_type = $meta_type)"); // order
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

    public function UpdateMeta($id,$data){
        $id = (int) $id; //init
        System::Get('db')->Update($this->table_name,$data,"WHERE meta_id = '$id'"); //update
        $x = System::Get('db')->AffectedRows(); //check
        return $x? true:false;  //confirm
    }



} 