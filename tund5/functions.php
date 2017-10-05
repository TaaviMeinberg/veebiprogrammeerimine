<?php
	require("../../../config.php");
	$database = "if17_taavi_meinberg";
	
	//Alustame sessiooni
	session_start();

	
	function signIn($email, $password){
		$notice ="";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUserName"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, email, password FROM vpusers WHERE email = ? ");
		$stmt->bind_param("s", $email);
		$stmt->bind_result($id, $emailFromDb, $passwordFromDb);
		$stmt->execute();
		
		//Kontrollime kasutajat
		if($stmt->fetch()){
			$hash = hash("sha512", $password);
			if($hash == $passwordFromDb){
				$notice = "Kõik korras, logisimegi sisse!";
				
				//Salvestame sessioonimuutujad
				$_SESSION["userID"] = $id;
				$_SESSION["userEmail"] = $emailFromDb;
				
				//Liigume pealehele
				header("Location: main.php");
				exit();
			} else {
				$notice = "Sisestasite vale salasõna!";
			}
			
		} else {
			$notice ="Sellist kasutajat {" . $email . "} ei ole!";
		}
		
		return $notice;
	}
	
	//Sisestuse kontrollimine
	function cleanInput($strToClean){
		$strToClean = trim($strToClean);
		$strToClean = stripslashes($strToClean);
		$strToClean = htmlspecialchars($strToClean);
		return $strToClean;
	}
	
	//UUE KASUTAJA LISAMINE ANDMEBAASI
	function signUp($signupFirstName, $signupFamilyName, $signupBirthDate, $gender, $signupEmail, $signupPassword){
		
		echo "Hakkan andmeid salvestama";
		$signupPassword = hash("sha512", $_POST["signupPassword"]);
		
		//Ühendus serveriga
			
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUserName"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		//käsk serverlile
		$stmt = $mysqli->prepare("INSERT INTO vpusers (firstname, lastname, birthday, gender, email, password) VALUES (?, ?, ? ,? ,?, ?)");
		echo $mysqli->error;
		//s - string
		//i - int
		//d - decimal
		$stmt->bind_param("sssiss", $signupFirstName, $signupFamilyName, $signupBirthDate, $gender, $signupEmail, $signupPassword);
		//$stmt->execute();
		if($stmt->execute()){
			echo "Õnnestus";
		} else{
			echo "Tekkis viga: ". $stmt->error;
		}
		$stmt->close();
		$mysqli->close();
		
	}

?>