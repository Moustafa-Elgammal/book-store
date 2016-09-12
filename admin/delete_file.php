<?php

require_once("../globals.php");

Is_Admin();
if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
    die(0);
}

if(isset($_POST['file'])) {
    $dir = explode('/',$_POST['file']);
    if($dir[1] == 'uploads')
        die(unlink($_POST['file']));
    else
        die(0);
}
 else
    die(0);