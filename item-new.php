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
        <h1>New Item</h1>
    </div>

    <div class="content">
        <h2 class="content-subhead">Create a New Item</h2>
        <p>
            Thundercats venmo pinterest, street art irony hammock butcher chicharrones raw denim kogi. Umami etsy bicycle rights yuccie, 90's waistcoat typewriter dreamcatcher celiac austin blog.
        </p>

        <form class="pure-form pure-form-stacked" method="post" action="item-new-do.php">
            <fieldset>
                <legend>New Item</legend>

                <div class="pure-g">
                    <div class="pure-u-1-3">
                        <label for="item-name">Name</label>
                        <input name="item-name" type="text" placeholder="" required>
                    </div>

                    <div class="pure-u-1-3">
                        <label for="item-suggested-price">Suggested Price (JPY)</label>
                        <input name="item-suggested-price" type="text" placeholder="" required>
                    </div>

                    <div class="pure-u-1-3">
                        <label for="item-final-price">Final Price (JPY)</label>
                        <input name="item-final-price" type="text" placeholder="">
                    </div>

                    <div class="pure-u-1-3">
                        <label for="item-units">Units</label>
                        <input name="item-units" type="text" placeholder="">
                    </div>
                    <div class="pure-u-2-3">
                      <label for="item-notes">Notes</label>
                    <textarea name="item-notes" class="pure-input-1" placeholder="Add notes for this item."></textarea>
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
