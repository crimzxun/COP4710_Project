<!-- EVENT FUNCTIONS -->

<?php

include 'location.php';

function create_event($universityId, $eventName, $category, $description, $time, $date, $latitude, $longitude, $address, $contactPhone, $contactEmail, $eventType, $rsoID) {

    //Get connection
    $dbConn = db_get_connection();
    //Create the location
    $locationId = create_location($address, $latitude, $longitude);

    if ($eventType != 'rso')
        $rsoID = null;

    $stmt = $dbConn->prepare("INSERT INTO events (Name, Category, Description, Time, Date, LocationID, ContactPhone, ContactEmail, EventType, RSOID, UniversityID, Approved) VALUES (:eventName, :category, :description, :time, :date, :locationId, :contactPhone, :contactEmail, :eventType, :rsoID, :universityID, true)");
    $stmt->bindParam(':eventName', $eventName);
    $stmt->bindParam(':category', $category);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':time', $time);
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':locationId', $locationId);
    $stmt->bindParam(':contactPhone', $contactPhone);
    $stmt->bindParam(':contactEmail', $contactEmail);
    $stmt->bindParam(':eventType', $eventType);
    $stmt->bindParam(':rsoID', $rsoID);
    $stmt->bindParam(':universityID', $universityId);

    $stmt->execute();
}

function get_all_events($universityId) {

    //Get connection
    $dbConn = db_get_connection();

    $stmt = $dbConn->prepare('SELECT * FROM events WHERE UniversityID = :university_id ORDER BY Date ASC');
    $stmt->execute(['university_id' => $universityId]);
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $events;
}

function get_event($universityId, $eventId)
{
    //Get connection
    $dbConn = db_get_connection();

    $statement = 'SELECT * FROM events WHERE EventID = :eventId AND UniversityID = :universityId';
    $stmt = $dbConn->prepare($statement);
    $stmt->bindParam(':universityId', $universityId);
    $stmt->bindParam(':eventId', $eventId);
    $stmt->execute();

    return $stmt->fetch();
}

function approve_event($universityId, $eventId)
{
    //Get connection
    $dbConn = db_get_connection();

    $stmt = $dbConn->prepare('UPDATE events SET Approved = 1 WHERE UniversityID = :universityId AND EventID = :eventId');
    $stmt->bindParam(':universityId', $universityId);
    $stmt->bindParam(':eventId', $eventId);
    $stmt->execute();

    return $stmt->fetch();
}

// function get_event_rating($eventId) {

//     //Get connection
//     $dbConn = db_get_connection();

//     //Get the rating of the event
//     $statement = 'SELECT AVG(Stars) FROM Ratings WHERE EventID = :eventId';

//     $stmt = $dbConn->prepare($statement);
//     $stmt->bindParam(':eventId', $eventId);

//     //Execute the statement
//     $stmt->execute();

//     //Get the result
//     $rating = $stmt->fetchColumn();

//     if ($rating == null)
//         $rating = 0;

//     return $rating;
// }

// function set_event_rating($eventId, $userId, $rating) {

//     //Get connection
//     $dbConn = db_get_connection();

//     try {
//         // Insert the RSO
//         $stmt = $dbConn->prepare('SELECT COUNT(*) FROM ratings WHERE UserId = :userId AND EventID = :eventId');
//         $stmt->bindParam(':userId', $userId);
//         $stmt->bindParam(':eventId', $eventId);

//         //Execute the statement
//         $stmt->execute();

//         //Get the result
//         $count = $stmt->fetchColumn();

//         //If its not zero, it already exists!
//         if ($count == 0) {
//             $stmt = $dbConn->prepare('INSERT INTO ratings (UserID, EventID, Stars) VALUES (:userId, :eventId, :rating)');
//             $stmt->bindParam(':userId', $userId);
//             $stmt->bindParam(':eventId', $eventId);
//             $stmt->bindParam(':rating', $rating);

//             //Execute the statement
//             $stmt->execute();

//         } else {
//             $stmt = $dbConn->prepare('UPDATE ratings SET Stars = :rating WHERE UserID = :userId AND EventID = :eventId');
//             $stmt->bindParam(':userId', $userId);
//             $stmt->bindParam(':eventId', $eventId);
//             $stmt->bindParam(':rating', $rating);

//             //Execute the statement
//             $stmt->execute();
//         }

//         $stmt->execute();

//     } catch (PDOException $e) {
//         $error = "Error creating RSO: " . $e->getMessage();
//         echo $error;
//     }
// }

?>