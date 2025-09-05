<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
$host = 'localhost';
$dbname = 'help_the_homeless';
$username = 'root'; // No username required for root if no password is se
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}



