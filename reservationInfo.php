<!DOCTYPE html>
<html lang="en"> 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
        <style>
            ::placeholder {
            color: #999 !important;
            opacity: 1; 
            }
            .tiles article:before {
                opacity: 0.4;
            }
            header.major > :first-child:after {
                content: "";
                background-color: transparent;
            }
            table {
    margin: 0 0 2em 0;
    width: 100%;
    border-collapse: collapse;
    border-spacing: 0;
}
table thead {
    border-bottom: solid 2px #c9c9c9;
}
table tbody tr {
    border: solid 1px #c9c9c9;
    border-left: 0;
    border-right: 0;
}
table tbody tr:nth-child(2n + 1) {
    background-color: rgba(144, 144, 144, 0.075);
}
table td {
    padding: 0.75em 0.75em;
}
table th {
    font-size: 0.9em;
    font-weight: 900;
    padding: 0 0.75em 0.75em 0.75em;
    text-align: left;
}
</style>
</head>
<body class="is-preload">
    <!-- Wrapper -->
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
          session_start();
        if (!isset($_SESSION['ssn'])) { ?>
            <li class="nav-item"><a href="logorsign.html" class="nav-link">Login Or Register</a></li>
        <?php } else { ?>
            <li class="nav-item"><a href="destroy.php" class="nav-link">Sign Out</a></li>
        <?php } ?>


        <li><a href="dashboard.php">Dashboard</a></li>

<li><a href="about-us.php">About Us</a></li>

<li><a href="contact.php">Contact Us</a></li>
        </ul>
      </nav>

    
      <div >
        <h2 class="h2">Reservations</h2>
        <?php
            $mysqli=new mysqli("localhost","root","","car_rental_system");
            $result =$mysqli->query("SELECT * FROM car");
            $colors = Array();
            $models = Array();
            while($row = mysqli_fetch_assoc($result)){
                $models[] = strtolower($row['model']);
                $colors[] = strtolower($row['colour']);
            }
            $result = $mysqli->query("SELECT DISTINCT country FROM office");
            $locations = Array();
            while($row = mysqli_fetch_assoc($result)){
                $locations[] = $row['country'];
            }
        ?>

        <section>
            <form class="form-inline" method="post" id="search" name="search" action="" >
                
                <div class="form-group mx-sm-3 mb-2">
                    <input type="number"  min="1" name="phone" class="form-control" id="phone" placeholder="phone No.">
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <input type="text"  name="fname" class="form-control" id="fname" placeholder="First Name">
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <input type="text"  name="lname" class="form-control" id="lname" placeholder="Last Name">
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <input type="text"  name="email" class="form-control" id="email" placeholder="E-mail">
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <label for="min_DOB">Min. Birth Date:</label>
                    <input type="date"  name="min_DOB" class="form-control" id="min_DOB" placeholder="Min. Birth Date">
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <label for="max_DOB">Max. Birth Date:</label>
                    <input type="date"  name="max_DOB" class="form-control" id="max_DOB" placeholder="Max. Birth Date">
                </div>
                
                <div class="form-group mx-sm-3 mb-2">
                    <select name="sex" id="sex">
                        <option value="" disabled selected hidden>Male/Female</option>
                        <option value="M">Male</option>
                        <option value="F">Female</option>
                    </select>
                </div>
                       
                <div class="form-group mx-sm-3 mb-2">
                    <select name="model" id="model">
                        <option value="" disabled selected hidden>Model</option>
                        <?php
                            foreach (array_unique($models) as &$model) {
                                echo "<option value=\"$model\">$model</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <input type="number"  min="1" name="year" class="form-control" id="year" placeholder="Year">
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <input type="number"  min="1" name="min_price" class="form-control" id="min_price" placeholder="Min. Price">
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <input type="number" min="1" name="max_price" class="form-control" id="max_price" placeholder="Max. Price">
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <select name="color" id="color">
                        <option value="" disabled selected hidden>Color</option>
                        <?php
                            foreach (array_unique($colors) as &$color) {
                                echo "<option value=\"$color\">$color</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <input type="number"  min="1" name="min_power" class="form-control" id="min_power" placeholder="Min. Horse Power">
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <input type="number" min="1" name="min_capacity" class="form-control" id="min_capacity" placeholder="Min. Tank Capacity">
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <select name="location" id="location" >
                        <option value="" disabled selected hidden>Country</option>
                        <?php
                            foreach ($locations as &$location) {
                                echo "<option value=\"$location\">$location</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group mx-sm-3 mb-2">
                <select id="city" name="city">
                    <option value="" disabled selected hidden>City</option>
                </select>
                </div>    
                <div class="form-group mx-sm-3 mb-2">
                    <select name="automatic" id="automatic">
                        <option value="" disabled selected hidden>Automatic/Manual</option>
                        <option value="T">Automatic</option>
                        <option value="F">Manual</option>
                    </select>
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <label for="Rdate">Reservations within Date:</label>
                    <input type="date"  name="Rdate" class="form-control" id="Rdate">
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <label for="Cdate">Customer Reservation time:</label>
                    <input type="date"  name="Cdate" class="form-control" id="Cdate">
                </div>
                <input type="submit" name="submit" class="btn btn-primary mb-2" value="Search" />
            </form>
        </section>


        <section >
        <div style="overflow-x:auto;width:100%;height:500px">
                <table>
                    <thead>
                    <th style="text-align: center;">Plate id</th>
                    <th style="text-align: center;">Model</th>
                    <th style="text-align: center;">Year</th>
                    <th style="text-align: center;">Price</th>
                    <th style="text-align: center;">Color</th>
                    <th style="text-align: center;">Power</th>
                    <th style="text-align: center;">Automatic/Manual</th>
                    <th style="text-align: center;">Tank Capacity</th>
                    <th style="text-align: center;">Country</th>
                    <th style="text-align: center;">City</th>
                    <th style="text-align: center;">Location</th>
                    <th style="text-align: center;">SSN</th>
                    <th style="text-align: center;">First Name</th>
                    <th style="text-align: center;">Last Name</th>
                    <th style="text-align: center;">Phone Number</th>
                    <th style="text-align: center;">E-mail</th>
                    <th style="text-align: center;">Sex</th>
                    <th style="text-align: center;">Date Of Birth</th>
                    <th style="text-align: center;">Reservation number</th>
                    <th style="text-align: center;">Reservation time</th>
                    <th style="text-align: center;">Pickup Location</th>
                    <th style="text-align: center;">Return Location</th>
                    <th style="text-align: center;">Pickup Time</th>
                    <th style="text-align: center;">Return Time</th>
                    <th style="text-align: center;">Payment Date</th>
                    <th style="text-align: center;">Payment Method</th>

                    </thead>
            <?php
                
                if (isset($_POST['submit'])) {
                    $result = "SELECT * FROM reservation NATURAL JOIN car NATURAL JOIN user NATURAL JOIN office WHERE 1";

                    if (isset($_POST["model"])) {
                        $result = $result . " AND model = \"" . $_POST["model"] . "\"";
                    }
                    if ($_POST["year"] != "") {
                        $result = $result . " AND year = " . $_POST["year"];
                    }
                    if ($_POST["min_price"] != "") {
                        $result = $result . " AND price_per_day >= " . $_POST["min_price"];
                    }
                    if ($_POST["max_price"] != "") {
                        $result = $result . " AND price_per_day <= " . $_POST["max_price"];
                    }
                    if (isset($_POST["color"])) {
                        $result = $result . " AND colour = \"" . $_POST["color"] . "\"";
                    }
                    if ($_POST["min_power"] != "") {
                        $result = $result . " AND power >= " . $_POST["min_power"];
                    }
                    if ($_POST["min_capacity"] != "") {
                        $result = $result . " AND tank_capacity >= " . $_POST["min_capacity"];
                    }
                    if (isset($_POST["location"])) {
                        $result .= " AND country =  \"". $_POST["location"] . "\"";
                    }
                    if (isset($_POST["city"])) {
                        $result .= " AND city =  \"". $_POST["city"] . "\"";
                    }
                    if (isset($_POST["automatic"])) {
                        $result = $result . " AND automatic = \"" . $_POST["automatic"] . "\"";
                    }
                    if ($_POST["phone"]!= "") {
                        $result = $result . " AND phone = \"" . $_POST["phone"] . "\"";
                    }
                    if ($_POST["fname"] != "") {
                        $result = $result . " AND fname LIKE '%" . $_POST["fname"] . "%'";
                    }
                    if ($_POST["lname"] != "") {
                        $result = $result . " AND lname LIKE '%" . $_POST["lname"] . "%'";
                    }
                    if ($_POST["email"] != "") {
                        $result = $result . " AND email LIKE '%" . $_POST["email"] . "%'";
                    }
                    if (isset($_POST["sex"])) {
                        $result = $result . " AND sex = \"" . $_POST["sex"] . "\"";
                    }
                    if ($_POST["min_DOB"] != "") {
                        $result = $result . " AND DOB >= '" . $_POST["min_DOB"] . "'";
                    }
                    if ($_POST["max_DOB"] != "") {
                        $result = $result . " AND DOB <= '" . $_POST["max_DOB"] . "'";
                    }
                    if ($_POST["Rdate"] != ""){
                        $result .= " AND (pickup_time <= '" . $_POST["Rdate"] . "' AND return_time >= '" . $_POST["Rdate"] . "')";

                    }
                    if ($_POST["Cdate"] != ""){
                        $result .= " AND reservation_time = '" . $_POST["Cdate"] . "'";

                    }
                    $result = $mysqli->query($result);

                }
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td style=\"text-align: center;\">" . $row["plate_id"] . "</td>";
                    echo "<td style=\"text-align: center;\">" . $row["model"] . "</td>";
                    echo "<td style=\"text-align: center;\">" . $row["year"] . "</td>";
                    echo "<td style=\"text-align: center;\">" . $row["price_per_day"] . "</td>";
                    echo "<td style=\"text-align: center;\">" . $row["colour"] . "</td>";
                    echo "<td style=\"text-align: center;\">" . $row["power"] . "</td>";
                    echo "<td style=\"text-align: center;\">" . $row["automatic"] . "</td>";
                    echo "<td style=\"text-align: center;\">" . $row["tank_capacity"] . "</td>";
                    echo "<td style=\"text-align: center;\">" . $row["country"] . "</td>";
                    echo "<td style=\"text-align: center;\">" . $row["city"] . "</td>";
                    echo "<td style=\"text-align: center;\">" . $row["location"] . "</td>";
                    echo "<td style=\"text-align: center;\">" . $row["ssn"] . "</td>";
                    echo "<td style=\"text-align: center;\">" . $row["fname"] . "</td>";
                    echo "<td style=\"text-align: center;\">" . $row["lname"] . "</td>";
                    echo "<td style=\"text-align: center;\">" . $row["phone"] . "</td>";
                    echo "<td style=\"text-align: center;\">" . $row["email"] . "</td>";
                    echo "<td style=\"text-align: center;\">" . $row["sex"] . "</td>";
                    echo "<td style=\"text-align: center;\">" . $row["DOB"] . "</td>";
                    echo "<td style=\"text-align: center;\">" . $row["reservation_number"] . "</td>";
                    echo "<td style=\"text-align: center;\">" . $row["reservation_time"] . "</td>";
                    echo "<td style=\"text-align: center;\">" . $row["pickup_office_id"] . "</td>";
                    echo "<td style=\"text-align: center;\">" . $row["return_office_id"] . "</td>";
                    echo "<td style=\"text-align: center;\">" . $row["pickup_time"] . "</td>";
                    echo "<td style=\"text-align: center;\">" . $row["return_time"] . "</td>";
                    echo "<td style=\"text-align: center;\">" . $row["payment_date"] . "</td>";
                    echo "<td style=\"text-align: center;\">" . $row["payment_method"] . "</td>";
                    echo "</tr>";
                }
            ?>
            </table>
            </div>
        </section>

        <br>

    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script>
    $(document).ready(function() {
            $('#location').change(function() {
                var selectedCountry = $(this).val();
                $('#city').empty();
                var initialCityHtml = city.innerHTML;

// Empty city dropdown initially
city.innerHTML = '<option value="" disabled selected hidden>City</option>';

                $.ajax({
                    type: 'POST',
                    url: 'city.php', 
                    data: { country: selectedCountry },
                    dataType: 'json',
                    success: function(response) {
                        $.each(response, function(index, city) {
                            $('#city').append('<option value="' + city + '">' + city + '</option>');
                        });
                    }
                });
            });
        });
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