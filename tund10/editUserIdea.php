<?php 
	//Et pääseks ligi sessioonile
	require("functions.php");
	require("userTable.php");
	require("editIdeaFunctions.php");
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
		updateIdea($_POST["id"], cleanInput($_POST["idea"]), $_POST["ideaColour"]);
		//Jään siiasamasse
		header("Location: ?id=" . $_POST["id"]);
	}
	
	if(isset($_GET["delete"])){
		deleteIdea($_GET["id"]);
		header("Location: userIdeas.php");
		exit();
	}
	
	$idea = getSingleIdea($_GET["id"]);
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
	<p><a href="userIdeas.php">Tagasi mõtete lehele</a></p>
	
	<h2>Toimeta mõtet</h2>
	<hr>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
		<input name="id" type="hidden" value='<?php echo $_GET["id"] ?>'>
		<label>Hää möte: </label>
		<textarea name="idea"><?php echo $idea->text; ?></textarea>
		<br>
		<label>Mõttega seonduv värv: </label>
		<input name="ideaColour" type="color">
		<br>
		<input name="ideaButton" type="submit" value="Salvesta muudetud möte">
		<span><?php echo $notice; ?></span>
	</form>
	<p><a href="?id=<?=$_GET['id']; ?>&delete=1" >Kustuta</a> see mõte</p>
	<hr>
	
</body>
</html>