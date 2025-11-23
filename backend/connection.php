<?php
$conn = new mysqli('localhost', 'root', '', 'bellhouse_db');
if ($conn->connect_error) {
    die('Database connection error: ' . $conn->connect_error);
}
?>

