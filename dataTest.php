<?php
 class dataTest{
	public $connection;
	private static $instance;
	
	//constructor which connects to the db
	public function __construct(){
		echo "were in the constructor!";
		// Set options
		$options = array(
		PDO::ATTR_PERSISTENT => true, 
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
		try {
		$this->connection = new PDO('mysql:host=127.0.0.1;dbname=OApp', "OApp", "3ngin33ring", $options);
		$instance=$connection;
			echo "connected";
		} 
		catch (PDOException $e) {
			print "Error!: " . $e->getMessage() . "<br/>";
			die();
		}
	}
	
	 public static function getInstance()
    {
        if (!isset(self::$instance))
        {
            $object = __CLASS__;
            self::$instance = new $object;
        }
        return self::$instance;
    }
	//public function getTest(){
	
	//foreach($this->connection->query('SELECT * from Test') as $row) {
		//	print_r($row);
	//}
	//}
	public function addProduct($prodData){
		$query = $this->connection->prepare("INSERT INTO Products (prodID, catID, name, prodAbv) VALUES (DEFAULT,:catID,:name, :prodAbv)");
		//$query->bindParam(':prodID', $prodID);
		$query->bindParam(':catID', $catID);
		$query->bindParam(':name', $name);
		$query->bindParam(':prodAbv', $prodAbv);
		
		//$prodID=$prodData['prodID'];
		$catID= $prodData['catID'];
		$name=$prodData['name'];
		$prodAbv=$prodData['prodAbv'];
		
		$query->execute();
		echo"product added";
	}
}
?>	