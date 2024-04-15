<?php
session_start();

//Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo("No username");
    header("Location: index.php");
    exit;
}

$uniID = $_SESSION["user_universityid"];
if ($uniID == 1) {
    $uniImage = './img/ucf.png';
}
else if ($uniID == 2) {
    $uniImage = './img/fsu.jpg';
}
else if ($uniID == 3) {
    $uniImage = './img/uf.png';
}
else if ($uniID == 4) {
    $uniImage = './img/usf.png';
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
<style>
    #logoImage {
        margin: 10px 0; /* Add margin above and below*/
        margin-right: 50px; /* Add margin to separate logo from text */
        vertical-align: middle;
    }
</style>
<body>
    <div class="container">
        <img src="<?php echo $uniImage; ?>" alt="University Logo" id="logoImage" width="225" height="75">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Home Page</a>
            </li>
            <li class="nav-item">
                <a class="nav-link float-end" href="viewRSO.php">RSOs</a>
            </li>
            <li class="nav-item">
                <a class="nav-link float-end" href="create_rso.php">Create RSO</a>
            </li>
            <li class="nav-item">
                <a class="nav-link float-end" href="view_events.php">Events</a>
            </li>
            <li class="nav-item">
                <a class="nav-link float-end" href="create_event.php">Create Events</a>
            </li>
            <a href="logout.php" class="btn d-grid gap-2 d-md-flex justify-content-md-end">Logout</a>
        </ul>
        <div class="row mt-3">
            <div class="col-md-12">
                <h1>Welcome <?php echo $_SESSION['user_fullname']; ?>!</h1>
            </div>
        </div>
    </div>
    <script src="frontend/js/jquery.min.js"></script>
    <script src="frontend/js/bootstrap.min.js"></script>
</body>
</html>