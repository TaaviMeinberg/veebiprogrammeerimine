<?php 
	//Muutujad
	$time = date("H:i:s");
	$myName = "Taavi";
	$myFamilyName = "Meinberg";
	$monthNamesEt = ["jaanuar", "veebruar", "märts", "april", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];
	$month = date("n") -1;
	
	$dateString = date("d ") . $monthNamesEt[$month] . date(" Y");
	
	//Hindan päeva osa
	$hourNow = date("H");
	$partOfDay ="";
	if ($hourNow < 8){
		$partOfDay = "varahommik";
	} 
	if ($hourNow >= 8 and $hourNow < 16) {
		$partOfDay = "koolipäev";
	} else {
		$partOfDay = "vaba aeg";
	}
	//echo $partOfDay;
	
	// vanusega tegelemine
	//var_dump($_POST);
	//echo $_POST["birthYear"];
	
	$myBirthYear;
	$ageNotice ="";
	if(isset($_POST["birthYear"])){
		$myBirthYear = $_POST["birthYear"];
		$yourAge = date("Y") - $_POST["birthYear"];
		$ageNotice = "<p> Te olete umbes: " . $yourAge . " vana. </p>";
		
		$ageNotice .= "<p> Olete elanud järgnevatel aastatel: </p> <ul>";
		for ($i = $myBirthYear; $i <= date("Y"); $i++){
			$ageNotice .= "<li>" . $i . "</li>";
		}
		$ageNotice .= "</ul>";
	}
	
	/* for ($i = 0; $i < 100000; $i++){
		echo $i ." ";
	} */
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Taavi Meinberg</title>
</head>

<body> 
	<h1><?php echo $myName . " " . $myFamilyName; ?>, veebiprogemine</h1>
	
	
	<?php 
	echo "<p>Praegu on: " . $partOfDay . "</p>";
	echo "<p>Täna on: " . $dateString. " Kell oli avamise hetkel: " . $time .". </p>";
	?>
	
	<h2>Natukene vanusest</h2>
	<form method="POST">
		<label>Teie sünniaasta: </label> 
		<input name="birthYear" id="birthYear" type="number" value="<?php echo $myBirthYear;?>" min="1900" max="2017">
		<input name="submitBirthYear" type="submit" value="sisesta">
	</form>
	<?php 
		if($ageNotice != ""){
			echo $ageNotice;
		}
	?>
	
</body>
</html>