<?php
namespace Core\Solvers\AOC2024;

use Core\Helper\Splitter;

class Day_22 extends Day {
    protected function part_1() {
        $ans = 0;
        foreach(Splitter::splitOnLinebreak($this->input) as $inp) {
            $s = (int) $inp;
            for ($i = 0; $i < 2000; $i++) {
                $s = ($s ^ ($s<<6)) & (2**24-1);
                $s = ($s ^ ($s>>5));
                $s = ($s ^ ($s<<11)) & (2**24-1);
            }
            $ans+=$s;
        }
        return "the combined total of all secret numbers was $ans";
    }

    protected function part_2() {
        $sec_gen = 2000;
        foreach (Splitter::splitOnLinebreak($this->input) as $inp_pointer => $inp) {
            $s = (int) $inp;
            $secrets = [$s % 10];
            $delts = [];       
            for ($i = 0; $i < $sec_gen; $i++) {
                $s = ($s ^ ($s<<6)) & (2**24-1);
                $s = ($s ^ ($s>>5));
                $s = ($s ^ ($s<<11)) & (2**24-1);
                $secrets[] = $s % 10;
            }

            for ($i = 4; $i < $sec_gen+1; $i++) {
                [$d1, $d2, $d3, $d4] = [$secrets[$i-3]-$secrets[$i-4], $secrets[$i-2]-$secrets[$i-3], $secrets[$i-1]-$secrets[$i-2], $secrets[$i]-$secrets[$i-1]];
                $delts["$d1,$d2,$d3,$d4"] ??= $secrets[$i];
            }

            $all_difs[$inp_pointer] = $delts;
        }

        foreach ($all_difs as $difs) {
            foreach ($difs as $sequence => $bananas) {
                $totals[$sequence] ??= 0;
                $totals[$sequence]+=$bananas;
            }
        }

        $max = 0;
        foreach ($totals as $sequence => $bananas) {
            if ($bananas > $max) {
                $max = $bananas;
                $best_sequence = $sequence;
                $best_return = $bananas;
            }
        }

        return "the sequence $best_sequence had the best return at $best_return bananas";
    }

}