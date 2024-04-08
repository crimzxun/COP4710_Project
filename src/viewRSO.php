<?php

session_start();

//Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo("No username");
    header("Location: index.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="frontend/css/bootstrap.min.css" rel="stylesheet">
    <link href="frontend/css/style.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="dashboard.php">Home Page</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="viewRSO.php">RSOs</a>
            </li>
            <li class="nav-item">
                <a class="nav-link float-end" href="#">Create RSO</a>
            </li>
            <li class="nav-item">
                <a class="nav-link float-end" href="#">Events</a>
            </li>
            <li class="nav-item">
                <a class="nav-link float-end" href="#">Create Events</a>
            </li>
            <a href="logout.php" class="btn d-grid gap-2 d-md-flex justify-content-md-end">Logout</a>
        </ul>
        <div class="row mt-3">
            <div class="col-md-12">
                <h1>Your University RSOs:</h1>
            </div>
        </div>
        <div class="row mt-3">
    <div class="row">
        <?php
        require_once 'backend/rso.php';
        // Call get_all_rso function to fetch RSOs
        $rsoList = get_all_rsos($_SESSION["user_universityid"]);


        // Check if RSOs exist
        if ($rsoList) {
            // Display RSOs
            foreach ($rsoList as $rso) {
                $rsoMemberCount = count(get_members($rso["RSOID"]));
                //echo "<p>{$rso['Name']}</p>"; // Assuming 'name' is the column name for RSO name
                echo "<div class=\"col-lg-3 col-md-3 mb-3\">
                        <div class=\"card\" style=\"width: 18rem;\">
                        <div class='card-body'>
                            <h5 class='card-title'>{$rso['Name']}</h5>
                            <p class='card-text'>{$rso['Description']}</p>
                        </div>
                        <ul class='list-group list-group-flush'>
                            <li class='list-group-item'>Members: {$rsoMemberCount}</li>
                        </ul>
                        <div class='card-body'>
                            <a href='#' class='card-link'>Join</a>
                        </div>
                        </div>
                    </div>";
            }
        } else {
            echo "No RSOs found.";
        }
        ?>
    </div>
</div>
    </div>
    <script src="frontend/js/jquery.min.js"></script>
    <script src="frontend/js/bootstrap.min.js"></script>
</body>
</html>