<?php
session_start();
require_once 'backend/rso.php';
require_once 'backend/user.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$rsoId = $_GET['rsoId'] ?? null;

// if (!check_admin($rsoId, $_SESSION['user_id'])) {
//     echo $rsoId; check_admin($rsoId, $_SESSION['user_id']);

//     header("Location: dashboard.php"); // Redirect if not an admin or RSO ID is missing
//     exit;
// }

$members = get_members($rsoId);

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["newMemberEmail"])) {
    $newMemberEmail = $_POST["newMemberEmail"];
    $newMember = get_user_by_email($_SESSION["user_universityid"], $newMemberEmail);
    $newMemberId = $newMember['UserID'];
    if (!check_membership($_GET['rsoId'],  $newMemberId)) {
        add_member($rsoId, $newMemberId);
        // Redirect to prevent form resubmission
        header("Location: viewRSO.php"); 
        exit;
    } else {
        // Handle case when user with provided email doesn't exist
        // You can show an error message or handle it as needed
    }
}

// Remove member functionality
if (isset($_GET["removeUserId"])) {
    $removeUserId = $_GET["removeUserId"];
    remove_member($rsoId, $removeUserId);
    // Redirect to prevent form resubmission
    header("Location: viewRSO.php");
    exit;
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit RSO Members</title>
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
        <h2>Edit Members of RSO</h2>
        <ul>
            <?php foreach ($members as $member): ?>
                <li><?php $memberemail =  get_user_by_id($_SESSION["user_universityid"], $member['UserID']); echo $memberemail['Email']; // Display user details ?>
                <a href="./editRSO.php?removeUserId=<?php echo $member['UserID']; ?>&rsoId=<?php echo $rsoId; ?>">Remove</a>
                </li>
                <!-- <?php echo $rsoId ?> -->
            <?php endforeach; ?>
            
        </ul>
        <form method="POST" action="./editRSO.php?removeUserId=<?php echo $member['UserID']; ?>&rsoId=<?php echo $rsoId; ?>">
            <input type="email" name="newMemberEmail" placeholder="Enter member email">
            <button type="submit">Add Member</button>
        </form>
    </div>
    <script src="frontend/js/jquery.min.js"></script>
    <script src="frontend/js/bootstrap.min.js"></script>
</body>
</html>