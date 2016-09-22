<?php

function Author(){
    if (isset ( $_SESSION ['is_admin'] ) && $_SESSION ['is_admin'] > 1) {
        System::RedirectTo ( 'index.author.php' );
    }
}

/**
 * to check if there is an admin user is log in
 */

function Is_Admin() {
    if (! isset ( $_SESSION ['is_admin'] ) || $_SESSION ['is_admin'] < 1) {
        System::RedirectTo ( 'login.php' );
    }
    /*
     * file which assign all the important info for the recent user
     */
    require 'now.php';
}

/**
 * to check if there is an Author user is log in
 */
function Is_Author() {
    if (! isset ( $_SESSION ['is_admin'] ) || $_SESSION ['is_admin'] != 2) {
        System::RedirectTo ( 'login.php' );
    }
    /*
     * file which assign all the important info for the recent user
     */
    require 'now.php';
}

