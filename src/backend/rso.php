<!-- RSO FUNCTIONS -->

<?php

include 'dbconn.php';
include 'users.php';

function check_exists($universityId, $rsoName) {

    //Get the rso
    $rso = get_rsoid($universityId, $rsoName);

    return $rso == null;

}

function get_all_rsos($universityId) {

    //Get connection
    $dbConn = db_get_connection();

    // Fetch RSOs for the user's university
    $stmt = $dbConn->prepare('SELECT * FROM RSOs WHERE UniversityID = :university_id');
    $stmt->execute(['university_id' => $universityId]);
    $rsos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return$rsos;
}

function get_rso($universityId, $rsoId) {

    //Get connection
    $dbConn = db_get_connection();

    //Get the event
    $statement = 'SELECT * FROM rsos WHERE RSOID = :rsoId AND UniversityID = :universityId';

    $stmt = $dbConn->prepare($statement);
    $stmt->bindParam(':rsoId', $rsoId);
    $stmt->bindParam(':universityId', $universityId);

    //Execute the statement
    $stmt->execute();

    //Get the result
    $rso = $stmt->fetch();

    return $rso;
}


function get_rsoid($universityId, $rsoName) {

    //Get connection
    $dbConn = db_get_connection();

    //Get the event
    $statement = 'SELECT * FROM rsos WHERE Name = :rsoName AND UniversityID = :universityId';

    $stmt = $dbConn->prepare($statement);
    $stmt->bindParam(':rsoName', $rsoName);
    $stmt->bindParam(':universityId', $universityId);

    //Execute the statement
    $stmt->execute();

    //Get the result
    $rso = $stmt->fetch();

    return $rso;
}


function create_rso($universityId, $rsoName, $rsoDescription, $rsoImage, $adminId, $memberEmails) {

    //Get connection
    $dbConn = db_get_connection();

    // Insert the RSO
    $stmt = $dbConn->prepare("INSERT INTO RSOs (Name, AdminID, Description, ImageURL, UniversityID) VALUES (:name, :adminID, :rsoDescription,:rsoImage, :universityID)");
    $stmt->bindParam(':name', $rsoName);
    $stmt->bindParam(':rsoDescription', $rsoDescription);
    $stmt->bindParam(':rsoImage', $rsoImage);
    $stmt->bindParam(':adminID', $adminId);
    $stmt->bindParam(':universityID', $universityId);
    $stmt->execute();
    $rsoID = $dbConn->lastInsertId();

    // Get UserIDs for member email addresses
    foreach ($memberEmails as $email) {

        //Get the user
        $user = get_user_by_email($universityId, $email);

        //Check that theyre in the domain
        if ($user == null)
            continue;

        //Add the user to the RSO
        add_member($rsoID, $user["UserID"]);
    }
}

function update_rso($universityId, $rsoId, $rsoName, $adminId, $memberEmails) {

    //Get connection
    $dbConn = db_get_connection();

    //Get the RSO
    $rso = get_rso($universityId, $rsoId);

    //Check if name is taken
    if ($rso["Name"] != $rsoName)
        if (get_rsoid($universityId, $rsoName))
        return false;

    //Get the members
    $rsoCurrentMembers = get_members($rsoId);

    //Remove all members
    foreach ($rsoCurrentMembers as $rsoMember) {
        remove_member($rsoId, $rsoMember["UserID"]);
    }

    //Add all the members
    foreach ($memberEmails as $email) {

        //Get the user
        $user = get_user_by_email($universityId, $email);

        //Check that theyre in the domain
        if ($user == null)
            continue;

        //Add the user to the RSO
        add_member($rsoId, $user["UserID"]);
    }

    //Update admin and name
    $stmt = $dbConn->prepare('UPDATE rsos SET Name = :rsoName, AdminID = :adminId WHERE UniversityID = :universityId AND RSOID = :rsoId');
    $stmt->bindParam(':rsoName', $rsoName);
    $stmt->bindParam(':adminId', $adminId);
    $stmt->bindParam(':universityId', $universityId);
    $stmt->bindParam(':rsoId', $rsoId);

    //Execute the statement
    $stmt->execute();
}

function get_user_rso_admin($universityId, $userId) {

    //Get connection
    $dbConn = db_get_connection();

    // Fetch RSOs for the user's university
    $stmt = $dbConn->prepare('SELECT * FROM RSOs WHERE UniversityID = :universityId AND AdminID = :adminId');
    $stmt->bindParam(':universityId', $universityId);
    $stmt->bindParam(':adminId', $userId);

    $stmt->execute();

    $rsos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return$rsos;
}


function get_members($rsoId) {

    //Get connection
    $dbConn = db_get_connection();

    //Get the rating of the event
    $statement = 'SELECT * FROM rsomembers WHERE RSOID = :rsoId';

    $stmt = $dbConn->prepare($statement);
    $stmt->bindParam(':rsoId', $rsoId);

    //Execute the statement
    $stmt->execute();

    //Get the result
    return $stmt->fetchAll();
}

function check_admin($universityId, $rsoId, $userId) {

    //Get the RSO
    $rso = get_rso($universityId, $rsoId);

    //Return the status
    return $rso["AdminID"] == $userId;
}

function check_membership($universityId, $rsoId, $userId) {

    //Get connection
    $dbConn = db_get_connection();

    //Get the rating of the event
    $statement = 'SELECT COUNT(*) FROM rsomembers WHERE RSOID = :rsoId AND UserID = :userId';

    $stmt = $dbConn->prepare($statement);
    $stmt->bindParam(':rsoId', $rsoId);
    $stmt->bindParam(':userId', $userId);

    //Execute the statement
    $stmt->execute();

    //Get the result
    $count = $stmt->fetchColumn();

    //Get the result
    return $count > 0;
}

function add_member($rsoId, $newMemberId) {

    //Get connection
    $dbConn = db_get_connection();

    // Add members to the RSOMembers table
    $stmt = $dbConn->prepare("INSERT INTO RSOMembers (UserID, RSOID) VALUES (:userID, :rsoID)");

    $stmt->bindParam(':userID', $newMemberId);
    $stmt->bindParam(':rsoID', $rsoId);
    $stmt->execute();
}

function remove_member($rsoId, $memberId) {

    //Get connection
    $dbConn = db_get_connection();

    // Add members to the RSOMembers table
    $stmt = $dbConn->prepare("DELETE FROM RSOMembers WHERE UserID = :userId AND RSOID = :rsoId");

    $stmt->bindParam(':userId', $memberId);
    $stmt->bindParam(':rsoId', $rsoId);
    $stmt->execute();
}

?>