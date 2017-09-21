<?php 
	//Muutujad
	$time = date("H:i:s");
	$myName = "Taavi";
	$myFamilyName = "Meinberg";
	
	$picDir = "../../fotod/";
	$picFiles = [];
	$picFileTypes = ["jpg", "jpeg", "png", "gif"];
	
	$allFiles = array_slice(scandir($picDir), 2);
	foreach($allFiles as $file){
		$fileType = pathinfo($file, PATHINFO_EXTENSION);
		if(in_array($fileType, $picFileTypes) == true){
			array_push($picFiles, $file);
		}
	}
	
	//var_dump($allFiles);
	//$picFiles = array_slice($allFiles, 2);
	//var_dump($picFiles);
	$picFileCount = count($picFiles);
	$picNumber = mt_rand(0, $picFileCount-1);
	$picFile = $picFiles[$picNumber];
	?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Taavi Meinberg</title>
</head>

<body> 
	<h1><?php echo $myName . " " . $myFamilyName; ?>, veebiprogemine</h1>
	<img src="<?php echo $picDir . $picFile ?>" alt="Tallinna Ülikool">
	
</body>
</html>