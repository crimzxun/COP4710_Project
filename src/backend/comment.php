<!-- COMMENT FUNCTIONS -->

<?php

include 'dbconn.php';

function add_comment($userId, $eventId, $content) {

    //Get connection
    $dbConn = db_get_connection();

    $stmt = $dbConn->prepare('INSERT INTO comments (UserID, EventID, Content) VALUES (:userId, :eventId, :content)');
    $stmt->bindParam(':userId', $userId);
    $stmt->bindParam(':eventId', $eventId);
    $stmt->bindParam(':content', $content);

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

function edit_comment($commentID, $newContent) {

    //Get connection
    $dbConn = db_get_connection();

    $stmt = $dbConn->prepare('UPDATE comments SET Content = :newContent WHERE CommentID = :commentID');
    $stmt->bindParam(':commentID', $commentID);
    $stmt->bindParam(':newContent', $newContent);

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