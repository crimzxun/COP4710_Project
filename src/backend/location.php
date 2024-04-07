<!-- LOCATION FUNCTIONS -->

<?php

include 'dbconn.php';

function create_location($name, $latitude, $longitude) {

	//Get connection
	$dbConn = db_get_connection();

	// Add members to the RSOMembers table
	$stmt = $dbConn->prepare("INSERT INTO locations (Name, Latitude, Longitude) VALUES (:name, :latitude, :longitude)");

	$stmt->bindParam(':name', $name);
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