<?php
session_start();
if (!isset($_SESSION['user_id'])) {
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

    $id = $_POST['id'];
    $user_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare("DELETE FROM movie WHERE id = ? AND user_id = ?");
    $stmt->execute([$id, $user_id]);

    echo "SUCCESS";
} catch (Exception $e) {
    echo "ERROR";
}
?>