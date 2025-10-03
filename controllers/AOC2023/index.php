<?php

use Core\Lists\DayList2023;

$days = DayList2023::list();
view(
    "layouts/index.view.php",
    [
        'heading' => 'Georg AoC - 2023 index',
        'base_href' => 'year/2023/',
        'index_title' => 'AoC 2023 Days',
        'index_base' => 'day?id=',
        'index' => $days,
    ]
);