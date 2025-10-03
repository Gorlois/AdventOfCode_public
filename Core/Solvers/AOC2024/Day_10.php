<?php
namespace Core\Solvers\AOC2024;

use Core\Helper\Splitter;
use Core\Solvers\Day;

class Day_10 extends Day
{
    protected function part_1()
    {
        $ans = 0;
        foreach (Splitter::splitOnLinebreak($this->input) as $y => $row) {
            foreach (str_split($row) as $x => $h) {
                $map[$y][$x] = $h;
                if ($h == 0) {
                    $starts[] = [$y, $x];
                }
            }
        }
        foreach ($starts as [$y, $x]) {
            $ans += count($this->walk($map, $y, $x));
        }
        return "the trailheads scored an combined $ans";
    }

    protected function part_2()
    {
        $ans = 0;
        foreach (Splitter::splitOnLinebreak($this->input) as $y => $row) {
            foreach (str_split($row) as $x => $h) {
                $map[$y][$x] = $h;
                if ($h == 0) {
                    $starts[] = [$y, $x];
                }
            }
        }
        foreach ($starts as [$y, $x]) {
            $p = [];
            $ans += count($this->walk($map, $y, $x, $p, false));
        }
        return "the trailheads scored an combined $ans";
    }

    private function walk(array $map, $y, $x, array &$p = [], bool $dist = true)
    {
        $dir = [
            [0, -1],
            [0, 1],
            [1, 0],
            [-1, 0]
        ];
        $cur_h = $map[$y][$x];
        if ($cur_h != 9) {
            foreach ($dir as [$dx, $dy]) {
                if (isset($map[$y + $dy][$x + $dx]) && $map[$y + $dy][$x + $dx] == $cur_h + 1) {
                    $this->walk($map, $y + $dy, $x + $dx, $p, $dist);
                }
            }
        } else {
            if ($dist) {
                $p["$y,$x"] = 1;
            } else {
                $p[] = 1;
            }
        }
        return $p;
    }
}