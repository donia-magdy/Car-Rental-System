<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Car</title>
    <!-- Your CSS and other meta tags -->
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
            margin: 60px 0;
        }

        form {
            margin-top: 20px; /* Adjust top margin for the form */
        }

        /* Style for the Return Back button */
       


        input[type="number"] {
            color: initial; 
        }
        input[type="submit"] {
            margin-top: 30px;

        }
        input[type="file"] {
            width: 80%; /* Adjust width as needed */
            /* Other styles */
        }

        .inline-label {
        display: inline-flex;
        align-items: center;
        margin-top: 30px; 
        margin-bottom: 30px; 

        margin-right: 15px; 
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
    <h1>Add Car</h1>
    
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Establish database connection
        $mysqli = new mysqli("localhost", "root", "", "car_rental_system");

        // Check connection
        if ($mysqli->connect_error) {
            die("Connection failed: " . $mysqli->connect_error);
        }

        // Validate and sanitize input
        $plate_id = $_POST["plate_id"];
        $model = $_POST["model"];
        $year = $_POST["year"];
        $price_per_day = $_POST["price_per_day"];
        $colour = $_POST["colour"];
        $power = $_POST["power"];
        $automatic = $_POST["automatic"];
        $tank_capacity = $_POST["tank_capacity"];
        $office_id = $_POST["office_id"];
        $status = $_POST["status"];

        // Check for duplicate plate_id
        $check_duplicate = $mysqli->query("SELECT * FROM car WHERE plate_id = '$plate_id'");
        if ($check_duplicate->num_rows > 0) {
            echo"<script>alert(\"Plate ID already exists.\")</script>";
            echo"<script>window.location.href=\"add_car.php\"</script>";
                    
        }

        // Other validations for data types, required fields, etc.

       // Handle image upload
       $target_dir = "C:/xampp/htdocs/final_database_final/images/";
       $basename = basename($_FILES["img"]["name"]);
       $target_file = $target_dir . $basename;
       $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
       // Check if image file is a actual image or fake image
        if (isset($_POST["submit"])) {
            $check = getimagesize($_FILES["img"]["tmp_name"]);
            if ($check === false) {
              echo"<script>alert(\"File is not an image.\")</script>";
            echo"<script>window.location.href=\"add_car.php\"</script>";
               
            }
        }

        // Check file size and file type
        if ($_FILES["img"]["size"] > 500000) {
            
            echo"<script>alert(\"Image file is too large.\")</script>";
            echo"<script>window.location.href=\"add_car.php\"</script>";
        }
        if ($imageFileType !== "jpg" && $imageFileType !== "png" && $imageFileType !== "jpeg") {
          echo"<script>alert(\"Only JPG, JPEG, and PNG files are allowed.\")</script>";
            echo"<script>window.location.href=\"add_car.php\"</script>";
            
        }

        // Move uploaded file to destination directory
        if (move_uploaded_file($_FILES["img"]["tmp_name"], $target_file)) {
            // Insert data into the database
            $insert_query = "INSERT INTO car (plate_id, model, year, price_per_day, status , colour, power, automatic, tank_capacity, office_id, img) 
                 VALUES ('$plate_id', '$model', $year, $price_per_day,'$status' , '$colour', $power, '$automatic', $tank_capacity, $office_id, '$basename')";

if ($mysqli->query($insert_query) === true) {
    echo"<script>alert(\"Car added successfully.\")</script>";
    echo"<script>window.location.href=\"add_car.php\"</script>";
}else {
                echo "Error: " . $mysqli->error;
            }
        } else {
          
            echo"<script>alert(\"Error uploading image.\")</script>";
            echo"<script>window.location.href=\"add_car.php\"</script>";
        }

        // Close database connection
        $mysqli->close();
    }
    ?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <label for="plate_id">Plate ID:</label>
        <input type="text" name="plate_id" required><br>

        <label for="model">Model:</label>
        <input type="text" name="model" required><br>


        <label for="year">Year:</label>
        <select name="year" required>
        <?php
        // Get the current year
        $currentYear = date("Y");

    // Loop to generate options from the current year to 1990 (reversed)
    for ($year = $currentYear; $year >= 1990; $year--) {
        echo "<option value='$year'>$year</option>";
    }
        ?>
        </select><br>



        <label for="price_per_day">Price per Day:</label>
        <input type="number" name="price_per_day" required><br>

        <label for="colour">Colour:</label>
        <input type="text" name="colour" required><br>

        <label for="power">Power:</label>
        <input type="number" name="power" required><br>

        <label class="inline-label">Automatic:</label>
        <input type="radio" id="true" name="automatic" value="T" required>
        <label for="true" class="inline-label">True</label>
        <input type="radio" id="false" name="automatic" value="F" required>
        <label for="false" class="inline-label">False</label><br>


        <label for="tank_capacity">Tank Capacity:</label>
        <input type="number" name="tank_capacity" step="0.01" required><br>

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
<select name="status" required>
<option value="active">Active</option>
<option value="out_of_service">Out of Service</option>
</select><br>

        <label for="img">Car Image:</label>
        <input type="file" name="img" accept="image/*" required><br>

        <input type="submit" name="submit" value="Add Car" style="font-family: Arial, sans-serif;">
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