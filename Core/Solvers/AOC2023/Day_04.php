<?php
namespace Core\Solvers\AOC2023;

use Core\Helper\Splitter;
use Core\Solvers\Day;

class Day_04 extends Day {
        protected function part_1() {
        $totalValue  = 0;
        foreach (Splitter::splitOnLinebreak($this->input) as $line) {
            $worth = 0;
            [$_, $card] = explode(": ", $line, 2);
            $card = str_replace("  ", " ", $card);
            [$winners, $numbers] = explode(" | ", $card, 2);
            $winners = explode(" ", $winners);
            $numbers = explode(" ", $numbers);

            foreach ($numbers as $number) {
                if (in_array($number, $winners)) {
                    if ($worth != 0) {
                        $worth *= 2;
                    } else {
                        $worth = 1;
                    }
                }
            }
            $totalValue += $worth;
        }
        return "the scratchcards where worth $totalValue points in total";
    }

    protected function part_2() {
        $tot = 0;
        $cards = [];
        foreach (Splitter::splitOnLinebreak($this->input) as $line) {
            $worth = 0;
            [$_, $nums] = explode(": ", $line, 2);
            $card = str_replace(["Card   ", "Card  ", "Card "], "", $_);
            $nums = str_replace("  ", " ", $nums);
            [$winners, $numbers] = explode(" | ", $nums, 2);
            $winners = explode(" ", $winners);
            $numbers = explode(' ', $numbers);
            
            foreach ($numbers as $num) {
                if (in_array($num, $winners)) {
                    $worth++;
                }
            }
            $cards[$card] = [1, $worth];
        }

        $max = count($cards);
        foreach ($cards as $card => [&$amount, $worth]) {
            $tot += $amount;
            for ($i = 1; $i <= $worth && $card+$i <= $max; $i++) {
                $cards[$card+$i][0]+=$amount;                
            }
        }
        
        return "We ended up with $tot scratchcards";
    }
}