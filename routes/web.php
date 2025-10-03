<?php

// home
$router->get('/', 'controllers/index.php');

// AoC 2024
$router->get('/year/2024', 'controllers/AOC2024/index.php');
$router->get('/year/2024/day', 'controllers/AOC2024/show.php');
$router->post('/year/2024/day/solve', 'controllers/AOC2024/solve.php');

// AoC 2023
$router->get('/year/2023', 'controllers/AOC2023/index.php');
$router->get('/year/2023/day', 'controllers/AOC2023/show.php');
$router->post('/year/2023/day/solve', 'controllers/AOC2023/solve.php');

// http://localhost:8000/year/2023/day?id=01
// http://localhost:8000/year/2024/day?id=01
