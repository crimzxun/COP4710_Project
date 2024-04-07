<!-- UNIVERSITY FUNCTIONS -->

<?php

include 'dbconn.php';

function get_university($universityId) {

    //Get connection
    $dbConn = db_get_connection();

    $stmt = $dbConn->prepare("SELECT * FROM Universities WHERE UniversityID = :universityId");
    $stmt->bindParam(':universityId', $universityId);
    $stmt->execute();

    $user = $stmt->fetch();

    return $user;
}

function get_all_universities() {

    //Get connection
    $dbConn = db_get_connection();

    // Fetch RSOs for the user's university
    $stmt = $dbConn->prepare('SELECT * FROM Universities');
    $stmt->execute();
    $unis = $stmt->fetchAll();

    return $unis;
}

function check_superadmin($universityId, $userId) {

    //Get the uni
    $uni = get_university($universityId);

    return $uni["AdminID"] == $userId;
}

?>