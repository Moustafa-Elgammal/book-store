<?php
//data for user in login
$NOWUSER = $_SESSION;
System::Get('tpl')->assign('NOWUSERNAME',$NOWUSER['username']);
System::Get('tpl')->assign('NOWNAME',$NOWUSER['name']);
System::Get('tpl')->assign('NOWUID',$NOWUSER['uid']);

/**
 * the notification message in the headed
 * direct to get from the data base
 */


