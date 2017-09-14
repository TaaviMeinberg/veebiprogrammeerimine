<?php 
	//Muutujad
	$time = date("H:i:s");
	$myName = "Taavi";
	$myFamilyName = "Meinberg";
	
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
	echo "<p>Täna on: " . date("d-m-Y") . " Kell oli avamise hetkel: " . $time .". </p>";
	?>
</body>
</html>