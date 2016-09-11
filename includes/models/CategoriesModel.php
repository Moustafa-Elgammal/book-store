<?php

class CategoriesModel {
    private $table_name ;

    public function __construct(){
        $this->table_name = PREFIX."categories";
    }

    /**
     * get all Categories
     * @param string $extra [optional WHERE statement]
     * @return array 2D of the Categories || or Empty
     */
    public function GetAllCats($extra = '')
    {
        $category = array(); //init

        $query = sprintf("SELECT * FROM %s %s", $this->table_name, $extra); // query
        //echo $query;
        System::Get('db')->Execute($query); //execute the query
        if (System::Get('db')->AffectedRows()) { // check
            $category = System::Get('db')->GetRows(); //assign
            return $category; //return
        }
        return $category;// ! return
    }

    /**
     * get a Category by  id
     * @param $id
     * @return array of the category data or empty
     */
    public function GetById($id){
        $id = (int)$id;

        $category = $this->GetAllCats("WHERE category_id = $id");
        return !empty($category)? $category[0]: array();
    }

    /**
     * Delete a category by it's id
     * @param $cat_id
     * @return bool true when delete,else false
     */
    public function DeleteCategory($cat_id){
        $id = (int)$cat_id; //init
        System::Get('db')->Delete($this->table_name,"WHERE book_id = $id"); // delete
        $x = System::Get('db')->AffectedRows(); //check
        return $x ? true:false; //confirm
    }

    /**
     * @param $data
     * @return bool true if added |else false
     */
    public function AddNewCategory($data){
        System::Get('db')->Insert($this->table_name,$data); // add
        $x = System::Get('db')->AffectedRows(); //check
        return $x? true:false;  //confirm
    }

    public function UpdateCategory($id,$data)
    {
        $id = (int)$id; //init
        System::Get('db')->Update($this->table_name, $data, "WHERE category_id = '$id'"); //update
        $x = System::Get('db')->AffectedRows(); //check
        return $x ? true : false;  //confirm
    }

}