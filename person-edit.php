<?php
//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database
$mysqli = new mysqli("oniddb.cws.oregonstate.edu","bedellk-db","RCyLje1vIjJhBxQd","bedellk-db");
if($mysqli->connect_errno){
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
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
        <h1>Edit Person</h1>
    </div>
    <?php
    if(!($stmt = $mysqli->prepare("SELECT PER.id, PER.first_name, PER.last_name, PER.email, PER.delivery_pref FROM person_kyle PER WHERE PER.id = ?;"))){
      echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
    }
    if(!($stmt->bind_param("i",$_POST['id']))){
      echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
    }
    if(!$stmt->execute()){
      echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
    }
    if(!$stmt->bind_result($id, $first_name, $last_name, $email, $delivery_pref)){
      echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
    }
    while($stmt->fetch()){
    ?>

    <div class="content">
        <h2 class="content-subhead">Edit <?php echo $first_name ?> <?php echo $last_name ?></h2>
        <p>
            Thundercats venmo pinterest, street art irony hammock butcher chicharrones raw denim kogi. Umami etsy bicycle rights yuccie, 90's waistcoat typewriter dreamcatcher celiac austin blog.
        </p>

        <form class="pure-form pure-form-stacked" method="post" action="person-edit-do.php">
            <input type="hidden" name="id" value="<?php echo $_POST['id'] ?>">
            <fieldset>
                <legend>Edit Person</legend>

                <div class="pure-g">
                    <div class="pure-u-1-3">
                        <label for="first_name">First Name</label>
                        <input name="first_name" type="text" value="<?php echo $first_name ?>" required>
                    </div>

                    <div class="pure-u-1-3">
                        <label for="last_name">Last Name</label>
                        <input name="last_name" type="text" value="<?php echo $last_name ?>" required>
                    </div>

                    <div class="pure-u-1-3">
                        <label for="email">E-mail</label>
                        <input name="email" type="email" value="<?php echo $email ?>">
                    </div>

                    <div class="pure-u-1-3">
                        <label for="delivery_pref">Delivery Preference</label>
                        <input name="delivery_pref" type="text" value="<?php echo $delivery_pref ?>">
                    </div>
                </div>
                <p>
                <button type="submit" class="pure-button pure-button-primary">Submit</button>
                </p>
            </fieldset>
        </form>
        <?php
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
