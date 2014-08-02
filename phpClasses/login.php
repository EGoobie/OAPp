<?php

    ini_set('display_errors', 1);
	  error_reporting(E_ALL ^ E_NOTICE);
	  require($_SERVER['DOCUMENT_ROOT']."/dataManager.php");

	  $data= new dataManager();
	  $dbh=$data->getInstance();

    $submittedUsername=$_POST['username'];

    try{
       $row = $data->getLoginParams($submittedUsername);
    } catch(PDOException $ex){
       echo "problem";
    }

    $login_ok = false;


    // Using the password submitted by the user and the salt stored in the database,
    // we now check to see whether the passwords match by hashing the submitted password
    // and comparing it to the hashed version already stored in the database.
    $check_password = hash('sha256', $_POST['password'] . $row['salt']);
    for($round = 0; $round < 65536; $round++){
       $check_password = hash('sha256', $check_password . $row['salt']);
    }

    if($check_password === $row['password'] && $row['approved']==1){
       // If they do, then we flip this to true
       $login_ok = true;
    }

    // If the user logged in successfully, then we send them to the private members-only page
    // Otherwise, we display a login failed message and show the login form again
    if($login_ok){

       if($_POST['remember']) {
          $year = time() + 31536000;
          setcookie('remember_me', $_POST['username'], $year,'/');
       }
       elseif(!$_POST['remember']) {
	        if(isset($_COOKIE['remember_me'])) {
		        $past = time() - 100;
		        setcookie(remember_me, gone, $past,'/');
	        }
        }

       unset($row['salt']);
       unset($row['password']);

       //check if a session has already been started
       if(session_id() == '') {
         session_start();
       }

       // This stores the user's data into the session at the index 'user'.
       // We will check this index on the private members-only page to determine whether
       // or not the user is logged in.  We can also use it to retrieve
       // the user's details.
       $_SESSION['user'] = $row;

       //send back that lgin was successful
       echo true;
     }
     else{
       // Tell the user they failed
       echo false;
     }
?>
