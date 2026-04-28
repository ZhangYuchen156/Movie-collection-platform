<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

require 'dbconnect.php';

$id       = $_POST['id'];
$title    = $_POST['title'];
$type     = $_POST['type'];
$rating   = $_POST['rating'];

$stmt = $pdo->prepare("UPDATE movie SET title=?, type=?, rating=? WHERE id=? AND user_id=?");
$stmt->execute([$title, $type, $rating, $id, $_SESSION['user_id']]);

header("Location: pages/movie-list.html");
exit;
?>