<?php

require __DIR__ . '/../vendor/autoload.php';



use Dotenv\Dotenv;


$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();


$host = $_ENV['SQL_HOST'];
$dbname = $_ENV['SQL_DBNAME'];
$username = $_ENV['SQL_USERNAME'];
$password = $_ENV['SQL_PASSWORD'];


try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die(json_encode(["success" => false, "message" => "MySQL connection failed: " . $e->getMessage()]));
}
?>
