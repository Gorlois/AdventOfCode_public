<?php 
namespace Core\Solvers\AOC2024;

use Core\Helper\Splitter;

class Day_08 extends Day {
    protected function part_1() {
        foreach (Splitter::splitOnLinebreak($this->input) as $y => $row) {
            foreach (str_split($row) as $x => $char) {
                $map[$y][$x] = $char;
                if($char != ".") {
                    $antenna[$char][] = [$y, $x];
                }
            }
        }
        foreach ($antenna as $coords) {
            while (!empty($coords)) {
                [$y_cur, $x_cur] = array_pop($coords);
                foreach ($coords as [$y_other, $x_other]) {
                    $y_dif = $y_other - $y_cur;
                    $x_dif = $x_other - $x_cur;

                    if (isset($map[$y_cur-$y_dif][$x_cur-$x_dif])) {
                        $antinodes[($y_cur-$y_dif).",".($x_cur-$x_dif)] = 1;
                    }
                    if (isset($map[$y_other+$y_dif][$x_other+$x_dif])) {
                        $antinodes[($y_other+$y_dif).",".($x_other+$x_dif)] = 1;
                    }
                }
            }
        }
        $ans = count($antinodes);
        return "there are $ans unique locations with an antinode";
    }

    protected function part_2() {
        foreach (Splitter::splitOnLinebreak($this->input) as $y => $row) {
            foreach (str_split($row) as $x => $char) {
                $map[$y][$x] = $char;
                if($char != ".") {
                    $antenna[$char][] = [$y, $x];
                }
            }
        }
        foreach ($antenna as $coords) {
            while (!empty($coords)) {
                [$y_cur, $x_cur] = array_pop($coords);
                foreach ($coords as [$y_other, $x_other]) {
                    $y_dif = $y_other - $y_cur;
                    $x_dif = $x_other - $x_cur;

                    $m = 0;
                    while (isset($map[$y_cur-$y_dif*$m][$x_cur-$x_dif*$m])) {
                        $antinodes[($y_cur-$y_dif*$m).",".($x_cur-$x_dif*$m)] = 1;
                        $m++;
                    }
                    $m = 0;
                    while (isset($map[$y_other+$y_dif*$m][$x_other+$x_dif*$m])) {
                        $antinodes[($y_other+$y_dif*$m).",".($x_other+$x_dif*$m)] = 1;
                        $m++;
                    }
                }
            }
        }
        $ans = count($antinodes);
        return "there are $ans unique locations with an antinode";
    }
}