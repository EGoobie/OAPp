<?php session_start();?>
<!DOCTYPE html>
<!--PHP includes-->
<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL ^ E_NOTICE);
	require($_SERVER['DOCUMENT_ROOT']."/dataManager.php");
	$data= new dataManager();
	$category="Overview";

  if(empty($_SESSION['user'])){
     // If they are not, we redirect them to the login page.
     header("Location: loginPage.php");

    die("Redirecting to loginPage.php");
  }
  if($_SESSION['user']['admin']==0){
    header("Location: index.php");

    die("Redirecting to index.php");
  }

?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="oapIconB.jpg">

    <title>OApp main page</title>

    <!-- Bootstrap core CSS -->
	<script src="js/jquery-2.1.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/oappMain.css" rel="stylesheet">
	<link href="css/component.css" rel="stylesheet">
	<link href="css/font-awesome.min.css" rel="stylesheet">

	<!--Accordion Script -->
	<script src="js/accordion.js"></script>
	<script src="js/collapse.js"></script>
	<script src="js/jquery.redirect.min.js" type="text/javascript"></script>





    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <?php include($_SERVER['DOCUMENT_ROOT']."/navbar.php"); ?>

		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			<h1 class="page-header">Admin Menu</h1>
      <div class="row">
        <div class="col-md-12">
         <div class="panel panel-default">
          <table class="table">
                 <thead>
                  <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th></th>
                    <th></th>
                  </tr>
                 </thead>
                <tbody>
                  <?php $users=$data->getUsers();
                     foreach($users as $cUser){
									    $username= $cUser['username'];
									    $email= $cUser['email'];
                      $approved= $cUser['approved'];
                      $admin= $cUser['admin'];

									    echo ("<tr><th>".$username."</th><th>".$email."</th>");
                       if($admin==0){
                        echo("<th><button href=\"#\" onclick=\"addAdminUser('".$username."');return false;\" class=\"btn btn-sm btn-success\">Make Admin</button></th>");
                      }
                      else{
                        echo("<th><button href=\"#\" onclick=\"rmAdminUser('".$username."');return false;\" class=\"btn btn-sm btn-danger\">Remove Admin</button></th>");
                      }
                      if($approved==0){
                        echo("<th><button href=\"#\" onclick=\"approveUser('".$username."');return false;\" class=\"btn btn-sm btn-success\">Approve</button></th>");
                      }
                      else{
                        echo("<th><button href=\"#\" onclick=\"deleteUser('".$username."');return false;\" class=\"btn btn-sm btn-danger\">Delete Account</button></th>");
                      }

                      echo("</tr>");
                     }
                  ?>
               </tbody>
         </div>
        </div>
      </div>
	  </div>

  <script>
  	function linkCategory($category){
			console.log("function called");
			$.redirect('productPage.php', { 'Category': $category}, 'POST' );
		}
		function linkProduct($product){
			console.log("function called");
			$.redirect('itemPage.php', { 'Product': $product}, 'POST' );
		}

    function logoutClick(){
      console.log("logout");
				$.post( "/phpClasses/logout.php", function( data ) {
          location.reload();
        });
    }

    $(document).ready(function () {
			$("#user li:eq(2)").click(function(e){
				console.log("logout");
				e.preventDefault();
				e.stopPropagation();
				$.post( "/phpClasses/logout.php", function( data ) {
          location.reload();
        });
			});
		});

    function approveUser($user){
      $.ajax({
						type: "POST",
					  url: "phpClasses/approveUser.php",
            dataType: 'HTML',
					  data: {'username': $user, 'function': "approve"},
						success: function(data){
							if(data){
                location.reload();
              }
					 },
			});
    }

    function rmAdminUser($user){
      $.ajax({
            type: "POST",
            url: "phpClasses/approveUser.php",
            dataType: 'HTML',
            data: {'username': $user, 'function': "remove"},
            success: function(data){
              if(data){
                location.reload();
              }
           },
      });
    }

    function addAdminUser($user){
      $.ajax({
            type: "POST",
            url: "phpClasses/approveUser.php",
            dataType: 'HTML',
            data: {'username': $user, 'function': "add"},
            success: function(data){
              if(data){
                location.reload();
              }
           },
      });
    }

    function deleteUser($user){
      $.ajax({
            type: "POST",
            url: "phpClasses/approveUser.php",
            dataType: 'HTML',
            data: {'username': $user, 'function': "deleteAcc"},
            success: function(data){
              if(data){
                location.reload();
              }
           },
      });
    }

	</script>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->

    <!-- <script src="js/bootstrap.min.js"></script> -->

    <!--<script src="js\docs.min.js"></script>-->
	<script src="js\classie.js"></script>
	<!--<script src="js\gnmenu.js"></script>

	<script>
		new gnMenu( document.getElementById( 'gn-menu' ) );
	</script>-->
  </body>
</html>
