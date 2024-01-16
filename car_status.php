<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reporting Interface - Car Status on Specific Day</title>
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
            text-align: center;
            margin: 70px 0;
        }

        form {
            margin-top: 20px; /* Adjust top margin for the form */
        }

    

        /* Style for the table */
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

        input[type="date"] {
            color: initial; 
        }
        input[type="submit"] {
            margin-top: 30px;

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
    <h1>Car Status on Specific Day</h1>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div id="date_range">
            <label for="specific_day">Specific Day:</label>
            <input type="date" name="specific_day" required>
        </div>
        
        <input type="submit" name="check_status" value="Check Status" style="font-family: Arial, sans-serif;">
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

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["check_status"])) {
        $specific_day = $_POST["specific_day"];
        
        // SQL query to retrieve car status on the specific day
        $sql = "SELECT DISTINCT car.plate_id, car.model, car.img, 
        CASE 
            WHEN car.status = 'out_of_service' THEN 'Out of Service' 
            WHEN car.plate_id IN (
                SELECT reservation.plate_id 
                FROM reservation 
                WHERE 
                    '$specific_day' >= reservation.pickup_time 
                    AND '$specific_day' <= reservation.return_time 
                    AND payment_date IS NOT NULL
            ) THEN 'Rented'
            WHEN car.plate_id IN (
                SELECT reservation.plate_id 
                FROM reservation 
                WHERE 
                    '$specific_day' >= reservation.pickup_time 
                    AND '$specific_day' <= reservation.return_time 
                    AND payment_date IS NULL
            ) THEN 'Reserved (Not Rented)' 
            ELSE 'Active' 
        END AS status 
        FROM car 
        LEFT JOIN reservation ON car.plate_id = reservation.plate_id";

        
        // Execute the query and display results
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            echo "<h2>Car Status on $specific_day:</h2>";
            echo "<table border='1'><tr>";
            echo "<th>Plate ID</th><th>Model</th><th>Image</th><th>Status</th></tr>";

            // Display the retrieved results in a table format
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['plate_id'] . "</td>";
                echo "<td>" . $row['model'] . "</td>";
                echo "<td><img src='images/" . $row['img'] . "' alt='Car Image' style='width: 200px; height: auto;'></td>";

                echo "<td>" . $row['status'] . "</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
          echo"<script>alert(\"No results found.\")</script>";
        }
    }
    ?>


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
