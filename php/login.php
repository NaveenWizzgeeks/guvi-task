<?php
header('Content-Type: application/json');

require 'sql.php';
require 'mongo.php'; 
require 'redis.php';

$data = json_decode(file_get_contents("php://input"), true);
$username = trim($data['username'] ?? '');
$password = trim($data['password'] ?? '');

if (!$username || !$password) {
    echo json_encode(["success" => false, "message" => "Username and password are required."]);
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT * FROM users1 WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user || !password_verify($password, $user['password'])) {
        echo json_encode(["success" => false, "message" => "Invalid credentials."]);
        exit;
    }

    $profile = $mongoDB->users->findOne(['username' => $username]);

    $token = bin2hex(random_bytes(32));

    $redis->set("token:$token", $username);
    $redis->expire("token:$token", 3600 * 24);

    echo json_encode([
        "success" => true,
        "message" => "Login successful.",
        "token" => $token,
        "profile" => $profile
    ]);

} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "MySQL error: " . $e->getMessage()]);
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "Error: " . $e->getMessage()]);
}
