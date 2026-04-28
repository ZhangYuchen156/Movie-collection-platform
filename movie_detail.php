<?php
session_start();
if (file_exists("dbconnect.php")) {
    require "dbconnect.php";
}

if (isset($_POST['delete_comment']) && isset($_SESSION['user_id'])) {
    $comment_id = $_POST['comment_id'];
    $user_id = $_SESSION['user_id'];
    $del = $pdo->prepare("DELETE FROM movie_comments WHERE id=? AND user_id=?");
    $del->execute([$comment_id, $user_id]);
    echo "<script>location.replace('movie_detail.php?id=".$_GET['id']."');</script>";
    exit;
}

if (isset($_POST['like_comment']) && isset($_SESSION['user_id'])) {
    $comment_id = $_POST['comment_id'];
    $user_id = $_SESSION['user_id'];

    $check = $pdo->prepare("SELECT * FROM comment_likes WHERE comment_id=? AND user_id=?");
    $check->execute([$comment_id, $user_id]);

    if ($check->rowCount() == 0) {
        $stmt = $pdo->prepare("INSERT INTO comment_likes (comment_id, user_id) VALUES (?,?)");
        $stmt->execute([$comment_id, $user_id]);
    }

    echo "<script>location.replace('movie_detail.php?id=".$_GET['id']."');</script>";
    exit;
}

if (!isset($_GET['id'])) {
    echo "Movie ID not found";
    exit;
}

$movie_id = $_GET['id'];
$movie = null;
$average = 0;
$comments = [];

if (isset($pdo)) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM movie WHERE id = ?");
        $stmt->execute([$movie_id]);
        $movie = $stmt->fetch();

        if ($movie) {
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

            if (isset($_POST['comment']) && isset($_SESSION['user_id'])) {
                $text = trim($_POST['content']);
                $user_id = $_SESSION['user_id'];
                if ($text) {
                    $stmt = $pdo->prepare("INSERT INTO movie_comments (movie_id, user_id, comment) VALUES (?,?,?)");
                    $stmt->execute([$movie_id, $user_id, $text]);
                }
            }

            $avg = $pdo->prepare("SELECT AVG(rating) AS a FROM movie_ratings WHERE movie_id=?");
            $avg->execute([$movie_id]);
            $average = $avg->fetch()['a'] ?? 0;

            $cmt = $pdo->prepare("SELECT c.*, u.username,
                (SELECT COUNT(*) FROM comment_likes l WHERE l.comment_id = c.id) AS like_count
                FROM movie_comments c
                JOIN users u ON c.user_id = u.id
                WHERE movie_id=?
                ORDER BY created_at DESC");
            $cmt->execute([$movie_id]);
            $comments = $cmt->fetchAll();
        }
    } catch (Exception $e) {}
}

if (!$movie) {
    $movie = [
        'title' => 'Movie Title',
        'poster_url' => 'images/unknown.jpg',
        'type' => 'Action / Drama',
        'release_date' => '2026-01-01',
        'description' => 'Movie description here.'
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $movie['title'] ?></title>
    <style>
        *{margin:0;padding:0;box-sizing:border-box;font-family:Arial,sans-serif}
        .detail{max-width:900px;margin:40px auto;padding:0 20px}
        .movie-box{display:flex;gap:30px;margin-bottom:40px}
        .poster{width:280px;border-radius:12px}
        .info h1{margin-bottom:10px}
        .rating{color:#FF69B4;font-weight:bold;font-size:20px;margin:10px 0}
        .comment-box{margin:30px 0}
        .comment{padding:12px 16px;background:#fdfdfd;border-radius:8px;margin-bottom:10px}
        .comment-user{font-weight:bold}
        .comment-actions{display:flex;gap:10px;margin-top:6px;font-size:14px}
        .like-btn{background:none;border:none;color:#ff5252;cursor:pointer}
        .delete-btn{background:none;border:none;color:#ff4444;cursor:pointer}
        form{margin:20px 0}
        input,textarea,button{width:100%;padding:10px;margin:5px 0;border-radius:6px;border:1px solid #ddd}
        button{background:#FF69B4;color:white;border:none;cursor:pointer}
        .navbar {background:#FF69B4;padding:14px 20px}
        .navbar a{color:white;margin-right:16px;text-decoration:none}
    </style>
</head>
<body>

<div class="navbar">
    <a href="index.php">Home</a>
    <a href="pages/movie-list.html">Movies</a>
    <a href="pages/login.html">Login</a>
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
        <p>Please <a href="pages/login.html">login</a> to rate or comment.</p>
    <?php endif; ?>

    <div class="comment-box">
        <h3>Comments (<?= count($comments) ?>)</h3>
        <?php foreach ($comments as $c): ?>
        <div class="comment">
            <span class="comment-user"><?= $c['username'] ?? 'User' ?></span>
            <p><?= $c['comment'] ?></p>

            <div class="comment-actions">
                <form method="post" style="margin:0;display:inline;">
                    <input type="hidden" name="comment_id" value="<?= $c['id'] ?>">
                    <button type="submit" name="like_comment" class="like-btn">❤️ <?= $c['like_count'] ?></button>
                </form>

                <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $c['user_id']): ?>
                <form method="post" onsubmit="return confirm('Delete?');" style="margin:0;display:inline;">
                    <input type="hidden" name="comment_id" value="<?= $c['id'] ?>">
                    <button type="submit" name="delete_comment" class="delete-btn">🗑️ Delete</button>
                </form>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

</body>
</html>