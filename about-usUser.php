<!DOCTYPE html>
<html>
  <head>
    <title>Document</title>
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
          session_start();
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

      <!-- Main -->
      <div id="main" class="alt">
        <!-- One -->
        <section id="one">
          <div class="inner">
            <header class="major">
              <h1>About Us</h1>
            </header>
            <span class="image main"
              ><img src="images/about-fullscreen-1-1920x700.jpg" alt=""
            /></span>
            <p>
              Welcome to our car rental service, where convenience and
              reliability converge to provide you with an unmatched travel
              experience. At our core, we believe in making your journey
              seamless and enjoyable. Our commitment to excellence, safety, and
              customer satisfaction sets us apart in the car rental industry. As
              you explore our diverse fleet of well-maintained vehicles, you'll
              find options to suit every need and occasion. We understand that
              your time is valuable, and we strive to offer flexible rental
              solutions that align with your schedule and preferences. Our
              dedicated team of professionals is here to ensure that your travel
              plans unfold smoothly. Whether you're embarking on a business
              trip, a family vacation, or a spontaneous road adventure, our goal
              is to be your reliable companion on the road. Discover the freedom
              to travel at your own pace with our car rental service. We're not
              just a transportation option; we're your partner in creating
              memorable journeys. Thank you for considering us for your travel
              needs. Here's to countless miles of exploration and unforgettable
              moments.
            </p>
          </div>
        </section>
      </div>

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
