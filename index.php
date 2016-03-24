<?php
//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database
$mysqli = new mysqli("oniddb.cws.oregonstate.edu","bedellk-db","RCyLje1vIjJhBxQd","bedellk-db");
if($mysqli->connect_errno){
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
date_default_timezone_set('Asia/Tokyo');
?>

<!DOCTYPE html>
<html lang="en">

  <head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="A layout example with a side menu that hides on mobile, just like the Pure website.">
  <title></title>
  <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
  <!--[if lte IE 8]>
  <link rel="stylesheet" href="css/layouts/side-menu-old-ie.css">
  <![endif]-->
  <!--[if gt IE 8]><!-->
  <link rel="stylesheet" href="css/layouts/side-menu.css">
  <link rel="stylesheet" href="css/garage.css">
  <!--<![endif]-->
</head>


  <body>
    <div id="layout">
    <!-- Menu toggle -->
<a href="#menu" id="menuLink" class="menu-link">
    <!-- Hamburger icon -->
    <span></span>
</a>

<div id="menu">
    <div class="pure-menu">
        <a class="pure-menu-heading" href="#">Garage Sale</a>

        <ul class="pure-menu-list">
            <li class="pure-menu-item"><a href="" class="pure-menu-link">Orders</a></li>
            <li class="pure-menu-item"><a href="items.php" class="pure-menu-link">Items</a></li>

            <li class="pure-menu-item" class="menu-item-divided pure-menu-selected">
                <a href="people.php" class="pure-menu-link">People</a>
            </li>

        </ul>
    </div>
</div>


    <div id="main">
    <div class="header">
        <h1>Orders</h1>
    </div>

    <div class="content">
        <h2 class="content-subhead">All Orders</h2>
        <p>
            This site is styled using the <a href="http://purecss.io/">Pure CSS framework</a>. Javascript table sorting of <a href="people.php">people</a> is provided by <a href="http://www.listjs.com/">List.js</a>. The original HTML pages were generated with <a href="http://jekyllrb.com/">Jekyll</a>. Icons are provided by <a href="https://fortawesome.github.io/Font-Awesome/">Font Awesome</a>.
        </p>

          <div class="pure-g">
            <div class="pure-u-3-4"></div>
            <div class="pure-u-1-4"><a class="pure-button pure-button-primary" href="order-new.php"><i class="fa fa-plus"></i>
              New Order</a></div>
          </div>

          <?php
          if(!($stmt = $mysqli->prepare("SELECT O.id, CONCAT(P.first_name, ' ', P.last_name), O.deadline, O.order_date, O.pay_by, x.order_id FROM order_kyle O LEFT JOIN (SELECT DISTINCT order_id FROM payment_kyle) x ON x.order_id = O.id INNER JOIN person_kyle P ON P.id = O.person_id ORDER BY O.id;"))){
            echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
          }
          if(!$stmt->execute()){
            echo "Execute failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
          }
          $stmt->store_result();
          if(!$stmt->bind_result($id, $full_name, $deadline, $order_date, $pay_by, $has_payment)){
            echo "Bind failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
          }
          while($stmt->fetch()){
            echo "<div class=\"pure-g order\">";
            echo "<div class=\"pure-u-1-4\">";
            echo "<div>";
            echo "<h2>Order ";
            printf("%03d", $id);
            echo "</h2>";
            echo "<p>Made by: " . $full_name . " <br>";
            echo "Order Date: " . date('F d, Y', strtotime($order_date)) . "<br>";
            echo "Deadline: " . date('F d, Y', strtotime($deadline)) . "<br>";
            echo "Pay By: " . date('F d, Y', strtotime($pay_by)) . "</p>";
						if ($has_payment === null) {
							echo "<p><a class=\"pure-button\" href=\"#\"><i class=\"fa fa-trash\"></i>\n";
	            echo "Delete</a></p>";
						} else {
							echo "<p><a class=\"pure-button pure-button-disabled\"><i class=\"fa fa-trash\"></i>\n";
							echo "Delete</a></p>";
						}
            echo "<p><form method=\"post\" action=\"payment-new.php\"><input type=\"hidden\" name=\"id\" value=\"" . $id . "\"><button class=\"pure-button\" href=\"payment-new.php\"><i class=\"fa fa-credit-card\"></i>\n";
            echo "Add Payment</button></form></p>";
            echo "</div></div>";
            echo "<div class=\"pure-u-3-4\">";
            echo "<h4>Items</h4>";
            echo "<table class=\"pure-table pure-table-horizontal\">";
            echo "<thead><tr><th>ID</th><th>Name</th><th>Suggested&nbsp;Price</th><th>Final&nbsp;Price</th><th>Units</th></tr></thead>";
            echo "<tbody>";
            if(!($stmt_2 = $mysqli->prepare("SELECT OI.item_id, OI.units, I.name, I.suggested_price_jpy, I.final_price_jpy FROM order_item_kyle OI INNER JOIN item_kyle I ON OI.item_id = I.id WHERE OI.order_id = " . $id . ";"))){
              echo "Prepare failed: " . $stmt_2->errno . " " . $stmt_2->error;
            }
            if(!$stmt_2->execute()){
              echo "Execute failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
            }
            $stmt_2->store_result();
            if(!$stmt_2->bind_result($item_id, $item_units, $item_name, $item_suggested_price, $item_final_price)){
              echo "Bind failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
            }
            while($stmt_2->fetch()){
              echo "<tr>";
              echo "<td>" . $item_id . "</td>";
              echo "<td>" . $item_name . "</td>";
              echo "<td>JPY&nbsp;" . number_format($item_suggested_price) . "</td>";
              echo "<td>JPY&nbsp;" . number_format($item_final_price) . "</td>";
              echo "<td>" . $item_units . "</td>";
              echo "</tr>";
              }
            $stmt_2->close();
            echo "</tbody></table>";

            if(!($stmt_3 = $mysqli->prepare("SELECT P.id, type, amount_jpy, date, CONCAT(person_kyle.first_name, ' ', person_kyle.last_name) FROM payment_kyle P INNER JOIN person_kyle ON person_kyle.id = P.person_id WHERE order_id = " . $id . ";"))){
              echo "Prepare failed: " . $stmt_3->errno . " " . $stmt_3->error;
            }
            if(!$stmt_3->execute()){
              echo "Execute failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
            }
            $stmt_3->store_result();
            if(!$stmt_3->bind_result($payment_id, $payment_type, $payment_amount, $payment_date, $payment_name)){
              echo "Bind failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
            }
						if($stmt_3->num_rows() > 0) {
							echo "<h4>Payments</h4>";
							echo "<table class=\"pure-table pure-table-horizontal\"><thead><tr><th>ID</th><th>Date</th><th>Paid By</th><th>Amount</th><th>Type</th></tr></thead><tbody>";
	            while($stmt_3->fetch()){
	              echo "<tr>";
	              echo "<td>" . $payment_id . "</td>";
	              echo "<td>" . $payment_date . "</td>";
	              echo "<td>" . $payment_name . "</td>";
	              echo "<td>JPY&nbsp;" . number_format($payment_amount) . "</td>";
	              echo "<td>" . $payment_type . "</td>";
	              echo "</tr>";
	              }
	            } else {
								echo "<h4>Payments</h4>";
								echo "<p>There are currently no payments for this order.</p>";
							}
							$stmt_3->close();
							echo "</tbody></table></p></div></div>";
						}
          $stmt->close();
          ?>

    </div>

</div>


  </div>
  <script src="js/ui.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/list.js/1.1.1/list.min.js"></script>

  </body>

</html>
