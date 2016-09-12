<?php

require_once("../globals.php");

Is_Admin();
if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
    die(0);
}

if(isset($_POST['file']))
    die(unlink($_POST['file']));
 else
    die(0);