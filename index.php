<?php

session_start();
// $mysqli=new mysqli("localhost","root","","car_rental_system");
// // Check connection
// if ($mysqli->connect_error) {
//     die("Connection failed: " . $mysqli->connect_error);
// }
// $_SESSION['mysqli'] = $mysqli;

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Car Rental Website</title>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, user-scalable=no"
    />
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/main.css" />
    <noscript
      ><link rel="stylesheet" href="assets/css/noscript.css"
    /></noscript>
  </head>
  <body class="is-preload">
    <!-- Wrapper -->
    <div id="wrapper">
      <!-- Header -->
      <header id="header" class="alt">
        <a href="index.php" class="logo"
          ><strong>Car Rental</strong> <span>Website</span></a
        >
        <nav>
          <a href="#menu">Menu</a>
        </nav>
      </header>

      <!-- Menu -->
      <nav id="menu">
        <ul class="links">
          <li class="active"><a href="index.php">Home </a></li>

          <li><a href="car_list.php">Car Catalog</a></li>

          <?php
        if (!isset($_SESSION['ssn'])|| empty($_SESSION['ssn'])) { ?>
            <li class="nav-item"><a href="logorsign.html" class="nav-link">Login Or Register</a></li>
        <?php } else { ?>
            <li class="nav-item"><a href="destroy.php" class="nav-link">Sign Out</a></li>
        <?php } ?>

        <?php
          
          if (isset($_SESSION['ssn'])) { ?>
              <li><a href="user_reservations.php">Reservations</a></li>
          <?php }  ?>

          <li><a href="about-usUser.php">About Us</a></li>

          <li><a href="contactUser.php">Contact Us</a></li>
        </ul>
      </nav>

      <!-- Banner -->
      <section id="banner" class="major">
        <div class="inner">
          <header class="major">
            <h1>Explore the world with comfortable car</h1>
          </header>
          <div class="content">
            <p>
              Looking for a vehicle? You’re at the right place.We offer
              professional car rental & limousine services in our range of
              high-end vehicles.
            </p>
          </div>
        </div>
      </section>

      <!-- About us -->
      <section>
        <div class="inner">
          <header class="major">
            <h2>About us</h2>
          </header>
          <p>
            Welcome to our car rental service, where convenience and reliability
            converge to provide you with an unmatched travel experience. At our
            core, we believe in making your journey seamless and enjoyable. Our
            commitment to excellence, safety, and customer satisfaction sets us
            apart in the car rental industry.
          </p>
          <ul class="actions">
            <li><a href="about-usUser.php" class="button next">Read more</a></li>
          </ul>
        </div>
      </section>

      <!-- Footer -->
      <footer id="footer">
        <div class="inner">
          <ul class="icons">
            <li>
              <a href="#" class="icon alt fa-twitter"
                ><span class="label">Twitter</span></a
              >
            </li>
            <li>
              <a href="#" class="icon alt fa-facebook"
                ><span class="label">Facebook</span></a
              >
            </li>
            <li>
              <a href="#" class="icon alt fa-instagram"
                ><span class="label">Instagram</span></a
              >
            </li>
            <li>
              <a href="#" class="icon alt fa-linkedin"
                ><span class="label">LinkedIn</span></a
              >
            </li>
          </ul>
        </div>
      </footer>
    </div>

    <!-- Scripts -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/jquery.scrolly.min.js"></script>
    <script src="assets/js/jquery.scrollex.min.js"></script>
    <script src="assets/js/browser.min.js"></script>
    <script src="assets/js/breakpoints.min.js"></script>
    <script src="assets/js/util.js"></script>
    <script src="assets/js/main.js"></script>
  </body>
</html>
