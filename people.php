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
        <h1>People</h1>
    </div>

    <div class="content">
        <h2 class="content-subhead">All People</h2>
        <p>
            Thundercats venmo pinterest, street art irony hammock butcher chicharrones raw denim kogi. Umami etsy bicycle rights yuccie, 90's waistcoat typewriter dreamcatcher celiac austin blog.
        </p>

          <div class="pure-g">
            <div class="pure-u-3-4"></div>
            <div class="pure-u-1-4"><a class="pure-button pure-button-primary" href="person-new.php"><i class="fa fa-user-plus"></i>
              New Person</a></div>
          </div>


            <div class="pure-g">

            <div class="pure-u-1-1" id="people">
                    <h4>&nbsp;</h4>
                    <table class="pure-table pure-table-horizontal">
                        <thead>
                            <tr>
                                <th><button class="sort" data-sort="id">ID</button></th>
                                <th><button class="sort" data-sort="first_name">First&nbsp;Name</button></th>
                                <th><button class="sort" data-sort="last_name">Last&nbsp;Name</button></th>
                                <th><button class="sort" data-sort="email">Email</button></th>
                                <th><button class="sort" data-sort="delivery_pref">Delivery&nbsp;Preference</button></th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>

                        <tbody class="list">
                          <?php
                          if(!($stmt = $mysqli->prepare("SELECT PER.id, PER.first_name, PER.last_name, PER.email, PER.delivery_pref, x.person_id, y.person_id FROM person_kyle PER LEFT JOIN (SELECT DISTINCT person_id FROM payment_kyle) x ON x.person_id = PER.id LEFT JOIN (SELECT DISTINCT person_id FROM order_kyle) y ON y.person_id = PER.id;"))){
                          	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
                          }

                          if(!$stmt->execute()){
                          	echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
                          }
                          if(!$stmt->bind_result($id, $first_name, $last_name, $email, $delivery_pref, $has_payment, $has_order)){
                          	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
                          }
                          while($stmt->fetch()){
                            echo "<tr>";
                            echo "<td class=\"id\">" . $id . "</td>";
                            echo "<td class=\"first_name\">" . $first_name . "</td>";
                            echo "<td class=\"last_name\">" . $last_name . "</td>";
                            echo "<td class=\"email\">" . $email . "</td>";
                            echo "<td class=\"delivery_pref\">" . $delivery_pref . "</td>";
                            echo "<td><form method=\"post\" action=\"person-edit.php\"><input type=\"hidden\" name=\"id\" value=\"" . $id . "\"><button class=\"pure-button pure-button-primary\" href=\"person-edit.php\"><i class=\"fa fa-pencil\"></i></button></form></td>";
                            if($has_payment === null && $has_order === null) {
                              echo "<td><form method=\"post\" action=\"person-delete-do.php\"><input type=\"hidden\" name=\"id\" value=\"" . $id . "\"><button class=\"pure-button button-red\" href=\"#\"><i class=\"fa fa-trash\"></i></button></form></td>";
                            } else {
                              echo "<td><a class=\"pure-button pure-button-disabled\"><i class=\"fa fa-trash\"></i></a></td>";
                            }
                            echo "</tr>";
                          }
                          $stmt->close();
                          ?>
                        </tbody>
                    </table>
            </div>
          </div>

    </div>

</div>
<script src="//cdnjs.cloudflare.com/ajax/libs/list.js/1.1.1/list.min.js"></script>
<script>
var options = {
  valueNames: [ 'id', 'first_name', 'last_name', 'email', 'delivery_pref']
};

var userList = new List('people', options);
</script>


  </div>
  <script src="js/ui.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/list.js/1.1.1/list.min.js"></script>

  </body>

</html>
