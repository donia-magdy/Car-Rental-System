<!DOCTYPE html>
<html lang="en"> 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Catalog</title>
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
</style>
<script src="jquery.min.js"></script>
<script>function submitForm() {
            // Assuming your form has an ID of "paymentForm"
            var form = document.getElementById("search");
            form.submit();
        }
        
        </script>
<script src="assets/js/jquery.min.js"></script>
<script>

     $(document).ready(function () {
        $("#search").submit(function (event) {
          event.preventDefault();
          
            var formData = $(this).serialize();

            $.ajax({
              type: "POST",
              url: "search.php",
              data: formData,
              success: function (response) {
                $("#car_tiles").html(response);
                $('#search')[0].reset();
              },
            });
        });
      });
      
</script>

</head>
<body onload="submitForm()" class="is-preload">
    <!-- Wrapper -->
    <div id="wrapper">
      <!-- Header -->
      <header id="header" class="alt">
        <a href="index.php" class="logo"
          ><strong>Car Rental</strong> <span>Website</span></a
        >
        <nav>
          <a href="#menu">Menu</a>
        </nav>
      </header>

      <!-- Menu -->
      <nav id="menu">
        <ul class="links">
          <li class="active"><a href="index.php">Home </a></li>

          <li><a href="car_list.php">Car Catalog</a></li>
          <?php
          session_start();
        if (!isset($_SESSION['ssn'])) { ?>
            <li class="nav-item"><a href="logorsign.html" class="nav-link">Login Or Register</a></li>
        <?php } else { ?>
            <li class="nav-item"><a href="destroy.php" class="nav-link">Sign Out</a></li>
        <?php } ?>


        <?php
          
          if (isset($_SESSION['ssn'])) { ?>
              <li><a href="user_reservations.php">Reservations</a></li>
          <?php }  ?>




          <li><a href="about-us.php">About Us</a></li>

          <li><a href="contactUser.php">Contact Us</a></li>
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
            <form class="form-inline" method="post" id="search" name="search" action="search.php" >
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
                </select>

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
                        <label for="pickup_time">Pickup Time:</label>
                        <input type="date" id="pickup_time" name="pickup_time" ><br>
                        </div>
                        
                        <div class="form-group mx-sm-3 mb-2">
                        <label for="return_time">Return Time:</label>
                        <input type="date" id="return_time" name="return_time" ><br>
                        </div>

                <input type="hidden" name="submit" value="1" />
                <input type="submit" id="submit" class="btn btn-primary mb-2" value="Search" />
            </form>
        </section>
        <section id="car_tiles" class="tiles">
            
        </section>

        <br>

    </div>
    <script>function submitForm() {
              $(document).ready(function () {

            $.ajax({
              type: "POST",
              url: "retrievedata.php",
              success: function (response) {
                $("#car_tiles").html(response);
              },
        });
      });
        }
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
			<script src="assets/js/jquery.scrolly.min.js"></script>
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>
            <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
            <script src="assets/js/main.js"></script>
            
</body>
</html>