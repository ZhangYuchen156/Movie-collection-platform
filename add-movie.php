<?php
header('Content-Type: text/plain; charset=utf-8');
if(session_status() == PHP_SESSION_NONE){session_start();}

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo "NOT_LOGGED_IN";
    exit;
}

$host = 'localhost';
$dbname = 'movie_collect';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    http_response_code(500);
    echo "DB_CONN_FAILED";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $type = trim($_POST['type']);
    $rating = trim($_POST['rating']);
    $user_id = $_SESSION['user_id'];

    if (empty($title) || empty($type) || $rating === '') {
        http_response_code(400);
        echo "MISSING_FIELDS";
        exit;
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO movie (user_id, title, type, rating) VALUES (?, ?, ?, ?)");
        $stmt->execute([$user_id, $title, $type, $rating]);
        
        echo "SUCCESS";
        exit;
    } catch (PDOException $e) {
        http_response_code(500);
        echo "INSERT_ERROR: " . $e->getMessage();
        exit;
    }
}
?>