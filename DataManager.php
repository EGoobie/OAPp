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
        "INSERT INTO Products (catID, productName, prodAbv) VALUES (:catID,:prodName,:prodAbv)");
		
		//add check for if product already exists or has existed in the past
		
		$prodData=[':catID'=> $prodData['catID'], ':prodName'=> $prodData['prodName'], ':prodAbv'=>$prodData['prodAbv']];
		
		$query->execute($prodData);
	}
	
	//this method must take in product details and a number of items to add, requires html form
	//it must also generate a unique product code for each item and insert it with the item
	public function addItems($itemData){
		$numItems=$itemData['numItems'];
		
		$prodCode= genProdCode($itemData);//generate prodCode here
		
		for($i=0;$i<$numItems;$i++){
			$query = $this->connection->prepare(
			 "INSERT INTO Items (nameID, catID, prodCode) VALUES (:nameID, :catID,:prodCode)");
			$itemData=[':productID'=> $itemData['productID'], ':catID'=>$itemData['catID'], ':prodCode'=> $prodCode];
		
			$query->execute($prodData);	
		}
	}
	
	//generates a unique product code
	public function genProdCode($itemData){
		$productID=$itemData['productID'];
		$abv=getProdAbv($productID);
		
		//find largest value of prodCode for that item in stock and add 1 to it
		//sum the product abreviated code and the number code to generate the prodCode
		
	}
	
	//gets the 3 letter abbreviated code for the product
	public function getProdAbv($productID){
		$query=$this->connection->prepare("SELECT * FROM Products WHERE productID=:productID"); 
		
		$data=[':productID'=>$productID];
		
		$query->execute($data);
		
		return $query['productAbv'];
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
