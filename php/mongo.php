<?php

require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;


$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();


$mongoURI = $_ENV['MONGO_DB_URI'];
$databaseName = $_ENV['MONGO_DB_NAME'];


try {
    $client = new MongoDB\Client($mongoURI);
    $mongoDB = $client->$databaseName;
} catch (Exception $e) {
    die(json_encode(["success" => false, "message" => "MongoDB connection failed: " . $e->getMessage()]));
}
