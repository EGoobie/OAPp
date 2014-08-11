
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="oapIconB.jpg">

    <title>OAP Inventory Manager Login</title>

    <!-- Bootstrap core CSS -->
	  <script src="js\jquery-2.1.1.min.js"></script>
	  <script src="js\bootstrap.min.js"></script>
    <link href="css\bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/css/signin.css" rel="stylesheet">


  </head>

  <body>

    <div class="container">
      <h1 class="centered" id="text">OAP Inventory Manager</h1>

      <form class="form-signin" role="form">
        <h2 class="form-signin-heading">Please sign in</h2>
        <input type="email" name="username" class="form-control" placeholder="Username" value="<?php echo $_COOKIE['remember_me']; ?>" required autofocus>
        <input type="password" name="password" class="form-control" placeholder="Password" required>
        <div class="checkbox">
          <label>
            <input type="checkbox" value="remember-me" name="remember"<?php
              if(isset($_COOKIE['remember_me'])) {
		            echo 'checked="checked"';
	            }
	            else {
		            echo '';
	            }
	          ?>>Remember me
          </label>

        </div>
        <div class="alert alert-danger" role="alert" id="loginFail" style="display:none;">
              Incorrect username or password
        </div>
        <button class="btn btn-lg btn-primary btn-block" id="submit" type="submit">Sign in</button>
      </form>
      <div class="centered">
      <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#registerModal">
				    Register Account
		 </button>
     </div>
    </div> <!-- /container -->


 <script>
		$(document).ready(function () {
			$('#submit').click(function(e){
				console.log("in onclick");
				e.preventDefault();
				e.stopPropagation();
				loginUser();
			});
		});
		function loginUser() {
					console.log("were in");
					$.ajax({
						type: "POST",
					url: "/phpClasses/login.php",
          dataType: 'HTML',
					data: $('form.form-signin').serialize(),
						success: function(data){
							//alert(data);
							//console.log($('form.form-signin').serialize());
							if(data){
                 window.location.href='index.php';
              }

              else{
                $('#loginFail').show();
             }

						},
					error: function(){
						alert("failure");
						console.log($('form.removeItem').serialize());
						console.log("failed");
					}

					});

		}
  </script>

  <!-- Modal Register Account -->
			<div id="registerModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
			<div class="modal-content">
	        <div class="modal-header">
	              <a class="close" data-dismiss="modal">×</a>
	              <h3>Register Account</h3>
	        </div>
				<div>
					<form class="register">
					<fieldset>
					<div class="modal-body">
            <input type="email" name="username" class="form-control" placeholder="Username" required autofocus>
            <div class="alert alert-danger" role="alert" id="noUsername" style="display:none;">
              Please enter a username.
            </div>
            <div class="alert alert-danger" role="alert" id="takenUsername" style="display:none;">
              This username is already taken, please use another one.
            </div>
            <input type="email" name="email" class="form-control" placeholder="Email" required autofocus>
            <div class="alert alert-danger" role="alert" id="takenEmail" style="display:none;">
              This email is already registered to an account.
            </div>
            <div class="alert alert-danger" role="alert" id="invalidEmail" style="display:none;">
              Please enter a valid email address
            </div>
            <input type="password" name="password" class="form-control" placeholder="Password" required>
            <div class="alert alert-danger" role="alert" id="noPassword" style="display:none;">
              Please enter a password
            </div>
					</div>
					</fieldset>
					</form>
          <div class="alert alert-success" role="alert" id="registerSuccess" style="display:none;">
              Account has been registered. Please wait until an admin approves your account.
            </div>
				</div>
			<div class="modal-footer">
				<button class="btn btn-success" id="submit2">Register</button>
				<a href="#" class="btn btn-default" data-dismiss="modal">Cancel</a>
			</div>
			</div>
			</div>
		</div>

		<script>
		$(document).ready(function () {
			$('#submit2').click(function(e){
				console.log("in onclick");
				e.preventDefault();
				e.stopPropagation();
				register();
			});
		});
		function register() {
					console.log("were in");
					$.ajax({
						type: "POST",
					url: "/phpClasses/addUser.php",
          dataType: 'HTML',
					data: $('form.register').serialize(),
						success: function(data){
							//alert(data);
							if(data==1){
                 $('#noUsername').show();
                 $('#noPassword').hide();
                 $('#invalidEmail').hide();
                 $('#takenUsername').hide();
                 $('#takenEmail').hide();
              }
              else if(data==2){
                 $('#noPassword').show();
                 $('#noUsername').hide();
                 $('#invalidEmail').hide();
                 $('#takenUsername').hide();
                 $('#takenEmail').hide();
              }
              else if(data==3){
                 $('#invalidEmail').show();
                 $('#noUsername').hide();
                 $('#noPassword').hide();
                 $('#takenUsername').hide();
                 $('#takenEmail').hide();
              }
              else if(data==4){
                 $('#takenUsername').show();
                 $('#noUsername').hide();
                 $('#noPassword').hide();
                 $('#invalidEmail').hide();
                 $('#takenEmail').hide();
              }
              else if(data==5){
                 $('#takenEmail').show();
                 $('#noUsername').hide();
                 $('#noPassword').hide();
                 $('#invalidEmail').hide();
                 $('#takenUsername').hide();
              }
              else if(data==6){
                 $('form.register').hide();
                 $('#registerSuccess').show();
                 $('#noUsername').hide();
                 $('#noPassword').hide();
                 $('#invalidEmail').hide();
                 $('#takenUsername').hide();
                 $('#takenEmail').hide();
                 setTimeout(function() { $("#registerModal").modal('hide'); }, 2000);
              }

						},
					error: function(){
						alert("failure");
						console.log("failed");
					}

					});
		}
    </script>
  </body>
</html>
