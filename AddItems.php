<?php
 require 'DataManager.php';
 if(isset($_POST)&& sizeof($_POST)>0)){
	$data= new DataManager();
	$data->addItems($_POST);
 }
?> 