<!-- CONNECT TO DATABASE -->
<?php

function db_get_connection() {
    $dbConn = null;

    $host = '127.0.0.1';
    $db = 'UniversityEventSite';
    $user = 'UniversityEventSite';
    $pass = 'UniversityEventSite';
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    try {
        $dbConn = new PDO($dsn, $user, $pass, $options);
        return $dbConn;

    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }
}
?>