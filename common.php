<?php
session_start();
require_once 'dbconnect.php';
require_once 'error.php';
require_once 'check_login.php';

function isEmpty($str) {
    return empty(trim($str));
}

function check_length($str, $min, $max) {
    $len = mb_strlen($str, 'utf8');
    return $len >= $min && $len <= $max;
}

function safeFilter($str) {
    return htmlspecialchars($str, ENT_QUOT, 'utf8');
}

function getNow() {
    return date('Y-m-d H:i:s');
}

$user_id = $_SESSION['user_id'] ?? 0;

if (empty($user_id)) {
    error('Please login first', 401);
}

$title = safeFilter(trim($_POST['title'] ?? ''));
$category_id = (int)($_POST['category_id'] ?? 0);

if (isEmpty($title) || $category_id <= 0) {
    error('The name and category can\'t be empty', 400);
}

if (!check_length($title, 2, 50)) {
    error('movie name\'s length must be 2~50 characters', 400);
}

try {
    $cateStmt = $pdo->prepare("SELECT id FROM category WHERE id = ?");
    $cateStmt->execute([$category_id]);

    if ($cateStmt->rowCount() === 0) {
        error('Invalid category', 400);
    }

    $pdo->beginTransaction();

    $sql = "INSERT INTO movie (user_id, title) VALUES (?, ?)";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([$user_id, $title]);

    if ($result) {
        $movie_id = $pdo->lastInsertId();
        $sql_rel = "INSERT INTO movie_category_relation (movie_id, cate_id) VALUES (?, ?)";
        $stmt_rel = $pdo->prepare($sql_rel);
        $relResult = $stmt_rel->execute([$movie_id, $category_id]);

        if (!$relResult) {
            throw new PDOException('Failed to bind category');
        }

        $pdo->commit();
        success('add successfully!', [
            'title' => $title,
            'time' => getNow()
        ]);
    } else {
        throw new PDOException('Failed to add movie');
    }
} catch (PDOException $e) {
    $pdo->rollBack();
    error('database error', 500);
}
?>