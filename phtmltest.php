<?php
 echo "this is php";
?>
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

	<!--Accordion Script -->
	<script src="js\accordion.js"></script>
	<script src="js\collapse.js"></script>
    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
	
	<!--PHP includes--> 
		<?php
		 require($_SERVER['DOCUMENT_ROOT']."/dataTest.php");
		 $data= new dataTest();
		 echo "data test good";
		?>
	 
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
          <a class="navbar-brand" href="index.html">OAP Inventory Manager</a>
        </div>
      </div>
    </div>
	<div class="container-fluid" id="sidebar" role="navigation">
	
		<div class="row">
			<div class="col-sm-3 col-md-2 sidebar">
				
				<ul class="nav nav-sidebar">
					<li class="active"><a href="#">Overview</a></li>
				</ul>
				<ul class="nav nav-sidebar" id="accordion"> 
					<?php
						$catQuery=$data->getCategories();
						foreach($catQuery as $category){
							$catName= $category['category'];?> 
						<li><div><a href="#"><span><?php echo $catName;?></span></a></div>
						<ul>
							<?php
								$prodQuery=$data->getProducts($catName);
								foreach($prodQuery as $product){
									$prodName= $product['name'];?>
									<li><a href="#"><?php echo $prodName;?></a></li>
							<?php } ?>			
							
						</ul>
						</li>
						<?php } ?>
					
				
					<!--<li><div><a href="#"><span>Food</span></a></div>
						<ul>
							<li><a href="#">Burger</a></li>
							<li><a href="#">Chicken</a></li>
							<li><a href="#">Veggie</a></li>
						</ul>
					</li>
					<li><div><a href="#"><span>Beverages</span></a></div>
						<ul>
							<li><a href="#">Beer</a></li>
							<li><a href="#">Smirnoff</a></li>
							<li><a href="#">Non-Alcoholic</a></li>
						</ul>
					</li>-->
				</ul>
			</div>
			    
		</div>
	</div> 
	<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
				<h1 class="page-header">Inventory</h1>
	</div>      

   
  </body>
</html>	