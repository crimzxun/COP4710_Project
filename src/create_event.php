<?php

require_once 'backend/event.php';
require_once 'backend/rso.php';

session_start();

$userId = $_SESSION["user_id"];
$universityId = $_SESSION["user_universityid"];
									//Get the orgs the user is part of
$userRSOs = [];
// Define variables and initialize with empty values
$name = $category = $desc = $address = $phone = $email = $eventtype = "";
$latitude = $longitude = $address = $uniID = $time = $date = $rsoID = null;

$longitude = -81.2000599;
$latitude = 28.6024274;
// $name_err = $category_err = $desc_err = $address_err = $phone_err = $email_err = $rsoID_err = "";
// $eventtype_err = $latitude_err = $longitude_err = $address_err = $uniID_err = $time_err = $date_err = "";
$error = null;

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Check if email and password are empty
    // Validate email uniqueness
    
    if(empty(trim($_POST["name"]))){
        $error = "Please enter event name.";
    } else{
        $name = trim($_POST["name"]);
    }
    
    if(empty(trim($_POST["category"]))){
        $error = "Please enter event category.";
    } else{
        $category = trim($_POST["category"]);
    }

	if(empty(trim($_POST["description"]))){
        $error = "Please enter a description for the event.";
    } else{
        $desc = trim($_POST["description"]);
    }

	if(empty(trim($_POST["time"]))){
        $error = "Please enter time of event";
    } else{
        $time = trim($_POST["time"]);
    }

	if(empty(trim($_POST["date"]))){
        $error = "Please enter date of event";
    } else{
        $date = trim($_POST["date"]);
    }

	// location to be here.
	if(empty(trim($_POST["address"]))){
        $error = "Please enter address of event.";
    } else{
        $address = trim($_POST["address"]);
    }

	//$latitude = ($_POST['latitude']);
    //$longitude = ($_POST['longitude']);
    
    if(empty(trim($_POST["phone"]))){
        $error = "Please enter your phone number.";
    } else{
        $phone = trim($_POST["phone"]);
    }

	if(empty(trim($_POST["email"]))){
        $error = "Please enter your email address.";
    } else{
        $email = trim($_POST["email"]);
    }

	if(empty(trim($_POST["eventtype"]))){
        $error = "Please enter event type.";
    } else{
        $eventtype = trim($_POST["eventtype"]);
    }

	if ($eventtype == 'rso') {
		if(empty(trim($_POST["rsoID"]))){
			$error = "Please enter rso id.";
		} else{
			$rsoID = trim($_POST["rsoID"]);
		}

		// not working atm bc rso entity does not have AdminID
        // $rso = get_rso($uniID, $rsoID);
        // if ($_SESSION["user_id"] != $rso["AdminID"]) {
        //     $error = "You are not an admin of this RSO.";
        // }
    }

    // if(empty(trim($_POST["uniID"]))){
    //     $error = "Please enter your university.";
    // } else{
    //     //$uniID = trim($_POST["uniID"]);
	// 	$uniID= $_SESSION["user_universityid"];
    // }
	$uniID= $_SESSION["user_universityid"];
	
	create_event($uniID, $name, $category, $desc, $time, $date, $latitude, $longitude, $address, $phone, $email, $eventtype, $rsoID);

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
                <a class="nav-link float-end" href="events.php">Events</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="create_event.php">Create Events</a>
            </li>
            <a href="logout.php" class="btn d-grid gap-2 d-md-flex justify-content-md-end">Logout</a>
        </ul>
		<div class="container">
			<div class="row">
				<div class="col-md-4 offset-md-4 form-login mt-4">
					<h4>Create New Event:</h4>
					<form action="./create_event.php" method="post">
						<div class="pb-2">
							<input type="text" id="name" name="name" class="form-control my-2" placeholder="Event Name" required autofocus>
							<input type="text" id="category" name="category" class="form-control my-2" placeholder="Category" required>
							<input type="text" id="description" name="description" class="form-control my-2" placeholder="Description" required>
							<input type="time" id="time" name="time" class="form-control my-2" placeholder="Time" required>
							<input type="date" id="date" name="date" class="form-control my-2" placeholder="Date" required>
							<input type="text" id="address" name="address" class="form-control my-2" placeholder="Address" required>
							<li class="list-group-item">
								<strong>Contact Info:</strong>
								<input type="tel" id="phone" name="phone" class="form-control my-2" placeholder="Contact Phone" required>
								<input type="text" id="email" name="email" class="form-control my-2" placeholder="Contact Email" required>
                            </li>
							<li class="list-group-item">
								<strong>Event Type: </strong> <select class="form-control my-2" id="eventtype" name="eventtype" required="required">
									<option value="public">Public</option>
									<option value="private">Private</option>
									<option value="rso">RSO</option>
								</select>
							</li>
							<li class="list-group-item" id="rsoIdField" style="display: none;">
								<strong>RSO: </strong> <select class="form-control" id="rsoID" name="rsoID">
									<option disabled selected value> Select an organization.... </option>
									<?php
									 foreach ($userRSOs as $RSO) : ?>
										<option value="<?php echo $RSO['RSOID']; ?>"><?php echo $RSO['Name']; ?></option>
									<?php endforeach; ?>
								</select>
							</li>
							<select class="form-control my-2" aria-label="Default select example" id="UniID" name="UniID" disabled>
								<option value="1" <?php if ($_SESSION["user_universityid"] == 1) echo 'selected'; ?>>1- University of Central Florida</option>
								<option value="2" <?php if ($_SESSION["user_universityid"] == 2) echo 'selected'; ?>>2- Florida State University</option>
								<option value="3" <?php if ($$_SESSION["user_universityid"] == 3) echo 'selected'; ?>>3- University of Central Florida</option>
								<option value="4" <?php if ($_SESSION["user_universityid"] == 4) echo 'selected'; ?>>4- University of South Florida</option>
							</select>
						</div>

						<button class="btn btn-primary btn-block" id="submit" name="submit" type="submit">Create</button>
						<a href="events.php">View Events</a>
					</form>
				</div>
			</div>
		</div>
	</div>
	<script>
		function initMap() {
			var map = new google.maps.Map(document.getElementById('map'), {
				center: {lat: 0, lng: 0},
				zoom: 3
			});

			// Create a marker object
			var marker = new google.maps.Marker({
				map: map,
				draggable: true
			});

			// Hide the marker initially
			marker.setVisible(false);

			// Add click event listener to the map
			map.addListener('click', function (event) {
				document.getElementById('latitude').value = event.latLng.lat();
				document.getElementById('longitude').value = event.latLng.lng();


				getAddress(event.latLng.lat(), event.latLng.lng());

				// Update the marker position and show it
				marker.setPosition(event.latLng);
				marker.setVisible(true);


			});

			// Update latitude and longitude fields when the marker is dragged
			marker.addListener('dragend', function (event) {
				document.getElementById('latitude').value = event.latLng.lat();
				document.getElementById('longitude').value = event.latLng.lng();
			});
		}

		function getAddress(lat, lon) {

			const latlng = {
				lat: lat,
				lng: lon,
			};

			var geocoder = new google.maps.Geocoder();

			geocoder.geocode({location: latlng})
				.then((response) => {
					document.getElementById('address').value = response.results[0].formatted_address;
					document.getElementById('address-fake').value = response.results[0].formatted_address;
				})
				.catch((e) => window.alert("Geocoder failed due to: " + e));
		}
	</script>
	<script src="frontend/js/bootstrap.min.js"></script>
</body>
</html>