<!-- AUTHENTICATE LOGIN -->
<?php
include '../dashboard.php';
function auth_login($email, $password) {

    session_start();
    //Get connection
    $dbConn = db_get_connection();

    //Create the statement.
    $statement = 'SELECT UserID, Password, FullName, UniversityID FROM Users WHERE Email = :email';

    $stmt = $dbConn->prepare($statement);
    $stmt->bindParam(':email', $email);

    //Execute the statement
    $stmt->execute();

    //Get the result
    $queryResult = $stmt->fetch();

    echo $queryResult["Password"];

    //Check validity!
    if ($queryResult["UserID"] == null || $queryResult["Password"] == null) {
        header("Location: index.php?error=invalid_credentials");
        return false;

    }else if (!password_verify($password, $queryResult["Password"])) {
        header("Location: index.php?error=invalid_credentials");
        //return false;
    } else {
        $_SESSION["user_id"] = $queryResult["UserID"];
        $_SESSION["user_universityid"] = $queryResult["UniversityID"];
        $_SESSION["user_fullname"] = $queryResult["FullName"];
        header("Location: dashboard.php");
        exit;
        
    }

    //return true;
}

?>