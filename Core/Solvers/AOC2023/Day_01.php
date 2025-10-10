<?php
namespace Core\Solvers\AOC2023;

use Core\Helper\Splitter;
use Core\Solvers\Day;

class Day_01 extends Day
{
    protected function part_1(): string
    {
        $sumOfCalibrationValues = 0;
        
        foreach (Splitter::splitOnLinebreak($this->input) as $line) {
            // simply replace everything that isnt a number in a line
            $numbers = preg_replace("/[^0-9]/", "", $line);
            $length = strlen($numbers);

            // if length of string is larger than 0 contatenate the first and last number in the string and add that to the sum
            if ($length > 0) {
                $sumOfCalibrationValues += (int) ($numbers[0].$numbers[$length - 1]);
            }
        }
        
        return "The sum of calibration values was $sumOfCalibrationValues";
    }

    protected function part_2(): string
    {
        $sumOfCalibrationValues = 0;        
        $search = ['one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine'];
        $replace = ['o1e', 't2o', 't3e', 'f4r', 'f5e', 's6x', 's7n', 'e8t', 'n9e'];
        
        foreach (Splitter::splitOnLinebreak($this->input) as $line) {
            // replace the words for numbers in the string with their number equivalent taking care to still allow for overlap of a single letter
            $adjustedLine = str_replace($search, $replace, $line);
            $numbers = preg_replace("/[^0-9]/", "", $adjustedLine);
            $length = strlen($numbers);
            if ($length > 0) {
                $sumOfCalibrationValues += (int) ($numbers[0].$numbers[$length-1]);
            }
        }
        
        return "The sum of calibration values was $sumOfCalibrationValues";
    }
}