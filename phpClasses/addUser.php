<?php


    ini_set('display_errors', 1);
	  error_reporting(E_ALL ^ E_NOTICE);
	  require($_SERVER['DOCUMENT_ROOT']."/dataManager.php");

	  $data= new dataManager();
	  $dbh=$data->getInstance();
    //echo $_POST['username'];

        $userTaken=$data->isUsernameTaken($_POST['username']);
        $emailTaken=$data->isEmailTaken($_POST['email']);
        // Ensure that the user has entered a non-empty username
        if(empty($_POST['username'])) {
            echo 1;
        }
        // Ensure that the user has entered a non-empty password
        else if(empty($_POST['password'])){
            echo 2;
        }
        // Make sure the user entered a valid E-Mail address
        else if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
        {
            echo 3;
        }
        else if($userTaken){
          echo 4;
        }

        // Now we perform the same type of check for the email address, in order
        // to ensure that it is unique.

        else if($emailTaken){
          echo 5;
        }
        else{
          $data->hashPassAndStore($_POST);
          echo 6;
        }

?>
