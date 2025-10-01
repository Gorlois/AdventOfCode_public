<?php
namespace Core\Solvers\AOC2024;

use Core\Helper\Splitter;

class Day_09 extends Day {
    protected function part_1() {
        $ans = 0;
        // sanitize input string
        $inp = Splitter::mergeOnLinebreak($this->input);
        
        // initialize id and pos (p) counters;
        $id = 0;
        $p = 0;
        // construct the memory array consisting out of bits of "memory" with an "id", "pos" and "len"
        for ($i = 0; $i < strlen($inp); $i++) {
            $l = (int) $inp[$i];
            $cid = $i%2==0 ? $id : false;
            while ($l > 0) {
                $memory[] = ['id' => $cid, 'pos' => $p, 'len' => 1];
                $l--;
                $p++;
            }
            $id+= $i%2==0 ? 1 : 0;
        }

        // iterate over the memory array from the back to get filled memory objects;
        $i_s = 0;
        for ($i = count($memory) - 1; $i >= 0; $i--) {
            for ($i_f = $i_s; $memory[$i]['id'] && $i_f < $i; $i_f++) {
                if (
                    $memory[$i_f]['id'] === false &&
                    $memory[$i_f]['pos'] <= $memory[$i]['pos'] &&
                    $memory[$i]['len'] <= $memory[$i_f]['len']
                ) {
                    $memory[$i]['pos']=$memory[$i_f]['pos'];
                    $memory[$i_f]['pos']+=$memory[$i]['len'];
                    $memory[$i_f]['len']-=$memory[$i]['len'];
                    $i_s = $i_f;
                    break;
                }
            }
        }

        foreach ($memory as ['id' => $id, 'pos' => $pos, 'len' => $l]) {
            if ($id) {
                $ans+=$id*$pos;
            }
        }

        return "the checksum for the disk is $ans";
    }

    protected function part_2() {
        $ans = 0;
        // sanitize input string
        $inp = Splitter::mergeOnLinebreak($this->input);
        
        // initialize id and pos (p) counters;
        $id = 0;
        $p = 0;
        // construct the mem array consisting out of bits of "memory" with an "id", "pos" and "len"
        for ($i = 0; $i < strlen($inp); $i++) {
            $l = (int) $inp[$i];
            $cid = $i%2==0 ? $id : false;
            $memory[] = ['id' => $cid, 'pos' => $p, 'len' => $l];
            $p+=$l;
            $id+= $i%2==0 ? 1 : 0;
        }

        // iterate over the memory$memory array from the back to get filled memory$memory objects knowing that they are on the n, n-2 etc positions with n being the last;
        for ($i = count($memory) - 1; $i >= 0; $i-=2) {
            // knowing that the free memory$memory cells are on all odd numbers in the array 1, 3 etc iterate over those;
            for ($i_f = 1; $i_f < $i; $i_f+=2) {
                if (
                    $memory[$i_f]['pos'] <= $memory[$i]['pos'] &&
                    $memory[$i]['len'] <= $memory[$i_f]['len']
                ) {
                    $memory[$i]['pos']=$memory[$i_f]['pos'];
                    $memory[$i_f]['pos']+=$memory[$i]['len'];
                    $memory[$i_f]['len']-=$memory[$i]['len'];
                    break;
                }
            }
        }

        foreach ($memory as ['id' => $id, 'pos' => $pos, 'len' => $l]) {
            if ($id) {                
                $ans += $l * $id * ($pos + ($l - 1)/ 2);
            }
        }

        return "the checksum for the disk is $ans";
    }

}