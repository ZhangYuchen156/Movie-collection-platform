<?php
require_once 'common.php';
require_once 'error.php';
require_once 'dbconnect.php';
header('Content-Type: application/json; charset=utf-8');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
error('method fault', 405);}
$username = safeFilter(trim($_POST['username'] ?? ''));
$password = trim($_POST['password'] ?? '');
if (empty($username) || empty($password)) {
error('user or password can't be empty', 400);}
if (strlen($password) < 6) {
    error('password must be at least 6 characters', 400);
}
try{
$stmt = $pdo->prepare("SELECT id FROM user WHERE username=?");
$stmt->execute([$username]);

if ($stmt -> fetch(PDO::FETCH_ASSOC)) {
error('user has existed', 409);}
$pwd = password_hash($password, PASSWORD_DEFAULT);
$stmt = $pdo->prepare("INSERT INTO user(username,password) VALUES(?,?)");
$result = $stmt->execute([$username, $pwd]);
if($result) {
    success('successing registration', [
       'username' => $username,
       'time' => getNow()
]);
}
else {
  error('failed registration', 500);}}
catch (PDOException $e) {
error('sorry, there are mistakes', 500);
}
?>