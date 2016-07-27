<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL ^ E_NOTICE);
	require($_SERVER['DOCUMENT_ROOT']."/dataManager.php");
	$data= new dataManager();
	//echo "connected";
	$prodID=$_POST['prodID'];
  $actual=$_POST['numItems'];

  $remaining=$data->getRemaining($prodID);
  //echo $remaining;
  $difference=$remaining-$actual;

  if($difference>0){
    try{
      $data->removeItemsNoArchive($prodID, $difference);
      echo true;
    }catch (Exception $e) {
      //echo 'Caught exception: ',  $e->getMessage(), "\n";
      echo false;
    }
  }
  elseif ($difference<0) {
    $absdiff=abs($difference);
    $toAdd=array("prodID"=>$prodID,"numItems"=>$absdiff);
    try{
      $data->addItems($toAdd);
      echo true;
    }catch(Exception $e){
      echo false;
    }
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