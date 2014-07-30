<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL ^ E_NOTICE);

  $filepath=$_POST['filepath'];
  //echo $filepath;
  $fullFilepath=$_SERVER['DOCUMENT_ROOT'].$filepath;
  //echo $fullFilepath;
  unlink($fullFilepath);

?>
