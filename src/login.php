<?php

//session_start();

// Check if user is already logged in, if yes, redirect to dashboard or desired page
// if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
//     header("location: ./dashboard.php");
//     exit;
// }

// Include database connection file
require_once "./backend/dbconn.php";

require_once './backend/loginauth.php';

// Define variables and initialize with empty values
$email = $password = "";
$email_err = $password_err = $login_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Check if email and password are empty
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter email.";
    } else{
        $email = trim($_POST["email"]);
    }
    
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    auth_login($email, $password);
    
    // Close connection $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="frontend/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4 form-login mt-4">
                <h4>Welcome Back!</h4>
                <form action="./login.php" method="post">
                    <input type="text" id="email" name="email" class="form-control my-2" placeholder="Email" required autofocus>
                    <input type="password" id="password" name="password" class="form-control my-2" placeholder="Password" required>
                    <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>

                    <a href="signup.php">Signup</a>
                </form>
            </div>
        </div>
    </div>
    <script src="frontend/js/bootstrap.min.js"></script>
</body>
</html>