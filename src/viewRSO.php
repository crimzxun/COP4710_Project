<?php
session_start();

include_once 'backend/rso.php';

//Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo("No username");
    header("Location: index.php");
    exit;
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $rsoId = $_POST['rsoId'];
    $newMemberId = $_POST['newMemberId'];

    // Call the add_member function
    add_member($rsoId, $newMemberId);
    // Redirect to a success page or display a success message
    header("Location: view_events.php");
}

// Fetch RSOs from the database
$rsoList = get_all_rsos($_SESSION["user_universityid"]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View RSOs</title>
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
                <h1>Your University RSOs:</h1>
            </div>
        </div>
        <div class="row mt-3">
            <div class="row">
                <?php
                // Check if RSOs exist
                if ($rsoList) {
                    // Display RSOs
                    foreach ($rsoList as $rso) {
                        $rsoMemberCount = count(get_members($rso["RSOID"]));
                        // $isAdmin = is_rso_admin($_SESSION["user_universityid"], $rso["RSOID"], $_SESSION['user_id']);
                        echo "<div class=\"col-lg-3 col-md-3 mb-3\">
                            <div class=\"card\" style=\"width: 18rem;\">
                            <div class='card-body'>
                                <h5 class='card-title'>{$rso['Name']}</h5>
                                <p class='card-text'>{$rso['Description']}</p>
                            </div>
                            <ul class='list-group list-group-flush'>
                                <li class='list-group-item'>Members: {$rsoMemberCount}</li>
                            </ul>
                            <div class='card-body'>";
                        if (check_admin($rso["RSOID"], $_SESSION['user_id'])) {
                            echo "<a href=\"editRSO.php?rsoId={$rso['RSOID']}\" class=\"btn btn-primary\">Edit RSO</a>";
                        }
                        if(check_membership($rso["RSOID"], $_SESSION['user_id'])) {
                            echo "<button class=\"btn btn-link p-0\" disabled>Already a Member!</button>";
                        } else {
                            echo "<form action=\"./viewRSO.php\" method=\"post\">
                                <input type=\"hidden\" name=\"rsoId\" value=\"{$rso["RSOID"]}\">
                                <input type=\"hidden\" name=\"newMemberId\" value=\"{$_SESSION['user_id']}\">
                                <button type=\"submit\" id=\"submit\" name=\"submit\" class=\"btn btn-link p-0\">Join RSO</button>
                            </form>";
                        }
                        echo "</div>
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