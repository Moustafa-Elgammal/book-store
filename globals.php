<?php
date_default_timezone_set ( "Africa/Cairo" );
session_start ();
/*
 * project DIRS INFO
 */
define ( "ROOT", dirname ( __FILE__ ) );
define ( "INC", ROOT . "/includes/" );
define ( 'CORE', INC . '/core/' );
define ( "MODELS", INC . '/models/' );
define ( "CONTROLLERS", INC . '/controllers/' );
define ( "LIBS", INC . '/libs/' );


/*
 * requiring the main System files
 */
require_once (CORE . 'config.php');

//require_once (CORE . 'mysql.class.php');
require_once (CORE . 'pdo.php');

require_once (CORE . 'raintpl.class.php');
require_once (CORE . 'system.class.php');
require_once (CORE . 'transcript.php');
require_once (LIBS . 'uploader.php');
require_once (INC . 'general.php');

// strore object of RAINTPL CLASS
System::Store ( 'tpl', new RainTPL () );

// strore object of DB CLASS
require_once (CORE . 'pdo.php');
System::Store ( 'db', new MyPDO() );

System::Get('tpl')->assign('NOWUID','');
if(!empty($_SESSION)) {
    $NOWUSER = $_SESSION;
    System::Get('tpl')->assign('NOWUSERNAME', $NOWUSER['username']);
    System::Get('tpl')->assign('NOWNAME', $NOWUSER['name']);
    System::Get('tpl')->assign('NOWUID', $NOWUSER['uid']);
}