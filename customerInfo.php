<?php session_start()?>
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
        <h2 class="h2">Customers</h2>
        <?php
            $mysqli=new mysqli("localhost","root","","car_rental_system");
            $result =$mysqli->query("SELECT * FROM `user`");
            while($row = mysqli_fetch_assoc($result)){
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
                <input type="submit" name="submit" class="btn btn-primary mb-2" value="Search" />
            </form>
        </section>
        <section >
        <div style="overflow-x:auto;width:100%;height:500px">
                <table>
                    <thead>
                    <th style="text-align: center;">SSN</th>
                    <th style="text-align: center;">First Name</th>
                    <th style="text-align: center;">Last Name</th>
                    <th style="text-align: center;">E-mail</th>
                    <th style="text-align: center;">Date Of Birth</th>
                    <th style="text-align: center;">Phone Number</th>
                    <th style="text-align: center;">Sex</th>
                    </thead>
            <?php
                
                if (isset($_POST['submit'])) {
                    $result = "SELECT user.* FROM user WHERE 1";
                    if ($_POST["phone"] != "") {
                        $result = $result . " AND phone = " . $_POST["phone"];
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

                   $result = $mysqli->query($result);
                } 
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td style=\"text-align: center;\">" . $row["ssn"] . "</td>";
                    echo "<td style=\"text-align: center;\">" . $row["fname"] . "</td>";
                    echo "<td style=\"text-align: center;\">" . $row["lname"] . "</td>";
                    echo "<td style=\"text-align: center;\">" . $row["phone"] . "</td>";
                    echo "<td style=\"text-align: center;\">" . $row["email"] . "</td>";
                    echo "<td style=\"text-align: center;\">" . $row["sex"] . "</td>";
                    echo "<td style=\"text-align: center;\">" . $row["DOB"] . "</td>";
                    echo "</tr>";
                }
            ?>
            </table>
            </div>
        </section>

        <br>

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