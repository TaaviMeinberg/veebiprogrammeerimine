<?php 
	//Et pääseks ligi sessioonile
	require("functions.php");
	require("userTable.php");
	
	//Kui pole sisseloginud, liigume login lehele
	if(!isset($_SESSION["userID"])){
		header("Location: login.php");
		exit();
	}

	
	if(isset($_GET["logout"])){
		session_destroy();
		header("Location: login.php");
		exit();
	}
	?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Taavi Meinberg</title>
</head>

<body> 
	<h1><?php echo $_SESSION["firstName"] . " " . $_SESSION["lastName"]; ?> </h1>
	<br>
	<br>
	<?php generateUserTable(); ?>
	<p><a href="?logout=1">Logi välja!</a></p>
	<p><a href="main.php">Pealehele</a></p>
</body>
</html>