<?php

use Core\Lists\DayList2024;

$id = $_GET['id'];
$daylist = DayList2024::list();
$heading = "AoC '24 - day $id - $daylist[$id]";

view(
    "layouts/input.view.php",
    [
        'heading' => $heading,
        'dayId' => $id,
    ]
);