<?php
header('Content-Type: application/json');

require 'sql.php'; 
require 'mongo.php';
require 'redis.php';

$data = json_decode(file_get_contents("php://input"), true);
$username = trim($data['username'] ?? '');
$password = trim($data['password'] ?? '');
$age      = trim($data['age'] ?? '');
$dob      = trim($data['dob'] ?? '');
$contact  = trim($data['contact'] ?? '');

if (!$username || !$password) {
    echo json_encode(["success" => false, "message" => "Username and password are required."]);
    exit;
}

try {
    $stmt = $pdo->prepare("INSERT INTO users1 (username, password) VALUES (?, ?)");
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt->execute([$username, $hashedPassword]);

    $userProfile = [
        "username" => $username,
        "age" => $age,
        "dob" => $dob,
        "contact" => $contact
    ];
    $mongoDB->users->insertOne($userProfile);

    echo json_encode(["success" => true, "message" => "User registered successfully."]);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "MySQL error: " . $e->getMessage()]);
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "MongoDB error: " . $e->getMessage()]);
}
?>
