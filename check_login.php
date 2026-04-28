<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'common.php';
require_once 'error.php';

function checkLogin() {
    return isset($_SESSION['is_login']) && $_SESSION['is_login'] === true;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (checkLogin()) {
        success('already login', [
            'user_id' => $_SESSION['user_id'],
            'username' => $_SESSION['username']
        ]);
    } else {
        error('not login or login expired', 401);
    }
}
?>