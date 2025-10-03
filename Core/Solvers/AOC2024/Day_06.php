<?php
namespace Core\Solvers\AOC2024;

use Core\Helper\Splitter;
use Core\Solvers\Day;

class Day_06 extends Day
{
    protected function part_1() {
        // make map
        foreach (Splitter::splitOnLinebreak($this->input) as $y => $row) {
            foreach (str_split($row) as $x => $char) {
                $map[$y][$x] = $char == "#" ? 1 : 0;           
                if ($char == "^") {
                    [$g_y, $g_x] = [$y, $x];
                }
            }
        }

        $p = $this->walk($map, $g_y, $g_x);
        if ($p) {
            $ans = count($p);
            return "the guard visited $ans distinct positions";
        } else {
            return "the path apparently looped";
        }
    }

    protected function part_2() {
        $ans = 0;
        // make map
        foreach (Splitter::splitOnLinebreak($this->input) as $y => $row) {
            foreach (str_split($row) as $x => $char) {
                $map[$y][$x] = $char == "#" ? 1 : 0;           
                if ($char == "^") {
                    [$g_y, $g_x] = [$y, $x];
                }
            }
        }
        foreach ($this->walk($map, $g_y, $g_x) as $step => $_) {
            [$y, $x] = explode(",", $step);
            if ("$y,$x" == "$g_y,$g_x") {
                continue;
            }
            $map[$y][$x] = 1;
            if (!$this->walk($map, $g_y, $g_x)) {
                $ans++;
            }
            $map[$y][$x] = 0;
        }
        return "there were $ans positions where an obstacle placed would cause a loop";
    }

    private function walk(array $map, int $y, int $x, int $dir = 0) {
        $path = ["$y,$x" => 1];
        $dirs = [
            [-1,0], // up
            [0,1], // left
            [1,0], // down
            [0,-1] // right
        ];
        // create a loop that breaks on exit, 
        while (true) {
            // assign next tile
            [$ny, $nx] = [$y + $dirs[$dir][0], $x + $dirs[$dir][1]];

            // check if next tile exists
            if (!isset($map[$ny][$nx])) {
                break;
            }

            // check if its an obstacle
            if ($map[$ny][$nx] == 1) {
                $dir = ($dir + 1) % 4;
                continue;
            }

            // take step
            [$y, $x] = [$ny, $nx];
            $s = "$y,$x";

            // check in path if step is set and if it is if the direction has been used already if so it loops
            if (!isset($path[$s])) {
                $path[$s] = 0;
            } elseif ($path[$s] & (1 << $dir)) {
                return false;
            }
            
            // add direction to path
            $path[$s] |= 1 << $dir;
        }

        // if while was broken on the check if next exists return path
        return $path;
    }

}