<?php
class DataManager{
	/*
	Assuming table names of Category:(catID,category), Products:(productID,catID, product name), 
		ItemList:(itemID, productID, categoryID, productCode)
	*/
	protected $connection;
	
	//constructor which connects to the db
	public function _construct(){
		$this->connect;
	}
	
	//connects to the database
	public function connect(){
		try {
			$this->connection= new PDO("mysql:host=localhost;dbname=OApp", "OApp", "3ngin33ring"); //change access parameters
		}
		catch(PDOException $e) {
			echo $e->getMessage();
		}
	}
	
	//returns database result object containing categories
	public function getCategories(){
		$query=$this->connection->prepare("SELECT * FROM Categories");
		$query->execute();
		
		return $query;
	}
	
	//returns database result object containing item names from chosen category
	public function getProducts($catID){
		$query=$this->connection->prepare("SELECT * FROM Products WHERE catID=:catID"); 
		
		$data=[':catID'=>$catID];
		
		return $query->execute($data);
	}
	
	//returns database result object containing list of items in stock for a given item in a given category
	public function getItemList($productID){
		$query=$this->connection->prepare("SELECT * FROM ItemList WHERE productID= :productID"); //change this to select desired category
		
		$data=[':productID'=>$productID];
		
		return $query->execute($data);
	}
	
	//adds a new product into the database, requires interaction with an html form
	public function addProduct($prodData){
		$query = $this->connection->prepare(
        "INSERT INTO Products (catID, productName) VALUES (:catID,:prodName)");
		$prodData=[':catID'=> $prodData['catID'], ':prodName'=> $prodData['prodName']];
		
		$query->execute($prodData);
	}
	
	//this method must take in product details and a number of items to add, requires html form
	//it must also generate a unique product code for each item and insert it with the item
	public function addItems($itemData){
	
	}
	
	//removes an item from inventory and places it in the archive database with the timestamp of removal for data generation
	public function removeItem($prodCode){
		$this->addToArchive($prodCode); //adds the product to the archive for data generation
		
		$query= $this->connection->prepare("DELETE FROM ItemList WHERE prodCode= :prodCode");
		
		$data=[':prodCode'=>$prodCode];
		
		return $query->execute($data);
	}
	
	//adds removed item to the archive db
	public function addToArchive($prodCode){
	
	}
}
?>