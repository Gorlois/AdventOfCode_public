<?php
namespace Core\Solvers\AOC2024;

use Core\Helper\Splitter;
use Core\Solvers\Day;
use Exception;

class Day_01 extends Day
{
    protected function part_1()
    {
        $sumOfDifference = 0;
        foreach (Splitter::splitOnLinebreak($this->input) as $input) {
            [$a, $b] = explode("   ", $input, 2) + [null, null];
            if ($a === null || $b === null) {
                continue;
            }
            $locationListA[] = (int) trim($a);
            $locationListB[] = (int) trim($b);
        }

        // check if data is as expected
        $nA = count($locationListA);
        $nB = count($locationListB);
        if ($nA != $nB || $nA === 0) {
            throw new Exception('lists must be of equal lenght and not empty');
        }

        // numeric sort of arrays
        sort($locationListA, SORT_NUMERIC);
        sort($locationListB, SORT_NUMERIC);
        
        for ($i = 0, $n = $nA; $i < $n; $i++) {
            $sumOfDifference += abs($locationListA[$i] - $locationListB[$i]);
        }
        return "there was $sumOfDifference difference between the two lists";
    }

    protected function part_2()
    {
        
        foreach (Splitter::splitOnLinebreak($this->input) as $input) {
            [$a, $b] = explode("   ", $input, 2) + [null, null];
            if ($a === null || $b === null) {
                continue;        
            }
            $locationListA[] = (int) trim($a);
            $locationListB[] = (int) trim($b);
        }

        // check if data is as expected
        $nA = count($locationListA);
        $nB = count($locationListB);
        if ($nA != $nB || $nA === 0) {
            throw new Exception('lists must be of equal lenght and not empty');
        }

        // creates an array with how often a "location" in list b occurs in it
        $countsB = array_count_values($locationListB);
        
        $similarityScore = 0;
        foreach ($locationListA as $a) {
            $count = $countsB[$a] ?? 0;
            $similarityScore += $a * $count;
        }

        return "the similarity score for the two lists is $similarityScore";
    }
}