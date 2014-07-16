<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL ^ E_NOTICE);
 require($_SERVER['DOCUMENT_ROOT']."/dataManager.php");
 $data= new dataManager();
	//echo "connected";

  $chart=$_GET['chartType'];

  if($chart=="remaining"){
    $cat=$_GET['catID'];
	  $dataSend=$data->prepRemainingChart($cat);
	  return $dataSend;
  }

  if($chart=='timeline'){
    $cat=$_GET['catID'];
    $days=$_GET['days'];
    $dataSend=$data->prepTimelineChart($days,$cat);
    return $dataSend;
  }
?>
