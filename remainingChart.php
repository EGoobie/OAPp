<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL ^ E_NOTICE);
 require($_SERVER['DOCUMENT_ROOT']."/dataManager.php");
 $data= new dataManager();
	//echo "connected";
  $cat=$_GET['catID'];
  $chart=$_GET['chartType'];

  if($chart=="remaining"){
	  $dataSend=$data->prepRemainingChart($cat);
	  return $dataSend;
  }
?>
