<?php
/**
 * Created by PhpStorm.
 * User: tone
 * Date: 12/09/2016
 * Time: 10:51 ص
 */

class CategoriesController {

    private $CatModel;

    /**
     * @param CategoriesModel $model
     */
    public function __construct(CategoriesModel $model){
        $this->CatModel = $model;
    }

    public function AddCategory(){

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

           $data = array(
               'category_title' => $_POST['title'],
               'category_content' => $_POST['content'],
               'category_user_id' => $_SESSION['uid']
           );

           $x = $this->CatModel->AddNewCategory($data);

           if ($x)
           die(json_encode(array(
               'status' => 1,
               "msg"    => "New category Added successfully"
           )));

           else
               die(json_encode(array(
                   'status' => 0,
                   "msg"    => "Error to add the category"
               )));

       }else{
            System::Get('tpl')->draw('addcategory');
       }

    }



} 