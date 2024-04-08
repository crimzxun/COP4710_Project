<?php

session_start();

//Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo("No username");
    header("Location: index.php");
    exit;
}

require_once "backend/event.php";
require_once "backend/university.php";

$user_id = $_SESSION["user_id"];
$uniID = $_SESSION["user_universityid"];

$events = get_all_events($uniID);
$university = get_university($uniID);

// Close database connection
// $mysqli->close();
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
        <div class="row mt-3">
            <div class="col-md-12">
                <h1>List of Events: </h1>
            </div>
        </div>
    </div>
	<div class="event-list">
		<div class="row">
            <?php foreach ($events as $event): ?>
                <div class="col-md-4 mb-4">
					<div class="card" style="width: 18rem;">
						<div class="card-body">
							<h3 class="card-title"><?php echo $event['Name']; ?></h3>
							<h6 class="card-subtitle mb-2 text-muted"><?php echo $event['Category']; ?></p>
							<p class="card-text"><?php echo $event['Description']; ?></p>
							<p class="card-text">Date: <?php echo $event['Date']; ?></p>
							<p class="card-text">Time: <?php echo $event['Time']; ?></p>
							<p class="card-text">Location: <?php echo $event['LocationID']; ?></p>
							<p class="card-text">Phone: <?php echo $event['ContactPhone']; ?></p>
							<p class="card-text">Email: <?php echo $event['ContactEmail']; ?></p>
						</div>
					</div>
                </div>
            <?php endforeach; ?>
		</div>
    </div>
    <script src="frontend/js/jquery.min.js"></script>
    <script src="frontend/js/bootstrap.min.js"></script>
</body>
</html>