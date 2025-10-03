<?php

use Core\Lists\DayList2023;

$id = $_GET['id'];
$daylist = DayList2023::list();
$heading = "AoC '23 - day $id - $daylist[$id]";

view(
    "layouts/input.view.php",
    [
        'heading' => $heading,
        'year' => '2023',
        'dayId' => $id,
    ]
);