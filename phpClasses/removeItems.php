<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL ^ E_NOTICE);
	require($_SERVER['DOCUMENT_ROOT']."/dataManager.php");
	$data= new dataManager();
	//echo "connected";
	$prodAbv=$_POST['prodAbv'];
  $number=$_POST['number'];
  //$prodID=data->getProdIDFromCode($prodCode);
  //$initialRem=$data->getRemaining($prodID);

  try{
	  $data->removeItems($prodAbv, $number);
    echo true;
  }catch (Exception $e) {
    //echo 'Caught exception: ',  $e->getMessage(), "\n";
    echo false;
  }
  //$finalRem=$data->getRemaining($prodID);
  //if($initialRem==$finalRem){
    //return true;
  //}
  //else{
    //return false;
  //}

  //shit needs to go in a try catch for this to work
?>
