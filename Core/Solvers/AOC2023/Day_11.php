<?php
namespace Core\Solvers\AOC2023;

use Core\Helper\Splitter;
use Core\Solvers\Day;

class Day_11 extends Day {
    protected function part_1() {
        foreach (Splitter::splitOnLinebreak($this->input) as $y => $row) {
            foreach (str_split($row) as $x => $c) {
                $row_contains_galaxy[$y] ??= false;
                $collumn_contains_galaxy[$x] ??= false;
                if ($c == "#") {
                    $row_contains_galaxy[$y] = true;
                    $collumn_contains_galaxy[$x] = true;
                    $galaxies[] = [$y, $x];
                }
            }
        }

        // age galaxy;
        $age = 1;

        $aged_galaxies = $galaxies;
        foreach ($row_contains_galaxy as $y => $b) {
            if (!$b) {
                foreach ($galaxies as $galaxy => [$g_y, $_]) {
                    if ($g_y > $y) {
                        $aged_galaxies[$galaxy][0] += $age;
                    }
                }
            }
        }
        foreach ($collumn_contains_galaxy as $x => $b) {
            if (!$b) {
                foreach ($galaxies as $galaxy => [$_, $g_x]) {
                    if ($g_x > $x) {
                        $aged_galaxies[$galaxy][1] += $age;
                    }
                }
            }
        }

        $ans = 0;
        while(!empty($aged_galaxies)) {
            [$gal_y, $gal_x] = array_shift($aged_galaxies);
            foreach ($aged_galaxies as [$oth_y, $oth_x]) {
                $dx = abs($gal_x - $oth_x);
                $dy = abs($gal_y - $oth_y);
                $ans+=$dx+$dy;
            }
        }
        return "the sum of the minimum distances between galaxies is $ans";
    }

    protected function part_2() {
        foreach (Splitter::splitOnLinebreak($this->input) as $y => $row) {
            foreach (str_split($row) as $x => $c) {
                $row_contains_galaxy[$y] ??= false;
                $collumn_contains_galaxy[$x] ??= false;
                if ($c == "#") {
                    $row_contains_galaxy[$y] = true;
                    $collumn_contains_galaxy[$x] = true;
                    $galaxies[] = [$y, $x];
                }
            }
        }

        // age galaxy;
        $age = 999999;

        $aged_galaxies = $galaxies;
        foreach ($row_contains_galaxy as $y => $b) {
            if (!$b) {
                foreach ($galaxies as $galaxy => [$g_y, $_]) {
                    if ($g_y > $y) {
                        $aged_galaxies[$galaxy][0] += $age;
                    }
                }
            }
        }
        foreach ($collumn_contains_galaxy as $x => $b) {
            if (!$b) {
                foreach ($galaxies as $galaxy => [$_, $g_x]) {
                    if ($g_x > $x) {
                        $aged_galaxies[$galaxy][1] += $age;
                    }
                }
            }
        }

        $ans = 0;
        while(!empty($aged_galaxies)) {
            [$gal_y, $gal_x] = array_shift($aged_galaxies);
            foreach ($aged_galaxies as [$oth_y, $oth_x]) {
                $dx = abs($gal_x - $oth_x);
                $dy = abs($gal_y - $oth_y);
                $ans+=$dx+$dy;
            }
        }
        return "the sum of the minimum distances between galaxies is $ans";
    }
}