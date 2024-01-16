<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reporting Interface - Customer Reservations</title>

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
            margin: 180px 0;
            height: calc(100vh - 80px); /* Adjust the height considering the added margins */
        }

        form {
            margin-top: 20px; /* Adjust top margin for the form */
        }


        table {
            margin-top: 20px; /* Adjust top margin for the table */
            border-collapse: collapse;
            width: 100%;
        }
        th {
            background-color: #f2f2f2; /* Light gray background for table headers */
            color: black; /* Set the text color of table headers to black */
        }

        td {
            /* Set the text color of table content cells to black */
            color: #f2f2f2;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        input[type="text"] {
            color: white; 
        }

        input[type="submit"] {
            margin-top: 30px;
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

    <h1>Reservations of a Specific Customer</h1>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

        
        <div id="customer_selection">
            <label for="customer_ssn">Customer SSN:</label>
            <input type="text" name="customer_ssn" id="customer_ssn" required>
        </div>
        
        <input type="submit" name="generate_report" value="Generate Report" style="font-family: Arial, sans-serif;">
    </form>
    

    <?php
    // Establish database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "car_rental_system";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["generate_report"])) {
        $selected_customer_ssn = $_POST["customer_ssn"];
        
        // SQL query to fetch all reservations of a specific customer including customer information, car model, and plate id
        $sql = "SELECT r.reservation_number, r.reservation_time, r.pickup_time, r.return_time,
                        c.model AS car_model, c.plate_id AS car_plate_id,
                        u.ssn, u.fname, u.lname, u.phone, u.email
                FROM reservation r
                JOIN car c ON r.plate_id = c.plate_id
                JOIN user u ON r.ssn = u.ssn
                WHERE u.ssn = '$selected_customer_ssn'";
        
        // Execute the query and display results
        $result = $conn->query($sql);
        
        if ($result && $result->num_rows > 0) {
            echo "<h2>Search Results:</h2>";
            echo "<table border='1'><tr>";
            echo "<th>Reservation Number</th><th>Reservation Time</th><th>Pickup Time</th><th>Return Time</th>";
            echo "<th>Car Model</th><th>Car Plate ID</th><th>Customer Information</th></tr>";


            // Display the retrieved results in a table format
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
    
                // Display reservation details
                echo "<td>" . $row['reservation_number'] . "</td>";
                echo "<td>" . $row['reservation_time'] . "</td>";
                echo "<td>" . $row['pickup_time'] . "</td>";
                echo "<td>" . $row['return_time'] . "</td>";
                
                // Display car details
                echo "<td>" . $row['car_model'] . "</td>";
                echo "<td>" . $row['car_plate_id'] . "</td>";
                
                // Display customer information
                echo "<td>";
                echo "SSN: " . $row['ssn'] . "<br>";
                echo "First Name: " . $row['fname'] . "<br>";
                echo "Last Name: " . $row['lname'] . "<br>";
                echo "Phone: " . $row['phone'] . "<br>";
                echo "Email: " . $row['email'] . "<br>";
                echo "</td>";
    
                echo "</tr>";
            }
    
            echo "</table>";
        } else {
          echo"<script>alert(\"No results found.\")</script>";
          echo "<script>window.location.href=\"customer_reservations.php\"</script>";
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