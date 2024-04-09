<?php
require_once 'backend/user.php'; // Include RSO functions
require_once 'backend/comment.php'; // Include database connection


session_start();
// Define variables and initialize with empty values
$name = $description = $imageURL = $email1  = $email2 = $email3 = $adminemail = "";
$memberEmails = [];
$uniID = $_SESSION["user_universityid"];
$name_err = $description_err = $imageURL_err = $uniID_err = $email_err = "";

//$event = events_get_event($_SESSION["user_universityid"], $_GET["id"]);
// Processing form data when form is submitted


//Get the comments
//$comments = get_all_comments($_GET["id"]);
$comments = [];

if($_SERVER["REQUEST_METHOD"] == "POST"){
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create RSO</title>
    <link href="frontend/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<style>
    /* Style for selected stars */
    .btn-group input[type="radio"]:checked + label .fa-star,
    .btn-group input[type="radio"]:checked + label .fa-star-o {
        color: gold; /* Change the color to indicate selection */
    }
</style>
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
                    <a class="nav-link float-end" href="create_rso.php">Create RSO</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link float-end active" href="view_events.php">Events</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link float-end" href="create_event.php">Create Events</a>
                </li>
                <a href="logout.php" class="btn d-grid gap-2 d-md-flex justify-content-md-end">Logout</a>
            </ul>
        <div class="row">
        <div class="container">
    <div class="p-5 pb-md-4 mx-auto text-center">
        <h1 class="display-6 fw-normal">Comments</h1>
    </div>

    <div class="row">
        <div class="col col-md-6 align-self-top h-100">
            <div class="comment-section">
                <?php foreach ($comments as $eventComment) : ?>
                    <?php

                    $commentUser = get_user_by_id($universityId, $eventComment["UserID"]);

                    ?>
                    <div class="card">
                        <h5 class="card-header">
                            <strong><?= $commentUser["FullName"] ?></strong>
                        </h5>
                        <div class="card-body">
                            <p class="card-text"><?= $eventComment["Content"]; ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="col col-md-6 align-self-top">
            <div class="row my-2">
                <div class="col-md-12">
                    <div class="card">
                        <h5 class="card-header">
                            Leave a Rating and Comment
                        </h5>
                        <div class="card-body">
                            <form class="text-center w-100" action="/events/update_rating.php" method="post">
                                <input type="hidden" class="form-control" id="event_id" name="event_id"
                                    value="<?= $_GET['event_id']; ?>" required>
                                    <div class="mb-3 d-flex flex-wrap justify-content-center">
                                        <div class="btn-group" role="group" aria-label="Rating">
                                            <input type="radio" id="rating1" name="rating" value={1} style="display: none;">
                                            <label class="btn btn-secondary" for="rating1">
                                                <i class="fa fa-star"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>
                                            </label>

                                            <input type="radio" id="rating2" name="rating" value={2} style="display: none;">
                                            <label class="btn btn-secondary" for="rating2">
                                                <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>
                                            </label>

                                            <input type="radio" id="rating3" name="rating" value={3} style="display: none;">
                                            <label class="btn btn-secondary" for="rating3">
                                                <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>
                                            </label>

                                            <input type="radio" id="rating4" name="rating" value={4} style="display: none;">
                                            <label class="btn btn-secondary" for="rating4">
                                                <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i>
                                            </label>

                                            <input type="radio" id="rating5" name="rating" value={5} style="display: none;">
                                            <label class="btn btn-secondary" for="rating5">
                                                <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
                                            </label>
                                        </div>
                                    </div>
                                        <form class="text-start" action="/events/add_comments.php" method="post">
                                            <input type="hidden" class="form-control" id="event_id" name="event_id"
                                                value="<?=$_GET['event_id']; ?>" required>
                                            <div class="mb-3">
                                                <div class="form-floating">
                                                    <textarea class="form-control" placeholder="Leave a comment here"
                                                            id="comment" name="comment"
                                                            style="height: 200px; resize: none;"></textarea>
                                                    <label for="comment">Type your comment here.</label>
                                                </div>
                                            </div>
                                            <button type="submit" id="submit" name="submit"
                                                    class="btn btn-primary text-center w-100">Add comment
                                            </button>
                                        <a href="/events/edit_comments.php?id=<?= $event["EventID"] ?>" class="nav-link">Edit Your
                                            Comment</a>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 align-self-center">
                    <div class="card">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="frontend/js/bootstrap.min.js"></script>
</body>
</html>