<?php
$host = 'localhost';
$dbname = 'dbkhngvdfanb5z';
$username = 'urnrgaote95vf';
$password = 'tgk9ztof7xb1';

try {
    $conn = new mysqli($host, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
} catch (Exception $e) {
    die("Database connection error: " . $e->getMessage());
}
?>
