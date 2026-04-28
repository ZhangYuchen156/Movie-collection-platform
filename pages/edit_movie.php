<?php
session_start();
require '../dbconnect.php';

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM movie WHERE id = ? AND user_id = ?");
$stmt->execute([$id, $_SESSION['user_id']]);
$movie = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Movie</title>
    <style>
        * { box-sizing: border-box; font-family: Arial, sans-serif; }
        body { background: #f5f5f5; margin: 0; padding: 0; }
        .nav { background: #FF69B4; padding: 16px; text-align: center; }
        .nav a { color: white; text-decoration: none; margin: 0 16px; font-weight: bold; }
        .container { max-width: 500px; margin: 40px auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        h2 { text-align: center; margin-bottom: 24px; color: #333; }
        .form-group { margin-bottom: 16px; }
        label { display: block; margin-bottom: 8px; font-weight: 600; color: #333; }
        input, select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 16px;
        }
        button {
            width: 100%;
            padding: 12px;
            background: #FF69B4;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }
        button:hover { background: #FF1493; }
    </style>
</head>
<body>
    <div class="nav">
        <a href="../index.php">Home</a>
        <a href="movie-list.html">Movies</a>
    </div>

    <div class="container">
        <h2>Edit Movie</h2>
        <form action="../update_movie.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $movie['id']; ?>">
            
            <div class="form-group">
                <label>Movie Title</label>
                <input type="text" name="title" required value="<?php echo $movie['title']; ?>">
            </div>

            <div class="form-group">
                <label>Type</label>
                <select name="type" required>
                    <option value="">-- Select Type --</option>
                    <option value="Action" <?php if($movie['type'] == 'Action') echo 'selected'; ?>>Action</option>
                    <option value="Comedy" <?php if($movie['type'] == 'Comedy') echo 'selected'; ?>>Comedy</option>
                    <option value="Drama" <?php if($movie['type'] == 'Drama') echo 'selected'; ?>>Drama</option>
                    <option value="Horror" <?php if($movie['type'] == 'Horror') echo 'selected'; ?>>Horror</option>
                    <option value="Sci-Fi" <?php if($movie['type'] == 'Sci-Fi') echo 'selected'; ?>>Sci-Fi</option>
                </select>
            </div>

            <div class="form-group">
                <label>Rating (0-10)</label>
                <input type="number" step="0.1" name="rating" min="0" max="10" required value="<?php echo $movie['rating']; ?>">
            </div>

            <button type="submit">Update</button>
        </form>
    </div>
</body>
</html>