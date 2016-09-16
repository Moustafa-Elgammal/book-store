<?php
/**
 * Created by PhpStorm.
 * User: music
 * Date: 9/16/2016
 * Time: 4:15 PM
 */

class UsersMetaController {
    private $MetaModel;

    public function __construct(UsersMetaModel $model){
        $this->MetaModel = $model;
    }

    public function addReview(){
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            if ($_SESSION['uid'])
                die(json_encode(array(
                    'status' => 0,
                    'msg' => 'you Must login first'
                )));

            if (!$_POST['book_id'])
                die(json_encode(array(
                    'status' => 0,
                    'msg' => 'please refresh this page'
                )));
            $data =array(

            );

        }else{
            die(json_encode(array(
                'status' => 0,
                'msg' => 'error'
            )));
        }

    }


} 