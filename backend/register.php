<?php
include 'cors.php';
include 'db.php';

$data = json_decode(file_get_contents("php://input"), true);
$username = $data['username'];
$email = $data['email'];
$password = password_hash($data['password'], PASSWORD_BCRYPT);

try {
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);

    if ($stmt->rowCount() > 0) {
        echo json_encode(["success" => false, "message" => "Email already registered"]);
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
    $stmt->execute(['username' => $username, 'email' => $email, 'password' => $password]);

    echo json_encode(["success" => true, "message" => "Registration successful"]);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
?>
