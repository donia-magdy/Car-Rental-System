<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle actions based on the form submitted
    if (isset($_POST['action'])) {
        $mysqli = new mysqli("localhost", "root", "", "car_rental_system");

        // Check connection
        if ($mysqli->connect_error) {
            die("Connection failed: " . $mysqli->connect_error);
        }

        // Check if the provided SSN belongs to an existing customer
        $reservation_number = $_POST["reservation_number"];

        // Check if the customer exists
        $check_reservation_number_query = "SELECT * FROM reservation WHERE reservation_number = ?";
        $stmt = $mysqli->prepare($check_reservation_number_query);
        $stmt->bind_param("s", $reservation_number );
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Customer exists, proceed with deletion
            $delete_query = "DELETE FROM reservation WHERE reservation_number = ?";
            $stmt = $mysqli->prepare($delete_query);
            $stmt->bind_param("s", $reservation_number );

            if ($stmt->execute()) {
                echo '<script>alert("Reservation deleted successfully.");</script>';
                echo"<script>window.location.href=\"reservation_management.php\"</script>";
            } else {
                echo "Error deleting Reservation: " . $stmt->error;
            }
        } else {
            echo '<script>alert("Reservation not found.");</script>';
            echo"<script>window.location.href=\"reservation_management.php\"</script>";
        }

        // Close the database connection
        $stmt->close();
        $mysqli->close();
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reservation Management</title>
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
            margin: 180px 0; /* Adjust the top and bottom margins */
            height: calc(100vh - 80px); /* Adjust the height considering the added margins */
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 80%;
            max-width: 400px; /* Adjust max-width as needed */
        }

        input[type="text"],
        input[type="button"] {
            width: 100%;
            margin-bottom: 10px;
            padding: 8px;
        }

        #confirmation-modal {
            display: none;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        #confirmation-modal button {
            margin: 5px;
            padding: 8px 16px;
        }
        .delete-car-btn {
        font-family: Arial, sans-serif;

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
      <form id="deleteForm" method="post">
        <h2>Delete Reservation</h2>
        <label for="ssn">Reservation Number:</label>
        <input type="text" name="reservation_number" required><br>
        <input type="submit" value="Delete Reservation" class="delete-car-btn" name="action" onclick="return confirm('Are you sure you want to delete this Reservation?');">
    </form>

   
    
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