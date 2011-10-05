<?php
$request=$_SERVER['REQUEST_METHOD'];
 $databasehost="localhost";
 $databasename="travit";
 $databasetable="productsInformation";
 $databaseusername="root";
 $databasepassword="";

if($request=="GET"){
	global $databasehost,$databasename,$databaseusername,$databasepassword,$databasetable;
	$typeOfRequest=$_GET['typeOfRequest'];
	$con=mysql_connect($databasehost,$databaseusername,$databasepassword) or die(mysql_error());
	mysql_select_db($databasename) or die(mysql_error());
	if($typeOfRequest=='TypesOfProducts'){
		$query="SELECT DISTINCT(productType) FROM $databasetable";
		$result=mysql_query($query);
		while($output=mysql_fetch_array($result)){
			echo $output['productType'].";";
			
		}
	}else if($typeOfRequest=="ParticularType"){
		$nameOfProduct=$_GET['nameOfProduct'];
		$query="SELECT * FROM $databasetable where productType='$nameOfProduct'";
		$result=mysql_query($query);
		while($output=mysql_fetch_array($result)){
			echo $output['productName'].";";			
		}

		
	}else if($typeOfRequest=="ParticularTypeOfProduct"){
		$productName=$_GET['productName'];
		$query="SELECT * FROM $databasetable where productName='$productName'";
		$result=mysql_query($query);
		while($output=mysql_fetch_array($result)){
			echo $output['storeName']."-";
			echo $output['storeAddress'].",";		
			echo $output['storeCity'].",";
			echo $output['StoreState'].",";
			echo $output['StoreZipCode'].",";
			echo "Quantity Left-".$output['quantityLeft'].";";
		}

		
	}
}
//138855461214
//Disneyland-Younger childer
//California adventure- Adults-Less rides for younger children
?>