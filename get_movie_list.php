<?php
header('Content-Type: application/json; charset=utf-8');
if(session_status() == PHP_SESSION_NONE){session_start();}
require_once 'dbconnect.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode([]);
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT id, title, type, rating FROM movie WHERE user_id = ? ORDER BY id DESC");
    $stmt->execute([$_SESSION['user_id']]);
    $list = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($list);
} catch (Exception $e) {
    echo json_encode([]);
}
?>