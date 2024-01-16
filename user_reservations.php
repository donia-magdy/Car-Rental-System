


<!DOCTYPE html>
<html lang="en">
<head>

    <title>Car Reservation Form</title>    
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
<body>

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
        if (!isset($_SESSION['ssn'])) { ?>
            <li class="nav-item"><a href="logorsign.html" class="nav-link">Login Or Register</a></li>
        <?php } else { ?>
            <li class="nav-item"><a href="destroy.php" class="nav-link">Sign Out</a></li>
        <?php } ?>

          <li><a href="user_reservations.php">Reservations</a></li>

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




</body>
<script src="reservation.js"></script>
<script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/jquery.scrolly.min.js"></script>
    <script src="assets/js/jquery.scrollex.min.js"></script>
    <script src="assets/js/browser.min.js"></script>
    <script src="assets/js/breakpoints.min.js"></script>
    <script src="assets/js/util.js"></script>
    <script src="assets/js/main.js"></script>
</html>







<section>
    <?php 
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "car_rental_system";
        
        $conn = new mysqli($servername, $username, $password, $dbname);
        
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        
        if (!isset($_SESSION['ssn'])) {
            // SSN doesn't exist, echo a message and stop processing
            echo '<script>';
           // echo "alert('Please sign in first.');";
            echo "window.location.href = 'index.php';";
            echo '</script>';

        }
        $ssn = $_SESSION['ssn'];
        $sql = "SELECT r.*, c.* FROM reservation r
                JOIN car c ON r.plate_id = c.plate_id
                WHERE r.ssn = $ssn";
        
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result)>0) {
            echo "<h2>Reservations</h2>";
        } else {
            echo "<h2>No reservations yet !</h2>";
        }

        if (isset($_POST['delete_reservation'])) {
            $reservation_number_to_delete = $_POST['reservation_number'];
            // Implement deletion logic here
            $delete_sql = "DELETE FROM reservation WHERE reservation_number = $reservation_number_to_delete";
            if ($conn->query($delete_sql) === TRUE) {
                echo '<script>alert("Reservation deleted successfully.");</script>';
                echo '<script>';
            echo "window.location.href = 'index.php';";
            echo '</script>';

            } else {
                echo '<script>alert("Error deleting reservation: ' . $conn->error . '");</script>';
            }
        }
    ?>
    <div>
        <ul>
            <?php
                $reserv_num = 1;             
                while($car = mysqli_fetch_assoc($result)) {
                    echo "<br>";
                    echo "<h3>Reservation #" . $reserv_num . "</h3>";
                    $reserv_num = $reserv_num + 1;

                    echo "<img src=\"images/" . $car['img'] . "\" class=\"nav-item\" style=\"width: 500px; height: 300px;\">";
                    echo "<li class=\"nav-item\">Reservation Code: " . $car['reservation_number'] . "</li>";
                    echo "<li class=\"nav-item\">Model: " . $car['model'] . "</li>";
                    echo "<li class=\"nav-item\">Year: " . $car['year'] . "</li>";
                    echo "<li class=\"nav-item\">Colour: " . $car['colour'] . "</li>";
                    if($car['automatic'] === 'T') {
                        $type = "Automatic";
                    } else {
                        $type = "Manual";
                    }
                    echo "<li class=\"nav-item\">Type: " . $type . "</li>";
                    echo "<li class=\"nav-item\">Plate ID: " . $car['plate_id'] . "</li>";


                    $pickupOfficeQuery = "SELECT office.* FROM office WHERE office_id = '" . $car['pickup_office_id'] . "'";
                    $pickupOfficeResult = $conn->query($pickupOfficeQuery);
                    $pickupOfficeRow = $pickupOfficeResult->fetch_assoc();
                    $pickup_country= isset($pickupOfficeRow["country"]) ? $pickupOfficeRow["country"] : "N/A";
                    $pickup_city = isset($pickupOfficeRow["city"]) ? $pickupOfficeRow["city"] : "N/A";
                    $pickup_location= isset($pickupOfficeRow["location"]) ? $pickupOfficeRow["location"] : "N/A";
                    
                    
                    
                    


                    
                    $returnOfficeQuery = "SELECT office.* FROM office WHERE office_id = '" . $car['return_office_id'] . "'";
                    $returnOfficeResult = $conn->query($returnOfficeQuery);
                    $returnOfficeRow = $returnOfficeResult->fetch_assoc();
                    $return_country= isset($returnOfficeRow["country"]) ? $returnOfficeRow["country"] : "N/A";
                    $return_city = isset($returnOfficeRow["city"]) ? $returnOfficeRow["city"] : "N/A";
                    $return_location= isset($returnOfficeRow["location"]) ? $returnOfficeRow["location"] : "N/A";
                    



                    echo "<li class=\"nav-item\">Pickup Country: " . $pickup_country. "</li>";
                    echo "<li class=\"nav-item\">Pickup City: " . $pickup_city. "</li>";
                    echo "<li class=\"nav-item\">Pickup Location: " . $pickup_location. "</li>";
                    echo "<li class=\"nav-item\">Pickup Time " . $car['pickup_time'] . "</li>";


                    echo "<li class=\"nav-item\">Return Country: " . $return_country. "</li>";
                    echo "<li class=\"nav-item\">Return City: " . $return_city . "</li>";
                    echo "<li class=\"nav-item\">Return Location: " . $return_location . "</li>";
                    echo "<li class=\"nav-item\">Return Time: " . $car['return_time'] . "</li>";
                    echo "<li class=\"nav-item\">Price per day: " . $car['price_per_day'] . "</li>";
                    
                    $start_date = strtotime($car['pickup_time']);  
                    $end_date = strtotime($car['return_time']);
                    $days = (($end_date - $start_date)/60/60/24) + 1;  //calculate number of reservation days
                    $price_per_day = $car['price_per_day'];  //price of the car per day
                    $amount_per_reservation = $price_per_day * $days;  //total amount to be paid
                    echo "<li class=\"nav-item\">Total payment: $" . $amount_per_reservation . "</li>";


                    echo "<form method='post' action=''>";
                    echo "<input type='hidden' name='reservation_number' value='{$car['reservation_number']}'>";
                    echo "<button type='submit' class='delete-button' name='delete_reservation' onclick=\"return confirm('Are you sure you want to delete this reservation?');\">Delete</button>";
                    echo "</form>";
                }
            ?>
        </ul>
    </div>
</section>

<?php ?>

</body>
</html>
