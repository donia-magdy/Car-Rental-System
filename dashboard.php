<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
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
            margin: 300px 0; /* Adjust the top and bottom margins */
            height: calc(100vh - 80px); /* Adjust the height considering the added margins */
        }



        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        /* Style for each button */
        .container > * {
            margin-top: 20px;
        }



    </style>
</head>
<body>
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
   


<h1>Dashboard</h1>
<div class="container">
    
    
    <div>
        <label for="carManagement">Car Management Interface</label>
        <select id="carManagement" onchange="location = this.value;">
            <option value="" disabled selected>Select an option</option>
            <option value="add_car.php">Add Car</option>
            <option value="update_car.php">Update Car</option>
            <option value="delete_car.php">Delete Car</option>
        </select>
    </div> 

    <div>
        <label for="customerManagement">Customer Management Interface</label>
        <select id="customerManagement" onchange="location = this.value;">
            <option value="" disabled selected>Select an option</option>
            <option value="update_customer.php">Update Customer</option>
            <option value="delete_customer.php">Delete Customer</option>
        </select>
    </div> 

    <div class="container"> 

    <!-- Reservation Management Interface Button -->
    <button onclick="location.href='reservation_management.php'">Reservation Management Interface</button>

    <div>
        <label for="advanced_search">Advanced Search </label>
        <select id="advanced_search" onchange="location = this.value;">
            <option value="" disabled selected>Select an option</option>
            <option value="carInfo.php">Car informations</option>
            <option value="customerInfo.php">Customer informations</option>
            <option value="reservationInfo.php">Reservations</option>
        </select>
    </div> 
    <!-- cash_payment Button -->
    <button onclick="location.href='cash_payment.php'">Cash Payment Interface</button>
    
    </div>
    
    <div>
        <label for="reportGeneration">Report Generation Interface</label>
        <select id="reportGeneration" onchange="location = this.value;">
            <option value="" disabled selected>Select an option</option>
            <option value="reservation_within_a_period.php">Reservation Within A Period</option>
            <option value="car_reservations.php">Car Reservations</option>
            <option value="car_status.php">Car Status</option>
            <option value="customer_reservations.php">Customer Reservations</option>
            <option value="daily_payments.php">Daily Payments</option>
        </select>
    </div> 

</div>
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
