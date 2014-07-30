<?php
 class dataManager{
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
	}

  public function addProductFromRemProd($name){
    $nameInCaps=strtoupper($name);
    $products= $this->connection->prepare("SELECT * FROM RemovedProducts");
		$products->execute();
    $prodList=$products->fetchAll();

    foreach ($prodList as $product){
      $prodNameCaps=strtoupper($product['name']);
      if($nameInCaps==$prodNameCaps){
        $name1=$product['name'];
        $catID=$product['catID'];
        $prodAbv=$product['prodAbv'];

        $query = $this->connection->prepare("INSERT INTO Products (prodID, catID, name, prodAbv) VALUES (DEFAULT,:catID,:name, :prodAbv)");

		    $query->bindParam(':catID', $catID);
		    $query->bindParam(':name', $name1);
		    $query->bindParam(':prodAbv', $prodAbv);

		    $query->execute();

        $query = $this->connection->prepare("DELETE FROM RemovedProducts WHERE name = :name");

		    $query->bindParam(':name', $name1);

		    $query->execute();
      }
    }
  }

  public function containsProdCurr($name){
    $nameInCaps=strtoupper($name);
    $products= $this->connection->prepare("SELECT * FROM Products");
		$products->execute();
    $prodList=$products->fetchAll();

    foreach ($prodList as $product){
      $prodNameCaps=strtoupper($product['name']);
      if($nameInCaps==$prodNameCaps){
        return true;
      }
    }

    return false;
  }

  public function containsProdRem($name){
    $nameInCaps=strtoupper($name);
    $products= $this->connection->prepare("SELECT * FROM RemovedProducts");
		$products->execute();
    $prodList=$products->fetchAll();

    foreach ($prodList as $product){
      $prodNameCaps=strtoupper($product['name']);
      if($nameInCaps==$prodNameCaps){
        return true;
      }
    }

    return false;
  }

  public function containsAbv($prodAbv){
    $abvCaps=strtoupper($prodAbv);
    $products = $this->connection->prepare("SELECT * FROM Products");
		$products->execute();
		$prodList=$products->fetchAll();

    foreach($prodList as $product){
      $prodAbv=$product['prodAbv'];
      if($abvCaps==$prodAbv){
        return true;
      }
    }

    $remProducts = $this->connection->prepare("SELECT * FROM RemovedProducts");
		$remProducts->execute();
		$remProdList=$products->fetchAll();

    foreach($prodList as $product){
      $prodAbv=$product['prodAbv'];
      if($abvCaps==$prodAbv){
        return true;
      }
    }

    return false;

  }

  public function abvCheck($prodAbv){
    $abvLength=strlen($prodAbv);

    if (!preg_match('/[^A-Za-z]/', $prodAbv)&&$abvLength==3){
      return true;
    }

    return false;

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

  public function getProdIDFromCode($prodCode){
		$prodID= $this->connection->prepare("SELECT * FROM Items WHERE prodCode=:prodCode");
		$prodID->bindParam(':prodCode',$prodCode);
		$prodID->execute();
		$result=$prodID->fetch();
		return $result['prodID'];
	}

  public function getCatFromProd($prodID){
    $catID= $this->connection->prepare("SELECT * FROM Products WHERE prodID=:prodID");
		$catID->bindParam(':prodID',$prodID);
		$catID->execute();
    $result=$catID->fetch();
    if(! $result){
      $catID= $this->connection->prepare("SELECT * FROM RemovedProducts WHERE prodID=:prodID");
		  $catID->bindParam(':prodID',$prodID);
		  $catID->execute();
      $result2=$catID->fetch();
		  return $result2['catID'];
    }
    else{
		  //$result=$catID->fetch();
		  return $result['catID'];
    }
  }

  public function getName($prodID){
    $prod= $this->connection->prepare("SELECT * FROM Products WHERE prodID=:prodID");
		$prod->bindParam(':prodID',$prodID);
		$prod->execute();
    $result=$prod->fetch();
    if(! $result){
      $prod= $this->connection->prepare("SELECT * FROM RemovedProducts WHERE prodID=:prodID");
		  $prod->bindParam(':prodID',$prodID);
		  $prod->execute();
      $result2=$prod->fetch();
		  return $result2['name'];
    }
    else{
		  //$result=$catID->fetch();
		  return $result['name'];
    }
  }

  public function getCatName($catID){
    $prod= $this->connection->prepare("SELECT * FROM Categories WHERE catID=:catID");
		$prod->bindParam(':catID',$catID);
		$prod->execute();
    $result=$prod->fetch();
    return $result['category'];
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
    $data=array();
    foreach($products as $prod){
      $prodID=$prod['prodID'];
      //echo $prodID;
      $remaining=$this->getRemaining($prodID);
      //echo $remaining;
      $name=$prod['name'];
      //echo $name;
      //$data[]="{ name: "."'". $name."'" . ", data: "."[". $remaining."] }";
      $data[]=array('name'=>$name,'data'=>array($remaining));
    }
    //change json encode here and in the other place before attempting
    //$dataTwo=array();
    //$dataTwo[0]=>$data;
    $json2=json_encode($data, JSON_NUMERIC_CHECK);
    //$json2 = preg_replace('/"([^"]+)"\s*:\s*/', '$1:', $json);
    echo $json2;
    //implode(",\n ",$data)
    //return;
  }

  public function getTimestamp($prodCode){
    $products=$this->connection->prepare("SELECT * FROM RemovedItems WHERE prodCode= :prodCode");
    $products->bindParam(':prodCode', $prodCode);
    $products->execute();
    $timestamp=$products->fetch();
    $timestamp1=$timestamp['timestamp'];
    return strtotime($timestamp1);
    //var_dump($timestamp1);
  }

  public function prepTimelineChart($days, $catID){
    $currTime= time();
    $daysInMs=$days*24*60*60;
    $timeCutoff=$currTime-$daysInMs;

    //get removed items
    $remItems=$this->connection->prepare("SELECT * FROM  RemovedItems ORDER BY  timestamp ASC");
    //$remItems=$this->connection->prepare("SELECT * FROM RemovedItems");
    //$remItems->bindParam(':prodCode', $prodCode);
    $remItems->execute();
    $remItems1=$remItems->fetchAll();

    //collect all removed items of the desired category
    $itemsInCat=array();
    foreach($remItems1 as $item){
      $prodID=$item['prodID'];
      if($this->getCatFromProd($prodID)==$catID){
        $itemsInCat[]=$item;
      }
    }

    //collect all items removed in the timespan
    $itemsInTimespan=array();
    foreach($itemsInCat as $item){
      $timeOfRem=$item['timestamp'];
      $timestampOfRem=strtotime($timeOfRem);
      if($timestampOfRem > $timeCutoff){
        $itemsInTimespan[]=$item;
      }
    }

    //create array of unique products in set
    $products=array();
    foreach($itemsInTimespan as $prod){
      $prodID=$prod['prodID'];
      if(! in_array($prodID,$products)){
        $products[]=$prodID;
      }
    }

    $mainData=array();
    foreach($products as $product){
      //get name of product
      $prodCodeCheck=$product;
      //echo $prodCodeCheck. ", ";
      $name=$this->getName($product);
      //create data array
      $data=array();
      //set first time
      $firstTime= 0;
      $count=1;

      foreach($itemsInTimespan as $item){
        //all this neeeds to be in an if statement
        $itemProdCode=$item['prodID'];
        //echo $itemProdCode. " ";
        if($itemProdCode==$prodCodeCheck){
          //if timestamp is within a min of first time, increment count and save over previous
          $time=$item['timestamp'];
          $timestamp=strtotime($time);

          //echo $firstTime. ", ".$timestamp;
          //echo "end";
          if($firstTime==0){
            //check if you need time or timestamp
            //echo "were here";
            $count=1;
            $jsTime=$timestamp*1000;
            $data[]=array($jsTime,0,$count);
            $firstTime=$timestamp;
          }
          else if($timestamp<($firstTime+(60))){
            $count++;
            end($data);
            $last_id=key($data);
            $jsTime=$timestamp*1000;
            $data[$last_id]=array($jsTime,0,$count);
          }

          else{
            $count=1;
            $jsTime=$timestamp*1000;
            $data[]=array($jsTime,0,$count);
            $firstTime=$timestamp;
          }
        }
      }

      $mainData[]=array('name'=>$name,'data'=>$data);
    }

    $json=json_encode($mainData, JSON_NUMERIC_CHECK);
    echo $json;
  }

  public function prepExcelData($days){
    $currTime= time();
    $daysInMs=$days*24*60*60;
    $timeCutoff=$currTime-$daysInMs;

    //get removed items
    $remItems=$this->connection->prepare("SELECT * FROM  RemovedItems ORDER BY  timestamp ASC");
    //$remItems=$this->connection->prepare("SELECT * FROM RemovedItems");
    //$remItems->bindParam(':prodCode', $prodCode);
    $remItems->execute();
    $remItems1=$remItems->fetchAll();

    //collect all items removed in the timespan
    $itemsInTimespan=array();
    foreach($remItems1 as $item){
      $timeOfRem=$item['timestamp'];
      $timestampOfRem=strtotime($timeOfRem);
      if($timestampOfRem > $timeCutoff){
        $itemsInTimespan[]=$item;
      }
    }
    return $itemsInTimespan;
  }
}
?>
