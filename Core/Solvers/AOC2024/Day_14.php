<?php
namespace Core\Solvers\AOC2024;

use Core\Solvers\Day;
use Core\Helper\Splitter;

class Day_14 extends Day
{
    protected function part_1()
    {
        $input = Splitter::splitOnLinebreak($this->input);
        // find out if its a test case on the assumption that if the input is less than 100 lines its too simple to be the actual puzzle input;
        [$width, $height] = count($input) < 100 ? [11, 7] : [101, 103];
        // initialise the 4 counters
        [$tl, $tr, $bl, $br] = [0, 0, 0, 0];
        $cut_x = ($width + 1) / 2 - 1;
        $cut_y = ($height + 1) / 2 - 1;
        foreach ($input as $inp) {
            preg_match_all("/-?\d+/", $inp, $out);
            // parse the regex into the correct variables;
            [$ini_x, $ini_y, $vec_x, $vec_y] = [$out[0][0], $out[0][1], $out[0][2], $out[0][3]];
            $final_x = ($ini_x + 100 * $vec_x) % $width;
            $final_y = ($ini_y + 100 * $vec_y) % $height;
            // correct for negatives 
            $final_x += $final_x < 0 ? $width : 0;
            $final_y += $final_y < 0 ? $height : 0;
            if ($final_x < $cut_x) {
                if ($final_y < $cut_y) {
                    $bl++;
                } elseif ($final_y > $cut_y) {
                    $tl++;
                }
            } elseif ($final_x > $cut_x) {
                if ($final_y < $cut_y) {
                    $br++;
                } elseif ($final_y > $cut_y) {
                    $tr++;
                }
            }
        }
        echo "$tl, $br, $tr, $br";
        $ans = $tl * $bl * $tr * $br;
        return "the safety factor after 100 seconds was $ans";
    }

    protected function part_2()
    {
        $input = Splitter::splitOnLinebreak($this->input);
        // find out if its a test case on the assumption that if the input is less than 100 lines its too simple to be the actual puzzle input;
        [$width, $height] = count($input) < 100 ? [11, 7] : [101, 103];
        $robot_count = count($input);
        foreach ($input as $inp) {
            preg_match_all("/-?\d+/", $inp, $out);
            // parse the regex into the correct variables;
            $robot[] = [$out[0][0], $out[0][1], $out[0][2], $out[0][3]];
        }
        $or_rob = $robot;
        $min_var_x = INF;
        $min_var_y = INF;
        for ($i = 1; $i <= 103; $i++) {
            $nr = [];
            // calculate next position
            foreach ($robot as [$x, $y, $v_x, $v_y]) {
                $nx = ($x + $v_x) % $width;
                $nx += $nx < 0 ? $width : 0;
                $ny = ($y + $v_y) % $height;
                $ny += $ny < 0 ? $height : 0;
                $nr[] = [$nx, $ny, $v_x, $v_y];
            }
            $robot = $nr;
            // calculate average x and y

            $avg_x = 0;
            $avg_y = 0;
            foreach ($nr as [$x, $y, $v_x, $v_y]) {
                $avg_x += $x;
                $avg_y += $y;
            }
            $avg_x /= $robot_count;
            $avg_y /= $robot_count;

            // calculate variance from average;
            $var_x = 0;
            $var_y = 0;
            foreach ($robot as [$x, $y, $v_x, $v_y]) {
                $var_x += ($x - $avg_x) ** 2;
                $var_y += ($y - $avg_y) ** 2;
            }
            $var_x /= $robot_count;
            $var_y /= $robot_count;

            if ($var_x < $min_var_x) {
                $min_var_x = $var_x;
                $t_var_x = $i;
            }
            if ($var_y < $min_var_y) {
                $min_var_y = $var_y;
                $t_var_y = $i;
            }
        }

        // find frame on which both overlap by sieving for it
        for ($frame = $t_var_y; $frame < $width * $height; $frame += $height) {
            if ($frame % $width == $t_var_x) {
                break;
            }
        }

        // generate map at this frame for fun
        foreach ($or_rob as [$x, $y, $v_x, $v_y]) {
            $f_x = ($x + $frame * $v_x) % $width;
            $f_x += $f_x < 0 ? $width : 0;
            $f_y = ($y + $frame * $v_y) % $height;
            $f_y += $f_y < 0 ? $height : 0;
            $f[$f_y][$f_x] = 1;
        }

        $map = "";
        for ($y = 0; $y < $height; $y++) {
            for ($x = 0; $x < $width; $x++) {
                $map .= isset($f[$y][$x]) ? "*" : ".";
            }
            $map .= "\r\n";
        }



        return "at $t_var_x s the robots clustered around a vertical line  \r\n and at $t_var_y s the robots clustered around a horizontal line \r\n this means that at frame $frame there should be a christmas tree as that is when the robots first have low variance on both a vertical and a horizontal line \r\n that would look like \r\n $map \r\n";
    }
}