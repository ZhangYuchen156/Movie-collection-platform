<?php
session_start();
header("Content-Type: application/json");

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "message" => "Please login"]);
    exit;
}

require 'dbconnect.php';

$id = $_GET['id'] ?? 0;

$stmt = $pdo->prepare("SELECT movie_id, title, type, rating FROM movie WHERE movie_id = ? AND user_id = ?");
$stmt->execute([$id, $_SESSION['user_id']]);
$movie = $stmt->fetch(PDO::FETCH_ASSOC);

if ($movie) {
    echo json_encode([
        "success" => true,
        "data" => $movie
    ]);
} else {
    echo json_encode(["success" => false, "message" => "No data"]);
}
?>