<?php
namespace Core\Solvers\AOC2024;

use Core\Solvers\Day;
use Core\Helper\Splitter;

class Day_25 extends Day {
        protected function part_1() {
        // loop through input
        foreach(Splitter::splitOnEmpty($this->input) as $inp) {
            $is_lock = false;
            $pins = [];
            foreach (Splitter::splitOnLinebreak($inp) as $y => $row) {
                foreach (str_split($row) as $x => $c) {
                    // if first character of the first row is an # the input is considered a lock
                    if ($y == 0 && $x == 0 && $c == "#") {
                        $is_lock = true;
                    }

                    // initialise pins at -1 because the top and bottom rows dont count
                    if ($c == "#") {
                        $pins[$x] ??= -1;
                        $pins[$x]++;
                    }
                }
            }

            if ($is_lock) {
                $locks[] = $pins;
            } else {
                $keys[] = $pins;
            }
        }

        // loop every key through every lock;
            // checking if the combined total of individual pins is < 6 (and thus fits);
                // if so increment answer for having found a correct combination
        $ans = 0;
        foreach ($locks as $lock) {
            foreach ($keys as $key) {
                $pin_it = count($key);
                $is_fit = true;
                if($pin_it == count($lock)) {
                    for ($it = 0; $it < $pin_it; $it++) {
                        if ($key[$it] + $lock[$it] < 6) {
                            continue;
                        } else {
                            $is_fit = false;
                            break;
                        }
                    }
                    if ($is_fit) {
                        $ans++;
                    }
                } else {
                    throw new \Exception("key pins and lock tumblers werent equal");
                }
            }
        }
        return "there were $ans combinations of locks and keys that sort of fit";
    }

    protected function part_2() {
        return "the second part was a freebie! I am done! WE ARE FREE!!!";
    }

}