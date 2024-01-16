<?php
// Include your database connection code here
$mysqli = new mysqli("localhost", "root", "", "car_rental_system");

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Check if the country parameter is set in the POST request
if (isset($_POST['country'])) {
    $selectedCountry = $_POST['country'];

    // Query to get cities based on the selected country
    $query = "SELECT DISTINCT `city` FROM `office` WHERE `country` = ?";
    
    // Use prepared statement to prevent SQL injection
    $statement = $mysqli->prepare($query);
    $statement->bind_param("s", $selectedCountry);
    $statement->execute();

    // Get the result
    $result = $statement->get_result();

    // Fetch cities and store them in an array
    $cities = array();
    while ($row = $result->fetch_assoc()) {
        $cities[] = $row['city'];
    }

    // Close the prepared statement
    $statement->close();

    // Return the cities in JSON format
    echo json_encode($cities);
} else {
    // If the country parameter is not set, return an empty JSON array
    echo json_encode(array());
}

// Close the database connection
$mysqli->close();
?>