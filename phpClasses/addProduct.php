<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL ^ E_NOTICE);
 require($_SERVER['DOCUMENT_ROOT']."/dataManager.php");
 $data= new dataManager();
	//echo "connected";
  $name=$_POST['name'];
  $prodAbv=$_POST['prodAbv'];
  $abvGood=$data->abvCheck($prodAbv);
  $inProducts=$data->containsProdCurr($name);
  $inRemProducts=$data->containsProdRem($name);
  $usedAbv=$data->containsAbv($prodAbv);

  //case 1: product already exists.
  //case 2: product existed but was deleted, add it back to active products
  //case 3: abbreviation is used
  //case 4: everything is good, add the product
  //case 5: abbreviation is not 3 letters
 if($inProducts){
    echo '1';
  }
  else if($inRemProducts){
    $data->addProductFromRemProd($name);
    echo '2';
  }
  else if(!$abvGood){
    echo '5';
  }
  else if($usedAbv){
    echo '3';
  }
  else{
	  $data->addProduct($_POST);
	  echo '4';
  }
?>
