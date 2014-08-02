<?php
    ini_set('display_errors', 1);
	  error_reporting(E_ALL ^ E_NOTICE);
	  require($_SERVER['DOCUMENT_ROOT']."/dataManager.php");

	  $data= new dataManager();
	  $dbh=$data->getInstance();

    session_start();

    // We remove the user's data from the session
    unset($_SESSION['user']);

    echo true;
?>