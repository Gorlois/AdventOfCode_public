<?php
namespace Core\Solvers\AOC2023;

use Core\Helper\Splitter;
use Core\Solvers\Day;

class Day_06 extends Day {
    protected function part_1() {
        $regexPattern = "/\d+/";
        $num = [];
        preg_match_all($regexPattern, $this->input, $num);
        $num = $num[0];
        $c_h = count($num) / 2;
        $tot = 1;
        for ($i = 0; $i < $c_h; $i++) {
            $time = (int) $num[$i];
            $dist = (int) $num[$i+$c_h];
            $tot_2 = -1;
            if ($time % 2 == 0) {
                $t_h = $time / 2;                
            } else {
                $tot_2--;
                $t_h = ($time + 1) / 2;
            }
            while ($dist < ($time - $t_h) * $t_h) {
                $t_h--;
                $tot_2+=2;
            }
            $tot *= $tot_2;
        }
        return "there are $tot combinations of ways to win each race \r\n";
    }

    protected function part_2() {
        $ss = Splitter::splitOnLinebreak($this->input);
        $time = (int) preg_replace("/[^\d]+/", "", $ss[0]);
        $dist = (int) preg_replace("/[^\d]+/", "", $ss[1]);
        $tot = -1;
        if ($time % 2 == 0) {
            $t_h = $time / 2;                
        } else {
            $tot--;
            $t_h = ($time + 1) / 2;
        }
        while ($dist < ($time - $t_h) * $t_h) {
            $t_h--;
            $tot+=2;
        }
        $tot;
        return "you can win this race in $tot ways \r\n";
    }

}