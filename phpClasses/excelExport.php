<?php
  //header("Pragma: public");
  //header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
  //header('Content-Disposition: attachment; filename="oap_inventory_data.xlsx"');
  //header("Content-Type: application/force-download");
  //header("Content-Type: application/octet-stream");
  //header("Content-Type: application/download");
  //header('Cache-Control: max-age=0');
  ini_set('display_errors', 1);
	error_reporting(E_ALL ^ E_NOTICE);
	require($_SERVER['DOCUMENT_ROOT']."/dataManager.php");
	$data= new dataManager();
	$dbh=$data->getInstance();

  include ($_SERVER['DOCUMENT_ROOT']."/phpClasses/PHPExcel.php");
  include ($_SERVER['DOCUMENT_ROOT']."/phpClasses/PHPExcel/Writer/Excel2007.php");

  $objPHPExcel = new PHPExcel();
  //echo "created obj";
  $objPHPExcel->getProperties()->setTitle("OAP Inventory Data".date('Ymd'));
  $objPHPExcel->setActiveSheetIndex(0);
  //header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
  //header('Content-Disposition: attachment; filename="oap_inventory_data". date('Ymd') ."xls"');




  $days=$_POST['days'];
  //echo $days;
  $excelData=$data->prepExcelData($days);

  $rowCount=1;
  foreach($excelData as $row){
    $catID=$data->getCatFromProd($row['prodID']);
    $cat=$data->getCatName($catID);
    $prodName=$data->getName($row['prodID']);
    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $cat);
    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $prodName);
    $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row['timestamp']);
    $rowCount++;
  }
  //echo "through chart build";
  $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
  //$objWriter->save('php://output');
  $today = date("Ymd");
  $filename="/excelDownloads/oap_inventory_data".$today.".xlsx";
  $objWriter->save($_SERVER['DOCUMENT_ROOT'].$filename);

  $response = array(
    'success' => true,
    'url' => $filename,
  );

  header('Content-type: application/json');

  // and in the end you respond back to javascript the file location
  echo json_encode($response);
?>

