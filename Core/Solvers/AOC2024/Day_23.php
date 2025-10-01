<?php
namespace Core\Solvers\AOC2024;

use Core\Helper\Splitter;

class Day_23 extends Day {
    protected function part_1() {
        foreach (Splitter::splitOnLinebreak($this->input) as $inp) {
            [$conn1, $conn2] = explode("-", $inp);
            $N[$conn1][] = $conn2;
            $N[$conn2][] = $conn1;
        }

        $cliques = [];
        $this->find_nCliques($N, [], array_keys($N), 3, $cliques);

        $ans = 0;

        foreach ($cliques as $clique) {
            foreach ($clique as $conn) {
                if (str_starts_with($conn, "t")) {
                    $ans++;
                    break;
                }
            }
        }

        return "there were $ans interconnected pcs with at least one pc starting with the letter \"t\"";
    }

    private function find_nCliques($N, $R = [], $P, $n, &$out) {
        if (count($R) == $n) {
            $out[] = $R;
            return $out;
        }

        while (!empty($P)) {
            $v = array_shift($P);
            $this->find_nCliques($N, array_merge($R, [$v]), array_intersect($P, $N[$v]), $n, $out);
        }
    }

    protected function part_2() {
        foreach (Splitter::splitOnLinebreak($this->input) as $inp) {
            [$conn1, $conn2] = explode("-", $inp);
            $N[$conn1][] = $conn2;
            $N[$conn2][] = $conn1;
        }
        $V = array_keys($N);

        $cliques = [];
        $this->findMaxCliques($N, [], $V, [], $cliques);

        $max_s = 0;
        foreach ($cliques as $clique) {
            $s = count($clique);
            if ($s > $max_s) {
                $max_clique = $clique;
                $max_s = $s;
            }
        }

        sort($max_clique, SORT_STRING);

        $ans = implode(",", $max_clique);
        

        return "the password ended up being \"$ans\"";
    }

    private function findMaxCliques($N, $R, $P, $X, &$out) {

        // uses bron kerbosch algorithm

        if (!$P && !$X) {
            $out[] = $R;
            return;
        }

        while (!empty($P)) {
            $v = array_shift($P);
            $this->findMaxCliques($N, array_merge($R, [$v]), array_intersect($P, $N[$v]), array_intersect($X, $N[$v]), $out);
            $X = array_merge($X, [$v]);
        }
    }
}