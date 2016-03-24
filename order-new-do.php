<?php
//Turn on error reporting
ini_set('display_errors', 'On');
$last_inserted = null;
//Connects to the database
$mysqli = new mysqli("oniddb.cws.oregonstate.edu","bedellk-db","RCyLje1vIjJhBxQd","bedellk-db");
if(!$mysqli || $mysqli->connect_errno){
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}

// insert order
if(!($stmt = $mysqli->prepare("INSERT INTO order_kyle (person_id, deadline, order_date, pay_by) VALUES (?,?,?,?);"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!($stmt->bind_param("isss",$_POST['person'],$_POST['order_deadline'],$_POST['order_date'],$_POST['order_pay_by']))){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->execute()){
	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
} else {
	$last_inserted = $mysqli->insert_id;
}
$stmt->close();


// insert items for the order
foreach ($_POST['item'] as $k => $v) {
	if ($v === '') continue;
	if(!($stmt = $mysqli->prepare("INSERT INTO order_item_kyle (order_id, item_id, units) VALUES (?,?,?);"))){
		echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
	}
	if(!($stmt->bind_param("iii",$last_inserted,$k,$v))){
		echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
	}
	if(!$stmt->execute()){
		echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
	}
}
$stmt->close();

echo "<script type=\"text/javascript\">window.location = \"index.php\";</script>";

?>
