
<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL ^ E_NOTICE);
	require($_SERVER['DOCUMENT_ROOT']."/dataManager.php");
	//echo $_SERVER['DOCUMENT_ROOT'];
	//echo "include";
	$data= new dataManager();
	//echo ", good constructor";
	$dbh=$data->getInstance();
  //include($_SERVER['DOCUMENT_ROOT']."/chartManager.php");
	//echo "got instance";

	//$data->addItemsTest('5');
	//$data->genNumCode('1');
	//$data->removeItem('sap1');
	//$prodCode="testing";
	//$data->prepRemainingChart('1');
	//echo strtoupper("hello325");

  $poo=$data->recentlyRemoved();
  //foreach($poo as $pee){
    //echo "{".$pee['name'].",".$pee['timestamp'].",".$pee['quantity']."}";
  //}
  echo $poo[1]['name'];
  //$paul=$data->getProdFromAbv('sum');
//echo $paul;
  //$data->prepTimelineChart('1','1');
  //foreach($json as $poop){
  //  echo $poop;
  //}







//$dbhandle = mysql_connect("127.0.0.1", "OApp", "3ngin33ring")
  //or die("Unable to connect to MySQL");
//echo "Connected to MySQL<br>";
		/*try {
			$connection= new PDO("mysql:host=127.0.0.1;dbname=OApp", "OApp", "3ngin33ring"); //change access parameters
		}
		catch(PDOException $e) {
			echo $e->getMessage();
		}
		echo "connected";



		$query=$connection->prepare('SELECT * FROM Test WHERE ID="1"');
		echo ", prepared";
		$query->execute();
		echo ", executed";
		echo $query;
		echo ", success";

		$connection=null;*/


	/*try {
		$dbh = new PDO('mysql:host=127.0.0.1;dbname=OApp', "OApp", "3ngin33ring");

	} catch (PDOException $e) {
		print "Error!: " . $e->getMessage() . "<br/>";
		die();
	}

		/*foreach($dbh->query('SELECT * from Test') as $row) {
			print_r($row);
			}
	$stmt = $dbh->prepare("INSERT INTO Test (ID, name) VALUES (:ID, :name)");
	$stmt->bindParam(':ID', $ID);
	$stmt->bindParam(':name', $name);

		$ID= 2;
		$name='test2';
		$stmt->execute();
		echo "item added";*/
		/*$prodData=array("prodID"=>2,"catID"=>1,"name"=>'Sleeman',"prodAbv"=>'sle');

		$query = $dbh->prepare("INSERT INTO Products (prodID, catID, name, prodAbv) VALUES (DEFAULT,:catID,:name, :prodAbv)");
		//$query->bindParam(':prodID', $prodID);
		$query->bindParam(':catID', $catID);
		$query->bindParam(':name', $name);
		$query->bindParam(':prodAbv', $prodAbv);

		//$prodID=$prodData['prodID'];
		$catID= $prodData['catID'];
		$name=$prodData['name'];
		$prodAbv=$prodData['prodAbv'];

		$query->execute();
		echo"product added";*/





			//$dbh = null;
		//$productData=array(':ID'=>'1',':name'=> 'hello');
		//$q=$connection->prepare('INSERT INTO Test (ID,name) VALUES (:name)');

		//$q->execute($productData);
		//echo ", thing added";
		/*if (!defined('PDO::ATTR_DRIVER_NAME')) {
		echo 'PDO unavailable';
		}
		elseif (defined('PDO::ATTR_DRIVER_NAME')) {
		echo 'PDO available';
		}*/
?>

