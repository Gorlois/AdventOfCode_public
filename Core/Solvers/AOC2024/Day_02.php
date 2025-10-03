<?php
namespace Core\Solvers\AOC2024;

use Core\Helper\Splitter;
use Core\Solvers\Day;

class Day_02 extends Day
{
    protected function part_1()
    {
        $ans = 0;
        foreach (Splitter::splitOnLinebreak($this->input) as $inp) {
            $lvls = array_map("intval", explode(" ", $inp));
            if ($this->check($lvls)) {
                $ans++;
            }
        }
        return "there are $ans safe reports";
    }

    protected function part_2()
    {
        $ans = 0;
        foreach (Splitter::splitOnLinebreak($this->input) as $inp) {
            $lvls = array_map("intval", explode(" ", $inp));
            if ($this->check($lvls)) {
                $ans++;
            } else {
                for ($i = 0; $i < count($lvls); $i++) {
                    $dup = $lvls;
                    unset($dup[$i]);
                    if ($this->check(array_values($dup))) {
                        $ans++;
                        break 1;
                        ;
                    }
                }
            }
        }
        return "after dampening there were $ans safe reports";
    }

    private function check(array $lvls)
    {
        $size = count($lvls);
        if ($size > 1) {
            $sign = $lvls[1] <=> $lvls[0];
            for ($i = 1; $i < $size; $i++) {
                $dif = ($lvls[$i] - $lvls[$i - 1]) * $sign;
                if ($dif < 1 || $dif > 3) {
                    return false;
                }
            }
        }
        return true;
    }
}