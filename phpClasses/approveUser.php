<?php


    ini_set('display_errors', 1);
	  error_reporting(E_ALL ^ E_NOTICE);
	  require($_SERVER['DOCUMENT_ROOT']."/dataManager.php");

	  $data= new dataManager();
	  $dbh=$data->getInstance();
    //echo $_POST['username'];


       $user=$_POST['username'];
       $data->approveUser($user);
?>
