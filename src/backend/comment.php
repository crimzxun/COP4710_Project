<!-- COMMENT FUNCTIONS -->

<?php

include_once 'dbconn.php';

function add_comment($userId, $eventId, $context, $stars) {

    //Get connection
    $dbConn = db_get_connection();

    $stmt = $dbConn->prepare('INSERT INTO comments (UserID, EventID, Context, Rating) VALUES (:userId, :eventId, :context, :rating)');
    $stmt->bindParam(':userId', $userId);
    $stmt->bindParam(':eventId', $eventId);
    $stmt->bindParam(':context', $context);
    $stmt->bindParam(':rating', $stars);

    //Execute the statement
    $stmt->execute();

    //Get the result
    return $stmt->fetch();
}

function get_all_comments($eventId) {

    //Get connection
    $dbConn = db_get_connection();

    //Get the rating of the event
    $statement = 'SELECT * FROM comments WHERE EventID = :eventId';

    $stmt = $dbConn->prepare($statement);
    $stmt->bindParam(':eventId', $eventId);

    //Execute the statement
    $stmt->execute();

    //Get the result
    return $stmt->fetchAll();
}


function delete_comment($commentID) {

    //Get connection
    $dbConn = db_get_connection();

    //Get the rating of the event
    $statement = 'DELETE FROM comments WHERE commentID = :commentID';

    $stmt = $dbConn->prepare($statement);
    $stmt->bindParam(':commentID', $commentID);

    //Execute the statement
    $stmt->execute();

    //Get the result
    return $stmt->fetch();
}

function edit_comment($commentID, $newContext) {

    //Get connection
    $dbConn = db_get_connection();

    $stmt = $dbConn->prepare('UPDATE comments SET Context = :newContext WHERE CommentID = :commentID');
    $stmt->bindParam(':commentID', $commentID);
    $stmt->bindParam(':newContext', $newContext);
    // $stmt->bindParam(':newRating', $newRating);

    //Execute the statement
    $stmt->execute();

    //Get the result
    return $stmt->fetch();
}

function get_all_user_comments($userId, $eventId) {

    //Get connection
    $dbConn = db_get_connection();
    
    // Insert the RSO
    $stmt = $dbConn->prepare('SELECT * FROM comments WHERE (UserId = :userId) AND (EventID = :eventId)');
    $stmt->bindParam(':userId', $userId);
    $stmt->bindParam(':eventId', $eventId);

    //Execute the statement
    $stmt->execute();

    //Get the result
    //$count = $stmt->fetchColumn();
        
    return $stmt->fetchAll();
}

?>