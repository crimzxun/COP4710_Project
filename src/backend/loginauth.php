<?php
function auth_login($email, $password) {

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

//echo $queryResult["Password"];

//Check validity!
if ($queryResult["UserID"] == null || $queryResult["Password"] == null) {
    return false;

}else if (($password != $queryResult["Password"])) {
    //echo $queryResult["Password"];
    return false;
} else {
    //echo $queryResult["Password"];
    $_SESSION["user_id"] = $queryResult["UserID"];
    $_SESSION["user_universityid"] = $queryResult["UniversityID"];
    $_SESSION["user_fullname"] = $queryResult["FullName"];
    //echo $_SESSION["user_fullname"] ;
    header("Location: ../src/dashboard.php");
}

return true;
}
