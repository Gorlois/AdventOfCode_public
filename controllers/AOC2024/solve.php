<?php
use Core\Lists\DayList2024;

$daylist = DayList2024::list();
$id = (string) $_GET['id'];
$heading = "day $id - $daylist[$id]";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['puzzle_in']) && $_FILES['puzzle_in']['error'] === UPLOAD_ERR_OK) {
        $f_tmp_path = $_FILES['puzzle_in']['tmp_name'];
        $input = file_get_contents($f_tmp_path);
        $part = $_POST['part'];
        $classname = "Core\\Solvers\\AoC2024\\Day_". str_pad($id, 2, '0', STR_PAD_LEFT);
        if (class_exists($classname)) {
            consoleLog("load ".$classname);
            $solver = new $classname($input, $part);
        } else {
            throw new \Exception("Solver class for ID {$id} not found");
        }
        $solution = $solver->run();
    } else {
        consoleLog("the error was " . $_FILES['puzzle']['error']);
        $solution = "There was an error with the file upload process";
    }
}

view(
    'layouts/solution.view.php',
    [
        'heading' => $heading,
        'dayId' => $id,
        'solution' => $solution
    ]
);