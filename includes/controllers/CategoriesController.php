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
               'category_photo' => $_POST['photo'],
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

    /**
     * get all categories
     */
    public function AllCategories(){
        $cats = $this->CatModel->GetAllCats();
        System::Get('tpl')->assign('categories',$cats);
        System::Get('tpl')->draw('allCats');
    }

    /**
     * delete category
     */
    public function deleteCategory(){
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){

            if(!isset($_POST['id']) || !(int)$_POST['id'] )
                die(json_encode(array(
                    'status' => 0
                )));
            $id = (int)$_POST['id'];
            $x = $this->CatModel->DeleteCategory($id);
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

    public function GetCategoryInfo(BooksModel $bookModel){
        if(isset($_GET['id']) && (int)$_GET['id']){
            $id = (int)$_GET['id'];
            $category = $this->CatModel->GetById($id);
            !empty($category)?System::Get('tpl')->assign($category):die('404');
            $books = $bookModel->GetByCatId($id);
            System::Get('tpl')->assign('books',$books);
            System::Get('tpl')->draw('header');
            System::Get('tpl')->draw('category');
            System::Get('tpl')->draw('footer');
        }else{
            echo '404';
        }
    }

    /**
     * update category
     */
    public function UpdateCategory(){
        $data= array(); //init

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

            //init cover photo
            if(isset($_POST['photo']) && strlen($_POST['photo']) > 5 && file_exists($_POST['photo'])){
                $data['category_photo'] = $_POST['photo'];
            } else{
                $data['category_photo'] = $_POST['photo_old'];
            }

            $data['category_title'] = $_POST['title'];
            $data['category_content'] = $_POST['content'];
            $id = (int)$_POST['id'];
            $x = $this->CatModel->UpdateCategory($id,$data);
            if ($x)
                die(json_encode(array(
                    'status' => 1,
                    "msg"    => "Category Update successfully"
                )));

            else
                die(json_encode(array(
                    'status' => 0,
                    "msg"    => "No thing changed"
                )));

        }elseif(isset($_GET['id'])&&(int)$_GET['id']){
            $id = (int)$_GET['id'];
            $category = $this->CatModel->GetById($id);
            System::Get('tpl')->assign($category);
            System::Get('tpl')->draw('UpdateCategory');

        }

    }

} 