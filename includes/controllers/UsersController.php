<?php

class UsersController
{
    private $UsersModel;

    public function __construct(UsersModel $UsersModel)
    {
        $this->UsersModel= $UsersModel;
    }

    /* --------------------for ADMIN---------------------- */
    public function ShowAllUsers()
    {
        $users = $this->UsersModel->Get();
        System::Get('tpl')->assign('users',$users);
        System::Get('tpl')->draw('users');
    }
    /*
     * show admin user
     */
    public function ShowAdminUsers()
    {
        $users = $this->UsersModel->Get_By_Admin();
        System::Get('tpl')->assign('users',$users);
        System::Get('tpl')->draw('users');
    }

    public function ShowUser()
    {
        $uid=0; // init
        if(isset($_GET['uid']) && (int)$_GET['uid'] > 0 )
        {
            $uid=(int)$_GET['uid'];
            $user = $this->UsersModel->Get_By_ID($uid);
            if(count($user) > 0)
            {
                System::Get('tpl')->assign($user);
                System::Get('tpl')->draw('user');
            }
            else
            {
                System::Get('tpl')->assign('message',"User Not Found");
                System::Get('tpl')->draw('error');
            }
        }
        else
        {
            System::Get('tpl')->assign('message',"BAD");
            System::Get('tpl')->draw('404');
        }

    }
    /**
     * add new user
     */
    public function AddNewUser()
    {
        if(isset($_POST['submit']))
        {
            //set variables
            $name=$_POST['name'];
            $username=$_POST['username'];
            $email=$_POST['email'];
            $password=$_POST['password'];
            $re_password=$_POST['re_password'];
            $job=$_POST['job'];
            $is_admin=$_POST['is_admin'];
            $adddate=date('d-m-Y');


            //---------------validation-------//
            $error=array();

            // name check
            if(strlen($name) < 5)
                $error[]="name length must be more than 5 letters";

            //username check
            if(strlen($username) < 4)
                $error[]="username length must be more than 4 letters";



            //email check
            if(!filter_var($email,FILTER_VALIDATE_EMAIL))
                $error[]="chech the E-mail";


            //password matched check
            if($password != $re_password)
            {
                $error[]="The password Not Matched";

            }


            //password length check
            if( strlen($password) < 8)
            {
                $error[]="the password must be at least 8 letters";
            }



            if(count($error) == 0)
            {

                //set user info in  array $data
                $data=array(
                    'name' 		=>	$name,
                    'username'	=>	$username,
                    'email'		=>  $email,
                    'password'	=>  System::Hash($password),
                    'adddate'	=>	$adddate,
                    'is_admin'	=>  $is_admin,
                    'job'		=>  $job,
                );

                //sort the user in db
                $this->UsersModel->Add($data);
                System::Get('tpl')->assign('message','User Added');
                System::Get('tpl')->draw('success');

            }
            else
            {
                System::Get('tpl')->assign('message',$error);
                System::Get('tpl')->draw('back');

            }


        }
        else
        {

            System::Get('tpl')->draw('adduser');


        }


    }





    /**
     * upadet user
     */
    public function Update()
    {

        if(isset($_POST['submit']))
        {
            //set variables
            $name=$_POST['name'];
            $username=$_POST['username'];
            $email=$_POST['email'];
            $job=$_POST['job'];
            $is_admin=$_POST['is_admin'];

            //validation
            $error=array();
            // name check
            if(strlen($name) < 5)
                $error[]="name length must be more than 5 letters";

            //username check
            if(strlen($username) < 4)
                $error[]="username length must be more than 4 letters";
            //email check
            if(!filter_var($email,FILTER_VALIDATE_EMAIL))
                $error[]="chech the E-mail";

            /*-----chech errors----*/
            if(count($error) == 0)
            {

                //set user info in  array $data
                $data=array(
                    'name' 		=>	$name,
                    'username'	=>	$username,
                    'email'		=>  $email,
                    'is_admin'	=>  $is_admin,
                    'job'		=>  $job
                );

                //sort the user in db
                $uid=(int)$_POST['uid'];
                $this->UsersModel->Update($uid, $data);
                System::Get('tpl')->assign('message','User INFO Updated');
                System::Get('tpl')->draw('success');

            }
            else
            {
                System::Get('tpl')->assign('message',$error);
                System::Get('tpl')->draw('updateuser');

            }
        }



        else
        {

            $uid=0;
            if(isset($_GET['uid']) && (int)$_GET['uid'] > 0)
            {

                $uid=(int)$_GET['uid'];

                //get user from db
                $user= $this->UsersModel->Get_By_ID($uid);
                if(count($user) > 0)
                {
                    // if user  found
                    System::Get('tpl')->assign($user);
                    System::Get('tpl')->draw('updateuser');
                }
                else
                {
                    //article not found
                    System::Get('tpl')->assign('message','Id Not Found');
                    System::Get('tpl')->draw('404');

                }

            }
            else
            {
                // no id
                System::Get('tpl')->assign('message','Invalid Id');
                System::Get('tpl')->draw('404');
            }


        }

    }







    /**
     * delete user
     */
    public function Delete()
    {
        $uid=0; //init

        if(isset($_GET['uid']) && (int)$_GET['uid'] > 0)
        {

            $uid=(int)$_GET['uid'];


            $this->UsersModel->Delete($uid);
            if(System::Get('db')->AffectedRows() > 0 )
            {
                System::Get('tpl')->assign('message','User Deleted');
                System::Get('tpl')->draw('success');
            }
            else
            {
                System::Get('tpl')->assign('message',"NOT FOUND");
                System::Get('tpl')->draw('404');
            }




        }
        else
        {
            System::Get('tpl')->assign('message','You are lost !');
            System::Get('tpl')->draw('404');
        }
    }

    /**
     * log in function
     *
     */
    public function login()
    {
        //assign init value for nothing
        System::Get('tpl')->assign("message","");

        //checking form submit
        if(isset($_POST['submit']))
        {


            //varibles
            $username = $_POST['username'];
            $password = $_POST['password'];

            //validation
            $error=array();
            if (strlen($username) <= 0)
                $error[]="check Username";
            if (strlen($password) <= 0)
                $error[]="check Password";

            //check errors
            if(count($error) == 0 )
            {
                //check in model db if True
                if($this->UsersModel->Login($username,$password))
                {

                    $userdata = $this->UsersModel->GetUserInfo();

                    //set user sessions
                    $_SESSION["is_admin"] = $userdata['is_admin'];
                    $_SESSION["username"] = $userdata['username'];
                    $_SESSION["name"] = $userdata['name'];
                    $_SESSION["uid"] = $userdata['uid'];

                    //var_dump($_SESSION);
                    if($_SESSION['is_admin']==1)
                    {

                        System::RedirectTo('index.php');

                    }
                    else
                    {

                        System::Get('tpl')->assign("message",array(0=>"you can't continue because you are not admin user"));
                        System::Get('tpl')->draw("login");
                    }
                }

                //user not in db
                else
                {

                    System::Get('tpl')->assign("message",array(0=>'User not found'));
                    System::Get('tpl')->draw("login");

                }

            }
            // there are errors in submited username or password
            else
            {
                System::Get('tpl')->assign("message",$error);
                System::Get('tpl')->draw("login");
            }


        }
        // nothing happened else
        else
        {
            System::Get ( 'tpl' )->draw ( "login" );
        }


    }

    public function Reset_password()
    {
        if (isset($_POST["submit"]) && isset($_POST["uid"]) && (int)$_POST["uid"] > 0)
        {
            //variables
            $uid = (int)$_POST["uid"]; //init

            //get the old password in hash
            $old_password_from_user=System::Hash($_POST["old_password"]);
            var_dump($old_password_from_user);
            //the new password
            $new_password = System::Hash($_POST["new_password"]);
            $re_password = System::Hash($_POST["re_password"]);
            var_dump($new_password);
            //check the data base
            System::Get('db')->Execute("SELECT * FROM `users` WHERE `users`.`uid`='$uid'");
            if(System::Get('db')->AffectedRows())
                $userinfo_from_db= System::Get('db')->GetRows();
            var_dump($userinfo_from_db[0]["password"]);
            //validation
            $error=array();
            //check old password
            if($old_password_from_user != $userinfo_from_db[0]["password"])
                $error [] = "check the past password";
            if($new_password != $re_password )
                $error [] = "Keep the two password the same values ";

            if( count($error) == 0)
            {	//set the update in data base
                if($this->UsersModel->Reset_password($uid, $new_password))
                {	//if the update done show success message
                    System::Get('tpl')->assign('message',"password update");
                    System::Get('tpl')->draw("success");
                }
                else//can't update the password in database
                {
                    System::Get('tpl')->assign('message',"can't reset password");
                    System::Get('tpl')->draw('404');
                }
            }
            else
            {	//show the errors when the user reset the passwird
                System::Get ( 'tpl' )->assign ( 'message', $error ); // show the error
                System::Get ( 'tpl' )->draw ( 'back' );

            }
        }
        else
        {
            System::Get ( 'tpl' )->draw ( 'reset_passowrd' ); //draw the template of  the reset form
        }
    }

    public function SignUp(){
        if(isset($_POST['id']))
            if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

            } else {


            }
        else{
            System::Get('tpl')->draw('header');
            System::Get('tpl')->draw('signup');
            System::Get('tpl')->draw('footer');
        }
    }

}