<?php
namespace Core\Solvers\AOC2024;

use Core\Helper\Splitter;

class Day_04 extends Day
{
    protected function part_1()
    {
        $ans = 0;
        $dir = [
            [-1, -1],
            [-1, 0],
            [-1, 1],
            [0, -1],
            [0, 1],
            [1, -1],
            [1, 0],
            [1, 1]
        ];
        foreach (Splitter::splitOnLinebreak($this->input) as $y => $row) {
            foreach (str_split($row) as $x => $char) {
                $map[$y][$x] = $char;
            }
        }
        foreach ($map as $y => $row) {
            foreach ($row as $x => $char) {
                if ($char === 'X') {
                    foreach ($dir as [$dy, $dx]) {
                        if (isset($map[$y + $dy * 3][$x + $dx * 3]) && $map[$y + $dy * 1][$x + $dx * 1] . $map[$y + $dy * 2][$x + $dx * 2] . $map[$y + $dy * 3][$x + $dx * 3] === "MAS") {
                            $ans++;
                        }
                    }
                }
            }
        }
        return "the sequence \"XMAS\" appears $ans times";
    }

    protected function part_2()
    {
        $ans = 0;
        $comb = [
            ["M", "M", "S", "S"],
            ["S", "S", "M", "M"],
            ["S", "M", "S", "M"],
            ["M", "S", "M", "S"]
        ];
        foreach (Splitter::splitOnLinebreak($this->input) as $y => $row) {
            foreach (str_split($row) as $x => $char) {
                if ($char != "X") {
                    $map[$y][$x] = $char;
                }
            }
        }
        foreach ($map as $y => $row) {
            foreach ($row as $x => $char) {
                if ($char === "A") {
                    if (isset($map[$y - 1][$x - 1]) && isset($map[$y - 1][$x + 1]) && isset($map[$y + 1][$x - 1]) && isset($map[$y + 1][$x + 1])) {
                        foreach ($comb as [$c1, $c2, $c3, $c4]) {
                            if ($map[$y - 1][$x - 1] === $c1 && $map[$y - 1][$x + 1] === $c2 && $map[$y + 1][$x - 1] === $c3 && $map[$y + 1][$x + 1] === $c4) {
                                $ans++;
                            }
                        }
                    }
                }
            }
        }
        return "as \"X-MAS\" appear $ans times";
    }
}