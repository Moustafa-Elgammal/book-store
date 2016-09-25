<?php
/**
 * Created by PhpStorm.
 * User: music
 * Date: 9/17/2016
 * Time: 10:19 AM
 */

class ReviewsController {
    private $reviewsModel;

    public function __construct(ReviewsModel $model){
        $this->reviewsModel = $model;
    }

    public function AddReview(){
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            if (!$_SESSION['uid'])
                die(json_encode(array(
                    'status' => 0,
                    'msg' => 'you Must login first'
                )));

            if (!isset($_POST['uid']) || $_SESSION['uid'] != (int)$_POST['uid']  )
                die(json_encode(array(
                    'status' => 0,
                    'msg' => 'Please Refresh this page'
                )));
            if ($this->reviewsModel->ReviewExist((int)$_POST['book_id'],(int)$_SESSION['uid']))
                die(json_encode(array(
                    'status' => 0,
                    'msg' => 'You have been review this book before'
                )));

            if (!isset($_POST['number']) || (int)$_POST['number'] < 1 || (int)$_POST['number']  > 10 )
                die(json_encode(array(
                    'status' => 0,
                    'msg' => 'review scale must be from 1 to 10 only'
                )));

            if (!isset($_POST['book_id']) || !(int)$_POST['book_id'])
                die(json_encode(array(
                    'status' => 0,
                    'msg' => 'please refresh this page'
                )));

            if ($this->reviewsModel->ReviewExist((int)$_POST['book_id'],(int)$_SESSION['uid']))
                die(json_encode(array(
                    'status' => 0,
                    'msg' => 'You have been review this book before'
                )));

            $data = array(
                'review_percent'=>(int)$_POST['number'],
                'review_content'=>$_POST['content'],
                'review_book_id'=>(int)$_POST['book_id'],
                'review_user_id'=>$_SESSION['uid']
            );

            $x= $this->reviewsModel->AddNewReview($data);
            $x?die(json_encode(array(
                'status' => 1,
                'msg' => 'Successfully Reviewed.'
            ))):die(json_encode(array(
                'status' => 0,
                'msg' => 'Error in connection.'
            )));

        } else{
            echo '404';
        }
    }

    public function DeleteReview()
    {
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            if (!$_SESSION['uid'])
                die(json_encode(array(
                    'status' => 0,
                    'msg' => 'you Must login first'
                )));

            if (!isset($_POST['user_id']) ||( $_SESSION['is_admin'] != 1 &&  $_SESSION['uid'] != (int)$_POST['user_id']))
                die(json_encode(array(
                    'status' => 0,
                    'msg' => 'You can\'t delete this.'
                )));




        }
    }
} 