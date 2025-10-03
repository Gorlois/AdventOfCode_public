<?php
namespace Core\Solvers\AOC2024;

use Core\Solvers\Day;
use Core\Helper\Splitter;

class Day_20 extends Day
{
    private function p_1()
    {
        $inp = Splitter::splitOnLinebreak($this->input);
        foreach ($inp as $y => $row) {
            foreach (str_split($row) as $x => $tile) {
                $map[$y][$x] = $tile;
                if ($tile == "S") {
                    [$y_start, $x_start] = [$y, $x];
                } elseif ($tile == "E") {
                    [$y_end, $x_end] = [$y, $x];
                }
            }
        }

        $steps["$y_start,$x_start"] = 0;
        $step_iter = 0;

        [$y_cur, $x_cur] = [$y_start, $x_start];
        while (!isset($steps["$y_end,$x_end"]) && $step_iter < 10000) {
            foreach ([[0, 1], [0, -1], [1, 0], [-1, 0]] as [$y_dif, $x_dif]) {
                [$y_next, $x_next] = [$y_cur + $y_dif, $x_cur + $x_dif];
                if (!isset($steps["$y_next,$x_next"]) && $map[$y_next][$x_next] != "#") {
                    $steps["$y_next,$x_next"] = $steps["$y_cur,$x_cur"] + 1;
                    [$y_cur, $x_cur] = [$y_next, $x_next];
                    break;
                }
            }
            $step_iter++;
        }

        $ans = 0;

        // construct an array of valid cheaty coordinates
        $dur = 2;
        $min_saved = count($inp) < 50 ? 1 : 100;
        $dur2 = $dur ** 2;
        for ($x = -$dur; $x <= $dur; $x++) {
            for ($y = -$dur; $y <= $dur; $y++) {
                $cheat_time = abs($x) + abs($y);
                if ($cheat_time <= $dur) {
                    $dis = $x ** 2 + $y ** 2;
                    if ($dis <= $dur2) {
                        $cheatrange[] = [$y, $x, $cheat_time];
                    }
                }
            }
        }

        foreach ($steps as $step => $time) {
            [$y_cheat_start, $x_cheat_start] = explode(",", $step);
            foreach ($cheatrange as [$y_dif, $x_dif, $cheat_time]) {
                [$y_cheat_goal, $x_cheat_goal] = [$y_cheat_start + $y_dif, $x_cheat_start + $x_dif];
                if (($steps["$y_cheat_goal,$x_cheat_goal"] ?? 0) > $time) {
                    if ($steps["$y_cheat_goal,$x_cheat_goal"] - $time - $cheat_time >= $min_saved) {
                        $ans++;
                    }
                }
            }
        }
        return "there where $ans cheats that saved at least $min_saved s time";
    }

    private function p_2()
    {
        $inp = Splitter::splitOnLinebreak($this->input);
        foreach ($inp as $y => $row) {
            foreach (str_split($row) as $x => $tile) {
                $map[$y][$x] = $tile;
                if ($tile == "S") {
                    [$y_start, $x_start] = [$y, $x];
                } elseif ($tile == "E") {
                    [$y_end, $x_end] = [$y, $x];
                }
            }
        }

        $steps["$y_start,$x_start"] = 0;
        $step_iter = 0;

        [$y_cur, $x_cur] = [$y_start, $x_start];
        while (!isset($steps["$y_end,$x_end"]) && $step_iter < 10000) {
            foreach ([[0, 1], [0, -1], [1, 0], [-1, 0]] as [$y_dif, $x_dif]) {
                [$y_next, $x_next] = [$y_cur + $y_dif, $x_cur + $x_dif];
                if (!isset($steps["$y_next,$x_next"]) && $map[$y_next][$x_next] != "#") {
                    $steps["$y_next,$x_next"] = $steps["$y_cur,$x_cur"] + 1;
                    [$y_cur, $x_cur] = [$y_next, $x_next];
                    break;
                }
            }
            $step_iter++;
        }

        $ans = 0;

        // construct an array of valid cheaty coordinates
        $dur = 20;
        $min_saved = count($inp) < 50 ? 50 : 100;
        $dur2 = $dur ** 2;
        for ($x = -$dur; $x <= $dur; $x++) {
            for ($y = -$dur; $y <= $dur; $y++) {
                $cheat_time = abs($x) + abs($y);
                if ($cheat_time <= $dur) {
                    $dis = $x ** 2 + $y ** 2;
                    if ($dis <= $dur2) {
                        $cheatrange[] = [$y, $x, $cheat_time];
                    }
                }
            }
        }

        foreach ($steps as $step => $time) {
            [$y_cheat_start, $x_cheat_start] = explode(",", $step);
            foreach ($cheatrange as [$y_dif, $x_dif, $cheat_time]) {
                [$y_cheat_goal, $x_cheat_goal] = [$y_cheat_start + $y_dif, $x_cheat_start + $x_dif];
                if (($steps["$y_cheat_goal,$x_cheat_goal"] ?? 0) > $time) {
                    if ($steps["$y_cheat_goal,$x_cheat_goal"] - $time - $cheat_time >= $min_saved) {
                        $ans++;
                    }
                }
            }
        }
        return "there where $ans cheats that saved at least $min_saved s time";
    }
}