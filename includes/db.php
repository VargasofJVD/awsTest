// includes/db.php

<?php
$host = 'localhost';
$dbname = 'animals_db';
$username = 'root';  // This is XAMPP's default username
$password = '';      // XAMPP's default password is blank

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>