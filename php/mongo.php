<?php

require __DIR__ . '/../vendor/autoload.php';

$mongoURI = "mongodb+srv://naveenkumar:medsy@medsy.vu7dt.mongodb.net/";
$databaseName = "taskdb";

try {
    $client = new MongoDB\Client($mongoURI);
    $mongoDB = $client->$databaseName;
} catch (Exception $e) {
    die(json_encode(["success" => false, "message" => "MongoDB connection failed: " . $e->getMessage()]));
}
