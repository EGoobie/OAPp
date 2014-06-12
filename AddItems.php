<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL ^ E_NOTICE);	
	require($_SERVER['DOCUMENT_ROOT']."/dataTest.php");
	$data= new dataTest();
	//echo "connected";
	$data->addItems($_POST);
	echo "items added";
 
?> 