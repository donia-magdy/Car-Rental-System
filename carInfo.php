<?php  session_start()  
?>
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

    
      <div >
        <h2 class="h2">Cars</h2>
        <?php
            $mysqli=new mysqli("localhost","root","","car_rental_system");
            $result =$mysqli->query("SELECT * FROM `car`");
            $colors = Array();
            $models = Array();
            while($row = mysqli_fetch_assoc($result)){
                $models[] = strtolower($row['model']);
                $colors[] = strtolower($row['colour']);
            }

            $result = $mysqli->query("SELECT DISTINCT `country` FROM `office`");
            $locations = Array();
            while($row = mysqli_fetch_assoc($result)){
                $locations[] = $row['country'];
            }
        ?>

        <section>
            <form class="form-inline" method="post" id="search" name="search" action="" >
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
                    </thead>
            <?php
                
                if (isset($_POST['submit'])) {
                    $result = "SELECT car.*, office.* FROM car JOIN office ON car.office_id = office.office_id WHERE 1";
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
                    if($row['automatic'] === 'T') {
                        $type = "Automatic";
                    } else {
                        $type = "Manual";
                    }
                    echo "<td style=\"text-align: center;\">" . $type. "</td>";
                    echo "<td style=\"text-align: center;\">" . $row["tank_capacity"] . "</td>";
                    echo "<td style=\"text-align: center;\">" . $row["country"] . "</td>";
                    echo "<td style=\"text-align: center;\">" . $row["city"] . "</td>";
                    echo "<td style=\"text-align: center;\">" . $row["location"] . "</td>";
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
    
			<script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
			<script src="assets/js/jquery.scrolly.min.js"></script>
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>
            
</body>
</html>