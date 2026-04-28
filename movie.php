<?php
session_start();
require "dbconnect.php";
$stmt = $pdo->query("SELECT * FROM movie ORDER BY created_at DESC");
$movies = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Movies List</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="navbar">
        <a href="index.html">Home</a>
        <a href="movies.php">Movies</a>
        <a href="add_movie.php">Add Movie</a>
        <?php if(isset($_SESSION["user_id"])): ?>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
        <?php endif; ?>
    </div>

    <div class="container">
        <h2>Movie List</h2>
        <?php foreach($movies as $m): ?>
            <div class="card">
                <h3><?= $m["title"] ?></h3>
                <p><strong>Type:</strong> <?= $m["type"] ?></p>
                <p><strong>Rating:</strong> <?= $m["rating"] ?> / 10</p>
                <p><strong>Released:</strong> <?= $m["release_date"] ?></p>
                <p><?= $m["description"] ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>