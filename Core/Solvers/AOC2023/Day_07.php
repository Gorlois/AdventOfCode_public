<?php
namespace Core\Solvers\AOC2023;

use Core\Helper\Splitter;
use Core\Solvers\Day;

class Day_07 extends Day {
    protected function part_1() {
        $hands_by_type = [];
        foreach (Splitter::splitOnLinebreak($this->input) as $inp) {
            [$hand, $bid] = explode(" ", $inp, 2);
            [$h, $t] = $this->assignType($hand);
            $hands_by_type[$t][$h] = $bid; 
        }
        ksort($hands_by_type);
        $r = 1;
        $tot = 0;
        while (!empty($hands_by_type)) {
            $cur = array_shift($hands_by_type);
            ksort($cur, SORT_DESC);
            while (!empty($cur)) {
                $c = array_shift($cur);
                $tot+=$c*$r;
                $r++;
            }
        }
        return "we won a nice round $tot accross all hands";
    }

    protected function part_2() {
        $hands_by_type = [];
        foreach (Splitter::splitOnLinebreak($this->input) as $inp) {
            [$hand, $bid] = explode(" ", $inp, 2);
            [$h, $t] = $this->assignTypeWJ($hand);
            $hands_by_type[$t][$h] = $bid; 
        }
        ksort($hands_by_type);
        $r = 1;
        $tot = 0;
        while (!empty($hands_by_type)) {
            $cur = array_shift($hands_by_type);
            ksort($cur, SORT_DESC);
            while (!empty($cur)) {
                $c = array_shift($cur);
                $tot+=$c*$r;
                $r++;
            }
        }
        return "with the new rules in place we still won like $tot in total";
    }
    
    private function assignType($hand) {
        $cards = [];
        $h = "";
        for($i = 0; $i < strlen($hand); $i++) {
            $c = $hand[$i];
            $h.= match($c) {
                'A' => '14',
                'K' => '13',
                'Q' => '12',
                'J' => '11',
                'T' => '10',
                default => '0'.$c  
            };
            if (!isset($cards[$c])) {
                $cards[$c] = 1;
            } else {
                $cards[$c]++;
            }
        }
        switch(count($cards)) {
            case 5:
                return [$h, 1];
            case 4:
                return [$h, 2];
            case 3:
                foreach ($cards as $k => $v) {
                    if ($v == 3) {
                        return [$h, 4];
                    }
                }
                return [$h, 3];
            case 2:
                foreach ($cards as $k => $v) {
                    if ($v == 3) {
                        return [$h, 5];
                    }
                }
                return [$h, 6];
            case 1:
                return [$h, 7];
            default:
                return [$h, -1];
        }
    }

    private function assignTypeWJ($hand) {
        $cards = [];
        $h = "";
        for($i = 0; $i < strlen($hand); $i++) {
            $c = $hand[$i];
            $h.= match($c) {
                'A' => '13',
                'K' => '12',
                'Q' => '11',
                'J' => '01',
                'T' => '10',
                default => '0'.$c  
            };
            if (!isset($cards[$c])) {
                $cards[$c] = 1;
            } else {
                $cards[$c]++;
            }
        }
        if(isset($cards['J'])) {
            $jc = $cards['J'];
            if ($jc != 5) {
                unset($cards['J']);
                $k = array_search(max($cards), $cards);
                $cards[$k]+=$jc;
            }
        }
        switch(count($cards)) {
            case 5:
                return [$h, 1];
            case 4:
                return [$h, 2];
            case 3:
                foreach ($cards as $k => $v) {
                    if ($v == 3) {
                        return [$h, 4];
                    }
                }
                return [$h, 3];
            case 2:
                foreach ($cards as $k => $v) {
                    if ($v == 3) {
                        return [$h, 5];
                    }
                }
                return [$h, 6];
            case 1:
                return [$h, 7];
            default:
                return [$h, -1];
        }
    }

}