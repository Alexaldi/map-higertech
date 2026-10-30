<?php

$publicPath = __DIR__.'/public';

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? ''
);

// Emulate Apache/Nginx rewrite functionality for the built-in PHP web server.
// Only serve direct files (assets). Directories should fall through to Laravel index.php.
if ($uri !== '/' && file_exists($publicPath.$uri) && !is_dir($publicPath.$uri)) {
    return false;
}

require_once $publicPath.'/index.php';
