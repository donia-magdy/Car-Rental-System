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
            .box {
    background-color: white;
    padding: 20px;
}

.box .ima {
    overflow: hidden;
    position: relative;
}

.box .ima::before {
    content: "";
    position: absolute;
    width: 0;
    height: 0;
    background-color: rgb(255 255 255 / 20%);
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    z-index: 2;
}

.box:hover .ima::before {
    animation: fill-frame .5s 1;
}

@keyframes fill-frame {
    100% {
        width: 100%;
        height: 100%;
    }
}

.box img {
    width: 90%;
    transition: .3s;
}
.box > :last-child > :last-child{margin-bottom: inherit;}

.box:hover img {
    transform: rotate(5deg) scale(1.2);
}
.box h2,.box p{
    margin:0;
}
input[type=date]{
    color: #000;
}
    
</style>
</head>
<body>
<?php
                session_start();

                require_once "database.php";
                $query = '';
                $output = array();
                 $query = "SELECT car.*, office.* FROM car JOIN office ON car.office_id = office.office_id WHERE 1";

                $statement = $databaseConnexion->prepare($query);
                $statement->execute();
                $result = $statement->fetchAll();
                $data = array();
                $filtered_rows = $statement->rowCount();
                foreach ($result as $row) {
                    echo "<article class=\"box\">";
                    echo"<header class=\"major\">";
                    echo "<a href=\"backup3_1.php?plate_id=" . $row["plate_id"] . "\">";  
                   
                    echo "<div class=\"ima\"><img src=\"images/" . $row["img"] . "\" alt=\"\"/></div>";
                    
                      
                    echo "<h2>" . $row["model"] . " " . $row["year"] . "</h2>";
                    echo "<p>Price: <strong>". $row["price_per_day"] . "</strong> per day</p>";
                    echo "<div >";
                    
                    if($row['automatic'] === 'T') {
                        $type = "Automatic";
                    } else {
                        $type = "Manual";
                    }
                    echo "<p>Type: <strong>". $type . "</strong></p>";
                    echo "</div>";
                    echo "</header>";
                    echo "</a>";
                    echo "</article>";
                }
            ?>
           
			<script src="assets/js/main.js"></script>
            <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>