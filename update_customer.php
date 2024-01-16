<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Customer</title>
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

        form {
            margin-top: 20px; /* Adjust top margin for the form */
        }

    



        input[type="number"] {
            color: initial; 
        }
        input[type="submit"] {
            display: block;
            margin: 10px auto;
            text-align: center;
            margin-top: 30px;

        }
        input[type="file"] {
            width: 80%; /* Adjust width as needed */
            /* Other styles */
        }

        label {
            display: block;
            text-align: center;
            margin-bottom: 5px; /* Adjust spacing between labels and inputs */
        }

        #date{
        color: #232943; 
        text-align: center;
    }
    #date {
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    width: 15%;
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

          <li><a href="contact.html">Contact Us</a></li>
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

      <h1>Update Customer Information</h1>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Establish database connection
    $mysqli = new mysqli("localhost", "root", "", "car_rental_system");

    // Check connection
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Validate and sanitize input
    $customerSSN = $_POST["ssn"];

    $checkExistingSSN = $mysqli->query("SELECT * FROM user WHERE ssn = '$customerSSN'");

    if ($checkExistingSSN->num_rows === 0) {
        echo "<script>alert(\"The provided SSN does not belong to an existing customer.\")</script>";
    } else {
        // Check if phone or email already exists
        $phone = $_POST["phone"];
        $email = $_POST["email"];

        $checkExistingPhone = $mysqli->query("SELECT * FROM user WHERE phone = '$phone' AND ssn != '$customerSSN'");
        $checkExistingEmail = $mysqli->query("SELECT * FROM user WHERE email = '$email' AND ssn != '$customerSSN'");

        if ($checkExistingPhone->num_rows > 0) {
            echo "<script>alert(\"Phone number already exists for another customer.\")</script>";
            echo "<script>window.location.href=\"update_customer.php\"</script>";

        }

        if ($checkExistingEmail->num_rows > 0) {
            echo "<script>alert(\"Email already exists for another customer.\")</script>";
            echo "<script>window.location.href=\"update_customer.php\"</script>";

        }
        if ($checkExistingEmail->num_rows > 0 && !filter_var($email, FILTER_VALIDATE_EMAIL)) {

            echo"<script>alert(\"Invalid email format.\")</script>";
            echo "<script>window.location.href=\"update_customer.php\"</script>";

        }
        // Continue with the update if phone and email are unique
        if ($checkExistingPhone->num_rows === 0 && $checkExistingEmail->num_rows === 0) {
            // Create an array to store the fields to be updated
            $updateFields = array();

            // Iterate through all input fields and add non-empty values to the array
            foreach ($_POST as $key => $value) {
                if (!empty($value) && $key != "ssn") {
                    // Encrypt password using MD5
                    if ($key === "pass") {
                        $value = md5($value);
                    }
                    $updateFields[$key] = $value;
                }
            }

            // Check if there are fields to update
            if (count($updateFields) > 0) {
                // Build the SQL query dynamically
                $update_query = "UPDATE user SET ";
                foreach ($updateFields as $key => $value) {
                    $update_query .= "$key = '$value', ";
                }
                $update_query = rtrim($update_query, ", "); // Remove the trailing comma
                $update_query .= " WHERE ssn = '$customerSSN'";

                // Execute the update query
                if ($mysqli->query($update_query)) {
                    echo "<script>alert(\"Customer updated successfully.\")</script>";
                    echo "<script>window.location.href=\"update_customer.php\"</script>";
                } else {
                    echo "Error updating customer information: " . $mysqli->error;
                }
            } else {
                echo "<script>alert(\"No fields to update.\")</script>";
            }
        }
    }

    // Close the database connection
    $mysqli->close();
}
?>


<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <label for="ssn">Customer SSN:</label>
    <input type="text" name="ssn" required><br>

    <label for="fname">First Name:</label>
    <input type="text" name="fname"><br>

    <label for="lname">Last Name:</label>
    <input type="text" name="lname"><br>

    <label for="phone">Phone:</label>
    <input type="text" name="phone"><br>

    <label for="email">Email:</label>
    <input type="text" name="email"><br>

    <label for="pass">Password:</label>
    <input type="password" name="pass"><br>

    <label for="sex">Sex:</label>
    <select name="sex">
        <option value="M">Male</option>
        <option value="F">Female</option>
    </select><br>

    <div id="dob">
      <label for="DOB">Date of Birth:</label>
      <input type="date" id="date" name="DOB"><br>
    </div>
   
    <input type="submit" value="Apply Update" style="font-family: Arial, sans-serif;">
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
