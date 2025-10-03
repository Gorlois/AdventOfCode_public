<?php 
namespace Core\Solvers\AOC2024;

use Core\Helper\Splitter;
use Core\Solvers\Day;

class Day_07 extends Day {
    protected function part_1() {
        $ans = 0;
        foreach (Splitter::splitOnLinebreak($this->input) as $inp) {
            $bs = explode(": ", $inp);
            $big = (int) $bs[0];
            $littles = explode(" ", $bs[1]);

            $f = (int) array_shift($littles);
            $pos = [$f];
            while (!empty($littles)) {
                $small = (int) array_shift($littles);
                $npos = [];
                
                while(!empty($pos)) {
                    $c = array_pop($pos);
                    $mul = $c * $small;
                    $add = $c + $small;
                    
                    if ($mul <= $big) {
                        $npos[] = $mul;
                    }
                    if ($add <= $big) {
                        $npos[] = $add;
                    }
                }
                $pos = $npos;
                
            }
            if (in_array($big, $pos)) {
                $ans+=$big;
            }
        }
        return "the total calibration result was $ans";
    }

    protected function part_2() {
        $ans = 0;
        foreach (Splitter::splitOnLinebreak($this->input) as $inp) {
            $bs = explode(": ", $inp);
            $big = (int) $bs[0];
            $littles = explode(" ", $bs[1]);

            $f = (int) array_shift($littles);
            $pos = [$f];
            while (!empty($littles)) {
                $small = (int) array_shift($littles);
                $npos = [];
                
                while(!empty($pos)) {
                    $c = array_pop($pos);
                    $mul = $c * $small;
                    $add = $c + $small;
                    $con = (int) ((string)$c.(string)$small);
                    
                    if ($mul <= $big) {
                        $npos[] = $mul;
                    }
                    if ($add <= $big) {
                        $npos[] = $add;
                    }
                    if ($con <= $big) {
                        $npos[] = $con;
                    }
                }
                $pos = $npos;
                
            }
            if (in_array($big, $pos)) {
                $ans+=$big;
            }
        }
        return "the total calibration result was $ans";
    }
}