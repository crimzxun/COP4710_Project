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
require_once "backend/rso.php";
require_once "backend/gmap.php";

$user_id = $_SESSION["user_id"];                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              
$uniID = $_SESSION["user_universityid"];

$events = get_all_events($uniID);
$university = get_university($uniID);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['event_id'])) {
    // store eventID in the session variable
    $_SESSION['event_id'] = $_POST['event_id'];

    // redirect to comments_page.php
    header("Location: comments_page.php");
    exit; // stop further execution
}

// Close database connection
// $mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Events</title>
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
                <a class="nav-link float-end" href="viewRSO.php">RSOs</a>
            </li>
            <li class="nav-item">
                <a class="nav-link float-end" href="create_rso.php">Create RSO</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="view_events.php">Events</a>
            </li>
            <li class="nav-item">
                <a class="nav-link float-end" href="create_event.php">Create Events</a>
            </li>
            <a href="logout.php" class="btn d-grid gap-2 d-md-flex justify-content-md-end">Logout</a>
        </ul>
        <div class="row mt-3">
            <div class="col-md-12">
                <h1>List of Events: </h1>
            </div>
        </div>
        <div class="event-list">
            <div class="row">
                <?php foreach ($events as $event): ?>
                        <?php if ((($event['EventType'] == 'rso') && check_membership($event['RSOID'], $user_id)) || ($event['EventType'] == 'public') || ((($event['EventType'] == 'private') && ($event['UniversityID']== $uniID))))
                        {
                            echo '
                            <div class="col-lg-3 col-md-3 mb-3">
                                <div class="card" style="width: 18rem;">
                                <div class="card h-25">
                                    <div id="googleMap_' . $event['LocationID'] . '" style="width: auto; height: 15rem;"></div>
                                </div>
                                <div class="card-body">
                                    <h3 class="card-title">' . $event['Name'] . '</h3>
                                    <h6 class="card-subtitle mb-2 text-muted">' . $event['Category'] . '</p>
                                    <p class="card-text">' . $event['Description'] . '</p>
                                    <p class="card-text">Date: ' . $event['Date'] . '</p>
                                    <p class="card-text">Time: ' . $event['Time'] . '</p>
                                    <p class="card-text">Location: ';
                                        $location = get_location($event['LocationID']); 
                                        echo $location['Place'];
                                    echo '</p>
                                    <p class="card-text">Phone: ' . $event['ContactPhone'] . '</p>
                                    <p class="card-text">Email: ' . $event['ContactEmail'] . '</p>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">';
                                        if ($event['EventType'] == 'rso') {
                                            echo "RSO Members Only"; 
                                        }
                                        if ($event['EventType'] == 'private') {
                                            echo "Private Event"; 
                                        }
                                        if ($event['EventType'] == 'public') {
                                            echo "Public Event"; 
                                        }
                                    echo '</li>
                                </ul>
                                <a href="#" class="btn btn-primary comments-button" data-event-id="' . $event['EventID'] . '">Comments</a>
                            </div>
                        </div>
                        ';
                        }
                        ?>

                    <script>
                        function initMap_<?php echo $event['LocationID']; ?>() {
                            var location = {lat: <?php echo $location['Latitude']; ?>, lng: <?php echo $location['Longitude']; ?>};
                            var map = new google.maps.Map(document.getElementById('googleMap_<?php echo $event['LocationID']; ?>'), {
                                zoom: 15,
                                center: location
                            });
                            var marker = new google.maps.Marker({
                                position: location,
                                map: map
                            });
                        }
                        initMap_<?php echo $event['LocationID']; ?>();
                    </script>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <script>
        document.querySelectorAll('.comments-button').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault(); // prevent default link behavior
                var eventId = this.getAttribute('data-event-id');

                // create a form element to submit the eventID
                var form = document.createElement('form');
                form.method = 'post';
                form.action = '<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>'; // Form action to the same page

                // create a hidden input field to store the eventID
                var eventIdInput = document.createElement('input');
                eventIdInput.type = 'hidden';
                eventIdInput.name = 'event_id';
                eventIdInput.value = eventId;
                
                // append eventIdInput to the form then the form to the document body and submit it
                form.appendChild(eventIdInput);
                document.body.appendChild(form);
                form.submit();
            });
        });
    </script>
    <script src="frontend/js/jquery.min.js"></script>
    <script src="frontend/js/bootstrap.min.js"></script>
</body>
</html>