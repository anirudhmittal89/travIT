<?php
$request=$_SERVER['REQUEST_METHOD'];
 $databasehost="localhost";
 $databasename="travit";
 $databasetable="accounts";
 $databaseusername="root";
 $databasepassword="";

if($request=="GET"){
global $databasehost,$databasename,$databaseusername,$databasepassword,$databasetable;
if(isset($_GET['storeName'])){
$nameOfStore=$_GET['storeName'];
}
if(isset($_GET['storeCity'])){
$storeCity=$_GET['storeCity'];
}
//echo ":".$nameOfStore.":";
//echo ":".$storeCity.":";
$con=mysql_connect($databasehost,$databaseusername,$databasepassword) or die(mysql_error());
mysql_select_db($databasename) or die(mysql_error());
if(!isset($nameOfStore)|| empty($nameOfStore)){
$query="SELECT Firstname,Lastname,Address FROM $databasetable WHERE Usertype='retail' AND Address LIKE '%".$storeCity."%' ";
}
else if(!isset($storeCity) || empty($storeCity)){
$storename=explode(" ",$nameOfStore);
$query="SELECT Firstname,Lastname,Address FROM $databasetable WHERE Usertype='retail' AND Firstname LIKE '$storename[0]' AND Lastname LIKE '$storename[1]'";
}
else{
$storename=explode(" ",$nameOfStore);
$query="SELECT Firstname,Lastname,Address FROM $databasetable WHERE Usertype='retail' AND Firstname LIKE '$storename[0]' AND Lastname LIKE '$storename[1]' AND Address LIKE '%".$storeCity."%'";
}
//echo "query:".$query;
$result=mysql_query($query);
while($output=mysql_fetch_array($result)){
echo $output['Firstname']."-";
echo $output['Lastname'].",";
echo $output['Address'].";";

//echo "<br>";
	}
}
?>