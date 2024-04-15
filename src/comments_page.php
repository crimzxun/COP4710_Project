<?php

require_once 'backend/user.php'; // Include RSO functions
require_once 'backend/comment.php'; // Include database connection

session_start();

// Define variables and initialize with empty values
$name = $description = $imageURL = $email1  = $email2 = $email3 = $adminemail = "";
$name_err = $description_err = $imageURL_err = $uniID_err = $email_err = "";

$uniID = $_SESSION["user_universityid"];
$userID = $_SESSION["user_id"];
$eventID = $_SESSION["event_id"];
// echo "Event ID: " . $_SESSION['event_id'];

$comments = get_all_comments($eventID);

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Check if the form data is submitted
    if (isset($_POST['submit'])) {
        $stars = $_POST['rate'];
        $comment = $_POST['comment']; 
        
        add_comment($userID, $eventID, $comment, $stars);

        // echo "Comment added successfully!";
        header('Location: comments_page.php');
        exit();  // Ensure that no other code is executed after redirection
    }

    if (isset($_POST['deleteComment'])) {

        $commentID = $_POST['commentID'];

        delete_comment($commentID);
        
        header("Location: ./comments_page.php");
        exit(); 
    }

    // aint getting trigger
    if (isset($_POST['updateComment'])) {
        
        $commentID = $_POST['commentID'];
        $newContext = $_POST['newContext'];

        edit_comment($commentID, $newContext);

        header("Location: ./comments_page.php");
        exit();
    }

} /*else {
    http_response_code(405); // Method Not Allowed
    echo "Invalid request method!";
}*/


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comments</title>
    <link href="frontend/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<style>
    /* Style for selected stars */
    /* .btn-group input[type="radio"]:checked + label .fa-star,
    .btn-group input[type="radio"]:checked + label .fa-star-o {
        color: gold;
    } */

    .fa-star {
        color: #ccc; /* Default color for empty star */
    }

    .checked {
        color: gold; /* Color for checked (filled) star */
    }

    *{
        margin: 0;
        padding: 0;
    }
    .rate {
        float: left;
        height: 46px;
        padding: 0 10px;
    }
    .rate:not(:checked) > input {
        position:absolute;
        top:-9999px;
    }
    .rate:not(:checked) > label {
        float:right;
        width:1em;
        overflow:hidden;
        white-space:nowrap;
        cursor:pointer;
        font-size:30px;
        color:#ccc;
    }
    .rate:not(:checked) > label:before {
        content: '★ ';
    }
    .rate > input:checked ~ label {
        color: #ffc700;    
    }
    .rate:not(:checked) > label:hover,
    .rate:not(:checked) > label:hover ~ label {
        color: #deb217;  
    }
    .rate > input:checked + label:hover,
    .rate > input:checked + label:hover ~ label,
    .rate > input:checked ~ label:hover,
    .rate > input:checked ~ label:hover ~ label,
    .rate > label:hover ~ input:checked ~ label {
        color: #c59b08;
    }   
</style>
<body>
    <div class="container">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="dashboard.php">Home Page</a>
            </li>
            <li class="nav-item">
                <a class="nav-link float-end" href="viewRSO.php">RSOs</a>
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
            </div>
            <div class="col col-md-6 align-self-top h-100">
                <div class="comment-section">
                    <?php foreach ($comments as $eventComment) : ?>
                        <?php
                        $commentUser = get_user_by_id($uniID, $eventComment["UserID"]);

                        // check if comment belongs to the user that is logged in
                        $isUserComment = ($eventComment["UserID"] === $userID);
                        ?>
                        <div class="card">
                            <h5 class="card-header">
                                <strong><?= $commentUser["FullName"] ?></strong>
                                <?php if ($isUserComment) : ?>
                                    <div class="float-end">
                                        <button type="button" name="editComment" class="btn btn-sm btn-primary edit-comment">Edit</button>
                                        <form action="./comments_page.php" method="post" class="d-inline">
                                            <input type="hidden" name="commentID" value="<?= $eventComment["CommentID"] ?>">
                                            <button type="submit" name="deleteComment" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </div>
                                <?php endif; ?>
                            </h5>
                            <div class="card-body">
                                <div class="ratings-container">
                                    <div class="rating">
                                        <?php 
                                        $stars = $eventComment["Rating"];
                                        for ($i = 1; $i <= 5; $i++) {
                                            if ($i <= $stars) {
                                                echo '<i class="fa fa-star checked"></i>'; // Filled star icon
                                            } 
                                            else {
                                                echo '<i class="fa fa-star"></i>'; // Empty star icon
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                                <p class="card-text comment-text"><?= $eventComment["Context"]; ?></p>
                                <form action="./comments_page.php" method="post" class="edit-comment-form d-inline">
                                    <input type="hidden" name="commentID" value="<?= $eventComment["CommentID"] ?>">
                                    <textarea name="newContext" class="form-control edit-comment-field" style="display: none;"><?= $eventComment["Context"]; ?></textarea>
                                    <button type="submit" name="updateComment" class="btn btn-sm btn-success save-comment" style="display: none;">Save</button>
                                </form>
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
                                <form id='commentForm' class="text-center w-100" action="./comments_page.php" method="post" onsubmit="return success()">
                                    <input type="hidden" class="form-control" id="event_id" name="event_id"
                                        value="<?= $eventID; ?>" required>
                                    <div class="mb-3 d-flex flex-wrap justify-content-center">
                                        <div class="rate">
                                            <input type="radio" id="star5" name="rate" value="5" required/>
                                            <label for="star5" title="text">5 stars</label>
                                            <input type="radio" id="star4" name="rate" value="4" />
                                            <label for="star4" title="text">4 stars</label>
                                            <input type="radio" id="star3" name="rate" value="3" />
                                            <label for="star3" title="text">3 stars</label>
                                            <input type="radio" id="star2" name="rate" value="2" />
                                            <label for="star2" title="text">2 stars</label>
                                            <input type="radio" id="star1" name="rate" value="1" />
                                            <label for="star1" title="text">1 star</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-floating">
                                            <textarea class="form-control" placeholder="Leave a comment here"
                                                    id="comment" name="comment"
                                                    style="height: 200px; resize: none;"></textarea>
                                            <label for="comment">Type your comment here.</label>
                                        </div>
                                    </div>
                                    <button type="submit" id="submit" name="submit" class="btn btn-primary text-center w-100">Add comment</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('submit').addEventListener('click', function(event) {            
            var isRated = false;
            var rating = document.getElementsByName('rate');
            for (var i = 0; i < rating.length; i++) {
                if (rating[i].checked) {
                    isRated = true;
                    break;
                }
            }

            if (!isRated) {
                event.preventDefault(); // Prevent form submission
                alert('Please select a rating.'); // Show pop-up
            }
        });

        function success() {
            alert('Comment submitted successfully!');
            return true;
        }

        document.addEventListener("DOMContentLoaded", function() {
            var editButtons = document.querySelectorAll(".edit-comment");
            var saveButtons = document.querySelectorAll(".save-comment");
            

            editButtons.forEach(function(button) {
                button.addEventListener("click", function() {
                    event.preventDefault();

                    var cardBody = button.closest(".card").querySelector(".card-body");
                    var ratingsContainer = cardBody.querySelector(".ratings-container");
                    var commentText = cardBody.querySelector(".comment-text");
                    var editField = cardBody.querySelector(".edit-comment-field");
                    var saveButton = cardBody.querySelector(".save-comment");

                    // console.log("commentText:", commentText);
                    // console.log("editField:", editField); 
                    // console.log("saveButton:", saveButton);

                    commentText.style.display = "none";
                    editField.style.display = "block";
                    saveButton.style.display = "block";
                });
            });

            saveButtons.forEach(function(button) {
                button.addEventListener("click", function() {
                    event.preventDefault();

                    var cardBody = button.closest(".card").querySelector(".card-body");
                    var commentText = cardBody.querySelector(".comment-text");
                    var editField = cardBody.querySelector(".edit-comment-field");
                    var commentID = button.closest(".card").querySelector('input[name="commentID"]').value;

                    // Update the comment text
                    commentText.textContent = editField.value;

                    // Send a POST request to the PHP script to update the comment
                    fetch('comments_page.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type':'application/x-www-form-urlencoded'
                        },
                        body: new URLSearchParams({
                            updateComment: 'true',
                            commentID: commentID,
                            newContext: editField.value
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        console.log('Comment updated successfully');
                    })
                    .catch(error => {
                        console.error('There was a problem with the fetch operation:', error);
                    });

                    // Hide the edit field and save button
                    commentText.style.display = "block";
                    editField.style.display = "none";
                    button.style.display = "none";
                });
            });
        });
    </script>
    <script src="frontend/js/bootstrap.min.js"></script>
</body>
</html>