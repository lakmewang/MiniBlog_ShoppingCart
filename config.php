<?php
// Database connection settings
$host = 'localhost';  // Change if your database is hosted elsewhere
$db = 'mini_blog_cart';  // Database name
$user = 'root';  // Default XAMPP username
$pass = '';  // Default XAMPP password is empty

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Start the session
session_start();
?>
