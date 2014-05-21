<?php
 require 'DataManager.php';
 if(!isset($_GET['prodCode'])||empty($_GET['prodCode'])){
	echo "Please input product code.]";
	exit;
 }
 
 $data= new DataManager();
 $item= $data->getItem($_GET['prodCode']);
 
 if($item===false){
	echo "Item has already been removed from inventory";
	exit;
 }
 
 if($data->removeItem($_GET['prodCode'])){
	//add a pointer here to redirect back to main page
	//header("Location:");
	exit;
 }
 else{
	echo "An error occurred, please try again"
 }
?>