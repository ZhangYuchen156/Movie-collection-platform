<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = "localhost";
$dbname = "movie_collect";
$user = "root";
$pass = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

$error = "";
$success = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);
    $confirm = trim($_POST["confirm_password"]);

    if(empty($username) || empty($password) || empty($confirm)) {
        $error = "All fields are required!";
    } elseif($password !== $confirm) {
        $error = "Passwords do not match!";
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        try {
            $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt->execute([$username, $hash]);
            $success = "✅ Registration successful! You can now login.";
            header("refresh:2; url=pages/login.html");
        } catch(PDOException $e) {
            $error = "❌ Registration failed: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <div class="navbar">
        <a href="index.html">Home</a>
        <a href="pages/login.html">Login</a>
        <a href="register.php">Register</a>
    </div>

    <div class="form-box">
        <h2>User Registration</h2>

        <?php if($error): ?>
            <p style="color:red;"><?= $error ?></p>
        <?php endif; ?>
        <?php if($success): ?>
            <p style="color:green;"><?= $success ?></p>
        <?php endif; ?>

        <form method="POST" action="">
            <div>
                <label>Username</label>
                <input type="text" name="username" placeholder="Enter username" required>
            </div>
            <div>
                <label>Password</label>
                <input type="password" name="password" placeholder="Enter password" required>
            </div>
            <div>
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" placeholder="Confirm password" required>
            </div>
            <button type="submit">Register</button>
        </form>

        <p style="margin-top: 1rem;"><a href="pages/login.html">Back to Login</a></p>
    </div>
</body>
</html>