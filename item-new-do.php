<?php
//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database
$mysqli = new mysqli("oniddb.cws.oregonstate.edu","bedellk-db","RCyLje1vIjJhBxQd","bedellk-db");
if(!$mysqli || $mysqli->connect_errno){
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}

if(!($stmt = $mysqli->prepare("INSERT INTO item_kyle (name, notes, final_price_jpy, suggested_price_jpy, units) VALUES (?,?,?,?,?);"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!($stmt->bind_param("ssiii",$_POST['item-name'],$_POST['item-notes'],$_POST['item-final-price'],$_POST['item-suggested-price'],$_POST['item-units']))){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->execute()){
	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
} else {
	echo "<script type=\"text/javascript\">window.location = \"items.php\";</script>";
}
$stmt->close();
?>
