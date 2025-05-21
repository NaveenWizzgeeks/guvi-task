<?php

require 'vendor/autoload.php'; 

$mongoURI = "mongodb+srv://naveenkumar:medsy@medsy.vu7dt.mongodb.net/";
$databaseName = "taskdb";

try {
    $client = new MongoDB\Client($mongoURI);
    $mongoDB = $client->$databaseName;
} catch (Exception $e) {
    die(json_encode(["success" => false, "message" => "MongoDB connection failed: " . $e->getMessage()]));
}
?>


<!-- 
sudo apt install php-cli unzip
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
cd /var/www/html/php
composer require mongodb/mongodb -->