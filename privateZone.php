<?php

	$name = trim(strtolower($_POST['name']));   //in php these variables aren't available inside the function!! o my!!
	$password = trim($_POST['password']);

	
//define function for later use	
	function userPasswordStored($name, $password) {  //so pass them in
	
		$documentRoot = $_SERVER['DOCUMENT_ROOT']; 
		$passwordFilePath = "$documentRoot/../login.txt"; 
	
		$fp = fopen("$passwordFilePath", 'rb');  //open file for reading
		
		
		while (!feof($fp)) {  
			
			$userPasswordString = fgets($fp); //read out file line
			
			if($userPasswordString=='') {  //fgets reads in an empty string before eof. break out rather than test it. 
				break;
			}
		
			$userPassword = explode(',',$userPasswordString);  //user and password seperated by a comma
			
			$storedName = trim($userPassword[0]); 
			$storedPass = trim($userPassword[1]); 
			
		
			if($name == $storedName && sha1($password) == $storedPass) { //test name and password against registered name/pass
			
				return true; 
			}
			
		}
		return false; 
	}

?>
<!DOCTYPE html>
<html lang= "en">
<head>

	<meta charset="utf-8">
	<title>Private Zone</title>
	
	<style>
		form {  padding:2em; 
				padding-top: 1.5em;
				background-color:lightgray; 
				width: 16em;
			
				position: absolute;  /**centering**/
				left: 50%; 
				margin-left: -160px; 
				top: 50%; 
				margin-top: -100px; 
		}
		input { position: absolute; left: 11em; }
		button { position: relative; left: 5em; }
		#register { font-size: 0.8em; }
		#centerMessage {
		
			width: 55em;
			position: absolute; 
			top: 45%;
			left: 50%; 
			margin-left: -27.5em;
			text-align: center;
		}
	</style>

</head>
<body>

<? 
	if(empty($name)|| empty($password)) {  //hasn't logged in or poor login attempt. display the login.  
	
?>

	<form action = "privateZone.php" method = "post">
		<p><label for="name">Name:</label>
  		<input type="text" name="name" id="name"/></p>
  		
  		<p><label for="password">Password:</label>
  		<input type="text" name="password" id="password"/></p>
  		
  		<a id = "register" href="register.php">Register (if you are Nina)</a>
  		<button type="submit">Enter</button>
	
	</form>
	
<?
} else {

	if(userPasswordStored($name, $password)) {
	
		require('privateZonePage.php');  //logged in, so display private Zone
	
	} else {
	
		echo "<div id='centerMessage'>Sorry that's not a valid user name and password. Plz leave thx."; 
		
	}
}
?>


</body>
</html>