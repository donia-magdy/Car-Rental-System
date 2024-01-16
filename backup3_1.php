
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "car_rental_system";
session_start();
$conn = new mysqli($servername, $username, $password, $dbname);
$plate_id = $_GET['plate_id'];

$result = mysqli_query($conn, "SELECT car.*,office.* FROM `car` JOIN office ON car.office_id = office.office_id  WHERE plate_id ='$plate_id'");
$carinfo = mysqli_fetch_assoc($result);

    if (isset($_SESSION['ssn'])) {
        $ssn = $_SESSION['ssn'];
    }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture form data
    

    $return_location = $_POST["return_location"];
    $pickup_time = $_POST["pickup_time"];
    $return_time = $_POST["return_time"];
    
    $currentDate = date("Y-m-d H:i:s");
 if (!isset($_SESSION['ssn'])) {
        // SSN doesn't exist, echo a message and stop processing
        echo '<script>';
        echo "alert('Please sign in first.');";
        echo "window.location.href = 'backup3_1.php?plate_id=" . $plate_id . "';";
        echo '</script>';
        exit;
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


    $payment_method = $_POST["payment_method"];
    
    // Check if a payment method is selected
    if (!isset($payment_method) || ($payment_method != "credit" && $payment_method != "cash")) {
        echo '<script>';
        echo 'alert("Please select a valid payment method (credit or cash).");';
        echo '</script>';
        exit;
    }




    $pickup_office_id = $carinfo['office_id'];

    list($return_country, $return_city, $return_location) = explode('|', $return_location);

    // Retrieve office ID for return city
    $returnOfficeQuery = "SELECT office_id FROM office WHERE country = '$return_country' AND city = '$return_city' AND location = '$return_location'";
    $returnOfficeResult = $conn->query($returnOfficeQuery);
    
    if ($returnOfficeResult->num_rows > 0) {
        $returnOfficeRow = $returnOfficeResult->fetch_assoc();
        $return_office_id = $returnOfficeRow["office_id"];
    } else {
        
        echo"<script>alert(\"Return office not found for the specified country, city, and location.\")</script>";
        echo"<script>window.location.href=\"backup3_1.php\"</script>";
    }
    
    
      $statusCheckQuery = "SELECT `status` FROM car WHERE plate_id = '$plate_id'";
      $statusResult = $conn->query($statusCheckQuery);
      
      if ($statusResult === false) {
          die("Error executing status check query: " . $conn->error);
      }
      
      if ($statusResult->num_rows > 0) {
          // Fetch the result as an associative array
          $row = $statusResult->fetch_assoc();
          
          // Access the 'status' column
          $existingStatus = $row["status"];
          
          if ($existingStatus == 'out_of_service') {
              echo '<script>';
              echo 'alert("This car is out of service ");';
              echo 'window.location = "car_list.php"';
              echo '</script>';
          }
          else{
            $rentedCheckQuery = "SELECT reservation_number
            FROM reservation
            WHERE plate_id = '$plate_id'
            AND (
                (pickup_time <= '$pickup_time' AND return_time >= '$pickup_time')
                OR (pickup_time <= '$return_time' AND return_time >= '$return_time')
                OR (pickup_time >= '$pickup_time' AND pickup_time <= '$return_time')
                OR (return_time >= '$pickup_time' AND return_time <= '$return_time')
            )";
            $rentedCheckResult = $conn->query($rentedCheckQuery);
            if ($rentedCheckResult->num_rows > 0)
            {
                echo '<script>';
                echo 'alert("This car is not valid for this interval ");';
                echo 'window.location = "car_list.php"';
                echo '</script>';
            }
            else
            {
                
                if ($payment_method == "credit") {
                    // Insert reservation
                    $sql = "INSERT INTO reservation (plate_id, ssn, pickup_office_id, return_office_id, pickup_time, return_time, reservation_time, payment_date, payment_method)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    $payment_date = $currentDate;
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("sssssssss", $plate_id, $ssn, $pickup_office_id, $return_office_id, $pickup_time, $return_time, $currentDate, $payment_date, $payment_method);
                
                    if ($stmt->execute()) {
                        // Get the reservation ID
                        $reservation_id = mysqli_insert_id($conn);
                
                        // Insert payment details
                        $card_number = $_POST["card_number"];
                        $cardholder_name = $_POST["cardholder_name"];
                        $expiration_date = $_POST["expiration_date"];
                        $cvv = $_POST["cvv"];
                        $sqlPaymentDetails = "INSERT INTO payment_details (card_number, cardholder_name, expiration_date, cvv, reservation_number) VALUES (?, ?, ?, ?, ?)";
                        $stmtPaymentDetails = $conn->prepare($sqlPaymentDetails);
                        $stmtPaymentDetails->bind_param("ssssi", $card_number, $cardholder_name, $expiration_date, $cvv, $reservation_id);
                
                        if ($stmtPaymentDetails->execute()) {
                            // Success
                            echo '<script>';
                            echo 'alert("Reservation and payment details made successfully. ");';
                            echo 'window.location = "car_list.php"';
                            echo '</script>';
                        } else {
                            // Error
                            die("Error inserting new payment details: " . $stmtPaymentDetails->error);
                        }
                
                        $stmtPaymentDetails->close();
                    } else {
                        // Error
                        die("Error inserting new reservation: " . $stmt->error);
                    }
                
                    $stmt->close();
                } else {
                    // Insert reservation for cash payment
                    $sql = "INSERT INTO reservation (plate_id, ssn, pickup_office_id, return_office_id, pickup_time, return_time, reservation_time, payment_date, payment_method)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    $payment_date = null;
                    $payment_method = "cash";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("sssssssss", $plate_id, $ssn, $pickup_office_id, $return_office_id, $pickup_time, $return_time, $currentDate, $payment_date, $payment_method);
                
                    if ($stmt->execute()) {
                        // Success
                        echo '<script>';
                        echo 'alert("Reservation made successfully");';
                        echo 'window.location = "car_list.php"';
                        echo '</script>';
                    } else {
                        // Error
                        die("Error inserting new reservation: " . $stmt->error);
                    }
                
                    $stmt->close();
                }
                
              
          }
        }
    }
    $conn->close();
}
?>

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

    <style>
    #expiration_date, #return_time, #pickup_time{
        color: #232943; 
    }
    </style>




</head>
<body>
<div id="wrapper">
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
          
        if (!isset($_SESSION['ssn'])) { ?>
            <li class="nav-item"><a href="logorsign.html" class="nav-link">Login Or Register</a></li>
        <?php } else { ?>
            <li class="nav-item"><a href="destroy.php" class="nav-link">Sign Out</a></li>
        <?php } ?>


        <?php
          
          if (isset($_SESSION['ssn'])) { ?>
              <li><a href="user_reservations.php">Reservations</a></li>
          <?php }  ?>




          <li><a href="about-usUser.html">About Us</a></li>

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
    <div>
        <h2>Car Details</h2>
                    <div>
                        <ul>
                            <?php
                                echo "<img src=\"images/" . $carinfo['img'] . "\" class=\"nav-item\" style=\"width: 500px; height: 300px;\">";
                                echo "<li class=\"nav-item\">Model: " . $carinfo['model'] . "</li>";
                                echo "<li class=\"nav-item\">Year: " . $carinfo['year'] . "</li>";
                                echo "<li class=\"nav-item\">Color: " . $carinfo['colour'] . "</li>";
                                echo "<li class=\"nav-item\">Horse Power: " . $carinfo['power'] . "</li>";
                                if($carinfo['automatic'] === 'T') {
                                    $type = "Automatic";
                                } else {
                                    $type = "Manual";
                                }
                                echo "<li class=\"nav-item\">Type: " . $type . "</li>";
                                echo "<li class=\"nav-item\">Tank Capacity: " . $carinfo['tank_capacity'] . "</li>";
                                echo "<li class=\"nav-item\">Country: " . $carinfo['country'] . "</li>";
                                echo "<li class=\"nav-item\">City: " . $carinfo['city'] . "</li>";
                                echo "<li class=\"nav-item\">Location: " . $carinfo['location'] . "</li>";
                                echo "<li class=\"nav-item\">Price per day: " . $carinfo['price_per_day'] . "</li>";
                            ?>
                        </ul>
                    </div>
        
            <div class="card text-center" style="margin-top: 10px; padding: 50px; background: transparent;">
                <h2>Car Reservation Form</h2>
                <form class="form-inline justify-content-center" method="post" name="myForm" action="" onsubmit="return validateReservationForm();">
                                        <?php
                        $result = mysqli_query($conn, "SELECT DISTINCT country, city, location FROM office");
                        $locations = Array();
                        while ($row = mysqli_fetch_assoc($result)) {
                            $locations[] = [
                                'country' => strtolower($row['country']),
                                'city' => strtolower($row['city']),
                                'location' => strtolower($row['location']),
                            ];
                        }
                        ?>

                        <div class="form-group mx-sm-3 mb-2">
                            <select name="return_location" id="return_location" required>
                                <option value="" disabled selected hidden>Return Office</option>
                                <?php
                                foreach ($locations as $location) {
                                    $country = $location['country'];
                                    $city = $location['city'];
                                    $locationName = $location['location'];
                                    echo "<option value=\"$country|$city|$locationName\">$country, $city, $locationName</option>";
                                }
                                $conn->close();
                                ?>
                            </select>
                        </div>

                        <div class="form-group mx-sm-3 mb-2">
                        <label for="pickup_time">Pickup Time:</label>
                        <input type="date" id="pickup_time" name="pickup_time" required><br>
                        </div>
                        
                        <div class="form-group mx-sm-3 mb-2">
                        <label for="return_time">Return Time:</label>
                        <input type="date" id="return_time" name="return_time" required><br>
                        </div>

                        
                        <div class="form-check mx-sm-3 mb-2">
                            <input type="radio" class="form-check-input" id="credit" name="payment_method" value="credit"  required onclick="toggleCreditCardDetails()">
                            <label class="form-check-label" for="credit">Credit</label>
                        </div>
                        <div class="form-check mx-sm-3 mb-2">
                            <input type="radio" class="form-check-input" id="cash" name="payment_method" value="cash"  required onclick="toggleCreditCardDetails()">
                            <label class="form-check-label" for="cash">Cash</label>
                        </div>


                        <div id="creditCardDetails" style="display: none;">
                            <div class="form-group mx-sm-3 mb-2">
                                <label for="card_number">Credit Card Number:</label>
                                <input type="text" id="card_number" name="card_number"  placeholder="Enter credit card number">
                            </div>
                            <div class="form-group mx-sm-3 mb-2">
                                <label for="cardholder_name">Cardholder Name:</label>
                                <input type="text" id="cardholder_name" name="cardholder_name" placeholder="Enter CVcardholder name">
                            </div>
                            <div class="form-group mx-sm-3 mb-2">
                                <label for="expiration_date">Expiration Date:</label>
                                <input type="date" id="expiration_date" name="expiration_date"  >
                            </div>
                            <div class="form-group mx-sm-3 mb-2">
                                <label for="cvv">CVV:</label>
                                <input type="text" id="cvv" name="cvv" placeholder="Enter CVV" maxlength="3">
                            </div>
                        </div>
                        

                   
                        <div class="form-group mx-sm-3 mb-2">
                            <input type="submit" name="submit" value="Reserve" class="btn btn-primary" onsubmit="return validateReservationForm();" />
                        </div>
                    </form>
            </div>

    </div>


</div>


<script src="reservation.js"></script>
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
