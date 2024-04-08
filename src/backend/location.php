<!-- LOCATION FUNCTIONS -->

<?php

include 'dbconn.php';

function create_location($place, $latitude, $longitude) {

	//Get connection
	$dbConn = db_get_connection();

	// Add members to the RSOMembers table
	$stmt = $dbConn->prepare("INSERT INTO locations (Place, Latitude, Longitude) VALUES (:place, :latitude, :longitude)");

	$stmt->bindParam(':place', $place);
	$stmt->bindParam(':latitude', $latitude);
	$stmt->bindParam(':longitude', $longitude);
	$stmt->execute();

	return $dbConn->lastInsertId();
}

function get_location($locationid) {

	//Get connection
	$dbConn = db_get_connection();

	//Get the rating of the event
	$statement = 'SELECT * FROM locations WHERE LocationID = :locationid';

	$stmt = $dbConn->prepare($statement);
	$stmt->bindParam(':locationid', $locationid);

	//Execute the statement
	$stmt->execute();

	//Get the result
	return $stmt->fetch();
}

?>