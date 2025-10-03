<?php
namespace Core\Solvers\AOC2024;

use Core\Helper\Splitter;
use Core\Solvers\Day;
use Core\Helper\Mapper;

class Day_12 extends Day
{
    protected function part_1()
    {
        // parse input into a two dimenional map
        $map = Mapper::map(Splitter::splitOnLinebreak($this->input));
        $dir = Mapper::DIRECTIONS;

        // parse map into individual regions
        for ($y = 0; $y < count($map); $y++) {
            for ($x = 0; $x < count($map[$y]); $x++) {
                if ($map[$y][$x]) {
                    $current = $map[$y][$x];
                    $region = [];
                    $S = ["$y,$x" => [$y, $x]];
                    while (!empty($S)) {
                        [$cy, $cx] = array_pop($S);
                        $region[$cy][$cx] = $current;
                        $map[$cy][$cx] = 0;
                        foreach ($dir as [$dy, $dx]) {
                            [$ny, $nx] = [$cy + $dy, $cx + $dx];
                            if (isset($map[$ny][$nx]) && $map[$ny][$nx] == $current) {
                                $S["$ny,$nx"] = [$ny, $nx];
                            }
                        }
                    }
                    $regions[] = $region;
                }
            }
        }

        // find size and circumference of every region 
        $ans = 0;
        foreach ($regions as $reg) {
            $size = 0;
            $circ = 0;
            foreach ($reg as $y => $row) {
                foreach ($row as $x => $_) {
                    $size++;
                    foreach ($dir as [$dy, $dx]) {
                        if (!isset($reg[$y + $dy][$x + $dx])) {
                            $circ++;
                        }
                    }
                }
            }
            $ans += $size * $circ;
        }

        return "the total price for fencing was $ans";
    }

    // any simple polygon has as many sides as it has corners so instead of counting every part of the wall we just check every tile on its corners instead;
    protected function part_2()
    {
        // parse input as a map
        $map = Mapper::map(Splitter::splitOnLinebreak($this->input));
        $dir = Mapper::DIRECTIONS;
        // parse map into individual regions
        for ($y = 0; $y < count($map); $y++) {
            for ($x = 0; $x < count($map[$y]); $x++) {
                if ($map[$y][$x]) {
                    $current = $map[$y][$x];
                    $region = [];
                    $S = ["$y,$x" => [$y, $x]];
                    while (!empty($S)) {
                        [$cy, $cx] = array_pop($S);
                        $region[$cy][$cx] = $current;
                        $map[$cy][$cx] = 0;
                        foreach ($dir as [$dy, $dx]) {
                            [$ny, $nx] = [$cy + $dy, $cx + $dx];
                            if (isset($map[$ny][$nx]) && $map[$ny][$nx] == $current) {
                                $S["$ny,$nx"] = [$ny, $nx];
                            }
                        }
                    }
                    $regions[] = $region;
                }
            }
        }

        $dir_exp = [
            [-1, 0],
            [-1, -1],
            [0, -1],
            [1, -1],
            [1, 0],
            [1, 1],
            [0, 1],
            [-1, 1],
        ];

        $ans = 0;
        foreach ($regions as $region) {
            $size = 0;
            $corners = 0;
            foreach ($region as $y => $row) {
                foreach ($row as $x => $_) {
                    $size++;
                    // map all 8 tiles around current tile
                    foreach ($dir_exp as $d => [$dy, $dx]) {
                        $w[$d] = isset($region[$y + $dy][$x + $dx]) ? 1 : 0;
                    }

                    $c = 0;
                    for ($i = 0; $i < 4; $i++) {
                        // if the tiles A,W || W,D || S,D || S,A dont exist its a corner;
                        if ($w[$i * 2] + $w[(($i + 1) * 2) % 8] == 0) {
                            $c++;
                            // else if they both exist check the tile in between them on the diagonal if its not existing you also have a corner
                        } elseif ($w[$i * 2] + $w[(($i + 1) * 2) % 8] == 2) {
                            $c += 1 - $w[($i * 2 + 1) % 8];
                        }
                    }
                    $corners += $c;
                }
            }
            $ans += $size * $corners;
        }
        return "the total price for fencing was $ans";
    }
}