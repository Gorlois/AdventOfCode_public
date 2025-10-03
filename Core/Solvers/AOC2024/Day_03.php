<?php
namespace Core\Solvers\AOC2024;

use Core\Helper\Splitter;
use Core\Solvers\Day;

class Day_03 extends Day
{
    protected function part_1()
    {
        $ans = 0;
        foreach (Splitter::splitOnLinebreak($this->input) as $inp) {
            $ans += $this->solveMul($inp);
        }
        return "You get $ans if you add up the results of all valid multiplications";
    }

    protected function part_2()
    {
        $ans = 0;
        // make input a singular string 
        $inp = str_replace("\r\n", "", $this->input);
        // go over input to find all enabled bits with the recursive function
        $ans += $this->recSkip($inp);
        return "You get $ans if you add up the results of the enabled bits";
    }

    private function solveMul(string $inp)
    {
        $t = 0;
        $reg_pat = "/mul\(\d{1,3},\d{1,3}\)/";
        preg_match_all($reg_pat, $inp, $muls);
        foreach ($muls[0] as $mul) {
            $ps = explode(",", $mul);
            $a = substr($ps[0], 4);
            $b = substr($ps[1], 0, -1);
            $t += $a * $b;
        }
        return $t;
    }

    private function recSkip(string $inp, bool $skip = false, int $tot = 0)
    {
        if (strlen($inp) > 0) {
            if ($skip) {
                $pattern = "/do\(\)/";
                preg_match($pattern, $inp, $match, PREG_OFFSET_CAPTURE);
                if ($match) {
                    $offset = $match[0][1];
                    $string_to_check = substr($inp, $offset);
                } else {
                    $string_to_check = "";
                }
                return $this->recSkip($string_to_check, false, $tot);
            } else {
                $pattern = "/don't\(\)/";
                preg_match($pattern, $inp, $match, PREG_OFFSET_CAPTURE);
                if ($match) {
                    $offset = $match[0][1];
                    $string_with_valid_muls = substr($inp, 0, $offset);
                    $string_to_skip = substr($inp, $offset);
                } else {
                    $string_with_valid_muls = $inp;
                    $string_to_skip = "";
                }
                $tot += $this->solveMul($string_with_valid_muls);
                return $this->recSkip($string_to_skip, true, $tot);
            }
        } else {
            return $tot;
        }
    }
}