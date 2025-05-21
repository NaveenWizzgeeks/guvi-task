<?php

header('Content-Type: application/json');

require 'mongo.php';
require 'redis.php';

$data = json_decode(file_get_contents("php://input"), true);
$token = $data['token'] ?? null;
$action = $data['action'] ?? 'get';

if (!$token) {
    echo json_encode(["success" => false, "message" => "Missing session token."]);
    exit;
}

$username = $redis->get("session:$token");

if (!$username) {
    echo json_encode(["success" => false, "message" => "Invalid or expired session token."]);
    exit;
}

try {
    $usersCollection = $mongoDB->users;

    if ($action === "get") {
        $profile = $usersCollection->findOne(["username" => $username]);

        if ($profile) {
            unset($profile['_id']);
            echo json_encode(["success" => true, "profile" => $profile]);
        } else {
            echo json_encode(["success" => false, "message" => "User profile not found."]);
        }

    } elseif ($action === "update") {
        $age = trim($data['age'] ?? '');
        $dob = trim($data['dob'] ?? '');
        $contact = trim($data['contact'] ?? '');

        $updateResult = $usersCollection->updateOne(
            ["username" => $username],
            ['$set' => [
                "age" => $age,
                "dob" => $dob,
                "contact" => $contact
            ]]
        );

        echo json_encode(["success" => true, "message" => "Profile updated successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Invalid action."]);
    }

} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "MongoDB error: " . $e->getMessage()]);
}
?>
