<?php
// when header isn't set it redirect to $location
$location = "../../home";
if (! headers_sent ()) {
	header ( "Location:$location" );
	exit ();
} else {
	$red = '<script type="text/javascript">';
	$red .= 'window.location.href="' . $location . '";';
	$red .= '</script>';
	echo $red;
	
	/* -------------- HTML meta refresh--------- */
	$meta = '<noscript>';
	$meta .= '<meta-http-equiv="refresh" content="0;url=' . $location . '"/>';
	$meta .= '</noscript>';
	
	echo $meta;
	exit ();
}