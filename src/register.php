<?php

require_once 'backend/user.php';

// Define variables and initialize with empty values
$email = $password = $fullName = "";
$uniID = null;
$email_err = $password_err = $fullName_err = $uniID_err = $register_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Check if email and password are empty
    // Validate email uniqueness
    
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
    
    if(empty(trim($_POST["fullName"]))){
        $fullName_err = "Please enter your full name.";
    } else{
        $fullName = trim($_POST["fullName"]);
    }

    if(empty(trim($_POST["UniversityID"]))){
        $uniID_err = "Please enter your university.";
    } else{
        $uniID = trim($_POST["UniversityID"]);
    }

    $existing_user = user_email_exists($email);
    if ($existing_user) {
        // Display error message or handle duplicate email scenario
        $email_err = "Email address is already in use.";
    } else {
        // Proceed with user creation
        create_user($email, $password, $fullName, $uniID);
    }


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
                <h4>Please Register Here:</h4>
                <form action="./register.php" method="post">
                    <div class="pb-2">
                        <input type="text" id="email" name="email" class="form-control my-2" placeholder="Email" required autofocus>
                        <input type="password" id="password" name="password" class="form-control my-2" placeholder="Password" required>
                        <input type="text" id="fullName" name="fullName" class="form-control my-2" placeholder="Full Name" required>
                        <select class="form-control my-2" aria-label="Default select example" id="UniveristyID" name="UniversityID">
                            <option selected>Open this select University</option>
                            <option value=1>1- University of Central Flordia</option>
                            <option value=2>2- Florida State University</option>
                            <option value=3>3- University of Central Florida</option>
                            <option value=3>4- University of South Florida</option>
                        </select>
                    </div>

                    <button class="btn btn-primary btn-block" type="submit">Register</button>

                    <a href="login.php">Go back to Login</a>
                </form>
            </div>
        </div>
    </div>
    <script src="frontend/js/bootstrap.min.js"></script>
</body>
</html>