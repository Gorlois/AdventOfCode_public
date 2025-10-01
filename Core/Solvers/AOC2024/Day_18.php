<?php
namespace Core\Solvers\AOC2024;

use Core\Helper\Splitter;

class Day_18 extends Day
{
    protected function part_1()
    {
        $inp = Splitter::splitOnLinebreak($this->input);
        // decide on map sizes depending on input size small input = test thus use test values
        [$x_size, $y_size, $sim_t] = count($inp) < 50 ? [6, 6, 12] : [70, 70, 1024];

        // create map array
        for ($y = 0; $y <= $y_size; $y++) {
            for ($x = 0; $x <= $x_size; $x++) {
                $map[$y][$x] = 0;
            }
        }
        // simulate time
        for ($t = 0; $t < $sim_t; $t++) {
            [$x, $y] = explode(",", $inp[$t]);
            $map[$y][$x] = 1;
        }

        // create V and N;
        foreach ($map as $y => $row) {
            foreach ($row as $x => $byte) {
                if ($byte == 0) {
                    $n = [];
                    foreach ([[$y, $x - 1], [$y, $x + 1], [$y - 1, $x], [$y + 1, $x]] as [$ny, $nx]) {
                        if (($map[$ny][$nx] ?? -1) == 0) {
                            $n["$ny,$nx"] = 1;
                        }
                    }
                    $V[] = "$y,$x";
                    $N["$y,$x"] = $n;
                }
            }
        }

        // use dijkstra's 
        foreach ($V as $v) {
            $dist[$v] = INF;
            $Q[$v] = $dist[$v];
        }
        $s = "0,0";
        $end = "$y_size,$x_size";
        $dist[$s] = 0;
        $Q[$s] = 0;

        while (!empty($Q)) {
            $u = array_search(min($Q), $Q);
            unset($Q[$u]);

            if ($u == $end) {
                break;
            }

            foreach (array_intersect_key($N[$u], $Q) as $v => $edge_cost) {
                $alt = $dist[$u] + $edge_cost;
                if ($alt < $dist[$v]) {
                    $dist[$v] = $alt;
                    $Q[$v] = $dist[$v];
                }
            }
        }

        $ans = $dist[$end];
        return "you reached $y_size, $x_size in $ans";
    }

    protected function part_2()
    {
        $inp = Splitter::splitOnLinebreak($this->input);
        // decide on map sizes depending on input size small input = test thus use test values
        [$x_size, $y_size, $sim_t] = count($inp) < 50 ? [6, 6, 12] : [70, 70, 1024];

        // create map array
        for ($y = 0; $y <= $y_size; $y++) {
            for ($x = 0; $x <= $x_size; $x++) {
                $map[$y][$x] = 0;
            }
        }

        // simulate sim_t (you know that you can reach end from this point) so assign this map as the min map and this time as the min_t
        for ($t = 0; $t < $sim_t; $t++) {
            [$x, $y] = explode(",", $inp[$t]);
            $map[$y][$x] = 1;
        }

        // assign this as the min_map
        $min_map = $map;
        $min_t = $sim_t;
        $max_t = count($inp);
        $prev_t = null;
        // initialise piv_t as being the halfway point between max t and min t;
        $piv_t = $min_t + floor(($max_t - $min_t) / 2);

        do {
            // assign simulated map with map at min_t
            $sim_map = $min_map;

            // simulate the rest of the bytes to piv_t falling
            for ($t = $min_t; $t < $piv_t; $t++) {
                [$x, $y] = explode(",", $inp[$t]);
                $sim_map[$y][$x] = 1;
            }

            $V = [];
            $N = [];
            // create V and N;
            foreach ($sim_map as $y => $row) {
                foreach ($row as $x => $byte) {
                    if ($byte == 0) {
                        $n = [];
                        foreach ([[$y, $x - 1], [$y, $x + 1], [$y - 1, $x], [$y + 1, $x]] as [$ny, $nx]) {
                            if (($sim_map[$ny][$nx] ?? -1) == 0) {
                                $n["$ny,$nx"] = 1;
                            }
                        }
                        $V[] = "$y,$x";
                        $N["$y,$x"] = $n;
                    }
                }
            }

            $dist = [];
            $Q = [];
            // use dijkstra's 
            foreach ($V as $v) {
                $dist[$v] = INF;
                $Q[$v] = $dist[$v];
            }
            $s = "0,0";
            $end = "$y_size,$x_size";
            $dist[$s] = 0;
            $Q[$s] = 0;

            while (!empty($Q)) {
                $u = array_search(min($Q), $Q);
                unset($Q[$u]);

                if ($u == $end) {
                    break;
                }

                foreach (array_intersect_key($N[$u], $Q) as $v => $edge_cost) {
                    $alt = $dist[$u] + $edge_cost;
                    if ($alt < $dist[$v]) {
                        $dist[$v] = $alt;
                        $Q[$v] = $dist[$v];
                    }
                }
            }

            // assign piv t as either new max_t or min_t (and sim map to min map if new min t was assigned);
            if ($dist[$end] == INF) {
                $max_t = $piv_t;
            } else {
                $min_t = $piv_t;
                $min_map = $sim_map;
            }

            // assign this piv_t as the previous piv_t and calculate the next piv_t
            $prev_t = $piv_t;
            $piv_t = $min_t + floor(($max_t - $min_t) / 2);
        } while ($piv_t != $prev_t);
        return "the first byte that makes reaching the exit impossible was $inp[$piv_t]";
    }
}