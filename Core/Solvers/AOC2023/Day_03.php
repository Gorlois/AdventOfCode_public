<?php
namespace Core\Solvers\AOC2023;

use Core\Helper\Mapper;
use Core\Helper\Splitter;
use Core\Solvers\Day;

class Day_03 extends Day
{
    private array $directions = [
        [1, 0],
        [1, 1],
        [0, 1],
        [-1, 1],
        [-1, 0],
        [-1, -1],
        [0, -1],
        [1, -1]
    ];

    // loop over map
        // append to number
        // bind coord to number in map
        // $map = [];

        // $numberIndex = 0;
        // $number[$numberIndex] = "";
        // $coordsWithNumber = [];
        // $coordsWithSymbol = [];

        // foreach (Splitter::splitOnLinebreak($this->input) as $r => $row) {
        //     foreach (str_split($row) as $c => $char) {
        //         if ($char == ".") {
        //             continue;
        //         }
        //         while ($this->is_digit($char)) {
        //             $number[$numberIndex].=$char;
        //             $coordsWithNumber["$c,$r"] = $numberIndex;
        //         }
        //         $coordsWithSymbol["$c,$r"] = $char;
        //         $numberIndex++;
        //         $number[$numberIndex] = "";
        //     }
        // }


    protected function part_1()
    {
        $sumOfPartNr = 0;
        $map = $this->parse($this->input);

        foreach ($map as $coord => $char) {
            if ($this->is_digit($char)) {
                $numbers[$coord] = $char;
            } else {
                $symbols[$coord] = $char;
            }
        }

        foreach ($symbols as $coord => $_) {
            [$sym_x, $sym_y] = explode(",", $coord, 2);
            foreach ($this->directions as [$dx, $dy]) {
                $a_x = $sym_x + $dx;
                $a_y = $sym_y + $dy;
                if (isset($numbers["$a_x,$a_y"])) {
                    $firstnums[$this->findFirst($numbers, "$a_x,$a_y")] = 1;
                }
            }
        }

        foreach ($firstnums as $coord => $_) {
            $sumOfPartNr += $this->findNum($numbers, $coord);
        }

        return "the sum of all gear ratios in the schematic is $sumOfPartNr";
    }

    protected function part_2()
    {
        $SumOfGearRatios = 0;
        $map = $this->parse($this->input);

        foreach ($map as $coord => $char) {
            if (!$this->is_digit($char)) {
                if ($char == "*") {
                    $symbols[$coord] = $char;
                }
            } else {
                $numbers[$coord] = $char;
            }
        }

        foreach ($symbols as $a => $_) {
            $firstnums = [];
            [$sym_x, $sym_y] = explode(',', $a, 2);
            foreach ($this->directions as [$dx, $dy]) {
                $a_x = $sym_x + $dx;
                $a_y = $sym_y + $dy;
                if (isset($numbers["$a_x,$a_y"])) {
                    $firstnums[$this->findFirst($numbers, "$a_x,$a_y")] = 1;
                }
            }
            if (count($firstnums) == 2) {
                $SumOfGearRatios += $this->findNum($numbers, array_key_first($firstnums)) * $this->findNum($numbers, array_key_last($firstnums));
            }
        }
        return "the sum of the new gear ratios is $SumOfGearRatios";
    }

    private function parse($input)
    {
        $out = [];
        foreach (Splitter::splitOnLinebreak($input) as $y => $row) {
            foreach (str_split($row) as $x => $char) {
                if ($char != '.') {
                    $out["$x,$y"] = $char;
                }
            }
        }
        return $out;
    }

    private function is_digit($char)
    {
        return match ($char) {
            '0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
            1, 2, 3, 4, 5, 6, 7, 8, 9, 0 => true,
            default => false
        };
    }

    private function findFirst(array $map, $coord)
    {
        [$x, $y] = explode(',', $coord, 2);
        while (isset($map["$x,$y"])) {
            $x--;
        }
        $x++;
        return "$x,$y";
    }

    private function findNum(array $map, $coord)
    {
        [$x, $y] = explode(',', $coord, 2);
        $num = "";
        while (isset($map["$x,$y"])) {
            $num .= $map["$x,$y"];
            $x++;
        }
        return (int) $num;
    }

}