<?php

view(
    "layouts/index.view.php",
    [
        'heading' => "georg's AoC - Home",
        'index_title' => 'AoC Years',
        'index_base' => 'year/',
        'index' => [
            '2023' => 'AoC year',
            '2024' => 'AoC year',
        ]
    ]
);