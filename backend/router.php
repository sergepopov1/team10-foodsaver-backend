<?php
if (php_sapi_name() == 'cli-server') {
    $url = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];

    if (is_file($file)) {
        return false;
    } elseif (file_exists(__DIR__ . '/' . basename($url['path']))) {
        include __DIR__ . '/' . basename($url['path']);
        exit;
    } else {
        http_response_code(404);
        echo "File not found!";
        exit;
    }
}


