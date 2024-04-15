<?php
require_once 'backend/rso.php'; // Include RSO functions
require_once 'backend/dbconn.php'; // Include database connection

session_start();
// Define variables and initialize with empty values
$name = $description = $imageURL = $email1  = $email2 = $email3 = $adminemail = "";
$memberEmails = [];
$uniID = $_SESSION["user_universityid"];
$name_err = $description_err = $imageURL_err = $uniID_err = $email_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate RSO name
    //echo"testing";
    if(empty(trim($_POST["name"]))){
        $name_err = "Please enter RSO name.";
    } else{
        $name = trim($_POST["name"]);
    }
    
    // Validate RSO description
    if(empty(trim($_POST["description"]))){
        $description_err = "Please enter RSO description.";
    } else{
        $description = trim($_POST["description"]);
    }
    
    // Validate RSO image URL
    if(empty(trim($_POST["imageURL"]))){
        $imageURL_err = "Please enter RSO image URL.";
    } else{
        $imageURL = trim($_POST["imageURL"]);
    }

    //Validate Member Emails
    if(empty(trim($_POST["email1"])) || empty(trim($_POST["email2"] || empty(trim($_POST["email3"]))))){
        $email_err = "Please enter 3 emails.";
    } else{
        $email1 = trim($_POST["email1"]);
        $email2 = trim($_POST["email2"]);
        $email3 = trim($_POST["email3"]);
    }

    // Validate Admin Email
    if(empty(trim($_POST["adminemail"]))){
        $email_err = "Please enter your admin's email.";
    } else{
        $adminemail = trim($_POST["adminemail"]);
    }
    $memberEmails = [$email1, $email2, $email3];
    create_rso($uniID, $name, $description, $imageURL, $memberEmails, $adminemail);
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create RSO</title>
    <link href="frontend/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="dashboard.php">Home Page</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="viewRSO.php">RSOs</a>
            </li>
            <li class="nav-item">
                <a class="nav-link float-end active" href="create_rso.php">Create RSO</a>
            </li>
            <li class="nav-item">
                <a class="nav-link float-end" href="view_events.php">Events</a>
            </li>
            <li class="nav-item">
                <a class="nav-link float-end" href="create_event.php">Create Events</a>
            </li>
            <a href="logout.php" class="btn d-grid gap-2 d-md-flex justify-content-md-end">Logout</a>
        </ul>
        <div class="row">
            <div class="col-md-4 offset-md-4 form-login mt-4">
                <h4>Create RSO</h4>
                <form action="./create_rso.php" method="post">
                <div class="pb-2">
                    <input type="text" id="name" name="name" class="form-control my-2" placeholder="Name" required autofocus>
                    <input type="text" id="description" name="description" class="form-control my-2" placeholder="Description" required autofocus>
                    <input type="text" id="image_url" name="imageURL" class="form-control my-2" placeholder="Image URL" required autofocus>
                    <input type="text" id="uniID" name="uniID" class="form-control my-2" value="<?php echo $_SESSION["user_universityid"]; ?>" disabled>
                    <input type="text" id="email" name="adminemail" class="form-control my-2" placeholder="Admin Email" required autofocus>
                    <input type="text" id="email" name="email1" class="form-control my-2" placeholder="Student 1 Email" required autofocus>
                    <input type="text" id="email" name="email2" class="form-control my-2" placeholder="Student 2 Email" required autofocus>
                    <input type="text" id="email" name="email3" class="form-control my-2" placeholder="Student 3 Email" required autofocus>
                    </div>

                    <button class="btn btn-primary btn-block" type="submit">Create RSO</button>
                    <a href="dashboard.php">Go back to Dashboard</a>
                </div>
            </form>
        </div>
    </div>
    <script src="frontend/js/bootstrap.min.js"></script>
</body>
</html>