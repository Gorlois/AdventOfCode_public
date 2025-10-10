<?php
namespace Core\Solvers\AOC2023;

use Core\Helper\Splitter;
use Core\Solvers\Day;

class Day_02 extends Day
{
    protected function part_1(): string
    {
        $totalPossible = 0;
        $rules = [
            'red' => 12,
            'green' => 13,
            'blue' => 14
        ];

        // remove the set boundaries cause the question doesnt actually care for sets
        $input = str_replace(";", ",", $this->input);
        foreach (Splitter::splitOnLinebreak($input) as $line) {
            // parse each line such that you end up with the game index and an array with all cubes regardless of set
            [$gameIndex, $cubes] = explode(": ", $line, 2);
            $gameIndex = (int) substr($gameIndex, 5);
            $cubes = explode(", ", $cubes);
            
            foreach ($cubes as $cube) {
                [$cubeCount, $cubeColour] = explode(" ", $cube, 2) + [null, null];
                // evaluate for each cube if it would be allowed as soon as you find a disallowed one skip the rest of the game
                if ((int) $cubeCount > $rules[$cubeColour]) {
                    continue 2;
                }
            }
            $totalPossible += $gameIndex;
        }
        return "this was the sum of the indexes of games that where possible $totalPossible";
    }

    protected function part_2(): string {
        $sumOfPower = 0;
        $input = str_replace(";", ",", $this->input);
        foreach(Splitter::splitOnLinebreak($input) as $line) {
            $min = [];
            $power = 1;
            
            [$useless, $cubes] = explode(": ", $line, 2) + [null, null];
            $cubes = explode(", ", $cubes);
            foreach ($cubes as $cube) {
                [$count, $color] = explode(" ", $cube, 2) + [null, null];
                $count = (int) $count;
                $min[$color] ??= $count;
                if ($min[$color] < $count) {
                    $min[$color] = $count;
                }
            }

            foreach ($min as $color => $count) {
                $power *= $count;
            }
            $sumOfPower += $power;
        }

        return "The sum of all powers was $sumOfPower";
    }
}