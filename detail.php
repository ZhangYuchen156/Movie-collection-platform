<?php
session_start();
require "dbconnect.php";

if (!isset($_GET['id'])) {
    header("Location: movies.php");
    exit;
}
$movie_id = $_GET['id'];

// Get movie info
$stmt = $pdo->prepare("SELECT * FROM movie WHERE id = ?");
$stmt->execute([$movie_id]);
$movie = $stmt->fetch();

if (!$movie) {
    header("Location: movies.php");
    exit;
}

// Submit rating
if (isset($_POST['rate']) && isset($_SESSION['user_id'])) {
    $rating = $_POST['rating'];
    $user_id = $_SESSION['user_id'];

    $check = $pdo->prepare("SELECT * FROM movie_ratings WHERE movie_id=? AND user_id=?");
    $check->execute([$movie_id, $user_id]);

    if ($check->rowCount() > 0) {
        $stmt = $pdo->prepare("UPDATE movie_ratings SET rating=? WHERE movie_id=? AND user_id=?");
        $stmt->execute([$rating, $movie_id, $user_id]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO movie_ratings (movie_id, user_id, rating) VALUES (?,?,?)");
        $stmt->execute([$movie_id, $user_id, $rating]);
    }
}

// Submit comment
if (isset($_POST['comment']) && isset($_SESSION['user_id'])) {
    $text = trim($_POST['content']);
    $user_id = $_SESSION['user_id'];

    if ($text) {
        $stmt = $pdo->prepare("INSERT INTO movie_comments (movie_id, user_id, comment) VALUES (?,?,?)");
        $stmt->execute([$movie_id, $user_id, $text]);
    }
}

// Get avg rating
$avg = $pdo->prepare("SELECT AVG(rating) AS a FROM movie_ratings WHERE movie_id=?");
$avg->execute([$movie_id]);
$average = $avg->fetch()['a'] ?? 0;

// Get comments
$cmt = $pdo->prepare("SELECT c.*, u.username FROM movie_comments c JOIN users u ON c.user_id=u.id WHERE movie_id=? ORDER BY created_at DESC");
$cmt->execute([$movie_id]);
$comments = $cmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $movie['title'] ?></title>
    <link rel="stylesheet" href="style.css">
    <style>
        .detail{max-width:900px;margin:40px auto;padding:0 20px}
        .movie-box{display:flex;gap:30px;margin-bottom:40px}
        .poster{width:280px;border-radius:12px}
        .info h1{margin-bottom:10px}
        .rating{color:#FF69B4;font-weight:bold;font-size:20px;margin:10px 0}
        .comment-box{margin:30px 0}
        .comment{padding:12px 16px;background:#fdfdfd;border-radius:8px;margin-bottom:10px}
        .comment-user{font-weight:bold}
        .comment-date{font-size:12px;color:#888;margin-left:8px}
        form{margin:20px 0}
        input,textarea,button{width:100%;padding:10px;margin:5px 0;border-radius:6px;border:1px solid #ddd}
        button{background:#FF69B4;color:white;border:none;cursor:pointer}
    </style>
</head>
<body>

<div class="navbar">
    <a href="index.php">Home</a>
    <a href="movies.php">Movies</a>
    <a href="login.php">Login</a>
    <a href="register.php">Register</a>
</div>

<div class="detail">
    <div class="movie-box">
        <img src="<?= $movie['poster_url'] ?>" class="poster">
        <div class="info">
            <h1><?= $movie['title'] ?></h1>
            <p><strong>Type:</strong> <?= $movie['type'] ?></p>
            <p><strong>Release:</strong> <?= $movie['release_date'] ?></p>
            <div class="rating">Rating: <?= round($average,1) ?> / 10</div>
            <p><?= $movie['description'] ?></p>
        </div>
    </div>

    <?php if (isset($_SESSION['user_id'])): ?>
        <form method="post">
            <h3>Rate this movie</h3>
            <input type="number" step="0.1" min="0" max="10" name="rating" placeholder="0-10" required>
            <button type="submit" name="rate">Submit Rating</button>
        </form>

        <form method="post">
            <h3>Leave a comment</h3>
            <textarea name="content" required></textarea>
            <button type="submit" name="comment">Post Comment</button>
        </form>
    <?php else: ?>
        <p>Please <a href="login.php">login</a> to rate or comment.</p>
    <?php endif; ?>

    <div class="comment-box">
        <h3>Comments (<?= count($comments) ?>)</h3>
        <?php foreach ($comments as $c): ?>
            <div class="comment">
                <span class="comment-user"><?= $c['username'] ?></span>
                <span class="comment-date"><?= $c['created_at'] ?></span>
                <p><?= $c['comment'] ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</div>

</body>
</html>