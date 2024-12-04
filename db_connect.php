<?php
$host = 'localhost';
$username = 'root';
$password = 'Rohit213$'; // Usually, the default XAMPP password is empty
$database = 'project2';
$port = 3307;

try {
    $db = new mysqli($host, $username, $password, $database, $port);
    if ($db->connect_error) {
        throw new Exception("Connection failed: " . $db->connect_error);
    }
} catch (Exception $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>