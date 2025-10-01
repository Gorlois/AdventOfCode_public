<?php
// public/index.php

use Core\Router;

// define BasePath
const BASE_PATH = __DIR__ . '/../';

// load base functions
require_once BASE_PATH . 'Core/functions.php';

spl_autoload_register(function ($class) {
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    require base_path("{$class}.php");
});

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
if (preg_match('/\.[a-zA-Z0-9]{1,6}$/', $uri)) {
    $resources = realpath(BASE_PATH . 'resources');
    $request = realpath($resources . $uri);
    if ($request != false && strpos($request, $resources) === 0 && is_file($request)) {
        $extension = strtolower(pathinfo($request, PATHINFO_EXTENSION));
        $mimes = [
            'css' => 'text/css',
            'js' => 'application/javascript',
            'png' => 'image/png',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'gif' => 'image/gif',
            'svg' => 'image/svg+xml',
            'woff' => 'font/woff',
            'woff2' => 'font/woff2',
            'ttf' => 'font/ttf',
            'ico' => 'image/x-icon',
            'html' => 'text/html; charset=UTF-8',
        ];
        header('Content-Type: ' . ($mimes[$extension] ?? 'application/octet-stream'));
        header('Content-Length: ' . filesize($request));
        // caching headers (adjust as needed)
        header('Cache-Control: public, max-age=31536000, immutable');
        readfile($request);
        exit;
    }
}

$router = new Router();
$routes = require base_path('routes\web.php');

$method = $_POST['f_method'] ?? $_SERVER['REQUEST_METHOD'];

$router->route($uri, $method);