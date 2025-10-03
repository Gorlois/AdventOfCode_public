<?php
namespace Core\Solvers\AOC2024;

use Core\Solvers\Day;
use Core\Helper\Splitter;
use Exception;

class Day_17 extends Day
{
    protected function part_1()
    {
        [$registers, $program] = Splitter::splitOnEmpty($this->input);
        $registers = str_replace(["Register A: ", "Register B: ", "Register C: "], ["", "", ""], $registers);
        [$a, $b, $c] = Splitter::splitOnLinebreak($registers);
        [$a, $b, $c] = [(int) $a, (int) $b, (int) $c];
        $program = explode(",", str_replace("Program: ", "", $program));

        $ans = "";
        for ($pointer = 0; $pointer < count($program); $pointer += 2) {
            $inst = (int) $program[$pointer];
            $op = (int) $program[$pointer + 1];
            $com = match ($op) {
                0, 1, 2, 3 => $op,
                4 => $a,
                5 => $b,
                6 => $c,
                7 => throw new Exception('operand was a 7'),
                default => throw new Exception('operand was not between 0 and 7')
            };
            switch ($inst) {
                case 0:
                    $a = floor($a / (2 ** $com));
                    break;
                case 1:
                    $b = $b ^ $op;
                    break;
                case 2:
                    $b = $com % 8;
                    break;
                case 3:
                    $pointer = $a != 0 ? $op - 2 : $pointer;
                    break;
                case 4:
                    $b = $b ^ $c;
                    break;
                case 5:
                    $ans .= $ans != "" ? "," : "";
                    $ans .= (string) ($com % 8);
                    break;
                case 6:
                    $b = floor($a / (2 ** $com));
                    break;
                case 7:
                    $c = floor($a / (2 ** $com));
                    break;
                default:
                    throw new Exception("inst was not a valid case");
            }
        }
        return "after running the program this was the output: \r\n\r\n $ans \r\n";
    }

    protected function part_2()
    {
        [$registers, $program] = Splitter::splitOnEmpty($this->input);
        $registers = str_replace(["Register A: ", "Register B: ", "Register C: "], ["", "", ""], $registers);
        [$a, $b, $c] = Splitter::splitOnLinebreak($registers);
        [$a, $b, $c] = [(int) $a, (int) $b, (int) $c];
        $program = explode(",", str_replace("Program: ", "", $program));

        $ans = $this->regAfinder($program);

        return "running the program we got $ans;";
    }

    private function regAfinder($prog, $regA = 0, $iteration = 0)
    {
        $c = count($prog);
        if ($iteration == $c) {
            return $regA;
        } else {
            $a = $regA << 3;
            for ($b = 0; $b < 8; $b++) {
                if ($prog[$c - ($iteration + 1)] == $this->runProg($prog, $a + $b)[0]) {
                    $out = $this->regAfinder($prog, $a + $b, $iteration + 1);
                    if ($out) {
                        return $out;
                    }
                }
            }
        }
        return false;
    }

    private function runProg($program, int $a)
    {
        [$b, $c] = [0, 0];

        $out = "";
        for ($pointer = 0; $pointer < count($program); $pointer += 2) {
            $inst = (int) $program[$pointer];
            $op = (int) $program[$pointer + 1];
            $com = match ($op) {
                0, 1, 2, 3 => $op,
                4 => $a,
                5 => $b,
                6 => $c,
                7 => throw new Exception('operand was a 7'),
                default => throw new Exception('operand was not between 0 and 7')
            };
            switch ($inst) {
                case 0:
                    $a = floor($a / (2 ** $com));
                    break;
                case 1:
                    $b = $b ^ $op;
                    break;
                case 2:
                    $b = $com % 8;
                    break;
                case 3:
                    $pointer = $a != 0 ? $op - 2 : $pointer;
                    break;
                case 4:
                    $b = $b ^ $c;
                    break;
                case 5:
                    $out .= $out != "" ? "," : "";
                    $out .= (string) ($com % 8);
                    break;
                case 6:
                    $b = floor($a / (2 ** $com));
                    break;
                case 7:
                    $c = floor($a / (2 ** $com));
                    break;
                default:
                    throw new Exception("inst was not a valid case");
            }
        }

        return $out;
    }
}