<?php
session_start(); // start up your PHP session! 
?>
	<?php

	$request=$_SERVER['REQUEST_METHOD'];
	 $databasehost="localhost";
	 $databasename="travit";
	 $databasetable="accounts";
	 $databaseusername="root";
	 $databasepassword="";
	if($request=="GET"){
		 $username=$_GET['username'];


		 if(isset($_SESSION[$username])){
				$local=$_SESSION[$username];
				echo 'status,Accept,'."username,".$local['Username'].",email,".$local['Email'].",usertype,".$local['Usertype'],",phone number,".$local['PhoneNumber'],",address,",$local['Address'];
			  }else{
		// $userpass=md5($_POST['userpass']);
		
		if(isset($_GET['userpass'])){
		 $userpass=$_GET['userpass'];
}
		$result=selectFromDB();

		if($result['Password']==$userpass){
			 if(isset ($_SESSION[$username])){
				$local=$_SESSION[$username];
				echo 'status,Accept,'."username,".$local['Username'].",email,".$local['Email'].",usertype,".$local['Usertype'],",phone number,".$local['PhoneNumber'],",address,",$local['Address'];
			  }else{
				 $_SESSION[$username]=$result;
				 $local=$_SESSION[$username];
				 	
				 echo 'status,Accept,'."username,".$local['Username'].",email,".$local['Email'].",usertype,".$local['Usertype'],",phone number,".$local['PhoneNumber'],",address,",$local['Address'];
			  }
		}else{
			echo 'status,Wrong Password';
		}
	}//End of else
	 
	}else if($request=="POST"){
	
	 $username=$_POST['username'];
	// $userpass=md5($_POST['userpass']);
	 $userpass=$_POST['userpass'];
	 $useremail=$_POST['useremail'];
	 $usertype=$_POST['usertype'];
		 if(checkWhetherTheUserExists()=="new user"){
			addintoDB();
			echo 'new';	
		}else{
			echo 'Sorry the Username Already Exists'."\n";
		}
	}//End of Post
	else if($request=="PUT"){
	$username=$_GET['username'];
	$useremail=$_GET['useremail'];
	updateDB();
	}else if($request=="DELETE"){
	$username=$_GET['username'];
	deleteFromDB();
	}
	
	
	function updateDB(){
	global $username,$useremail,$databasehost,$databasename,$databaseusername,$databasepassword,$databasetable;
	//$firstname=$_POST["firstname"];
	//$lastname=$_POST["lastname"];
	//$address=$_POST["address"];
	//$phonenumber=$_POST["phonenumber"];
	$con=mysql_connect($databasehost,$databaseusername,$databasepassword) or die(mysql_error());
	mysql_select_db($databasename) or die(mysql_error());
	$query="UPDATE $databasetable SET Email='$useremail' WHERE Username='$username'";
	echo $query.":";
	$result=mysql_query($query);
	echo $result.":";
	echo mysql_affected_rows();
	}
	
	function deleteFromDB(){
	global $username,$useremail,$databasehost,$databasename,$databaseusername,$databasepassword,$databasetable;
	$con=mysql_connect($databasehost,$databaseusername,$databasepassword) or die(mysql_error());
	mysql_select_db($databasename) or die(mysql_error());
	$query="DELETE from $databasetable WHERE Username='$username'";
	//echo $query.":";
	$result=mysql_query($query);
	//echo $result.":";
	$num=mysql_affected_rows();
	
	if($num==1){
	echo 'Deleted';
	}
	else{
	echo 'Error';
	}
	
	
	}
	function checkWhetherTheUserExists(){
	global $username,$userpass,$databasehost,$databasename,$databaseusername,$databasepassword,$databasetable;
	$con=mysql_connect($databasehost,$databaseusername,$databasepassword) or die(mysql_error());
	mysql_select_db($databasename) or die(mysql_error());
	//echo "username:".$username."\n";
	//Dummy QueryINSERT INTO Account(Username,Password,Firstname,Lastname,Email,PhoneNumber,Address,Usertype) VALUES ('ani123','ani','a','a','a@a.com','1233211231','fucku','vendor')
	
	$query="SELECT * FROM $databasetable WHERE Username='$username'";
	$result=mysql_query($query);
	//echo $query;
	//echo "user exists result".$result."\n";
	$count=mysql_num_rows($result);
	//echo "user exists count:".$count."\n";
		if ($count==0){
			return "new user";
		 }else{
			return "username exists";
		 }
	}
	
	function selectFromDB(){
	global $username,$userpass,$databasehost,$databasename,$databaseusername,$databasepassword,$databasetable;
	//echo "db:".$databasehost."\n";
	$con=mysql_connect($databasehost,$databaseusername,$databasepassword) or die(mysql_error());
	//echo "connection:". $con. "\n";
	mysql_select_db($databasename) or die(mysql_error());
	$query="SELECT * FROM $databasetable WHERE Username='$username'";
	//echo "query:". $query."\n";
	$result=mysql_query($query);
	//echo "result:".$result."\n";
	$row=mysql_fetch_array($result);
	//echo "uanem:".$row["username"]."\n";
	$count=mysql_num_rows($result);
	//echo "count:".$count."\n";
		if($count){
			//$output=mysql_result($result,0);
			//echo "output:".$output."\n";
			return $row;
		}else{
			return "0";
		}
	mysql_free_result($result);
	mysql_close($con);
	}
	
	function addintoDB(){
	//echo "add into DB";
	global $username,$useremail	,$userpass,$databasehost,$databasename,$databaseusername,$databasepassword,$databasetable,$usertype;
	$con=mysql_connect($databasehost,$databaseusername,$databasepassword) or die(mysql_error());
	$firstname=$_POST["firstname"];
	$lastname=$_POST["lastname"];
	$address=$_POST["address"];
	$phonenumber=$_POST["phonenumber"];
	//echo "connection:". $con. "\n";
	mysql_select_db($databasename) or die(mysql_error());
	$query="INSERT INTO $databasetable(ID,Username,Password,Firstname,Lastname,Email,PhoneNumber,Address,Usertype) VALUES ('','$username','$userpass','$firstname','$lastname','$useremail','$phonenumber','$address','$usertype')";
	//echo "query:". $query."\n";
	$result=mysql_query($query);
	//echo "result".$result."\n";
	}
	?>