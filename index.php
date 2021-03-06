<?php session_start();?>
<!DOCTYPE html>
<!--PHP includes-->
<?php
ini_set('display_errors', 1);
error_reporting(E_ALL ^ E_NOTICE);
require($_SERVER['DOCUMENT_ROOT']."/dataManager.php");
$data= new dataManager();
$category="Overview";

 /* if(empty($_SESSION['user'])){
     // If they are not, we redirect them to the login page.
     header("Location: loginPage.php");

    die("Redirecting to loginPage.php");
  }*/
  /*if($_SESSION['preference']==2){
    echo <script type="text/javascript"> $("document").ready(function() { $("#foodClick").trigger('click');});</script>
  }*/
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

  </head>

    <body>

      <?php include($_SERVER['DOCUMENT_ROOT']."/navbar.php"); ?>

      <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
       <h1 class="page-header">Overview</h1>
       <div class="row">
        <ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
          <li class="active"><a href="#beverages" id="bev" data-toggle="tab">Beverages</a></li>
          <li><a href="#food" id="foodClick" data-toggle="tab">Food</a></li>
        </ul>
        <div id="my-tab-content" class="tab-content">
         <div class="tab-pane active" id="beverages">
           <div class="panel-body">
            <div class="col-md-12">
              <button class="btn btn-danger btn-block" data-toggle="modal" data-target="#removeBeverageModal">
                <i class="fa fa-minus-circle"></i> Remove Item
              </button>
            </div>

            <div class="col-md-12">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h4>Recently Removed Items</h4>
                </div>
                <div class="panel-body">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Time of removal</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $recentRem=$data->recentlyRemoved();
                      for($i=0;$i<15;$i++){
                        $itemProdCode=$recentRem[$i]['prodCode'];
                        $category=$data->getCatFromProd($itemProdCode);
                        $removalTime=strtotime($recentRem[$i]['timestamp']);
                        $currentTime=strtotime("now");
                        $timeDifference= $currentTime-$removalTime;
                        if($category==1){
                          if($timeDifference<1800){
                            $timeDifferenceMins=round($timeDifference/60);
                            echo ("<tr><th>".$recentRem[$i]['name']."</th><th>".$recentRem[$i]['quantity']."</th><th>".$timeDifferenceMins." mins ago</th></tr>");
                          }
                          else{
                            echo ("<tr><th>".$recentRem[$i]['name']."</th><th>".$recentRem[$i]['quantity']."</th><th>".$recentRem[$i]['timestamp']."</th></tr>");
                          }
                        }
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>    
          </div>
        </div>
        <div class="tab-pane active" id="food">
          <div class="panel-body">
            <div class="col-md-12">
              <button class="btn btn-danger btn-block" data-toggle="modal" data-target="#removeFoodModal">
                <i class="fa fa-minus-circle"></i> Remove Item
              </button>
            </div>

            <div class="col-md-12">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h4>Recently Removed Items</h4>
                </div>
                <div class="panel-body">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Time of removal</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $recentRem=$data->recentlyRemoved();
                      for($i=0;$i<15;$i++){
                        $itemProdCode=$recentRem[$i]['prodCode'];
                        $category=$data->getCatFromProd($itemProdCode);
                        $removalTime=strtotime($recentRem[$i]['timestamp']);
                        $currentTime=strtotime("now");
                        $timeDifference= $currentTime-$removalTime;
                        if($category==2){
                          if($timeDifference<1800){
                            $timeDifferenceMins=round($timeDifference/60);
                            echo ("<tr><th>".$recentRem[$i]['name']."</th><th>".$recentRem[$i]['quantity']."</th><th>".$timeDifferenceMins." mins ago</th></tr>");
                          }
                          else{
                            echo ("<tr><th>".$recentRem[$i]['name']."</th><th>".$recentRem[$i]['quantity']."</th><th>".$recentRem[$i]['timestamp']."</th></tr>");
                          }
                        }
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div> 
          </div>
        </div>
      </div>




      <!-- Modal Remove Beverages -->
      <div id="removeBeverageModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <a class="close" data-dismiss="modal">×</a>
              <h3><i class="fa fa-minus-circle"></i> Remove Item</h3>
            </div>
            <div>

              <div class="modal-body">
                <fieldset>
                  <form role="form" class="form removeItem" id="removeItem">
                  </form>
                  <div class="col-md-12" id="info">
                    <div class="alert alert-info" role="alert" id="prodIndex">

                      <?php
                      $beverageProducts=$data->getProducts('Beverages');
                      foreach($beverageProducts as $beverage){
                        $name=$beverage['name'];
                        $abv=$beverage['prodAbv'];
                        echo("<button class=\"btn btn-primary btn-lg btn-block\" id=\"submit1\" onclick=\"selectProduct('".$abv."');return false;\">".$name."</button>");
                      //echo ("<tr><th>".$name."</th><th>".$abv."</th></tr>");
                      }
                      ?>

                      <?php
                      $beverageProducts=$data->getProducts('Food');
                      foreach($beverageProducts as $beverage){
                        $name=$beverage['name'];
                        $abv=$beverage['prodAbv'];
                      //echo ("<tr><th>".$name."</th><th>".$abv."</th></tr>");
                      }
                      ?>

                    </div>

                    <div class="alert alert-info" role="alert" id="numItems" style="display:none;">



                      <button class="btn btn-danger btn-lg btn-block" id="submit1" onclick="setAmount('4');return false;">Remove 4</button>
                      <button class="btn btn-danger btn-lg btn-block" id="submit1" onclick="setAmount('3');return false;">Remove 3</button>
                      <button class="btn btn-danger btn-lg btn-block" id="submit1" onclick="setAmount('2');return false;">Remove 2</button>
                      <button class="btn btn-danger btn-lg btn-block" id="submit1" onclick="setAmount('1');return false;">Remove 1</button>


                    </div>
                  </div>

                  <div class="alert alert-success" role="alert" id="itemRemoveSuccess" style="display:none;">
                    Items have been successfully removed!
                  </div>
                  <div class="col-md-12">
                    <div class="alert alert-danger" role="alert" id="itemRemoveFail" style="display:none;">
                      Oops, something is wrong, please make sure you have entered a valid code
                    </div>
                  </div>
                </fieldset>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal Remove Food -->
      <div id="removeFoodModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <a class="close" data-dismiss="modal">×</a>
              <h3><i class="fa fa-minus-circle"></i> Remove Item</h3>
            </div>
            <div>

              <div class="modal-body">
                <fieldset>
                  <form role="form" class="form removeItem" id="removeItem">
                  </form>
                  <div class="col-md-12" id="info">
                    <div class="alert alert-info" role="alert" id="prodIndex2">

                      <?php
                      $beverageProducts=$data->getProducts('Food');
                      foreach($beverageProducts as $beverage){
                        $name=$beverage['name'];
                        $abv=$beverage['prodAbv'];
                        echo("<button class=\"btn btn-primary btn-lg btn-block\" id=\"submit1\" onclick=\"selectProduct('".$abv."');return false;\">".$name."</button>");
                      //echo ("<tr><th>".$name."</th><th>".$abv."</th></tr>");
                      }
                      ?>

                    </div>

                    <div class="alert alert-info" role="alert" id="numItems2" style="display:none;">



                      <button class="btn btn-danger btn-lg btn-block" id="submit1" onclick="setAmount('4');return false;">Remove 4</button>
                      <button class="btn btn-danger btn-lg btn-block" id="submit1" onclick="setAmount('3');return false;">Remove 3</button>
                      <button class="btn btn-danger btn-lg btn-block" id="submit1" onclick="setAmount('2');return false;">Remove 2</button>
                      <button class="btn btn-danger btn-lg btn-block" id="submit1" onclick="setAmount('1');return false;">Remove 1</button>


                    </div>
                  </div>

                  <div class="alert alert-success" role="alert" id="itemRemoveSuccess2" style="display:none;">
                    Items have been successfully removed!
                  </div>
                  <div class="col-md-12">
                    <div class="alert alert-danger" role="alert" id="itemRemoveFail2" style="display:none;">
                      Oops, something is wrong, please make sure you have entered a valid code
                    </div>
                  </div>
                </fieldset>
              </div>
            </div>
          </div>
        </div>
      </div>

  
   







  <script>
  <?php
    $userData=$_SESSION['user'];
    if($userData['dataPreference']==2){
      echo '$("document").ready(function() { $("#foodClick").trigger("click");});';
    }
  ?>
    $(document).ready(function () {
     $('#submit2').click(function(e){
      console.log("in onclick");
      e.preventDefault();
      e.stopPropagation();
      removeFromDB();
    });
   });
    function removeFromDB() {
					//console.log("were in");
          $( '#input' ).hide();
          $( '#input2' ).hide();

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
                $( '#input2' ).hide();
                $( '#info' ).hide();
                $('#itemRemoveSuccess').show();
                $('#itemRemoveFail').hide();
                $('#itemRemoveSuccess2').show();
                $('#itemRemoveFail2').hide();
                //$("#removeItemModal").modal('hide').delay(10000);
                setTimeout(function() { $("#removeItemModal").modal('hide'); }, 500);
                setTimeout(function() { location.reload(); }, 500);
              }

              else{
                $('#itemRemoveFail').show();
                $('#itemRemoveFail2').show();
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
(function ($) {
  $('.spinner .btn:first-of-type').on('click', function(e) {
    e.preventDefault();
    e.stopPropagation();
    $('.spinner input').val( parseInt($('.spinner input').val(), 10) + 1);
  });
  $('.spinner .btn:last-of-type').on('click', function(e) {
    e.preventDefault();
    e.stopPropagation();
    if(parseInt($('.spinner input').val(), 10)!=1){
      $('.spinner input').val( parseInt($('.spinner input').val(), 10) - 1);
    }
  });
})(jQuery);

$(document).ready(function () {
 $('#forgotCodes').click(function(e){
  e.preventDefault();
  e.stopPropagation();
  $( '#forgotCodes' ).hide();
  $( '#codeIndex' ).show();
});
});
$(document).ready(function () {
 $('#infoclose').click(function(e){
  e.preventDefault();
  e.stopPropagation();
  $( '#forgotCodes' ).show();
  $( '#codeIndex' ).hide();
});
});
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
  var prod;
  function selectProduct(prodAbv){
    prod=prodAbv;
    $( '#prodIndex' ).hide();
    $( '#numItems' ).show();
    $( '#prodIndex2' ).hide();
    $( '#numItems2' ).show();
      //console.log(prod);
    }

    function setAmount(amt){
      number=amt;
      $( '#numItems' ).hide();
      $( '#numItems2' ).hide();
      //console.log(number);
      removeAndSubmit();
    }

    function removeAndSubmit(){

      var i = document.createElement("input"); //input element, text
      i.setAttribute("type", "hidden");
      i.setAttribute("id", "input");
      i.setAttribute('type',"text");
      i.setAttribute('name',"prodAbv");
      i.setAttribute('value',window.prod);
      console.log(window.prod);

      var s = document.createElement("input"); //input element, Submit button
      s.setAttribute("type", "hidden");
      s.setAttribute("id", "input2");
      s.setAttribute('type',"text");
      s.setAttribute('name',"number");
      s.setAttribute('value',window.number);
      console.log(window.number);

      document.getElementById("removeItem").appendChild(i);
      document.getElementById("removeItem").appendChild(s);

      //and some more input elements here
      //and dont forget to add a submit button

      //document.getElementsByTagName('body')[0].appendChild(f);
      //$('body').append(f);
      removeFromDB();

    }

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
