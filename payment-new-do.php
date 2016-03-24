<?php
//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database
$mysqli = new mysqli("oniddb.cws.oregonstate.edu","bedellk-db","RCyLje1vIjJhBxQd","bedellk-db");
if(!$mysqli || $mysqli->connect_errno){
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}

if(!($stmt = $mysqli->prepare("INSERT INTO payment_kyle (type, amount_jpy, date, order_id, person_id) VALUES (?,?,?,?,?);"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!($stmt->bind_param("sssss",$_POST['payment-type'],$_POST['payment-amount'],$_POST['payment-date'],$_POST['order-id'],$_POST['payment-person']))){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->execute()){
	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
} else {
	echo "<script type=\"text/javascript\">window.location = \"index.php\";</script>";
}
$stmt->close();
?>
