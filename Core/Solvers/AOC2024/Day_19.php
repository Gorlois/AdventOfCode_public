<?php
namespace Core\Solvers\AOC2024;

use Core\Helper\Splitter;

class Day_19 extends Day
{
    protected function p_1()
    {
        [$towels, $patterns] = Splitter::splitOnEmpty($this->input);
        $towels = explode(", ", $towels);
        $patterns = Splitter::splitOnLinebreak($patterns);
        $mem = [];
        $ans = 0;
        foreach ($patterns as $pattern) {
            if ($this->recCheckPattern($pattern, $towels, $mem)) {
                $ans++;
            }
        }
        return "there were $ans designs possible";
    }

    private function recCheckPattern($pattern, $towels, &$mem)
    {
        foreach ($towels as $towel) {
            if (str_starts_with($pattern, $towel)) {
                // create a shorter pattern of what is left after subtracting the towel from the front;
                $alt_pattern = substr($pattern, strlen($towel));
                if (strlen($alt_pattern) == 0) {
                    return true;
                } else {
                    // using a boolean mem and doing null coalescing assignment on a mem value in a if statement feels dirty :3
                    if ($mem[$alt_pattern] ??= $this->recCheckPattern($alt_pattern, $towels, $mem)) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    protected function p_2()
    {
        [$towels, $patterns] = Splitter::splitOnEmpty($this->input);
        $towels = explode(", ", $towels);
        $patterns = Splitter::splitOnLinebreak($patterns);
        $mem = [];
        $ans = 0;
        foreach ($patterns as $pattern) {
            $ans += $this->recFindCombinations($pattern, $towels, $mem);
        }
        return "there were $ans number of different ways to get to the designs";
    }

    private function recFindCombinations($pattern, $towels, &$mem)
    {
        if (strlen($pattern) == 0) {
            return 1;
        }

        if (!isset($mem[$pattern])) {
            $c = 0;
            foreach ($towels as $towel) {
                if (str_starts_with($pattern, $towel)) {
                    $alt_pattern = substr($pattern, strlen($towel));
                    $c += $this->recFindCombinations($alt_pattern, $towels, $mem);
                }
            }
            $mem[$pattern] = $c;
        }

        return $mem[$pattern];
    }
}