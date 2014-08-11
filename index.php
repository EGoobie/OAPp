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
	<script src="js\jquery-2.1.1.min.js"></script>
	<script src="js\bootstrap.min.js"></script>
    <link href="css\bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css\oappMain.css" rel="stylesheet">
	<link href="css\component.css" rel="stylesheet">
	<link href="css\font-awesome.min.css" rel="stylesheet">

	<!--Accordion Script -->
	<script src="js\accordion.js"></script>
	<script src="js\collapse.js"></script>
	<script src="js\jquery.redirect.min.js" type="text/javascript"></script>

  <!--Chart js files-->
  <script src="js\highcharts.js"></script>
  <script src="js\highcharts-more.js"></script>
  <script src="js\exporting.js"></script>
  <script src="chartManager.js"></script>



    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
     <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container-fluid">
		 <div class="navbar-header">
		  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar">
			 <span class="sr-only">Toggle navigation</span>
             <span class="icon-bar"></span>
             <span class="icon-bar"></span>
             <span class="icon-bar"></span>
           </button>
          <a class="navbar-brand" href="index.php"><img  id="oapIcon" height="40px" src="oapIconB.jpg"  alt="The best place on Earth">OAP Inventory Manager</a>
        </div>
      </div>

    </div>

    <div class="container-fluid" id="sidebar" role="navigation">

		<div class="row">
			<div class="col-sm-3 col-md-2 sidebar">

				<!--<ul class="nav nav-sidebar">
					<li class="active"><a href="#">Overview</a></li>
				</ul>
				<ul class="nav nav-sidebar" id="accordion">
					<?php
						//$catQuery=$data->getCategories();
						//foreach($catQuery as $category){
							//$catName= $category['category'];?>
						<li><div><a href="#"><?php //echo $catName;?></a><a href="#"><span class="glyphicon glyphicon-chevron-down pull-right"></span></a></div>
						<ul>
							<?php
								//$prodQuery=$data->getProducts($catName);
								//foreach($prodQuery as $product){
									//$prodName= $product['name'];?>
									<li><a href="#"><?php //echo $prodName;?></a></li>
							<?php //} ?>
						</ul>
						</li>
						<?php //} ?>
				</ul>-->

				<div class="panel-group" id="accordion">
				<div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 id="Overview" class="panel-title">
                            <i class="fa fa-home"></i>
                            </span><a href ="#">Overview</a> </a>
                        </h4>
                    </div>

                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 id="Beverages" class="panel-title">
                            <i class="fa fa-beer"></i>
                            <a id= "Beverages" href = "#" onclick="linkCategory('Beverages');return false;">Beverages</a><i data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="fa fa-chevron-down pull-right"></i> </a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse">
                        <div class="panel-body">
                            <table class="table">
                                <?php
								$prodQuery=$data->getProducts('Beverages');
								foreach($prodQuery as $product){
									$prodName= $product['name'];
									$prodID= $product['prodID'];
									$remaining=$data->getRemaining($prodID);?>
								<tr>
                                    <td>
                                        <a href="#" onclick="linkProduct('<? echo $prodName;?>');return false;"><?php echo $prodName;?></a>
										<span class="badge"><?php echo $remaining;?></span>
                                    </td>
                                </tr>
								<?php } ?>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 id="Food" class="panel-title">
                            <i class="fa fa-cutlery"></i>
                            <a id="Food" href = "#" onclick="linkCategory('Food');return false;">Food</a><i data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" class="fa fa-chevron-down pull-right"></i> </a>
                        </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse">
                        <div class="panel-body">
                            <table class="table">
                                <?php
								$prodQuery=$data->getProducts('Food');
								foreach($prodQuery as $product){
									$prodName= $product['name'];
									$prodID= $product['prodID'];
									$remaining=$data->getRemaining($prodID);
									?>
								<tr>
                                    <td>
                                        <a href="#" onclick="linkProduct('<? echo $prodName;?>');return false;"><?php echo $prodName;?></a>
										<span class="badge"><?php echo $remaining;?></span>
                                    </td>
                                </tr>
								<?php } ?>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <i class="fa fa-bar-chart-o"></i>
                            <a href = "#">Analytics</a><i data-toggle="collapse" data-parent="#accordion" href="#collapseThree" class="fa fa-chevron-down pull-right"></i> </a>
                        </h4>
                    </div>
                    <div id="collapseThree" class="panel-collapse collapse">
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-usd"></span><a href="#">Sales</a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
			</div>
			</div>
		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			<h1 class="page-header">Overview</h1>
			<button class="btn btn-danger btn-lg" data-toggle="modal" data-target="#removeItemModal">
				Remove Item
			</button>

      <div class="btn-group">
        <button type="button" class="btn btn-success btn-lg dropdown-toggle" data-toggle="dropdown">
          <i class="fa fa-file-excel-o"></i> Excel export <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" role="menu">
            <li><a href="#" onclick="excelExporter('1');return false;" >Last day</a></li>
            <li><a href="#" onclick="excelExporter('2');return false;" >Last 2 days</a></li>
            <li><a href="#" onclick="excelExporter('7');return false;">Last week</a></li>
            <li><a href="#" onclick="excelExporter('31');return false;">Last month</a></li>
            <li><a href="#" onclick="excelExporter('365');return false;">All</a></li>
        </ul>
      </div>
      <button class="btn btn-danger btn-xs" id="logout">
				Logout
			</button>
      <div id="timelineChart">
        <div class="btn-group">
          <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
            <span class="Timespan">Last day</span> <span class="caret"></span>
          </button>
          <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
            <li><a href="#" onclick="updateTimeline('1');return false;">Last day</a></li>
            <li><a href="#" onclick="updateTimeline('2');return false;">Last 2 days</a></li>
            <li><a href="#" onclick="updateTimeline('7');return false;">Last week</a></li>
            <li><a href="#" onclick="updateTimeline('31');return false;">Last month</a></li>
            <li><a href="#" onclick="updateTimeline('365');return false;">All</a></li>
          </ul>
        </div>
        <div id="timeline" class="col-md-12"></div>
      </div>
      <div id="remBeverages" class="col-md-12"></div>
      <div id="remFood" class="col-md-12"></div>

			<!-- Modal Remove Item -->
			<div id="removeItemModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
			<div class="modal-content">
	        <div class="modal-header">
	              <a class="close" data-dismiss="modal">×</a>
	              <h3>Remove Item</h3>
	        </div>
				<div>
					<form class="removeItem">
					<fieldset>
					<div class="modal-body">
						<ul class="nav nav-list" id="input">
							<li class="nav-header">Enter 3 letter product code </li>
							<li><input class="input-xlarge" value="" type="text" name="prodAbv"></li>
              <li class="nav-header">Number of items to remove </li>
							<li><input class="input-xlarge" value="" type="text" name="number"></li>
						</ul>
            <div class="alert alert-success" role="alert" id="itemRemoveSuccess" style="display:none;">
              Items have been successfully removed!
            </div>
            <div class="alert alert-danger" role="alert" id="itemRemoveFail" style="display:none;">
              Oops, something is wrong, please try again
            </div>
					</div>
					</fieldset>
					</form>
				</div>
			<div class="modal-footer">
				<button class="btn btn-success" id="submit2">Remove Items</button>
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
				removeFromDB();
			});
		});
		function removeFromDB() {
					console.log("were in");
					$.ajax({
						type: "POST",
					url: "/phpClasses/removeItems.php",
          dataType: 'HTML',
					data: $('form.removeItem').serialize(),
						success: function(data){
							//alert(data);
							console.log($('form.removeItem').serialize());
							if(data){
                console.log(data);
                $( '#input' ).hide();
                $('#itemRemoveSuccess').show();
                $('#itemRemoveFail').hide();
                //$("#removeItemModal").modal('hide').delay(10000);
                setTimeout(function() { $("#removeItemModal").modal('hide'); }, 3000);
                setTimeout(function() { location.reload(); }, 3000);
              }

              else{
                $('#itemRemoveFail').show();
             }

						},
					error: function(){
						alert("failure");
						console.log($('form.removeItem').serialize());
						console.log("failed");
					}

					});

		}

    function excelExporter(days){
      filepath=null;
      $.ajax({
        type: 'POST',
        async: false,
        url: "/phpClasses/excelExport.php",
        data: {'days':days},
        success: function(retData) {
          console.log(retData);
          $("body").append("<iframe src='" + retData.url+ "' style='display: none;' ></iframe>");
          filepath=retData.url;
        }
      });

      setTimeout(function() {
        $.post('/phpClasses/deleteServerFile.php', {'filepath':filepath}, function(retData) {
          console.log(retData);
        });
      }, 3000);

    }
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

  $(function(){

    $(".dropdown-menu li a").click(function(){
        var li = $(this),
        btn=$(this).parents(".btn-group").find('.Timespan').text($(this).text());
        //btn = $('.btn:first-child'); // Maybe need a better selector?

        btn.find('span.Timespan').text(li.text());
        btn.val(li.text());
    });

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

    $(document).ready(function () {
			$('#logout').click(function(e){
				console.log("logout");
				e.preventDefault();
				e.stopPropagation();
				$.post( "/phpClasses/logout.php", function( data ) {
          location.reload();
        });
			});
		});

	</script>

    <?php //include($_SERVER['DOCUMENT_ROOT']."/chartManager.php"); ?>

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
