<!DOCTYPE html>
<html lang= "en">
<head>

	<meta charset="utf-8">
	<title>Registration Page</title>
	
	<style>
		form {  padding:2em; 
				padding-top: 1.5em;
				background-color:paleturquoise; 
				width: 20em;
			
				position: absolute;  /**centering**/
				left: 50%; 
				margin-left: -192px; 
				top: 50%; 
				margin-top: -120px; 
		}
		input { position: absolute; left: 16em; }
		button { position: relative; left: 13em; }
		#hi { font-size:0.8em; 
			  float: right;
			  position: relative;
              top: 25px; 
              left: 15px;
		}
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
<?php 

	$name = trim(strtolower($_POST['name']));
	$password = trim($_POST['password']);
	$repeatPassword = trim($_POST['repeatPassword']); 
	 
	
	if(empty($name) || empty($password) || empty($repeatPassword)) {

?> 
		
	<form action = "register.php" method = "post">
		
		<p><label for="name">Name:</label>
  		<input type="text" name="name" id="name"/></p>
  		
  		<p><label for="password">Password:</label>
  		<input type="text" name="password" id="password"/></p>
  		
  		<p><label for="repeatPassword">Repeat password:</label>
  		<input type="text" name="repeatPassword" id="passwordRepeat"/></p>
  		<button type="submit">Sign Up</button> <span id="hi">Hi Nina</span>
	
	</form>

<? 
	}
	
	elseif($name != 'nina' && $name != 'emilie') {
	
		echo "<div id='centerMessage'>nah. get out of here !! You got the wrong name!!</div>"; 
	
	}
	elseif($password != $repeatPassword) {
	
		echo "<div id='centerMessage'>password and repeat password don't match</div>"; 
	
	} 
	
	else { 

		//open text file, check user limit (2) hasn't been reached. if not, write in new name and password 
	
		$documentRoot = $_SERVER['DOCUMENT_ROOT']; 
		
		$passwordFilePath = "$documentRoot/../login.txt"; 
	
		$noOfLines = count(file($passwordFilePath)); 
		
	
		if($noOfLines > 1) {
		
			echo "<div id='centerMessage'>we're at capacity for number of users. soz</div>"; 
			exit; 
		}
		
		//write in new name and password 
		
		$fp = fopen("$passwordFilePath", 'ab'); //open file to write (append) 
		
		$encryptedPassword = sha1($password); //encrypt password 
		
		$newUserPassword = "$name,$encryptedPassword\n";  //store name and encrypted password
		
		fwrite($fp, $newUserPassword); //write the user and password to file 
		
		$success = fclose($fp); 
		
		echo "<div id = 'centerMessage'>You are registered! please return to the login page and log in with your name and password</div>"; 
	
	} 
?>
</body>
</html>