<?php
namespace Core\Solvers\AOC2023;

use Core\Helper\Splitter;
use Core\Solvers\Day;

class Day_10 extends Day {
    protected function part_1() {
        foreach (Splitter::splitOnLinebreak($this->input) as $row) {
            $map[] = str_split($row);
        }
        foreach ($map as $y => $row) {
            foreach ($row as $x => $c) {
                $n_nodes = [];
                $v = "$y,$x";
                $d = match($c) {
                    '|' => "ws",
                    '-' => "ad",
                    'L' => "wd",
                    'J' => "wa",
                    '7' => "as",
                    'F' => "sd",
                    'S' => "ad",
                    default => ""
                };
                if ($c == "S") {
                    $start = $v;
                }
                foreach (str_split($d) as $dir) {
                    switch ($dir) {
                        case "w":
                            $n_c = $map[$y-1][$x] ?? false;
                            if ($n_c && in_array($n_c, ['|', '7', 'F'])) {
                                $n_nodes[] = ($y-1).",$x";
                            }
                            break;
                        case "a":
                            $n_c = $map[$y][$x-1] ?? false;
                            if ($n_c && in_array($n_c, ['-', 'L', 'F', 'S'])) {
                                $n_nodes[] = "$y,".($x-1);
                            }
                            break;
                        case "s":
                            $n_c = $map[$y+1][$x] ?? false;
                            if ($n_c && in_array($n_c, ['|', 'J', 'L'])) {
                                $n_nodes[] = ($y+1).",$x";
                            }
                            break;
                        case "d":
                            $n_c = $map[$y][$x+1] ?? false;
                            if ($n_c && in_array($n_c, ['-', 'J', '7', 'S'])) {
                                $n_nodes[] = "$y,".($x+1);
                            }
                            break;
                    }
                }
                $N[$v] = $n_nodes;
            }
        }
        $start ?? throw new \Exception("start not found");

        $dist = array_fill_keys(array_keys($N), INF);
        $dist[$start] = 0;
        $queue[$start] = 0;
        
        while (!empty($queue)) {
            $u = array_keys($queue, min($queue))[0];
            unset($queue[$u]);
            foreach ($N[$u] as $n) {
                $alt = $dist[$u] + 1;
                if ($alt < $dist[$n]) {
                    $dist[$n] = $alt;
                    $queue[$n] = $alt;
                }
            }
        }

        foreach ($dist as $v => $d) {
            if ($d == INF) {
                unset($dist[$v]);
            }
        }

        $ans = max($dist);

        return "the furthest distance from start is $ans";
    }

    protected function part_2() {
        foreach (Splitter::splitOnLinebreak($this->input) as $row) {
            $map[] = str_split($row);
        }
        foreach ($map as $y => $row) {
            foreach ($row as $x => $c) {
                $n_nodes = [];
                $v = "$y,$x";
                $d = match($c) {
                    '|' => "ws",
                    '-' => "ad",
                    'L' => "wd",
                    'J' => "wa",
                    '7' => "as",
                    'F' => "sd",
                    'S' => "ad",
                    default => ""
                };
                if ($c == "S") {
                    $start = $v;
                }
                foreach (str_split($d) as $dir) {
                    switch ($dir) {
                        case "w":
                            $n_c = $map[$y-1][$x] ?? false;
                            if ($n_c && in_array($n_c, ['|', '7', 'F'])) {
                                $n_nodes[] = ($y-1).",$x";
                            }
                            break;
                        case "a":
                            $n_c = $map[$y][$x-1] ?? false;
                            if ($n_c && in_array($n_c, ['-', 'L', 'F', 'S'])) {
                                $n_nodes[] = "$y,".($x-1);
                            }
                            break;
                        case "s":
                            $n_c = $map[$y+1][$x] ?? false;
                            if ($n_c && in_array($n_c, ['|', 'J', 'L'])) {
                                $n_nodes[] = ($y+1).",$x";
                            }
                            break;
                        case "d":
                            $n_c = $map[$y][$x+1] ?? false;
                            if ($n_c && in_array($n_c, ['-', 'J', '7', 'S'])) {
                                $n_nodes[] = "$y,".($x+1);
                            }
                            break;
                    }
                }
                $N[$v] = $n_nodes;
            }
        }
        $start ?? throw new \Exception("start not found");

        $current = $start;
        $path = [];
        $step = 0;

        while (!isset($path[$current])) {
            $path[$current] = $step;
            $step++;

            foreach ($N[$current] as $n) {
                if (!isset($path[$n])) {
                    $current = $n;
                    break;
                }
            }
        }

        $path = array_flip($path);

        $a = 0;
        $path[] = $path[0];
        [$y_1, $x_1] = explode(",", $path[0]);
        for ($i = 1; $i < count($path); $i++) {
            [$y_2, $x_2] = explode(",", $path[$i]);
            $a+=($x_1*$y_2-$x_2*$y_1);
            [$y_1, $x_1] = [$y_2, $x_2];
        }
        $a = abs($a) / 2;
        $b = count($path) - 1;

        $interior = $a - $b / 2 + 1;

        return "the area withing the loop is $a, because the loop is $b in circumference \r\n which according to pick gives $interior inerior points \r\n so $interior is the answer";
    }

}