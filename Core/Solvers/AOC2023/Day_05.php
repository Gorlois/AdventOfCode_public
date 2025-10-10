<?php
namespace Core\Solvers\AOC2023;

use Core\Helper\Splitter;
use Core\Solvers\Day;

class Day_05 extends Day {
        protected function part_1() {
        $steps = Splitter::splitOnEmpty($this->input);
        $list = [];

        for ($i_1 = 1; $i_1 < count($steps); $i_1++) {
            $bits = explode("\r\n", $steps[$i_1]);
            for ($i_2 = 1; $i_2 < count($bits); $i_2++) {
                [$dest, $source, $range] = explode(" ", $bits[$i_2], 3);
                $list[$i_1-1][(int) $source] = ['dest' => (int) $dest, 'range' => (int) $range];
            }
        }

        $seeds = explode(' ', $steps[0]);
        $min = INF;
        for ($i = 1; $i < count($seeds); $i++) {
            $loc = $seeds[$i];
            for ($i_2 = 0; $i_2 < count($list); $i_2++) {
                foreach ($list[$i_2] as $key => $stuff) {
                    if ($loc > $key && $loc < $key + $stuff['range']) {
                        $loc = $stuff['dest'] + ($loc - $key);
                        break;
                    }
                }                
            }
            if ($loc < $min) {
                $min = $loc;
            }
        }
        
        return "the lowest location number in the initial seed numbers was $min";
    }

    protected function part_2() {
        $steps = Splitter::splitOnEmpty($this->input);
        $list = [];
        for ($i_1 = 1; $i_1 < count($steps); $i_1++) {
            $bits = explode("\r\n", $steps[$i_1]);
            for ($i_2 = 1; $i_2 < count($bits); $i_2++) {
                [$dest, $source, $range] = explode(" ", $bits[$i_2], 3);
                $list[$i_1-1][(int) $source] = ['dest' => (int) $dest, 'range' => (int) $range];
            }
        }
        $seeds = explode(' ', $steps[0]);
        $min = INF;
        $seed_pairs = [];
        for ($i=1; $i < count($seeds); $i+=2) {
            $seed_pairs[] = ['start' => $seeds[$i], 'range' => $seeds[$i+1]];
        }

        // you throw the seed ranges into the function and get a new list of seed ranges back 

        for ($list_i = 0; $list_i < count($list); $list_i++) {
            $seed_pairs = $this->calcnewpairs($list[$list_i], $seed_pairs);
        }

        // get the lowest starting point of the final seed pairs this is the answer
        foreach ($seed_pairs as $pair) {
            if ($pair['start'] < $min) {
                $min = $pair['start'];
            }
        }

        return "the lowest seed position is = $min";
    }

    private function calcnewpairs(array $list, array $seedpairs) {
        $listsize = count($list);
        $new_pairs = [];
        while (!empty($seedpairs)) {

            $pair = array_shift($seedpairs);
            $ls = $listsize;

        // go through list to see alterations
            foreach ($list as $key => $stuff) {
        // if the seed range start is in the range of an alteration
                if ($pair['start'] >= $key && $pair['start'] < $key + $stuff['range']) {
                    // calculate the altered location for the first seed of a seed rang
                    $np_first = $stuff['dest'] + $pair['start'] - $key;
                    // check if the seed range is larger than the alteration range
                    if (((int) $pair['start'] + (int) $pair['range']) >= ((int) $key + (int) $stuff['range'])) {
                        // add the overlapping seed range to output;
                        $ran = $stuff['range'] - ($pair['start'] - $key);                
                        $new_pairs[] = ['start' => $np_first, 'range' => $ran];
                        // calculate new start of resting range and add it to the seedpair buffer;
                        $a = $key+$stuff['range'];
                        $rl = $pair['start']+$pair['range']-$a;
                        $seedpairs[] = ['start' => $a, 'range' => $rl];
                    } else {
                        // if not add the complete altered seed range to output
                        $new_pairs[] = ['start' => $np_first, 'range' => $pair['range']];
                    }                    
                    break;
                } else {
        // if there was no new location for the seed range add it to the output seed ranges
                    $ls--;
                    if($ls == 0){
                        $new_pairs[] = $pair;
                    } 
                }
            }
        }

        $totran = 0;
        foreach ($new_pairs as $pair) {
            $totran+=$pair['range'];
        }
        
        // echo print_r($new_pairs, true)."<br>number of seeds = $totran<br>";

        return $new_pairs;
    }
}