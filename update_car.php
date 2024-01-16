<?php
session_start();
$mysqli = new mysqli("localhost", "root", "", "car_rental_system");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $plate_id = $_POST["plate_id"];
 // Check for duplicate plate_id
 $check_duplicate = $mysqli->query("SELECT * FROM car WHERE plate_id = '$plate_id'");
 if ($check_duplicate->num_rows === 0) {
     echo"<script>alert(\"Plate ID not exists.\")</script>";
     echo"<script>window.location.href=\"update_car.php\"</script>";
             
 }
    $updateFields = array();

    // Check and collect values for update
    if (!empty($_POST["price_per_day"])) {
        $updateFields[] = "price_per_day = '" . $_POST["price_per_day"] . "'";
    }

    $stmt_office = null;

    if (!empty($_POST["office_id"])) {
        // Validate if the office ID exists
        $check_office_query = "SELECT * FROM office WHERE office_id = ?";
        $stmt_office = $mysqli->prepare($check_office_query);
        if ($stmt_office) {
            $stmt_office->bind_param("i", $_POST["office_id"]);
            $stmt_office->execute();
            $result_office = $stmt_office->get_result();
            if ($result_office->num_rows === 0) {
                echo "<script>alert('Error: Office ID not found.');</script>";
                echo "<script>window.location.href='update_car.php';</script>";
                exit();
            }
            $updateFields[] = "office_id = '" . $_POST["office_id"] . "'";

            // Close the statement and result set
            $stmt_office->close();
            $result_office->close();
        } else {
            echo "<script>alert('Error preparing office check query: " . $mysqli->error . "');</script>";
            exit();
        }
    }

    if (!empty($_POST["status"])) {
        $updateFields[] = "status = '" . $_POST["status"] . "'";
    }

    // Construct the update query
    if (!empty($updateFields)) {
        $updateQuery = "UPDATE car SET " . implode(", ", $updateFields) . " WHERE plate_id = ?";
        $stmt_update = $mysqli->prepare($updateQuery);

        if ($stmt_update) {
            $stmt_update->bind_param("s", $plate_id);

            if ($stmt_update->execute()) {
                echo "<script>alert('Update successful.');</script>";
                echo "<script>window.location.href='update_car.php';</script>";
            } else {
                echo "<script>alert('Error updating record: " . $stmt_update->error . "');</script>";
            }

            $stmt_update->close();
        } else {
            echo "<script>alert('Error preparing update query: " . $mysqli->error . "');</script>";
            exit();
        }
    }

    // Close $stmt_office if it's not null
    if ($stmt_office) {
        $stmt_office->close();
    }

    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Car</title>
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

        .update-buttons {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Style for the buttons */
        .update-buttons button {
            margin: 10px;
        }

        .button-container {
        display: flex;
        justify-content: center;
        margin-top: 20px; /* Adjust margin top as needed */
        }
        label {
            display: block;
            text-align: center;
            margin-bottom: 5px; /* Adjust spacing between labels and inputs */
        }
 
    </style>
   
    <script>


        function clearForm() {
            document.getElementById("updateForm").reset();
        }

    </script>
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

    <h1>Update Car</h1>
    
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="plate_id">Plate ID:</label>
    <input type="text" id="plate_id"  name="plate_id" required><br>

    <!-- Other input fields for car attributes -->
    <label for="price_per_day">Price per Day:</label>
    <input type="text" id="price_per_day" name="price_per_day"><br>

    <label for="office_id">Office:</label>
        <select name="office_id" required>
            <?php
            // Establish database connection
            $mysqli = new mysqli("localhost", "root", "", "car_rental_system");

            // Check connection
            if ($mysqli->connect_error) {
                die("Connection failed: " . $mysqli->connect_error);
            }

            // Fetch office information
            $office_query = "SELECT office_id, country, city, location FROM office";
            $office_result = $mysqli->query($office_query);

            // Display options in the dropdown menu
            while ($row = $office_result->fetch_assoc()) {
                echo "<option value='{$row['office_id']}'>{$row['country']}, {$row['city']}, {$row['location']}</option>";
            }

            // Close database connection
            $mysqli->close();
            ?>
        </select><br>
    <label for="status">Status:</label>
    <select id="status" name="status">
        <option value="" disabled selected>Select an option</option>
        <option value="out_of_service">Out of Service</option>
        <option value="active">Active</option>
    </select><br>

    <!-- Submit button -->
    <div class="button-container">
        <input type="submit" name="submit" value="Update" style="font-family: Arial, sans-serif;">
    </div>
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
     