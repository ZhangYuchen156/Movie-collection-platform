<?php
session_start();
error_reporting(0);
ini_set('display_errors', 0);

$host = "localhost";
$dbname = "movie_collect";
$user = "root";
$pass = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo json_encode(["success" => false, "message" => "Database connection failed!"]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    if (empty($username) || empty($password)) {
        echo json_encode(["success" => false, "message" => "All fields are required!"]);
        exit;
    }

    $stmt = $pdo->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $username;

        echo json_encode(["success" => true]);
        exit;
    } else {
        echo json_encode(["success" => false, "message" => "❌ Invalid username or password!"]);
        exit;
    }
}

echo json_encode(["success" => false, "message" => "Invalid request!"]);
?>