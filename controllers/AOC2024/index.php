<?php

use Core\Lists\DayList2024;

$days = DayList2024::list();
view(
    "layouts/index.view.php",
    [
        'heading' => 'Georg AoC - 2024 index',
        'base_href' => 'year/2024/',
        'index_title' => 'AoC 2024 Days',
        'index_base' => 'day?id=',
        'index' => $days,
    ]
);