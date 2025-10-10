<?php
namespace Core\Solvers\AOC2024;

use Core\Helper\Splitter;
use Core\Solvers\Day;
use Core\Traits\Memoizable;

class Day_11 extends Day
{
    use Memoizable;
    protected function part_1()
    {
        // sanitize
        $input = Splitter::mergeOnLinebreak($this->input);
        $ans = 0;
        foreach (array_map('intval', explode(" ", $input)) as $stone) {
            $ans += $this->memoize("blink:$stone,25", function () use ($stone) {
                return $this->blink($stone, 25);
            });
        }
        return "there where $ans stones after 25 blinks";
    }

    /*
    this is p2 solved with improved blink 
    there where 22938365706844 stones after 75 blinks
    the problem was solved in 0.0034298896789551 seconds 

    this is p2 solved with original memoized blink
    there where 22938365706844 stones after 75 blinks
    the problem was solved in 0.0050129890441895 seconds
    */


    protected function part_2()
    {
        // sanitize
        $input = str_replace("\r\n", "", $this->input);
        $ans = 0;
        foreach (array_map('intval', explode(" ", $input)) as $stone) {
            $ans += $this->memoize("blink:$stone,75", function() use ($stone) {
                return $this->blink($stone, 75);
            });
        }
        return "there where $ans stones after 75 blinks";
    }

    private function blink(int $stone, int $blinks)
    {
        if ($blinks <= 0) {
            return 1;
        }
        
        $blinks--;

        $stone_count = 0;
        foreach ($this->memoize("split:$stone", function() use ($stone) {
            return $this->split_stone($stone); }) as $split_stone) {
            $stone_count += $this->memoize("blink:$split_stone,$blinks", function () use ($blinks, $split_stone) {
                return $this->blink($split_stone, $blinks);
            });
        }

        return $stone_count;
    }

    /**
     * split off the stone splitting into a memoized function
     * 
     * @param int $stone
     * @param mixed $stone_mem: a memoization array for split stone
     */
    private function split_stone(int $stone): array
    {
        if ($stone == 0)
            return [1];

        $length = strlen($stone);
        return $length % 2 == 0 ? [(int) substr((string) $stone, 0, $length / 2), (int) substr((string) $stone, $length / 2)] : [$stone * 2024];
    }

    private function memBlink(int $stone, int $blinks, &$mem)
    {
        $out = 0;
        if ($blinks > 0) {
            $blinks--;
            $str_len = strlen((string) $stone);
            if ($stone == 0) {
                $new[] = 1;
            } elseif ($str_len % 2 == 0) {
                $c = $str_len / 2;
                $stone = (string) $stone;
                $new[] = (int) substr($stone, 0, $c);
                $new[] = (int) substr($stone, $c);
            } else {
                $new[] = $stone * 2024;
            }
            foreach ($new as $n) {
                if (!isset($mem["$n,$blinks"])) {
                    $mem["$n,$blinks"] = $this->memBlink($n, $blinks, $mem);
                }
                $out += $mem["$n,$blinks"];
            }
        } else {
            $out = 1;
        }
        return $out;
    }
}