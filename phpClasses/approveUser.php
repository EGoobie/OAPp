<?php


    ini_set('display_errors', 1);
	  error_reporting(E_ALL ^ E_NOTICE);
	  require($_SERVER['DOCUMENT_ROOT']."/dataManager.php");

	  $data= new dataManager();
	  $dbh=$data->getInstance();
    //echo $_POST['username'];

	$fun=$_POST['function'];
	$user=$_POST['username'];
	if ($fun=="approve"){
    	try{
    		$data->approveUser($user);
	  		echo true;
  		}catch(Exception $e){
        	echo false;
  		}
	
	}elseif ($fun=="remove") {
	  	try{
    		$data->remAdminUser($user);
	  		echo true;
  		}catch(Exception $e){
        	echo false;
  		}
	 
	}elseif ($fun=="add") {
	  	try{
    		$data->addAdminUser($user);
	  		echo true;
  		}catch(Exception $e){
        	echo false;
  		}
	}elseif($fun=="deleteAcc"){
		try{
    		$data->deleteAccount($user);
	  		echo true;
  		}catch(Exception $e){
        	echo false;
  		}
	}

    
?>
