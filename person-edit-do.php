<?php
//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database
$mysqli = new mysqli("oniddb.cws.oregonstate.edu","bedellk-db","RCyLje1vIjJhBxQd","bedellk-db");
if(!$mysqli || $mysqli->connect_errno){
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
	//INSERT INTO tbl_name (a,b,c) VALUES (1,2,3), (4,5,6), (7,8,9);
	$thisUpdate = "UPDATE person_kyle SET first_name = ?, last_name = ?, email = ?, delivery_pref = ? WHERE id = ?;";
	if(!($stmt = $mysqli->prepare($thisUpdate))){
		echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
	}
	if(!($stmt->bind_param("ssssi",$_POST['first_name'],$_POST['last_name'],$_POST['email'],$_POST['delivery_pref'],$_POST['id']))){
		echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
	}
	if(!$stmt->execute()){
		echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
	}
	$stmt->close();
	echo "<script type=\"text/javascript\">window.location = \"people.php\";</script>";
?>
