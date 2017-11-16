<?php 
	//Et pääseks ligi sessioonile
	require("functions.php");
	
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
	<p><a href="?logout=1">Logi välja!</a></p>
	<p><a href="main.php">Pealehele</a></p>
	
	<h2>Lae oma pilt!</h2>
	<hr>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <p>Select image to upload: </p>
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="Upload Image" name="submit">
    </form>
	
</body>
</html>