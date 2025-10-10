<?php
namespace Core\Solvers\AOC2023;

use Core\Helper\Splitter;
use Core\Solvers\Day;

class Day_09 extends Day {
    protected function part_1() {
        $ans = 0;
        foreach (Splitter::splitOnLinebreak($this->input) as $inp) {
            $nums = explode(" ", $inp);
            $c = count($nums);
            $lasts = $this->extrapolate($nums, $c, []);
            $prev = 0;
            foreach(array_reverse($lasts) as $last) {
                $prev = $last + $prev;
                $extrapolated_row[] = $prev;
            }
            $ans+=end($extrapolated_row);
        }
        return "the sum of all extrapolated numbers is $ans";
    }

    private function extrapolate(array $numbers, int $count, array $lasts) {
        $difs_count = 0;
        $nodifs_count = 0;

        for ($i = 0; $i < $count - 1; $i++) {
            $dif = (int)$numbers[$i+1] - (int)$numbers[$i];
            if ($dif == 0) {
                $nodifs_count++;
            }
            $difs_count++;
            $deeper[] = $dif;
        }

        $lasts[] = $numbers[$count-1];

        if ($nodifs_count != $difs_count) {
            return $this->extrapolate($deeper, count($deeper), $lasts);
        } else {
            return $lasts;
        }



    }

    protected function part_2() {
        $ans = 0;
        
        foreach (Splitter::splitOnLinebreak($this->input) as $inp) {
            $nums = array_reverse(explode(" ", $inp));
            $c = count($nums);
            $lasts = $this->extrapolate($nums, $c, []);
            $prev = 0;
            foreach(array_reverse($lasts) as $last) {
                $prev = $last + $prev;
                $extrapolated_row[] = $prev;
            }
            $ans+=end($extrapolated_row);
        }
        
        return "the sum of all extrapolated numbers is $ans";
    }

}