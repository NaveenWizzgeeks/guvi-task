<?php

$host = "host";
$dbname = "taskdb";
$username = "user";
$password = "password";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die(json_encode(["success" => false, "message" => "MySQL connection failed: " . $e->getMessage()]));
}
?>
