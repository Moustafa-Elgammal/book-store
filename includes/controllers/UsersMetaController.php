<?php
/**
 * Created by PhpStorm.
 * User: music
 * Date: 9/16/2016
 * Time: 4:15 PM
 */
define('WANT_TO_READ','1');
define('DOWNLOADED','2');
class UsersMetaController {
    private $MetaModel;

    public function __construct(UsersMetaModel $model){
        $this->MetaModel = $model;
    }

    public function WantToRead(){
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            if (!$_SESSION['uid'])
                die(json_encode(array(
                    'status' => 0,
                    'msg' => 'you Must login first'
                )));

            if (!(int)$_POST['book_id'])
                die(json_encode(array(
                    'status' => 0,
                    'msg' => 'please refresh this page'
                )));
            if($this->MetaModel->CheckExist((int)$_POST['book_id'],(int)$_SESSION['uid'],WANT_TO_READ))
                die(json_encode(array(
                    'status' => 0,
                    'msg' => 'You have read this book before'
                )));

            $data =array(
                'meta_book_id'=>(int)$_POST['book_id'],
                'meta_user_id'=>(int)$_SESSION['uid'],
                'meta_type'=>WANT_TO_READ
            );

            $x = $this->MetaModel->AddNewMeta($data);
            $x?die(json_encode(array(
                'status' => 1,
                'msg' => 'Successfully Read'
            ))):die(json_encode(array(
                'status' => 0,
                'msg' => 'cant add now'
            )));

        }else{
            die(json_encode(array(
                'status' => 0,
                'msg' => 'error'
            )));
        }

    }

    public function DownloadBook(){
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            if (!$_SESSION['uid'])
                die(json_encode(array(
                    'status' => 0,
                    'msg' => 'you Must login first'
                )));

            if (!(int)$_POST['book_id'])
                die(json_encode(array(
                    'status' => 0,
                    'msg' => 'please refresh this page'
                )));
            if($this->MetaModel->CheckExist((int)$_POST['book_id'],(int)$_SESSION['uid'],DOWNLOADED))
                die(json_encode(array(
                    'status' => 0,
                    'msg' => 'You have downloaded this book before'
                )));

            $data =array(
                'meta_book_id'=>(int)$_POST['book_id'],
                'meta_user_id'=>(int)$_SESSION['uid'],
                'meta_type'=>DOWNLOADED
            );

            $x = $this->MetaModel->AddNewMeta($data);
            $x?die(json_encode(array(
                'status' => 1,
                'msg' => 'Successfully Read'
            ))):die(json_encode(array(
                'status' => 0,
                'msg' => 'cant add now'
            )));

        }else{
            die(json_encode(array(
                'status' => 0,
                'msg' => 'error'
            )));
        }

    }

    public function UserProfile(){
        $readBooks = $this->MetaModel->GetByMetaType($_SESSION['uid'],WANT_TO_READ);
        $downloadedBooks = $this->MetaModel->GetByMetaType($_SESSION['uid'],DOWNLOADED);

        echo'<pre>';
        var_dump($readBooks);
        echo'<hr>';
        var_dump($downloadedBooks);

    }

} 