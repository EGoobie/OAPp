<?php


    ini_set('display_errors', 1);
	  error_reporting(E_ALL ^ E_NOTICE);
	  require($_SERVER['DOCUMENT_ROOT']."/dataManager.php");

	  $data= new dataManager();
	  $dbh=$data->getInstance();
    echo $_POST['username'];

        $userTaken=$data->isUsernameTaken($_POST['username']);
        // Ensure that the user has entered a non-empty username
        if(empty($_POST['username'])) {
            //echo a code here
        }
        // Ensure that the user has entered a non-empty password
        else if(empty($_POST['password'])){
            //echo another code here
        }
        // Make sure the user entered a valid E-Mail address
        else if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
        {
            //echo another code here
        }
        else if($userTaken){
          //echo another code
          //die
        }

        // Now we perform the same type of check for the email address, in order
        // to ensure that it is unique.
        $emailTaken=$data->isEmailTaken($_POST['email']);
        if($emailTaken){
          //echo another code
          //die
        }
        else{
          $data->hashPassAndStore($_POST);
          //echo code
        }

?>
