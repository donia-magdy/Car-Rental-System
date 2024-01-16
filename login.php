<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
</head>
<body>
    <?php
    session_start();
    $mysqli=new mysqli("localhost","root","","car_rental_system");

    if (isset($_POST['login'])) {
    $email=$_POST["email"];
    $password=$_POST["pass"];
    $encryptpass=md5($password);
    $selectedUserType = $_POST["userType"];
    if($selectedUserType=="user"){
          $q="SELECT * FROM user WHERE email='$email' AND pass='$encryptpass'";
          $result=$mysqli->query($q);
          if($result->num_rows>0){
            $userData = $result->fetch_assoc();
            $_SESSION['ssn'] = $userData['ssn'];
                      echo "<script>
                      window.location.href='index.php';
             </script>";
          }
          else {
              echo "Invalid user email or password";
              
          }
    }else{
        $q="SELECT * FROM admin WHERE email='$email' AND pass='$encryptpass'";
        $result=$mysqli->query($q);
        if($result->num_rows>0){
            $userData = $result->fetch_assoc();
            $_SESSION['ssn'] = $userData['ssn'];
                    echo "<script>
                    window.location.href='indexAdmin.php';
           </script>";
           
        }
        else {
            echo "Invalid admin email or password";

            
        }
    }


    } elseif (isset($_POST['signup'])) {
    $fname=$_POST["fname"];
    $lname=$_POST["lname"];
    $email=$_POST["email"];
    $phone=$_POST["phone"];
    $password=$_POST["pass"];
    $encryptpass=md5($password);
    $gender=$_POST["gender"];
    $birthdate = $_POST["birthday"];
    $q="SELECT * FROM user WHERE email='$email'";
    $q2="SELECT * FROM user WHERE phone='$phone'";
    $result=$mysqli->query($q);
    $result2=$mysqli->query($q2);

    if($result->num_rows>0){
        echo "Email already exist";
    //     echo "<script>
    //     window.location.href='home.html';
    //     alert('Email already exists');
    //    </script>";
        exit();
    }else if ($result2->num_rows>0){
        echo "Phone Number already exist";
        exit();
    }
    else {
        $insert="INSERT INTO user VALUES (NULL,'$fname','$lname','$phone','$email','$encryptpass','$gender','$birthdate')";
        $mysqli->query($insert);
        $userQuery = "SELECT * FROM user WHERE email='$email'";
        $userResult = $mysqli->query($userQuery);
        $userData = $userResult->fetch_assoc();
        // Set session variable with user data
        $_SESSION['ssn'] = $userData['ssn'];
        echo "<script>
                window.location.href='index.php?';
       </script>";
    }
     }
    ?>
</body>
</html>