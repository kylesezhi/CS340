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
            <li class="pure-menu-item"><a href="index.php" class="pure-menu-link">Orders</a></li>
            <li class="pure-menu-item"><a href="items.php" class="pure-menu-link">Items</a></li>

            <li class="pure-menu-item" class="menu-item-divided pure-menu-selected">
                <a href="people.php" class="pure-menu-link">People</a>
            </li>

        </ul>
    </div>
</div>


    <div id="main">
    <div class="header">
        <h1>Add Payment</h1>
    </div>

    <div class="content">
        <h2 class="content-subhead">Add Payment to Order <?php printf("%03d", $_POST['id']); ?></h2>
        <p>
            This site is styled using the <a href="http://purecss.io/">Pure CSS framework</a>. Javascript table sorting is provided by <a href="http://www.listjs.com/">List.js</a>. The original HTML pages were generated with <a href="http://jekyllrb.com/">Jekyll</a>. Icons are provided by <a href="https://fortawesome.github.io/Font-Awesome/">Font Awesome</a>.
        </p>

        <form class="pure-form pure-form-stacked" method="post" action="payment-new-do.php">
            <fieldset>
                <legend>Payment Details</legend>
                <?php echo "<input type=\"hidden\" name=\"order-id\" value=\"" . $_POST['id'] . "\">"; ?>
                <div class="pure-g">
                    <div class="pure-u-1-3">
                        <label for="payment-date">Date</label>
                        <input name="payment-date" type="text" placeholder="YYYY-MM-DD" required>
                    </div>

                    <div class="pure-u-1-3">
                        <label for="payment-amount">Amount (JPY)</label>
                        <input name="payment-amount" type="text" required>
                    </div>

                    <div class="pure-u-1-3">
                        <label for="payment-type">Type</label>
                        <input name="payment-type" type="text" placeholder="cash, credit, etc." required>
                    </div>

                    <div class="pure-u-1-3">
                        <label for="payment-person">Person</label>
                        <select name="payment-person" class="pure-input-3-4" required>
                          <?php
                          if(!($stmt = $mysqli->prepare("SELECT id, CONCAT(P.first_name, ' ', P.last_name) FROM person_kyle P;"))){
                          	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
                          }

                          if(!$stmt->execute()){
                          	echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
                          }
                          if(!$stmt->bind_result($id, $full_name)){
                          	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
                          }
                          while($stmt->fetch()){
                            echo "<option name=\"payment-person\" value=\"" . $id . "\">" . $full_name . "</option>";
                          }
                          ?>
                        </select>
                    </div>

                </div>
                <p>
                <button type="submit" class="pure-button pure-button-primary">Submit</button>
                </p>
            </fieldset>
        </form>

    </div>

</div>


  </div>
  <script src="js/ui.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/list.js/1.1.1/list.min.js"></script>

  </body>

</html>
