<?php
namespace Core\Solvers\AOC2024;

use Core\Solvers\Day;
use Core\Helper\Splitter;

class Day_21 extends Day {
    private function getPathNum_keys() {
        $path = [
            'A' => [
              '0' => "<A", 
              '1' => "^<<A",
              '2' => "<^A", 
              '3' => "^A",
              '4' => "^^<<A", 
              '5' => "<^^A",
              '6' => "^^A", 
              '7' => "^^^<<A",
              '8' => "<^^^A", 
              '9' => "^^^A",
              'A' => "A"
            ],
            '0' => [
              '0' => "A", 
              '1' => "^<A",
              '2' => "^A", 
              '3' => "^>A",
              '4' => "^^<A", 
              '5' => "^^A",
              '6' => "^^>A", 
              '7' => "^^^<A",
              '8' => "^^^A", 
              '9' => "^^^>A",
              'A' => ">A"
            ],
            '1' => [
              '0' => ">vA",
              '1' => "A", 
              '2' => ">A",
              '3' => ">>A", 
              '4' => "^A",
              '5' => "^>A", 
              '6' => "^>>A",
              '7' => "^^A", 
              '8' => "^^>A",
              '9' => "^^>>A", 
              'A' => ">>vA"
            ],
            '2' => [
              '0' => "vA", 
              '1' => "<A",
              '2' => "A",
              '3' => ">A", 
              '4' => "<^A",
              '5' => "^A", 
              '6' => "^>A",
              '7' => "<^^A", 
              '8' => "^^A",
              '9' => "^^>A", 
              'A' => "v>A"
            ],
            '3' => [
              '0' => "<vA", 
              '1' => "<<A",
              '2' => "<A",
              '3' => "A", 
              '4' => "<<^A",
              '5' => "<^A", 
              '6' => "^A",
              '7' => "<<^^A", 
              '8' => "<^^A",
              '9' => "^^A", 
              'A' => "vA"
            ],
            '4' => [
              '0' => ">vvA", 
              '1' => "vA",
              '2' => "v>A", 
              '3' => "v>>A",
              '4' => "A",
              '5' => ">A", 
              '6' => ">>A",
              '7' => "^A", 
              '8' => "^>A",
              '9' => "^>>A", 
              'A' => ">>vvA"
            ],
            '5' => [
              '0' => "vvA", 
              '1' => "<vA",
              '2' => "vA", 
              '3' => "v>A",
              '4' => "<A",
              '5' => "A", 
              '6' => ">A",
              '7' => "<^A", 
              '8' => "^A",
              '9' => "^>A", 
              'A' => "vv>A"
            ],
            '6' => [
              '0' => "<vvA", 
              '1' => "<<vA",
              '2' => "<vA", 
              '3' => "vA",
              '4' => "<<A", 
              '5' => "<A",
              '6' => "A",
              '7' => "<<^A", 
              '8' => "<^A",
              '9' => "^A", 
              'A' => "vvA"
            ],
            '7' => [
              '0' => ">vvvA", 
              '1' => "vvA",
              '2' => "vv>A", 
              '3' => "vv>>A",
              '4' => "vA", 
              '5' => "v>A",
              '6' => "v>>A",
              '7' => "A", 
              '8' => ">A",
              '9' => ">>A", 
              'A' => ">>vvvA"
            ],
            '8' => [
              '0' => "vvvA", 
              '1' => "<vvA",
              '2' => "vvA", 
              '3' => "vv>A",
              '4' => "<vA", 
              '5' => "vA",
              '6' => "v>A", 
              '7' => "<A",
              '8' => "A",
              '9' => ">A", 
              'A' => "vvv>A"
            ],
            '9' => [
              '0' => "<vvvA", 
              '1' => "<<vvA",
              '2' => "<vvA", 
              '3' => "vvA",
              '4' => "<<vA", 
              '5' => "<vA",
              '6' => "vA", 
              '7' => "<<A",
              '8' => "<A",
              '9' => "A", 
              'A' => "vvvA"
            ]
          ];
          return $path;
    }

    private function getPathDir_keys() {
        $path = [
            'A' => [
              'A' => "A",
              '^' => "<A",
              '>' => "vA",
              'v' => "<vA",
              '<' => "v<<A"
            ],
            '^' => [
              'A' => ">A",
              '^' => "A",
              '>' => "v>A",
              'v' => "vA",
              '<' => "v<A"
            ],
            '>' => [
              'A' => "^A",
              '^' => "<^A",
              '>' => "A",
              'v' => "<A",
              '<' => "<<A"
            ],
            'v' => [
              'A' => "^>A",
              '^' => "^A",
              '>' => ">A",
              'v' => "A",
              '<' => "<A"
            ],
            '<' => [
              'A' => ">>^A",
              '^' => ">^A",
              '>' => ">>A",
              'v' => ">A",
              '<' => "A"
            ]
          ];
          return $path;
    }

    private function simulateKeyboard(string $inp, $num = false) {
        $output = "";
        $path = $num ? $this->getPathNum_keys() : $this->getPathDir_keys();
        $pos = 'A';
        foreach (str_split($inp) as $next_pos) {
            $output.=$path[$pos][$next_pos];
            $pos = $next_pos;
        }
        return $output;
    }

    protected function part_1() {
        $ans = 0;
        $show = "";
        foreach(Splitter::splitOnLinebreak($this->input) as $inp) {
            $num = (int) substr($inp, 0, 3);
            $pass = $this->simulateKeyboard($inp, true);
            $show.="for the third robot to input the sequence: \r\n $inp \r\n the second robot will have to put in: \r\n $pass \r\n the first robot will have to put in: \r\n";
            $pass = $this->simulateKeyboard($pass);
            $show.="$pass \r\n this means that I will have to put in: \r\n";
            $pass = $this->simulateKeyboard($pass);
            $complexity = $num * strlen($pass);
            $ans+=$complexity;
            $show.="$pass \r\n that means the complexity = $complexity \r\n\r\n";
        }
        return "$show this means the total complexity was $ans";
    }

    private function recursive_Simulate($input, $depth, $max_depth, &$mem) {
        $path = $this->getPathDir_keys();

        if ($depth == $max_depth) {
            return strlen($input);
        }

        $pos = "A";
        $inputlength = 0;

        foreach (str_split($input) as $next_pos) {
            $deep_input = $path[$pos][$next_pos];

            $n = $depth+1;

            $mem["$deep_input,$n"] ??= $this->recursive_Simulate($deep_input, $n, $max_depth, $mem);
            $inputlength+=$mem["$deep_input,$n"];

            $pos = $next_pos;
        }
        return $inputlength;
    }

    protected function part_2() {
        $mem = [];
        $ans = 0;
        foreach(Splitter::splitOnLinebreak($this->input) as $inp) {
            $num = (int) substr($inp, 0, 3);
            $pass = $this->simulateKeyboard($inp, true);
            $lastpasslength = $this->recursive_Simulate($pass, 0, 25, $mem);
            $ans+=$num*$lastpasslength;
        }
        return "the total complexity after 26 passes was $ans";
    }

}