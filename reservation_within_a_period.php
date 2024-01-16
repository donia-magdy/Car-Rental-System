<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reporting Interface</title>
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
            margin: 80px 0; /* Adjust the top and bottom margins */

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

    <h1>Reservations within a Period</h1>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" onsubmit="return validateReservationForm();">
        <label for="pickup_time">Start Date:</label>
        <input type="date" name="pickup_time" required>
        <label for="return_time">End Date:</label>
        <input type="date" name="return_time" required>
        <br> 
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
        $pickup_time = $_POST["pickup_time"];
        $return_time = $_POST["return_time"];

        // SQL query to retrieve all reservations within the specified period with car and customer information

        $sql = "SELECT r.*, c.*, u.* 
        FROM reservation r
        JOIN car c ON r.plate_id = c.plate_id
        JOIN user u ON r.ssn = u.ssn
        WHERE  (pickup_time <= '$pickup_time' AND return_time >= '$pickup_time')
            OR (pickup_time <= '$return_time' AND return_time >= '$return_time')
            OR (pickup_time >= '$pickup_time' AND pickup_time <= '$return_time')
            OR (return_time >= '$pickup_time' AND return_time <= '$return_time')
";

        // Execute the query and display results
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            echo "<h2>Search Results:</h2>";
            echo "<table border='1'><tr>";
            echo "<th>Reservation Number</th><th>Car Information</th><th>Customer Information</th></tr>";

            // Display the retrieved results in a table format
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";

                echo "<td>";
                echo "Reservation Number: " . $row['reservation_number'] . "<br>";
                echo "Reservation Time: " . $row['reservation_time'] . "<br>";
                

              


                $pickupOfficeId = $row['pickup_office_id'];
                $pickupOfficeQuery = "SELECT * FROM office WHERE office_id = $pickupOfficeId";
                $pickupOfficeResult = $conn->query($pickupOfficeQuery);
                if ($pickupOfficeResult && $pickupOfficeResult->num_rows > 0) {
                  
                    $pickupOfficeData = $pickupOfficeResult->fetch_assoc();
                    echo "Pickup Office Id: " . $pickupOfficeData['office_id'] . "<br>";
                    echo "Pickup Country: " . $pickupOfficeData['country'] . "<br>";
                    echo "Pickup City: " . $pickupOfficeData['city'] . "<br>";
                    echo "Pickup Location: " . $pickupOfficeData['location'] . "<br>";
                    
                }
                
        
                // Display office information for return office
               
                $returnOfficeId = $row['return_office_id'];
                $returnOfficeQuery = "SELECT * FROM office WHERE office_id = $returnOfficeId";
                $returnOfficeResult = $conn->query($returnOfficeQuery);
                if ($returnOfficeResult && $returnOfficeResult->num_rows > 0) {
                    $returnOfficeData = $returnOfficeResult->fetch_assoc();
                    echo "Return Office Id: " . $returnOfficeData['office_id'] . "<br>";
                    echo "Return Country: " . $returnOfficeData['country'] . "<br>";
                    echo "Return City: " . $returnOfficeData['city'] . "<br>";
                    echo "Return Location: " . $returnOfficeData['location'] . "<br>";
                    
                }
                




                echo "Pickup Time: " . $row['pickup_time'] . "<br>";
                echo "Return Time: " . $row['return_time'] . "<br>";
                echo "Payment Date: " . $row['payment_date'] . "<br>";
                echo "Payment Method: " . $row['payment_method'] . "<br>";
                echo "</td>";
                // echo "<td>" . $row['reservation_number'] . "</td>";

            
                // Display car information in separate cells
                echo "<td>";
                echo "Plate ID: " . $row['plate_id'] . "<br>";
                echo "Model: " . $row['model'] . "<br>";
                echo "Year: " . $row['year'] . "<br>";
                echo "Price per day: " . $row['price_per_day'] . "<br>";
                echo "Status: " . $row['status'] . "<br>";
                echo "Colour: " . $row['colour'] . "<br>";
                echo "Power: " . $row['power'] . "<br>";
                echo "Automatic: " . $row['automatic'] . "<br>";
                echo "Tank Capacity: " . $row['tank_capacity'] . "<br>";
                


                $carOfficeId = $row['office_id'];
                $carOfficeQuery = "SELECT * FROM office WHERE office_id = $carOfficeId";
                $carOfficeResult = $conn->query($carOfficeQuery);
                if ($carOfficeResult && $carOfficeResult->num_rows > 0) {
                    $carOfficeData = $carOfficeResult->fetch_assoc();
                    echo "Office Id: " . $carOfficeData['office_id'] . "<br>";
                    echo "Country: " . $carOfficeData['country'] . "<br>";
                    echo "City: " . $carOfficeData['city'] . "<br>";
                    echo "Location: " . $carOfficeData['location'] . "<br>";
                    
                }


                echo "<div style='text-align: center;'><img src='images/" . $row['img'] . "' alt='Car Image' style='width: 300px; height: auto;'></div>";
                echo "</div>";
                echo "</td>";
            
                // Display customer information in separate cells
                echo "<td>";
                echo "SSN: " . $row['ssn'] . "<br>";
                echo "First Name: " . $row['fname'] . "<br>";
                echo "Last Name: " . $row['lname'] . "<br>";
                echo "Phone: " . $row['phone'] . "<br>";
                echo "Email: " . $row['email'] . "<br>";
                echo "Password: " . $row['pass'] . "<br>";
                echo "Gender: " . $row['sex'] . "<br>";
                echo "DOB: " . $row['DOB'] . "<br>";
                echo "</td>";
            
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo"<script>alert(\"No results found.\")</script>";
        }



    }
    ?>
  <script>
function validateReservationForm(){
    let form = document.forms[0]; // or document.getElementById('yourFormId');
    let pickup_time = new Date(form["pickup_time"].value);
    let return_time = new Date(form["return_time"].value);
    pickup_time.setHours(0, 0, 0, 0);
    return_time.setHours(0, 0, 0, 0);
    
    if(pickup_time > return_time){
        alert("Start Time must be before the End Time");
        return false;
    }
} 
</script>

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
