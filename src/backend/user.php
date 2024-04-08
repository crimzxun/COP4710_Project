<!-- USER FUNCTIONS -->

<?php

include_once 'dbconn.php';

function get_user_by_email($universityId, $userEmail) {

    //Get connection
    $dbConn = db_get_connection();

    $stmt = $dbConn->prepare("SELECT * FROM Users WHERE UniversityID = :universityId AND Email = :email");
    $stmt->bindParam(':universityId', $universityId);
    $stmt->bindParam(':email', $userEmail);
    $stmt->execute();

    $user = $stmt->fetch();

    return $user;
}

function user_email_exists($email) {

    //Get connection
    $dbConn = db_get_connection();

    //Get the rating of the event
    $statement = 'SELECT COUNT(*) FROM Users WHERE Email = :email';

    $stmt = $dbConn->prepare($statement);
    $stmt->bindParam(':email', $email);

    //Execute the statement
    $stmt->execute();

    //Get the result
    $count = $stmt->fetchColumn();

    //Get the result
    return $count > 0;
}

function get_user_by_id($universityId, $userId) {

    //Get connection
    $dbConn = db_get_connection();

    $stmt = $dbConn->prepare("SELECT * FROM Users WHERE UniversityID = :universityId AND UserID = :userId");
    $stmt->bindParam(':universityId', $universityId);
    $stmt->bindParam(':userId', $userId);
    $stmt->execute();

    $user = $stmt->fetch();

    return $user;
}

function create_user($email, $password, $fullName, $universityId) {

    //Get connection
    $dbConn = db_get_connection();

    //Hash the password
    //$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    //Create the statement.
    $statement = 'INSERT INTO Users (Email, Password, FullName, UniversityID) VALUES (:email, :password, :fullName, :universityID)';

    $stmt = $dbConn->prepare($statement);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':fullName', $fullName);
    $stmt->bindParam(':universityID', $universityId);
    $userId = $dbConn->lastInsertId();

    //Execute the statement
    $stmt->execute();

    return $userId;
}

?>
