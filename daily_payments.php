<?php
session_start();
?>
<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "car_rental_system";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $start_date = mysqli_real_escape_string($conn, $_POST['start_date']);
    $end_date = mysqli_real_escape_string($conn, $_POST['end_date']);

    $query = "SELECT DATE(reservation.payment_date) as reservation_date, 
            SUM(DATEDIFF(reservation.return_time, reservation.pickup_time) * car.price_per_day) as total_payment
        FROM reservation
        LEFT JOIN car ON reservation.plate_id = car.plate_id
        WHERE reservation.payment_date >= '$start_date' AND reservation.payment_date <= '$end_date'
            AND reservation.payment_date IS NOT NULL
        GROUP BY reservation_date
        ORDER BY reservation_date;
    ";

    $result = $conn->query($query);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Total Payments Report</title>
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
        body {
            font-family: Arial, sans-serif;
        }

        .container-fluid {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-row {
            display: flex;
            justify-content: center;
        }

        .form-group {
            margin-right: 10px;
        }

        .btn-primary {
            width: 100%;
            text-align: center;
        }

        table {
            margin-top: 20px;
        }

        


    </style>

   
</head>
<body>

<div id="wrapper">
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

      
      


      <div class="container">

    <div class="offset-md-3 col-md-6">
      <h2 class="mt-4 mb-3 text-center">Total Payments Report</h2>

      <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="mb-4" onsubmit="return validateReservationForm();">
        <div class="form-row">
          <div class="form-group col-md-4">
            <label for="start_date">Start Date:</label>
            <input type="date" class="form-control" id="start_date" name="start_date" required>
          </div>
          <div class="form-group col-md-4">
            <label for="end_date">End Date:</label>
            <input type="date" class="form-control" id="end_date" name="end_date" required>
          </div>
          <div class="form-group col-md-4 text-center">
            <input type="submit" class="btn btn-primary mt-4" value="Generate">
          </div>
        </div>
      </form>
     
      <?php
      if ($_SERVER["REQUEST_METHOD"] == "POST" && $result->num_rows > 0) {
        echo "<table class='table table-bordered'>
                <thead class='thead-dark'>
                  <tr>
                    <th>Date</th>
                    <th>Total Payment</th>
                  </tr>
                </thead>
                <tbody>";

        while ($row = $result->fetch_assoc()) {
          echo "<tr>
                  <td>{$row['reservation_date']}</td>
                  <td>{$row['total_payment']}</td>
                </tr>";
        }

        echo "</tbody></table>";
      } elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
        echo"<script>alert(\"No results found.\")</script>";
      }
      ?>
    </div>
</div>

<script>
function validateReservationForm(){
    let form = document.forms[0]; // or document.getElementById('yourFormId');
    let pickup_time = new Date(form["start_date"].value);
    let return_time = new Date(form["end_date"].value);
    pickup_time.setHours(0, 0, 0, 0);
    return_time.setHours(0, 0, 0, 0);
    
    if(pickup_time > return_time){
        alert("Start Time must be before the End Time");
        return false;
    }
} 
</script>
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

<?php
$conn->close();
?>
