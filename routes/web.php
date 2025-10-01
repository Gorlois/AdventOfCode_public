<?php

// home
$router->get('/', 'controllers/index.php');

// AoC 2024
$router->get('/year/2024', 'controllers/AOC2024/index.php');
$router->get('/year/2024/day', 'controllers/AOC2024/show.php');
$router->post('/year/2024/day/solve', 'controllers/AOC2024/solve.php');