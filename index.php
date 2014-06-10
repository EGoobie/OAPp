
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../assets/ico/favicon.ico">

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
    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
	
	<!--PHP includes--> 
		<?php
		 require($_SERVER['DOCUMENT_ROOT']."/dataTest.php");
		 $data= new dataTest();
		?>
	 
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>	 
	<!--ASFOUR STUFF <div class="container">
		<ul id="gn-menu" class="gn-menu-main">
			<li class="gn-trigger">
				<a class="gn-icon gn-icon-menu"><span>Menu</span></a>
				<nav class="gn-menu-wrapper">
					<div class="gn-scroller">
						<ul class="gn-menu">
							<li class="gn-search-item">
								<input placeholder="Search" type="search" class="gn-search">
								<a class="gn-icon gn-icon-search"><span>Search</span></a>
							</li>
							<li>
								<a class="gn-icon gn-icon-download">Products</a>
							</li>
						</ul>
					</div><!-- /gn-scroller -->
				<!-- SECONDARY COMMENT BECAUSE THE OTHER ENDS ^</nav>
			</li>
			<li><a>OAP INVENTORY MANAGER</a></li>
			<li><a><span>Remove Product</span></a></li>
			<li><a><span>Add Product</span></a></li>
		</ul>
	</div><!-- /container -->

     <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container-fluid">
		 <div class="navbar-header">
		  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar">
			 <span class="sr-only">Toggle navigation</span>
             <span class="icon-bar"></span>
             <span class="icon-bar"></span>
             <span class="icon-bar"></span>
           </button>
          <a class="navbar-brand" href="index.html">OAP Inventory Manager</a>
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
                        <h4 class="active">
                            <i class="fa fa-home"></i>
                            </span><a href ="#">Overview</a> </a>
                        </h4>
                    </div>
                    
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"><i class="fa fa-beer"></i>
                            </span><a href = productPage.html>Beverages</a><i data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="fa fa-chevron-down pull-right"></i> </a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse">
                        <div class="panel-body">
                            <table class="table">
                                <?php
								$prodQuery=$data->getProducts('Beverages');
								foreach($prodQuery as $product){
									$prodName= $product['name'];?>
								<tr>
                                    <td>
                                        <a href="#"><?php echo $prodName;?></a>
										<span class="badge">4</span>
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
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"><i class="fa fa-cutlery"></i>
                            </span><a href = productPage.html>Food</a><i data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" class="fa fa-chevron-down pull-right"></i> </a>
                        </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse">
                        <div class="panel-body">
                            <table class="table">
                                <?php
								$prodQuery=$data->getProducts('Food');
								foreach($prodQuery as $product){
									$prodName= $product['name'];?>
								<tr>
                                    <td>
                                        <a href="#"><?php echo $prodName;?></a>
										<span class="badge">4</span>
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
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree"><span class="glyphicon glyphicon-file">
                            </span><a href = productPage.html>Analytics</a><i data-toggle="collapse" data-parent="#accordion" href="#collapseThree" class="fa fa-chevron-down pull-right"></i> </a>
                        </h4>
                    </div>
                    <div id="collapseThree" class="panel-collapse collapse">
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-usd"></span><a href="http://www.jquery2dotnet.com">Sales</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-user"></span><a href="http://www.jquery2dotnet.com">Customers</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-tasks"></span><a href="http://www.jquery2dotnet.com">Products</a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
			</div>
			</div>
			    
		</div>
	
	<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
				<h1 class="page-header">Inventory</h1>
	</div>      


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
