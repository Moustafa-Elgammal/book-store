<?php

/**
 * to check if there is an admine user is log in
 */
function Is_Admin() {
	if (! isset ( $_SESSION ['is_admin'] ) && $_SESSION ['is_admin'] != 1) {
		System::RedirectTo ( 'login.php' );
	}
	/*
	 * file which assign all the inportant info for the recent user
	 */
	require 'now.php';
}
?>