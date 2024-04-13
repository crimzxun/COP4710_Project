<?php

include_once 'dbconn.php';
include_once 'university.php';
include_once 'user.php';

function check_exists($universityId, $rsoName) {
    // Get the rso
    $rso = get_rsoid($universityId, $rsoName);
    return $rso == null;
}

function get_all_rsos($universityId) {
    // Get connection
    $dbConn = db_get_connection();

    // Fetch RSOs for the user's university
    $stmt = $dbConn->prepare('SELECT * FROM rsos WHERE UniversityID = :university_id');
    $stmt->execute(['university_id' => $universityId]);
    $rsos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $rsos;
}

function get_rso($universityId, $rsoId) {
    // Get connection
    $dbConn = db_get_connection();

    // Get the event
    $statement = 'SELECT * FROM rsos WHERE RSOID = :rsoId AND UniversityID = :universityId';

    $stmt = $dbConn->prepare($statement);
    $stmt->bindParam(':rsoId', $rsoId);
    $stmt->bindParam(':universityId', $universityId);

    // Execute the statement
    $stmt->execute();

    // Get the result
    $rso = $stmt->fetch();

    return $rso;
}

function get_rsoid($universityId, $rsoName) {
    // Get connection
    $dbConn = db_get_connection();

    // Get the event
    $statement = 'SELECT * FROM rsos WHERE Name = :rsoName AND UniversityID = :universityId';

    $stmt = $dbConn->prepare($statement);
    $stmt->bindParam(':rsoName', $rsoName);
    $stmt->bindParam(':universityId', $universityId);

    // Execute the statement
    $stmt->execute();

    // Get the result
    $rso = $stmt->fetch();

    return $rso;
}

function create_rso($universityId, $rsoName, $rsoDescription, $rsoImage, $memberEmails, $adminEmail) {
    // Get connection
    $dbConn = db_get_connection();
    $universityINT = (int)$universityId;
    // Insert the RSO
    $stmt = $dbConn->prepare("INSERT INTO rsos (Name, Description, ImageURL, UniversityID) VALUES (:name, :rsoDescription, :rsoImage, :universityID)");

    $stmt->bindParam(':name', $rsoName);
    $stmt->bindParam(':rsoDescription', $rsoDescription);
    $stmt->bindParam(':rsoImage', $rsoImage);
    $stmt->bindParam(':universityID', $universityINT);

    if (!$stmt->execute()) {
        // Handle the error
        $errorInfo = $stmt->errorInfo();
        echo "Error: " . $errorInfo[2];
        return;
    }

    $rsoID = $dbConn->lastInsertId();

    // Get UserIDs for member email addresses
    foreach ($memberEmails as $email) {
        // Get the user
        $user = get_user_by_email($universityId, $email);

        // Check that they're in the domain
        if ($user == null)
            continue;

        // Add the user to the RSO
        add_member($rsoID, $user["UserID"]);
        header("Location: dashboard.php");
    }
}

function update_rso($universityId, $rsoId, $rsoName, $adminId, $memberEmails) {
    // Get connection
    $dbConn = db_get_connection();

    // Get the RSO
    $rso = get_rso($universityId, $rsoId);

    // Check if name is taken
    if ($rso["Name"] != $rsoName)
        if (get_rsoid($universityId, $rsoName))
        return false;

    // Get the members
    $rsoCurrentMembers = get_members($rsoId);

    // Remove all members
    foreach ($rsoCurrentMembers as $rsoMember) {
        remove_member($rsoId, $rsoMember["UserID"]);
    }

    // Add all the members
    foreach ($memberEmails as $email) {
        // Get the user
        $user = get_user_by_email($universityId, $email);

        // Check that they're in the domain
        if ($user == null)
            continue;

        // Add the user to the RSO
        add_member($rsoId, $user["UserID"]);
    }

    // Update admin and name
    $stmt = $dbConn->prepare('UPDATE rsos SET Name = :rsoName, AdminID = :adminId WHERE UniversityID = :universityId AND RSOID = :rsoId');
    $stmt->bindParam(':rsoName', $rsoName);
    $stmt->bindParam(':adminId', $adminId);
    $stmt->bindParam(':universityId', $universityId);
    $stmt->bindParam(':rsoId', $rsoId);

    // Execute the statement
    $stmt->execute();
}

function get_user_rso_admin($universityId, $userId) {
    // Get connection
    $dbConn = db_get_connection();

    // Fetch RSOs for the user's university
    $stmt = $dbConn->prepare('SELECT * FROM RSOs WHERE UniversityID = :universityId AND AdminID = :adminId');
    $stmt->bindParam(':universityId', $universityId);
    $stmt->bindParam(':adminId', $userId);

    $stmt->execute();

    $rsos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $rsos;
}

function get_members($rsoId) {
    // Get connection
    $dbConn = db_get_connection();

    // Get the rating of the event
    $statement = 'SELECT * FROM rsomembers WHERE RSOID = :rsoId';

    $stmt = $dbConn->prepare($statement);
    $stmt->bindParam(':rsoId', $rsoId);

    // Execute the statement
    $stmt->execute();

    // Get the result
    return $stmt->fetchAll();
}

function check_admin($rsoId, $userId) {
    $dbConn = db_get_connection();

    $statement = 'SELECT * FROM `admin` WHERE RSOID = :rsoId';

    $stmt = $dbConn->prepare($statement);
    $stmt->bindParam(':rsoId', $rsoId);

    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Return the status
    if ($result && $result['UserID'] === $userId) {
        return true; // User is an admin for the specified RSO
    } else {
        return false; // User is not an admin for the specified RSO
    }
}

function check_membership($rsoId, $userId) {
    // Get connection
    $dbConn = db_get_connection();

    // Get the rating of the event
    $statement = 'SELECT COUNT(*) FROM rsomembers WHERE RSOID = :rsoId AND UserID = :userId';

    $stmt = $dbConn->prepare($statement);
    $stmt->bindParam(':rsoId', $rsoId);
    $stmt->bindParam(':userId', $userId);

    // Execute the statement
    $stmt->execute();

    // Get the result
    $count = $stmt->fetchColumn();

    // Get the result
    return $count > 0;
}

function add_member($rsoId, $newMemberId) {
    // Get connection
    $dbConn = db_get_connection();

    // Add members to the RSOMembers table
    $stmt = $dbConn->prepare("INSERT INTO RSOMembers (UserID, RSOID) VALUES (:userID, :rsoID)");

    $stmt->bindParam(':userID', $newMemberId);
    $stmt->bindParam(':rsoID', $rsoId);
    $stmt->execute();
}

function remove_member($rsoId, $memberId) {
    // Get connection
    $dbConn = db_get_connection();

    // Add members to the RSOMembers table
    $stmt = $dbConn->prepare("DELETE FROM RSOMembers WHERE UserID = :userId AND RSOID = :rsoId");

    $stmt->bindParam(':userId', $memberId);
    $stmt->bindParam(':rsoId', $rsoId);
    $stmt->execute();
}

function is_rso_admin($universityId, $rsoId, $userId) {
    // Get connection
    $dbConn = db_get_connection();

    // Prepare and execute query
    $stmt = $dbConn->prepare('SELECT * FROM rsos WHERE RSOID = :rsoId AND UniversityID = :universityId AND AdminID = :userId');
    $stmt->bindParam(':rsoId', $rsoId);
    $stmt->bindParam(':universityId', $universityId);
    $stmt->bindParam(':userId', $userId);
    $stmt->execute();

    // Fetch result
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Return true if the user is an admin of the RSO, otherwise false
    return $result !== false;
}

?>