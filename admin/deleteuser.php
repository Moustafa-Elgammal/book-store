<?php 
require_once ("../globals.php");
Is_Admin();
/**
 * Users controller
 */
require_once (CONTROLLERS . 'UsersController.php');


/**
 * models
 * users 
 */
require_once (MODELS . 'UsersModel.php');


// articles model object
$UsersModel = new UsersModel ();



// articles controller object
$Controller = new UsersController ($UsersModel );




// delete
$Controller->Delete();