<?php session_start();?>
<!DOCTYPE html>
<!--PHP includes-->
<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL ^ E_NOTICE);
	require($_SERVER['DOCUMENT_ROOT']."/dataManager.php");
	$data= new dataManager();
	$category="Analytics";

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

    <title>Analytics</title>

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

  <!--Chart js files-->
  <script src="js/highcharts.js"></script>
  <script src="js/highcharts-more.js"></script>
  <script src="js/exporting.js"></script>
  <script src="chartManager.js"></script>



    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

     <?php include($_SERVER['DOCUMENT_ROOT']."/navbar.php"); ?>

		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			<h1 class="page-header">Analytics</h1>
      <div class="col-lg-12">

          <div class="btn-group ">
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

      </div>
      <div class="col-lg-12">
       <div class="panel panel-default">
         <div class="panel-heading">
          <div class="row">
            <div class="col-md-6">
              <h4>Timeline of Beverage Item Removal</h4>
            </div>
            <div class="col-md-6">
             <div class="btn-group pull-right">
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
            </div>
           </div>
          </div>
        <div class="panel-body">
          <div id="timeline" class="col-md-12"></div>
        </div>
       </div>
      </div>

      <div class="col-lg-12">
       <div class="panel panel-default">
         <div class="panel-heading">
              <h4>Cases Remaining</h4>
         </div>
         <div class="panel-body">
            <div id="remBeverages" class="col-md-12"></div>
         </div>
       </div>
      </div>

      <div class="col-lg-12">
       <div class="panel panel-default">
         <div class="panel-heading">
              <h4>Food Items Remaining</h4>
         </div>
         <div class="panel-body">
            <div id="remFood" class="col-md-12"></div>
         </div>
       </div>
      </div>


    <script>
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
