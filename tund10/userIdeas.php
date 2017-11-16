<?php 
	//Et pääseks ligi sessioonile
	require("functions.php");
	require("userTable.php");
	$notice = "";
	
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
	
	if(isset($_POST["ideaButton"])){
		if(isset($_POST["idea"]) and !empty($_POST["idea"])){
			//echo $_POST["ideaColour"];
			$notice = saveIdea($_POST["idea"], $_POST["ideaColour"]);
			
		}
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
	
	<h2>Lisa oma hää möte</h2>
	<hr>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
		<label>Hää möte: </label>
		<input name="idea" type="text">
		<br>
		<label>Mõttega seonduv värv: </label>
		<input name="ideaColour" type="color">
		<br>
		<input name="ideaButton" type="submit" value="Salvesta möte">
		<span><?php echo $notice; ?></span>
	</form>
	<hr>
	<div style="width: 40%;">
		<?php echo listIdeas();?>
	</div>
	
</body>
</html>