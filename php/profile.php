<?php
header('Content-Type: application/json');

require 'mongo.php';
require 'redis.php';

$data = json_decode(file_get_contents("php://input"), true);
$token = $data['token'] ?? '';
$action = $data['action'] ?? '';

if (!$token) {
    echo json_encode(["success" => false, "message" => "Token missing"]);
    exit;
}

$username = $redis->get("token:$token");

if (!$username) {
    echo json_encode(["success" => false, "message" => "Token has expired or is invalid."]);
    exit;
}

$collection = $mongoDB->users;

if ($action === 'get') {
    $user = $collection->findOne(["username" => $username]);

    if ($user) {
        echo json_encode([
            "success" => true,
            "profile" => [
                "username" => $user['username'],
                "age" => $user['age'] ?? '',
                "dob" => $user['dob'] ?? '',
                "contact" => $user['contact'] ?? ''
            ]
        ]);
    } else {
        echo json_encode(["success" => false, "message" => "User not found."]);
    }
} elseif ($action === 'update') {
    $updateFields = [];

    if (!empty($data['age'])) $updateFields['age'] = $data['age'];
    if (!empty($data['dob'])) $updateFields['dob'] = $data['dob'];
    if (!empty($data['contact'])) $updateFields['contact'] = $data['contact'];

    $collection->updateOne(
        ['username' => $username],
        ['$set' => $updateFields]
    );

    echo json_encode(["success" => true, "message" => "Profile updated successfully."]);
} else {
    echo json_encode(["success" => false, "message" => "Invalid action."]);
}
