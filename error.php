<?php
function success($msg = 'success', $data = []) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'code' => 200,
        'msg'  => $msg,
        'data' => $data
    ], JSON_UNESCAPED_UNICODE);
    exit;
}
function error($msg = 'fail', $code = 500) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'code' => $code,
        'msg'  => $msg,
        'data' => []
    ], JSON_UNESCAPED_UNICODE);
    exit;
}
?>