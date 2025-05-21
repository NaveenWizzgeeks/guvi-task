<?php

$host = "guvi.cz8ugi66ap5w.eu-north-1.rds.amazonaws.com";
$dbname = "guvi";
$username = "admin";
$password = "Admin123";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die(json_encode(["success" => false, "message" => "MySQL connection failed: " . $e->getMessage()]));
}
?>
