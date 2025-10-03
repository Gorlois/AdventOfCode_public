<?php
namespace   Core\Solvers\AOC2023;

use Core\Helper\Splitter;
use Core\Solvers\Day;

class Day_02 extends Day {
    protected function part_1(): string {
        $totalPossible = 0;
        $games = [];
        $allowedSets = [
            'red' => 12,
            'green' => 13,
            'blue' => 14
        ];
        foreach(Splitter::splitOnLinebreak($this->input) as $line) {
            [$gameIndex, $sets] = explode(": ", $line, 2);
            $sets = explode("; ", $sets);
            $gameIndex = (int) substr($gameIndex, 5);
            $details = [];
            foreach ($sets as $set) {
                $cubes = explode(", ", $set);
                $roundDetails = [];
                foreach ($cubes as $cube) {
                    [$cubeCount, $cubeColour] = explode(" ", $cube, 2) + [null, null];
                    $roundDetails[$cubeColour] = (int) $cubeCount;
                }
                $details[] = $roundDetails;
            }
            $games[$gameIndex] = $details;

            if ()
        }
    }
}