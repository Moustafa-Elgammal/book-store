<?php
require_once("../globals.php");
Is_Author();
System::Get('tpl')->draw('header');
//System::Get('tpl')->draw(''); //index content
System::Get('tpl')->draw('footer');