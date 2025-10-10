<?php
namespace Core\Solvers\AOC2023;

use Core\Helper\Splitter;
use Core\Solvers\Day;

class Day_13 extends Day
{
    // read and save file as an array of 1s and 0s, 

    // try out every mirror line (assume there is only one perfect reflection?) also make array start from 1?
    // foreach row for mirror line count left and right of mirror if same continue to next line if false go to next mirror line;
    // if no line mirrors flip / transpose array and do the same thing once more (assume there is a mirror line)




    protected function part_1()
    {
        $patterns = $this->parseInput();
        $summary = 0;

        foreach ($patterns as $pattern) {
            $mirrorline = $this->findMirrorLine($pattern);
            if ($mirrorline) {
                $summary += $mirrorline;
            } else {
                $flippedPattern = $this->flipPattern($pattern);
                $summary += 100 * $this->findMirrorLine($flippedPattern);
            }
        }

        return "the answer we got was $summary";
    }

    protected function part_2()
    {
        $patterns = $this->parseInput();

        $t = 0;
        foreach ($patterns as $p) {
            $d = $this->DifferencesML($p);
            $k = array_search(1, $d);
            if ($k) {
                $t += $k;
            } else {
                $pf = $this->flipPattern($p);
                $t += 100 * array_search(1, $this->DifferencesML($pf));
            }
        }
        return "the new answer we got was $t";
    }

    private function parseInput()
    {
        $input = str_replace([".", "#"], [0, 1], $this->input);
        $patterns = [];
        foreach (Splitter::splitOnEmpty($input) as $pattern) {
            $map = [];
            $y = 1;
            foreach (Splitter::splitOnLinebreak($pattern) as $row) {
                $x = 1;
                foreach(str_split($row) as $cell) {
                    $map[$y][$x] = $cell;
                    $x++;
                }
                $y++;
            }
            $patterns[] = $map;
        }
        return $patterns;
    }

    private function flipPattern(array $pattern)
    {
        $flippedPattern = [];
        foreach ($pattern as $yIndex => $row) {
            foreach ($row as $xIndex => $cell) {
                $flippedPattern[$xIndex][$yIndex] = $cell;
            }
        }
        return $flippedPattern;
    }

    private function findMirrorLine(array $pattern)
    {
        $length = count($pattern[1]);

        for ($mirrorline = 1; $mirrorline < $length; $mirrorline++) {
            // set a is mirror flag to true and try to disprove the fact the mirrorline is a mirrorline by looping over the lines that would be mirrored thanks to the mirror line;
            $is_mirror = true;
            foreach ($pattern as $row) {
                for ($i = min($mirrorline, $length - $mirrorline); $i > 0; $i--) {
                    if ($row[$mirrorline + 1 - $i] != $row[$mirrorline + $i]) {
                        $is_mirror = false;
                        break 2;
                    }
                }
            }
            if ($is_mirror) {
                return $mirrorline;
            }
        }
        return false;
    }

    private function DifferencesML(array $m)
    {
        $dif = [];

        $l = count($m[1]);

        for ($ml = 1; $ml < $l; $ml++) {
            $d = 0;
            foreach ($m as $row) {
                for ($i = min($ml, $l - $ml); $i > 0; $i--) {
                    if ($row[$ml + 1 - $i] != $row[$ml + $i]) {
                        $d++;
                    }
                }
            }
            $dif[$ml] = $d;
        }
        return $dif;
    }
}