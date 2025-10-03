<?php
namespace Core\Solvers\AOC2024;

use Core\Solvers\Day;
use Core\Helper\Splitter;

class Day_13 extends Day
{
    protected function part_1()
    {
        $ans = 0;
        foreach (Splitter::splitOnEmpty($this->input) as $machine) {
            preg_match_all("/\d+/", $machine, $o);
            [$a_x, $a_y, $b_x, $b_y, $g_x, $g_y] = [$o[0][0], $o[0][1], $o[0][2], $o[0][3], $o[0][4], $o[0][5]];

            $det = $a_x * $b_y - $b_x * $a_y;

            if ($det != 0) {
                $det_a = $g_x * $b_y - $g_y * $b_x;
                $det_b = $g_y * $a_x - $g_x * $a_y;
                if ($det_a % $det == 0 && $det_b % $det == 0) {
                    $ans += $det_a / $det * 3 + $det_b / $det;
                }
            }
        }
        return "the min cost for all valid machines combined was $ans";
    }

    protected function part_2()
    {
        $ans = 0;
        foreach (Splitter::splitOnEmpty($this->input) as $machine) {
            preg_match_all("/\d+/", $machine, $o);
            [$a_x, $a_y, $b_x, $b_y, $g_x, $g_y] = [$o[0][0], $o[0][1], $o[0][2], $o[0][3], $o[0][4], $o[0][5]];

            $det = $a_x * $b_y - $b_x * $a_y;

            // alter goal x and y by adding 10000000000000
            $g_x += 10000000000000;
            $g_y += 10000000000000;

            if ($det != 0) {
                $det_a = $g_x * $b_y - $g_y * $b_x;
                $det_b = $g_y * $a_x - $g_x * $a_y;
                if ($det_a % $det == 0 && $det_b % $det == 0) {
                    $ans += $det_a / $det * 3 + $det_b / $det;
                }
            }
        }
        return "the min cost for all valid machines combined was $ans";
    }
}