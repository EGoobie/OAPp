<?php
 class dataTest{
	public $connection;
	private static $instance;

	//constructor which connects to the db
	public function __construct(){
		//echo "were in the constructor!";
		// Set options
		$options = array(
		PDO::ATTR_PERSISTENT => true,
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
		try {
		$this->connection = new PDO('mysql:host=127.0.0.1;dbname=OApp', "OApp", "3ngin33ring", $options);
		$instance=$connection;
			//echo "connected";
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
		$prodAbvCaps=$prodData['prodAbv'];
		$prodAbv=strtoupper($prodAbvCaps);

		$query->execute();
		echo"product added";
	}

	public function getCategories(){
		$query = $this->connection->prepare("SELECT * FROM Categories");
		$query->execute();
		return $query;
	}
	public function getProducts($category){
		$catID= $this->connection->prepare("SELECT * FROM Categories WHERE category=:category");
		$catID->bindParam(':category',$category);
		$catID->execute();
		$result=$catID->fetch();
		$ID=$result['catID'];
		$query = $this->connection->prepare("SELECT * FROM Products WHERE catID=:catID");
		$query->bindParam(':catID', $ID);
		$query->execute();
		return $query;
	}

	public function getCatID($category){
		$catID= $this->connection->prepare("SELECT * FROM Categories WHERE category=:category");
		$catID->bindParam(':category',$category);
		$catID->execute();
		$result=$catID->fetch();
		return $result['catID'];
	}

	public function deleteProduct($product) {
		$prodInfo= $this->connection->prepare("SELECT * FROM Products WHERE name=:name");
		$prodInfo->bindParam(':name',$product);
		$prodInfo->execute();
		$result=$prodInfo->fetch();

		$prodID=$result['prodID'];
		$catID=$result['catID'];
		$prodAbv=$result['prodAbv'];

		$itemDelete = $this->connection->prepare("DELETE FROM Items WHERE prodID = :prodID");
		$itemDelete->bindParam(':prodID', $prodID);
		$itemDelete->execute();
		$prodDelete = $this->connection->prepare("DELETE FROM Products WHERE name = :name");
		$prodDelete->bindParam(':name', $product);
		$prodDelete->execute();

		$archive=$this->connection->prepare("INSERT INTO RemovedProducts (prodID, catID, name, prodAbv) VALUES (:prodID,:catID,:name, :prodAbv)");
		$archive->bindParam(':prodID', $prodID);
		$archive->bindParam(':catID', $catID);
		$archive->bindParam(':name', $product);
		$archive->bindParam(':prodAbv', $prodAbv);

		return $archive->execute();
	}

	public function getProdID($product){
		$prodID= $this->connection->prepare("SELECT * FROM Products WHERE name=:name");
		$prodID->bindParam(':name',$product);
		$prodID->execute();
		$result=$prodID->fetch();
		return $result['prodID'];
	}

	public function getItems($product){
		$prodID= $this->connection->prepare("SELECT * FROM Products WHERE name=:name");
		$prodID->bindParam(':name',$product);
		$prodID->execute();
		$result=$prodID->fetch();
		$ID= $result['prodID'];
		$prodCode= $this->connection->prepare("SELECT * FROM Items WHERE prodID=:prodID");
		$prodCode->bindParam(':prodID',$ID);
		$prodCode->execute();
		return $prodCode;
	}

	public function addItems($itemData){
		$numItems=$itemData['numItems']; //check naming on this parameter
		for($i=0;$i<$numItems;$i++){
			$query = $this->connection->prepare("INSERT INTO Items (itemID, prodID, numCode, prodCode) VALUES (DEFAULT,:prodID,:numCode, :prodCode)");

			$query->bindParam(':prodID', $prodID);
			$query->bindParam(':numCode', $numCode);
			$query->bindParam(':prodCode', $prodCode);

			$passedID=$itemData['prodID'];


			$prodID= $passedID;
			$numCode=$this->genNumCode($passedID);
			$prodCode=$this->genProdCode($passedID,$numCode);

			$query->execute();
			echo"item added";
		}
	}

	public function genNumCode($prodID){
		$query = $this->connection->prepare("SELECT MAX(numCode) as maxCode FROM Items WHERE prodID=:prodID");
		$query->bindParam(':prodID', $prodID);
		$query->execute();
		$maxCode=$query->fetch();
		$maxCodeVal=$maxCode['maxCode'];
		return $maxCodeVal+1;
	}

	public function genProdCode($prodID,$numCode){
		$prodAbv= $this->connection->prepare("SELECT * FROM Products WHERE prodID=:prodID");
		$prodAbv->bindParam(':prodID',$prodID);
		$prodAbv->execute();
		$result=$prodAbv->fetch();
		$prodAbvValue=$result['prodAbv'];
		$numCodeS=strval($numCode);
		$prodCode=$prodAbvValue.$numCodeS;
		return $prodCode;
	}

	public function removeItem($prodCode) {
		$product=$this->connection->prepare("SELECT * FROM Items WHERE prodCode= :prodCode");
		$prodCodeCaps=strtoupper($prodCode);
		$product->bindParam(':prodCode', $prodCodeCaps);
		$product->execute();
		$prodInfo=$product->fetch();

		$delete = $this->connection->prepare("DELETE FROM Items WHERE prodCode = :prodCode");
		$delete->bindParam(':prodCode', $prodCodeCaps);
		$delete->execute();

		$archive=$this->connection->prepare("INSERT INTO RemovedItems (itemID, prodID, prodCode, timestamp) VALUES (:itemID,:prodID,:prodCode, now())");

		$itemID=$prodInfo['itemID'];
		$prodID=$prodInfo['prodID'];
		$prodCode=$prodInfo['prodCode'];
		//$timestamp=now();

		$archive->bindParam(':itemID',$itemID);
		$archive->bindParam(':prodID',$prodID);
		$archive->bindParam(':prodCode',$prodCode);
		//$archive->bindParam(':timestamp,$timestamp');

		return $archive->execute();
	}

	public function getRemaining($prodID){
		$query = $this->connection->prepare("SELECT count(*) FROM Items WHERE prodID=:prodID");
		$query->bindParam(':prodID', $prodID);
		$query->execute();
		$remaining=$query->fetch();
		$remItems=$remaining[0];
		return $remItems;
	}

  /*
    Graph data prep functions
  */

  public function prepRemainingChart($catID){
    $products=$this->connection->prepare("SELECT * FROM Products WHERE catID= :catID");
    $products->bindParam(':catID', $catID);
    $products->execute();
    //$remProducts=$products->fetch();
    $data='';
    foreach($products as $prod){
      $prodID=$prod['prodID'];
      //echo $prodID;
      $remaining=$this->getRemaining($prodID);
      //echo $remaining;
      $name=$prod['name'];
      //echo $name;
      $data[]="{ name: "."'". $name."'" . ", data: "."[". $remaining."] }";

    }

    echo implode(",\n ",$data);
    return;
  }
}
?>
