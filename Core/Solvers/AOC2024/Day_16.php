<?php
namespace Core\Solvers\AOC2024;

use Core\Helper\Splitter;

class Day_16 extends Day
{
    protected function part_1()
    {
        foreach (Splitter::splitOnLinebreak($this->input) as $y => $row) {
            foreach (str_split($row) as $x => $tile) {
                if ($tile == "S") {
                    [$start_y, $start_x] = [$y, $x];
                } elseif ($tile == "E") {
                    [$end_y, $end_x] = [$y, $x];
                }
                $map[$y][$x] = $tile;
            }
        }

        // set up Vertex and Neighbour arrays
        $V = [];
        foreach ($map as $y => $row) {
            foreach ($row as $x => $tile) {
                if ($tile != "#") {
                    $w = "$y,$x,w";
                    $a = "$y,$x,a";
                    $s = "$y,$x,s";
                    $d = "$y,$x,d";
                    $V = array_merge($V, [$w, $a, $s, $d]);
                    // set neighbours for w
                    $N[$w][$a] = 1000;
                    $N[$w][$d] = 1000;
                    $alt = $y - 1;
                    if (($map[$alt][$x] ?? 0) != '#') {
                        $n = "$alt,$x,w";
                        $N[$w][$n] = 1;
                    }

                    // set neighbours for a
                    $N[$a][$w] = 1000;
                    $N[$a][$s] = 1000;
                    $alt = $x - 1;
                    if (($map[$y][$alt] ?? 0) != '#') {
                        $n = "$y,$alt,a";
                        $N[$a][$n] = 1;
                    }

                    // set neighbours for s
                    $N[$s][$a] = 1000;
                    $N[$s][$d] = 1000;
                    $alt = $y + 1;
                    if (($map[$alt][$x] ?? 0) != '#') {
                        $n = "$alt,$x,s";
                        $N[$s][$n] = 1;
                    }

                    // set neighbours for d
                    $N[$d][$w] = 1000;
                    $N[$d][$s] = 1000;
                    $alt = $x + 1;
                    if (($map[$y][$alt] ?? 0) != '#') {
                        $n = "$y,$alt,d";
                        $N[$d][$n] = 1;
                    }
                }
            }
        }

        // use dijkstra's algorithm to find the map the cost for each vertex;
        foreach ($V as $v) {
            $dist[$v] = INF;
        }

        $start = "$start_y,$start_x,d";
        $dist[$start] = 0;

        $Q[$start] = 0;

        while (!empty($Q)) {
            $u = array_search(min($Q), $Q);
            unset($Q[$u]);

            foreach ($N[$u] as $n => $c) {
                $alt = $dist[$u] + $c;
                if ($alt < $dist[$n]) {
                    $dist[$n] = $alt;
                    $Q[$n] = $alt;
                }
            }
        }

        // find out which of the 4 end nodes has the shortest path
        $ans = INF;
        $end = "$end_y,$end_x";
        foreach (["$end,w", "$end,a", "$end,s", "$end,d"] as $e_n) {
            if ($ans > $dist[$e_n]) {
                $ans = $dist[$e_n];
            }
        }

        return "the shortest distance to the end was $ans";
    }

    protected function part_2()
    {
        foreach (Splitter::splitOnLinebreak($this->input) as $y => $row) {
            foreach (str_split($row) as $x => $tile) {
                if ($tile == "S") {
                    [$start_y, $start_x] = [$y, $x];
                } elseif ($tile == "E") {
                    [$end_y, $end_x] = [$y, $x];
                }
                $map[$y][$x] = $tile;
            }
        }

        // set up Vertex and Neighbour arrays
        $V = [];
        foreach ($map as $y => $row) {
            foreach ($row as $x => $tile) {
                if ($tile != "#") {
                    $w = "$y,$x,w";
                    $a = "$y,$x,a";
                    $s = "$y,$x,s";
                    $d = "$y,$x,d";
                    $V = array_merge($V, [$w, $a, $s, $d]);
                    // set neighbours for w
                    $N[$w][$a] = 1000;
                    $N[$w][$d] = 1000;
                    $alt = $y - 1;
                    if (($map[$alt][$x] ?? 0) != '#') {
                        $n = "$alt,$x,w";
                        $N[$w][$n] = 1;
                    }

                    // set neighbours for a
                    $N[$a][$w] = 1000;
                    $N[$a][$s] = 1000;
                    $alt = $x - 1;
                    if (($map[$y][$alt] ?? 0) != '#') {
                        $n = "$y,$alt,a";
                        $N[$a][$n] = 1;
                    }

                    // set neighbours for s
                    $N[$s][$a] = 1000;
                    $N[$s][$d] = 1000;
                    $alt = $y + 1;
                    if (($map[$alt][$x] ?? 0) != '#') {
                        $n = "$alt,$x,s";
                        $N[$s][$n] = 1;
                    }

                    // set neighbours for d
                    $N[$d][$w] = 1000;
                    $N[$d][$s] = 1000;
                    $alt = $x + 1;
                    if (($map[$y][$alt] ?? 0) != '#') {
                        $n = "$y,$alt,d";
                        $N[$d][$n] = 1;
                    }
                }
            }
        }

        // map the lowest cost to every vertex with a horrific mutant dijkstra / bfs;
        foreach ($V as $v) {
            $dist[$v] = INF;
        }

        $start = "$start_y,$start_x,d";
        $dist[$start] = 0;
        $prev[$start] = [-1];

        $Q[] = $start;

        while (!empty($Q)) {
            $u = array_shift($Q);
            foreach ($N[$u] as $n => $c) {
                $alt = $dist[$u] + $c;
                if ($alt < $dist[$n]) {
                    $dist[$n] = $alt;
                    $Q[] = $n;
                    $prev[$n] = [$u];
                } elseif ($alt === $dist[$n]) {
                    $prev[$n][] = $u;
                }
            }
        }

        // find out which of the 4 end nodes has the shortest path
        $shortest_route = INF;
        $end = "$end_y,$end_x";
        foreach (["$end,w", "$end,a", "$end,s", "$end,d"] as $e_n) {
            if ($shortest_route > $dist[$e_n]) {
                $shortest_end = $e_n;
                $shortest_route = $dist[$e_n];
            }
        }

        $paths = [];
        $this->rec_path($paths, [], $prev, $shortest_end);
        $tiles = [];
        foreach ($paths as $p) {
            foreach ($p as $t) {
                $t_short = substr($t, 0, -2);
                $tiles[$t_short] = 1;
            }
        }
        $ans = count($tiles);

        return "there where $ans unique tiles along the various shortest routes";
    }

    private function rec_path(&$paths, $path, $prev, $node)
    {
        if ($node === -1) {
            $paths[] = $path;
            return;
        }
        $path[] = $node;
        foreach ($prev[$node] as $u) {
            $this->rec_path($paths, $path, $prev, $u);
        }
    }
}