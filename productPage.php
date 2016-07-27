<?php session_start();?>
<!DOCTYPE html>
<!--PHP includes-->
<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL ^ E_NOTICE);
	require($_SERVER['DOCUMENT_ROOT']."/dataManager.php");
	$data= new dataManager();
	$mainCategory= $_POST['Category'];
  $catID=$data->getCatID($mainCategory);

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

    <title><?php echo $mainCategory; ?></title>

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
    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <?php include($_SERVER['DOCUMENT_ROOT']."/navbar.php"); ?>

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header"><?php echo $mainCategory; ?></h1>
		  <h2 class="sub-header">Products</h2>
          <div id="prodList" class="list-group">
				<?php
					$prodQuery=$data->getProducts($mainCategory);
					foreach($prodQuery as $product){
					  $prodName= $product['name'];
            $prodID= $product['prodID'];
            $remaining=$data->getRemaining($prodID);?>
					  <a href="#" onclick="linkProduct('<? echo $prodName;?>');return false;"class="list-group-item"><? echo $prodName;?></a>

					  <button href="#" onclick="storeProduct('<?php echo $prodName;?>');return false;" class="btn btn-sm btn-danger pull-right" data-toggle="modal" data-target="#deleteProductModal">Remove Product</button>
				<?php } ?>
			</div>
			<!-- Button trigger modal -->
			<button class="btn btn-success btn-lg" data-toggle="modal" data-target="#addProductModal">
				<i class="fa fa-plus-circle"></i> Add Product
			</button>

			<!-- Modal Add Product -->
			<div id="addProductModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
			<div class="modal-content">
	        <div class="modal-header">
	              <a class="close" data-dismiss="modal">×</a>
	              <h3><i class="fa fa-plus-circle"></i> Add Product</h3>
	        </div>
				<div>

					<div class="modal-body">
           <fieldset>
           <form role="form" class="addProduct">
            <div class="col-md-12" id="input">
              <div class="form-group">
                <label for="">Enter product name</label>
                <input type="email" class="form-control" id="" placeholder="ex: Sapporo"  name="name">
              </div>
            </div>
            <div class="col-md-12" id="input2">
              <div class="form-group">
                <label for="">Enter three letter product abbreviation code</label>
                <input type="email" class="form-control" id="" placeholder="ex: SAP"  name="prodAbv">
              </div>

            </div>

						<input type="hidden" name="catID" value=<?php echo $catID;?>>
            <div class="alert alert-success" role="alert" id="productAddSuccess" style="display:none;">
              Product has been successfully added!
            </div>
            <div class="alert alert-danger" role="alert" id="usedAbvFail" style="display:none;">
              The 3 letter code is already taken, please try again
            </div>
            <div class="alert alert-warning" role="alert" id="productAlreadyExists" style="display:none;">
              The product you have added already exists in the database
            </div>
            <div class="alert alert-danger" role="alert" id="abvError" style="display:none;">
              Oops, something is wrong with the 3 letter code, please try again making sure it contains no numbers and exactly 3 letters
            </div>
            <div class="alert alert-success" role="alert" id="productInRemProd" style="display:none;">
              Product has been successfully added back to database from the archive.
            </div>
					</div>
					</fieldset>
					</form>
				</div>
			<div class="modal-footer">
				<button class="btn btn-success" id="submit"><i class="fa fa-plus-circle"></i> Add Product</button>
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
					url: "/phpClasses/addProduct.php",
					data: $('form.addProduct').serialize(),
						success: function(data){
              console.log($('form.addProduct').serialize());
							if(data=='1'){
                $( '#input' ).hide();
                $( '#input2' ).hide();
                $('#productAlreadyExists').show();
                $('#usedAbvFail').hide();
                $('#productAddSuccess').hide();
                $('#abvError').hide();
                $('#productInRemProd').hide();
                setTimeout(function() { $("#addProductModal").modal('hide'); }, 500);
              }
              if(data=='2'){
                $( '#input' ).hide();
                $( '#input2' ).hide();
                $('#productAlreadyExists').hide();
                $('#usedAbvFail').hide();
                $('#productAddSuccess').hide();
                $('#abvError').hide();
                $('#productInRemProd').show();
                setTimeout(function() { $("#addProductModal").modal('hide'); }, 500);
                setTimeout(function() { linkCategory('<?php echo $mainCategory;?>'); }, 500);
              }
              if(data=='3'){
                $('#productAlreadyExists').hide();
                $('#usedAbvFail').show();
                $('#productAddSuccess').hide();
                $('#abvError').hide();
                $('#productInRemProd').hide();
              }
              if(data=='4'){
                $( '#input' ).hide();
                $( '#input2' ).hide();
                $('#productAlreadyExists').hide();
                $('#usedAbvFail').hide();
                $('#productAddSuccess').show();
                $('#abvError').hide();
                $('#productInRemProd').hide();
                setTimeout(function() { $("#addProductModal").modal('hide'); }, 500);
                setTimeout(function() { linkCategory('<?php echo $mainCategory;?>'); }, 500);
              }
              if(data=='5'){
                $('#productAlreadyExists').hide();
                $('#usedAbvFail').hide();
                $('#productAddSuccess').hide();
                $('#abvError').show();
                $('#productInRemProd').hide();
              }
						},
					error: function(){
						alert("failure");
					}

					});

		}
		</script>

		<!-- Modal Delete Product Warning -->
			<div id="deleteProductModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
			<div class="modal-content">
	        <div class="modal-header">
	              <a class="close" data-dismiss="modal">×</a>
	              <h3><i class="fa fa-exclamation-triangle"></i>Warning</h3>
	        </div>
				<div>

          <div class="alert alert-danger" role="alert" id="prodDeleteAlert" style="display:none;">
              There may be items remaining in stock for this product. Deleting this product will also remove all remaining items WITHOUT recording their removal. Are you sure you want to delete this product?
          </div>
          <div class="alert alert-success" role="alert" id="prodDeleteSuccess" style="display:none;">
              Product has been successfully deleted.
          </div>
          <div class="alert alert-danger" role="alert" id="prodDeleteFail" style="display:none;">
              Oops, something went wrong, please try again.
          </div>
          <script type="text/javascript">
          $('#prodDeleteAlert').show();
          </script>
				</div>
			<div class="modal-footer">
				<button class="btn btn-danger" id="submit1" onclick="deleteProduct(getStoredProduct());return false;">Delete Product</button>
				<a href="#" class="btn btn-default" data-dismiss="modal">Cancel</a>
			</div>
			</div>
			</div>
		</div>
        </div>
    </div>

	<script type="text/javascript">
		jQuery(document).ready(function($){
			//console.log("in function");
			var currCat = '<?php echo $mainCategory;?>';
			//console.log(currCat);
			$("h4[id="+currCat+"]").removeClass("panel-title").addClass("active");
		});
	</script>
	<script language="javascript">
		var storedProduct;
		function storeProduct($product){
			storedProduct=$product;
			return;
		}

		function getStoredProduct(){
			console.log(storedProduct);
			return storedProduct;
		}

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
			//$.post('deleteProduct.php', {'Product': $product}, );
      $.ajax({
						type: "POST",
					  url: "/phpClasses/deleteProduct.php",
            dataType: 'HTML',
					  data: {'Product': $product},
						success: function(data){
							if(data){
               $('#prodDeleteAlert').hide();
               $('#prodDeleteSuccess').show();
               $('#prodDeleteFail').hide();
               setTimeout(function() { $("#deleteProductModal").modal('hide'); }, 3000);
                setTimeout(function() { linkCategory('<?php echo $mainCategory;?>'); }, 3000);
              }

              else{
               $('#prodDeleteAlert').hide();
               $('#prodDeleteSuccess').hide();
               $('#prodDeleteFail').show();
             }
					 },
			});
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
