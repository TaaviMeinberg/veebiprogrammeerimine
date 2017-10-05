<?php
	require("../../../config.php");
	require("functions.php");
	//echo $serverHost;
	
	//Kui on sisseloginud
	if(isset($_SESSION["userID"])){
		header("Location: main.php");
		exit();
	}
	
	$signupFirstName = "";
	$signupFamilyName = "";
	$signupEmail = "";
	$gender = "";
	$signupBirthDay = null;
	$signupBirthMonth = null;
	$signupBirthYear = null;
	$signupBirthDate = null;
	
	$loginEmail = "";
	$notice ="";
	
	$signupFirstNameError = "";
	$signupFamilyNameError = "";
	$signupBirthDayError = "";
	$signupGenderError = "";
	$signupEmailError = "";
	$signupPasswordError = "";

	//Kas klõpsati sisselogimise nuppu
	if(isset($_POST["signInButton"])){
	
		//kas on kasutajanimi sisestatud
		if (isset ($_POST["loginEmail"])){
			if (empty ($_POST["loginEmail"])){
				$loginEmailError ="NB! Ilma selleta ei saa sisse logida!";
			} else {
				$loginEmail = $_POST["loginEmail"];
			}
		}
		
		//Kas kõik on sisestatud
		if(!empty($loginEmail) and !empty($_POST["loginPassword"])){
			//echo "Logime sisse";
			$notice = signIn($loginEmail, $_POST["loginPassword"]);
			
		}
	}
	
	//Kas luuakse uut kasutajat, vajutati nuppu
	if(isset($_POST["signUpButton"])){
	
	//kontrollime, kas kirjutati eesnimi
	if (isset ($_POST["signupFirstName"])){
		if (empty ($_POST["signupFirstName"])){
			$signupFirstNameError ="NB! Eesnime väli on kohustuslik!";
		} else {
			$signupFirstName = cleanInput($_POST["signupFirstName"]);
			
		}
	}
	
	//kontrollime, kas kirjutati perekonnanimi
	if (isset ($_POST["signupFamilyName"])){
		if (empty ($_POST["signupFamilyName"])){
			$signupFamilyNameError ="NB! Perekonnanime väli on kohustuslik!";
		} else {
			$signupFamilyName = cleanInput($_POST["signupFamilyName"]);
		}
	}
	
	//Kas päev on sisestatud
	if (isset ($_POST["signupBirthDay"])){
		$signupBirthDay = $_POST["signupBirthDay"];
		//echo $signupBirthDay;
	}
	
	//Kas kuu on sisestatud
	if(isset($_POST["signupBirthMonth"])){
		$signupBirthMonth = intval($_POST["signupBirthMonth"]);
	}
	
	//Kas sünnikuupäev on valiidne
	if(isset ($_POST["signupBirthDay"]) and isset ($_POST["signupBirthMonth"]) and isset ($_POST["signupBirthYear"])){
		if(checkdate(intval($_POST["signupBirthMonth"]), intval($_POST["signupBirthDay"]), intval($_POST["signupBirthYear"]))){
			
			$birthDate = date_create($_POST["signupBirthDay"]. "/" . $_POST["signupBirthMonth"]. "/" . $_POST["signupBirthYear"]);
			$signupBirthDate = date_format($birthDate, "Y-m-d");
			echo $signupBirthDate;
		} else {
			$signupBirthDayError = "Sünnikuupäev on invaliidne";
		}
	} else {
		$signupBirthDayError = "Sünnikuupäev pole määratud";
	}
	
	
	//Kas aasta on sisestatud
	if (isset ($_POST["signupBirthYear"])){
		$signupBirthYear = $_POST["signupBirthYear"];
		//echo $signupBirthYear;
	}
	
	//kontrollime, kas kirjutati kasutajanimeks email
	if (isset ($_POST["signupEmail"])){
		if (empty ($_POST["signupEmail"])){
			$signupEmailError ="NB! E-posti väli on kohustuslik!";
		} else {
			$signupEmail = cleanInput($_POST["signupEmail"]);
			
			$signupEmail = filter_var($signupEmail, FILTER_SANITIZE_EMAIL);
			$signupEmail = filter_var($signupEmail, FILTER_VALIDATE_EMAIL);
		}
	}
	
	if (isset ($_POST["signupPassword"])){
		if (empty ($_POST["signupPassword"])){
			$signupPasswordError = "NB! Parooli väli on kohustuslik!";
		} else {
			if (strlen($_POST["signupPassword"]) < 8){
				$signupPasswordError = "NB! Liiga lühike salasõna, vaja vähemalt 8 tähemärki!";
			} else{
				$signupPassword = $_POST["signupPassword"];
			}
		}
	}
	
	if (isset($_POST["gender"]) && !empty($_POST["gender"])){ //kui on määratud ja pole tühi
			$gender = intval($_POST["gender"]);
		} else {
			$signupGenderError = " (Palun vali sobiv sugu!) Määramata!";
	}
	
	
	}
	//Uue kasutaja loomise lõpp
	
	//Tekitame kuupäeva valiku
	$signupDaySelectHTML = "";
	$signupDaySelectHTML .= '<select name="signupBirthDay">' ."\n";
	$signupDaySelectHTML .= '<option value="" selected disabled>päev</option>' ."\n";
	for ($i = 1; $i < 32; $i ++){
		if($i == $signupBirthDay){
			$signupDaySelectHTML .= '<option value="' .$i .'" selected>' .$i .'</option>' ."\n";
		} else {
			$signupDaySelectHTML .= '<option value="' .$i .'">' .$i .'</option>' ." \n";
		}
		
	}
	$signupDaySelectHTML.= "</select> \n";
	
	//tekitan sünnikuu valiku
	$monthNamesEt = ["jaanuar", "veebruar", "märts", "april", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];
	$signupMonthSelectHTML ="";
	$signupMonthSelectHTML .= '<select name ="signupBirthMonth">' ."\n";
	$signupMonthSelectHTML .= '<option value="" selected disabled>kuu</option>'."\n";
	foreach($monthNamesEt as $key => $month){
		if($key + 1 === $signupBirthMonth){
			$signupMonthSelectHTML .= '<option value="'.($key+1).'" selected>' .$month."</option> \n";
		} else {
			$signupMonthSelectHTML .= '<option value="'.($key+1).'" >' .$month."</option> \n";
		}
	}
	$signupMonthSelectHTML .="</select> \n";
	
	//UUE KASUTAJA LISAMINE ANDMEBAASI
	if(!empty($_POST["signupPassword"]) and empty($signupFirstNameError) and empty($signupFamilyNameError) and empty($signupBirthDayError) and empty($signupGenderError) and empty($signupEmailError) and empty($signupPasswordError)){
		signUp($signupFirstName, $signupFamilyName, $signupBirthDate, $gender, $signupEmail, $signupPassword);
	}
	
	//Tekitame aasta valiku
	$signupYearSelectHTML = "";
	$signupYearSelectHTML .= '<select name="signupBirthYear">' ."\n";
	$signupYearSelectHTML .= '<option value="" selected disabled>aasta</option>' ."\n";
	$yearNow = date("Y");
	for ($i = $yearNow; $i > 1900; $i --){
		if($i == $signupBirthYear){
			$signupYearSelectHTML .= '<option value="' .$i .'" selected>' .$i .'</option>' ."\n";
		} else {
			$signupYearSelectHTML .= '<option value="' .$i .'">' .$i .'</option>' ."\n";
		}
		
	}
	$signupYearSelectHTML.= "</select> \n";
	

	
?>
<!DOCTYPE html>
<html lang="et">
<head>
	<meta charset="utf-8">
	<title>Sisselogimine või uue kasutaja loomine</title>
</head>
<body>
	<h1>Logi sisse!</h1>
	<p>Siin harjutame sisselogimise funktsionaalsust.</p>
	
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
		<label>Kasutajanimi (E-post): </label>
		<input name="loginEmail" type="email" value="<?php echo $loginEmail; ?>">
		<br><br>
		<input name="loginPassword" placeholder="Salasõna" type="password">
		<br><br>
		<input name ="signInButton" type="submit" value="Logi sisse">
		<p><?php echo $notice;?> </p>
	</form>
	
	<h1>Loo kasutaja</h1>
	<p>Kui pole veel kasutajat....</p>
	
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
		<label>Eesnimi </label>
		<input name="signupFirstName" type="text" value="<?php echo $signupFirstName; ?>">
		<br>
		<label>Perekonnanimi </label>
		<input name="signupFamilyName" type="text" value="<?php echo $signupFamilyName; ?>">
		<br><br>
		<label>Sisesta oma Sünnikuupäev</label>
		<?php echo "\n <br> \n" .$signupDaySelectHTML ."\n" .$signupMonthSelectHTML ."\n" .$signupYearSelectHTML ."\n <br> \n";?>
		<br><br>
		<label>Sugu</label><span>
		<br>
		<!-- Kõik läbi POST'i on string!!! -->
		<input type="radio" name="gender" value="1" <?php if ($gender == '1') {echo 'checked';} ?>><label>Mees</label> 
		<input type="radio" name="gender" value="2" <?php if ($gender == '2') {echo 'checked';} ?>><label>Naine</label>
		<br><br>
		
		<label>Kasutajanimi (E-post)</label>
		<input name="signupEmail" type="email" value="<?php echo $signupEmail; ?>">
		<br><br>
		<input name="signupPassword" placeholder="Salasõna" type="password">
		<br><br>

		
		<input name ="signUpButton" type="submit" value="Loo kasutaja">
		<span>
		<?php 
		echo "<p>" . $signupFirstNameError . "</p>";
		echo "<p>" . $signupFamilyNameError. "</p>";
		echo "<p>" . $signupBirthDayError. "</p>";
		echo "<p>" . $signupGenderError ."</p>";
		echo "<p>" . $signupEmailError ."</p>";
		echo "<p>" . $signupPasswordError ."</p>";
		
		?>
		</span>
	</form>
		
</body>
</html>