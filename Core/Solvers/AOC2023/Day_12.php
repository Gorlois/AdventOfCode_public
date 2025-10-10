<?php
namespace Core\Solvers\AOC2023;

use Core\Helper\Splitter;
use Core\Solvers\Day;
use Core\Traits\Memoizable;

class Day_12 extends Day {
    use Memoizable;
    protected function part_1(): string {
        $sumOfArrangements = 0;
        $echo = "";

        foreach(Splitter::splitOnLinebreak($this->input) as $line) {
            [$row, $criteria] = explode(" ", $line, 2);
            $combinations = $this->combinationSolver($row, $criteria);
            $sumOfArrangements += $combinations;
            $echo.= "$line gave $combinations".PHP_EOL;
        }

        return "$echo so the total combinations i got was $sumOfArrangements";
    }

    protected function part_2(): string {
        $sumOfArrangements = 0;

        foreach(Splitter::splitOnLinebreak($this->input) as $line) {
            [$row, $criteria] = explode(" ", $line, 2);
            $nrow = "$row?$row?$row?$row?$row";
            $ncrit = "$criteria,$criteria,$criteria,$criteria,$criteria";
            $combinations = $this->combinationSolver($nrow, $ncrit);
            $sumOfArrangements += $combinations;
        }

        return "the total combinations i got was $sumOfArrangements";
    }

    private function combinationSolver(string $row, string $criteria): int {
        $arrangements = 0;
        
        if ($criteria == "") {
            if (str_contains($row, "#")) {
                return 0;
            }
            return 1;
        }
        
        
        [$current, $restCriteria] = explode(",", $criteria, 2) + ["", ""];
        $current = (int) $current;
        $length = strlen($row);


        // calc resting springs
        $crits = array_map('intval', explode(',', $criteria));
        $minlength = array_sum($crits) + count($crits) -1;
        if ($minlength > $length) {
            return 0;
        }

        // skip "."
        if ($row[0] == ".") {
            $restRow = substr($row, 1);
            return $this->memoize("$restRow|$criteria", function() use ($restRow,$criteria) {
                return $this->combinationSolver($restRow, $criteria);
            });
        }

        $bit = substr($row, 0, $current);
        $bitValid = !str_contains($bit, ".");
        $nextCharValid = $current == $length || $row[$current] != "#";
        if ($bitValid && $nextCharValid) {
            $restRow = substr($row, $current+1);
            $arrangements += $this->memoize("$restRow|$restCriteria", function() use ($restRow, $restCriteria) {
                return $this->combinationSolver($restRow, $restCriteria);
            });
        }

        if ($row[0] !== "#") {
            $restRow = substr($row, 1);
            $arrangements += $this->memoize("$restRow|$criteria", function() use ($restRow,$criteria) {
                return $this->combinationSolver($restRow, $criteria);
            });
        }
        return $arrangements;
    }
}