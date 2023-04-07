<?php 
require __DIR__ . '/models/Database.php';
require __DIR__ . '/config.php';

// database PDO object
$db_handle = new PDO
(
    'mysql:host='. MYSQL_HOST .
    ';dbname='. MYSQL_DB .
    ';charset=utf8mb4', 
    MYSQL_USER, 
    MYSQL_PASS, 
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, 
        PDO::MYSQL_ATTR_LOCAL_INFILE => true
    ]
);

// core DB library
$db = new DB($db_handle);
?>