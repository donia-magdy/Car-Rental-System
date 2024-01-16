<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cash Payment</title>
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
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin: 100px 0; /* Adjust the top and bottom margins */
            height: calc(100vh - 80px); /* Adjust the height considering the added margins */
        }

        form {
            margin-top: 20px; /* Adjust top margin for the form */
        }

      



        input[type="submit"] {
            margin-top: 30px;
            display: block;
            margin: 25px auto;
            text-align: center;

        }

        #markPaidForm button,
        #returnBack {
            display: block;
            margin: 25px auto;
            text-align: center;
        }


    </style>
</head>
<body>
    <!-- Header -->
    <header id="header" class="alt">
        <a href="indexAdmin.php" class="logo"
          ><strong>Car Rental</strong> <span>Website</span></a
        >
        <nav>
          <a href="#menu">Menu</a>
        </nav>
      </header>

      <!-- Menu -->
      <nav id="menu">
        <ul class="links">
          <li class="active"><a href="indexAdmin.php">Home </a></li>

          <?php
        if (!isset($_SESSION['ssn'])|| empty($_SESSION['ssn'])) { ?>
            <li class="nav-item"><a href="logorsign.html" class="nav-link">Login Or Register</a></li>
        <?php } else { ?>
            <li class="nav-item"><a href="destroy.php" class="nav-link">Sign Out</a></li>
        <?php } ?>
          <li><a href="dashboard.php">Dashboard</a></li>

          <li><a href="about-us.php">About Us</a></li>

          <li><a href="contact.php">Contact Us</a></li>
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

    <h1>Cash Payment</h1>

    <!-- Form for marking payment as paid -->
    <form id="markPaidForm" method="post" >
    <label for="reservation_number">Reservation Number:</label>
        <input type="text" name="reservation_number" required>
        <input type="submit" value="Paid" style="font-family: Arial, sans-serif;">

        <!-- Return Back Button -->
       </form>



       <?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['reservation_number'])) {
       
               
     

    $mysqli = new mysqli("localhost", "root", "", "car_rental_system");

    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    $reservationNumber = $_POST["reservation_number"];

    // Validate if the reservation exists
    $check_reservation_query = "SELECT * FROM reservation WHERE reservation_number = ?";
    $stmt = $mysqli->prepare($check_reservation_query);
    $stmt->bind_param("i", $reservationNumber);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $reservationData = $result->fetch_assoc();
        $paymentMethod = $reservationData['payment_method'];
        $paymentDate= $reservationData['payment_date'];

        // Check if the payment method is 'cash'
        if ($paymentMethod === 'cash' && $paymentDate == NULL) {
            // Proceed with marking as paid
            $mark_paid_query = "UPDATE reservation SET payment_date = CURRENT_DATE WHERE reservation_number = ?";
            $stmt = $mysqli->prepare($mark_paid_query);
            $stmt->bind_param("i", $reservationNumber);

            if ($stmt->execute()) {
                echo"<script>alert(\"Payment marked as paid successfully.\")</script>";
    echo"<script>window.location.href=\"cash_payment.php\"</script>";
            } else {
                echo "Error marking payment as paid: " . $stmt->error;
            }
        } else {
            echo "Payment method is already paid.";
            echo"<script>alert(\"Payment method is already paid.\")</script>";
            echo"<script>window.location.href=\"cash_payment.php\"</script>";
        }
    } else {
       
        echo"<script>alert(\" Reservation not found.\")</script>";
        echo"<script>window.location.href=\"cash_payment.php\"</script>";
        
    }
    
    $stmt->close();
    $mysqli->close();
    exit;
        
  }
}

?>
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