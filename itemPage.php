<?php session_start();?>
<!DOCTYPE html>
<!--PHP includes-->
<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL ^ E_NOTICE);
	require($_SERVER['DOCUMENT_ROOT']."/dataManager.php");
	$data= new dataManager();
	$prod= $_POST['Product'];
  $mainProdID=$data->getProdID($prod);

  if(empty($_SESSION['user'])){
     // If they are not, we redirect them to the login page.
     header("Location: loginPage.php");

    die("Redirecting to loginPage.php");
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

    <title><?php echo $prod;?></title>

     <!-- Bootstrap core CSS -->
	<script src="js/jquery-2.1.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/oappMain.css" rel="stylesheet">
	<link href="css/component.css" rel="stylesheet">
	<link href="css/font-awesome.min.css" rel="stylesheet">
   <link href="css/fontstyle.css" rel="stylesheet">

	<!--Accordion Script -->
	<script src="js/accordion.js"></script>
	<script src="js/collapse.js"></script>
	<script src="js/jquery.redirect.min.js" type="text/javascript"></script>

  </head>

  <body>

       <?php include($_SERVER['DOCUMENT_ROOT']."/navbar.php"); ?>

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header"><?php echo $prod;?></h1>
		  <h2 class="sub-header">Items</h2>
        <div class="row">
            <!-- Button trigger modal -->
        <div class="col-md-12">
			    <button class="btn btn-success btn-lg" data-toggle="modal" data-target="#addItemsModal" id="itemPage">
				     <i class="fa fa-plus-circle"></i> Adjust Number of Items
			    </button>
			  </div>


                    <div class="col-lg-4 col-md-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <span aria-hidden="true" data-icon="&#xe60c;" class="icon-bars2 large"></span>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php echo $data->getRemaining($mainProdID); ?></div>
                                        <div>Items Remaining</div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <span aria-hidden="true" data-icon="&#xe60a;" class="icon-stats large"></span>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php echo $data->itemsRemLastDay($mainProdID);?></div>
                                        <div>removed in last 24 hours</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <span aria-hidden="true" data-icon="&#xe609;" class="icon-pie large"></span>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php echo $data->itemsPercentage($mainProdID);?> %</div>
                                        <div>share of <?php $cat=$data->getCatFromProd($mainProdID); echo $data->getCatName($cat);?> sold</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

        <div class="col-md-12">
         <div class="panel panel-default">
           <div class="panel-heading">
              <h4>Recently Removed <?php echo $prod;?></h4>
           </div>
           <div class="panel-body">
            <table class="table">
               <thead>
                  <tr>
                    <th>Quantity</th>
                    <th>Time of removal</th>
                  </tr>
               </thead>
               <tbody>
                  <?php $recentRem=$data->recentlyRemoved();
                      for($i=0;$i<25;$i++){
                        if($recentRem[$i]['name']==$prod){
                        echo ("<tr><th>".$recentRem[$i]['quantity']."</th><th>".$recentRem[$i]['timestamp']."</th></tr>");
                        }
                      }
                  ?>
               </tbody>
            </table>
           </div>
         </div>
        </div>
      </div>

			<!-- Modal Add Items -->
			<div id="addItemsModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
			<div class="modal-content">
	        <div class="modal-header">
	              <a class="close" data-dismiss="modal">×</a>
	              <h3><i class="fa fa-plus-circle"></i> Adjust Number of Items</h3>
	        </div>
				<div>
					<form class="addItems">
					<fieldset>
					<div class="modal-body">
            <h4> Number of items </h4>
            <div class="col-md-12">
            <div class="input-group spinner" id="inputAdd">
              <input type="text" class="form-control" value=<?php echo $data->getRemaining($mainProdID); ?> name="numItems">
              <div class="input-group-btn-vertical">
                <button class="btn btn-primary"><i class="fa fa-caret-up"></i></button>
                <button class="btn btn-primary"><i class="fa fa-caret-down"></i></button>
              </div>
            </div>
            </div>
						<input type="hidden" name="prodID" value=<?php echo $mainProdID;?>>
            <div class="alert alert-success" role="alert" id="itemAddSuccess" style="display:none;">
              Item count has been successfully adjusted!
            </div>
            <div class="alert alert-danger" role="alert" id="itemAddFail" style="display:none;">
              Oops, something is wrong, please try again
            </div>
					</div>
					</fieldset>
					</form>
				</div>
			<div class="modal-footer">
				<button class="btn btn-success" id="submit"><i class="fa fa-plus-circle"></i> Adjust Number of Items</button>
				<a href="#" class="btn btn-default" data-dismiss="modal">Cancel</a>
			</div>
			</div>
			</div>
		</div>
		<script>
		$(document).ready(function () {
			$('#submit').click(function(e){
				e.preventDefault();
				e.stopPropagation();
				addToDB();
			});
		});
		function addToDB() {
					$.ajax({
						type: "POST",
					url: "/phpClasses/adjustNumbers.php",
					data: $('form.addItems').serialize(),
						success: function(data){
							//alert(data);
							console.log($('form.addItems').serialize());
              if(data){
                $( '#inputAdd' ).hide();
                $('#itemAddSuccess').show();
                $('#itemAddFail').hide();

							  setTimeout(function() { $("#addItemsModal").modal('hide');}, 500);
                setTimeout(function() { linkProduct('<?php echo $prod;?>'); }, 500);
              }

              else{
                $('#itemAddFail').show();
              }
						},
					error: function(){
						alert("failure");
					}

					});

		}

    (function ($) {
      $('.spinner .btn:first-of-type').on('click', function(e) {
        e.preventDefault();
				e.stopPropagation();
        $('.spinner input').val( parseInt($('.spinner input').val(), 10) + 1);
      });
      $('.spinner .btn:last-of-type').on('click', function(e) {
        e.preventDefault();
				e.stopPropagation();
        if(parseInt($('.spinner input').val(), 10)!=0){
          $('.spinner input').val( parseInt($('.spinner input').val(), 10) - 1);
        }
      });
    })(jQuery);
		</script>



        </div>
    </div>

	<script type="text/javascript">
	jQuery(document).ready(function($){
			console.log("in function");
			var currCat = '<?php echo $category;?>';
			console.log(currCat);
			$("h4[id="+currCat+"]").removeClass("panel-title").addClass("active");
		});
	</script>
	<script language="javascript">
		function linkCategory($category){
			console.log("function called");
			$.redirect('productPage.php', { 'Category': $category}, 'POST' );
		}

		function linkProduct($product){
			console.log("function called");
			$.redirect('itemPage.php', { 'Product': $product}, 'POST' );
		}

		function deleteProduct($product){
			console.log("function called");
			//add in warning message
			$.post('deleteProduct.php', {'Product': $product});
			//use ajax to update page
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
	</script>
  </body>
</html>
