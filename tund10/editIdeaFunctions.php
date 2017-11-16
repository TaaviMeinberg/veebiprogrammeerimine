<?php
	require("../../../config.php");
	$database = "if17_taavi_meinberg";
	
	function getSingleIdea($editId){
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUserName"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT idea, ideaColour FROM vpuserIdeas WHERE id = ?");
		echo $mysqli->error;
		
		$stmt->bind_param("i", $editId);
		$stmt->bind_result($idea, $color);
		$stmt->execute();
		$ideaObject = new Stdclass();
		
		if($stmt->fetch()){
			$ideaObject->text = $idea;
			$ideaObject->color = $color;
		} else{
			header("Location: userIdeas.php");
			$stmt->close();
			$mysqli->close();
			exit();
		}
		
		
		$stmt->close();
		$mysqli->close();
		return $ideaObject;
	}
	
	function updateIdea($id, $idea, $color){
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUserName"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE vpuserIdeas SET idea = ? , ideaColour = ? WHERE id = ?");
		echo $mysqli->error;
		
		$stmt->bind_param("ssi", $idea, $color, $id);
		$stmt->execute();
		
		$stmt->close();
		$mysqli->close();
	}
	
	function deleteIdea($id){
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUserName"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE vpuserIdeas SET deleted = NOW() WHERE id = ?");
		echo $mysqli->error;
		$stmt->bind_param("i", $id);
		$stmt->execute();
		
		$stmt->close();
		$mysqli->close();
	}
?>