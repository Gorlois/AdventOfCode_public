<?php
namespace Core\Solvers\AOC2024;

use Core\Solvers\Day;
use Core\Helper\Splitter;
use ErrorException;
use Exception;

class Day_15 extends Day
{
    protected function part_1()
    {
        [$raw_map, $ins] = Splitter::splitOnEmpty($this->input);
        foreach (Splitter::splitOnLinebreak($raw_map) as $y => $row) {
            foreach (str_split($row) as $x => $c) {
                $map[$y][$x] = $c;
                if ($c == "@") {
                    $rob_y = $y;
                    $rob_x = $x;
                }
            }
        }

        $ins = str_replace(["\r\n", "<", ">", "^", "v"], ["", 0, 1, 2, 3], $ins);
        $rob = [$rob_y, $rob_x];
        foreach (str_split($ins) as $inst) {
            [$map, $rob] = $this->tryInstruction($map, $rob, $inst);
        }

        $ans = 0;
        foreach ($map as $y => $row) {
            foreach ($row as $x => $c) {
                if ($c == 'O') {
                    $ans += 100 * $y + $x;
                }
            }
        }

        return "the sum of all boxes' gps coordinates was $ans";
    }



    protected function part_2()
    {
        [$raw_map, $ins] = Splitter::splitOnEmpty($this->input);

        $ins = str_replace(["\r\n", "<", ">", "^", "v"], ["", 0, 1, 2, 3], $ins);
        $raw_map = str_replace(['#', 'O', '.', '@'], ['##', '[]', '..', '@.'], $raw_map);

        $oldprint = "";
        foreach (Splitter::splitOnLinebreak($raw_map) as $y => $row) {
            foreach (str_split($row) as $x => $c) {
                $oldprint .= $c;
                $map[$y][$x] = $c;
                if ($c == "@") {
                    $rob_y = $y;
                    $rob_x = $x;
                }
            }
            $oldprint .= "\r\n";
        }

        $rob = [$rob_y, $rob_x];
        foreach (str_split($ins) as $inst) {
            [$map, $rob] = $this->tryInstruction($map, $rob, (int) $inst, true);
        }

        $ans = 0;
        $newprint = "";
        foreach ($map as $y => $row) {
            foreach ($row as $x => $c) {
                $newprint .= $c;
                if ($c == '[') {
                    $ans += 100 * $y + $x;
                }
            }
            $newprint .= "\r\n";
        }



        return "the map started out as: \r\n $oldprint \r\n at the end of the run it was \r\n $newprint \r\n the sum of all widened boxes' gps coordinates was $ans";
    }

    private array $dir = [
        [0, -1],
        [0, 1],
        [-1, 0],
        [1, 0]
    ];

    private function tryInstruction($map, $rob_pos, $inst, $wide = false)
    {
        [$rob_y, $rob_x] = $rob_pos;
        [$dy, $dx] = $this->dir[$inst];

        if ($map[$rob_y][$rob_x] == '@') {
            $ny = $rob_y + $dy;
            $nx = $rob_x + $dx;
            $m = match ($map[$ny][$nx]) {
                '.' => true,
                '#' => false,
                'O' => $this->tryPush($map, [$ny, $nx], $inst),
                '[', ']' => $this->tryWidePush($map, [$ny, $nx], $inst),
                default => consoleLog("???")
            };
            if ($m) {
                if (!$wide) {
                    $map = $this->move($map, [$rob_y, $rob_x], [$ny, $nx]);
                } else {
                    $map = $this->moveStack($map, [$rob_y, $rob_x], [$ny, $nx], $inst);
                }
                [$rob_y, $rob_x] = [$ny, $nx];
            }
        } else {
            consoleLog("you lost the robot???");
        }
        return [$map, [$rob_y, $rob_x]];
    }

    private function tryPush(&$map, $coord, $inst)
    {
        [$cy, $cx] = $coord;
        [$dy, $dx] = $this->dir[$inst];
        if ($map[$cy][$cx] == 'O') {
            [$ny, $nx] = [$cy + $dy, $cx + $dx];
            $m = match ($map[$ny][$nx]) {
                '.' => true,
                'O' => $this->tryPush($map, [$ny, $nx], $inst),
                default => false
            };
        }
        if ($m) {
            $map = $this->move($map, [$cy, $cx], [$ny, $nx]);
            return true;
        }
        return false;
    }

    private function move($map, $orig_coord, $new_coord)
    {
        [$o_y, $o_x] = $orig_coord;
        [$n_y, $n_x] = $new_coord;
        $map[$n_y][$n_x] = $map[$o_y][$o_x];
        $map[$o_y][$o_x] = '.';
        return $map;
    }

    private function tryWidePush(&$map, $coord, $inst)
    {
        [$c_y, $c_x] = $coord;
        [$d_y, $d_x] = $this->dir[$inst];
        $c = $map[$c_y][$c_x];
        if ($c == "[") {
            [$l_x, $r_x] = [$c_x, $c_x + 1];
        } elseif ($c == "]") {
            [$l_x, $r_x] = [$c_x - 1, $c_x];
        } else {
            throw new Exception('object was not a wide box');
        }
        [$new_box_l_y, $new_box_l_x] = [$c_y + $d_y, $l_x + $d_x];
        [$new_box_r_y, $new_box_r_x] = [$c_y + $d_y, $r_x + $d_x];
        $m_l = match ($map[$new_box_l_y][$new_box_l_x]) {
            '.' => true,
            '#' => false,
            '[' => match ($inst) {
                    2, 3 => $this->tryWidePush($map, [$new_box_l_y, $new_box_l_x], $inst),
                    0, 1 => throw new Exception('We think a box broke')
                },
            ']' => match ($inst) {
                    0, 2, 3 => $this->tryWidePush($map, [$new_box_l_y, $new_box_l_x], $inst),
                    1 => true
                },
            default => throw new Exception("left was naughty"),
        };
        $m_r = match ($map[$new_box_r_y][$new_box_r_x]) {
            '.' => true,
            '#' => false,
            '[' => match ($inst) {
                    1, 2, 3 => $this->tryWidePush($map, [$new_box_r_y, $new_box_r_x], $inst),
                    0 => true
                },
            ']' => match ($inst) {
                    2, 3 => $this->tryWidePush($map, [$new_box_r_y, $new_box_r_x], $inst),
                    0, 1 => throw new Exception("a box was broken")
                },
            default => throw new ErrorException("right tried something illegal")
        };
        if ($m_l && $m_r) {
            return true;
        }
        return false;
    }

    // finish move stack and wide move
    private function moveStack($map, $orig_coord, $new_coord, $inst)
    {
        [$n_y, $n_x] = $new_coord;
        switch ($map[$n_y][$n_x]) {
            case ".":
                $map = $this->move($map, $orig_coord, $new_coord);
                break;
            case "[":
                $map = $this->wideMove($map, [$n_y, $n_x], [$n_y, $n_x + 1], $inst);
                $map = $this->move($map, $orig_coord, $new_coord);
                break;
            case "]":
                $map = $this->wideMove($map, [$n_y, $n_x - 1], [$n_y, $n_x], $inst);
                $map = $this->move($map, $orig_coord, $new_coord);
                break;
        }
        return $map;
    }

    private function wideMove($map, $box_l, $box_r, $inst)
    {
        [$d_y, $d_x] = $this->dir[$inst];
        [$orig_box_l_y, $orig_box_l_x] = $box_l;
        [$orig_box_r_y, $orig_box_r_x] = $box_r;
        [$new_box_l_y, $new_box_l_x] = [$orig_box_l_y + $d_y, $orig_box_l_x + $d_x];
        [$new_box_r_y, $new_box_r_x] = [$orig_box_r_y + $d_y, $orig_box_r_x + $d_x];
        if ($map[$new_box_l_y][$new_box_l_x] == "[") {
            $map = $this->wideMove($map, [$new_box_l_y, $new_box_l_x], [$new_box_l_y, $new_box_l_x + 1], $inst);
        } elseif ($map[$new_box_l_y][$new_box_l_x] == "]" && $inst != 1) {
            $map = $this->wideMove($map, [$new_box_l_y, $new_box_l_x - 1], [$new_box_l_y, $new_box_l_x], $inst);
        }


        if ($map[$new_box_r_y][$new_box_r_x] == "]") {
            $map = $this->wideMove($map, [$new_box_r_y, $new_box_r_x - 1], [$new_box_r_y, $new_box_r_x], $inst);
        } elseif ($map[$new_box_r_y][$new_box_r_x] == "[" && $inst != 0) {
            $map = $this->wideMove($map, [$new_box_r_y, $new_box_r_x], [$new_box_r_y, $new_box_r_x + 1], $inst);
        }
        $map[$orig_box_l_y][$orig_box_l_x] = ".";
        $map[$orig_box_r_y][$orig_box_r_x] = ".";
        $map[$new_box_l_y][$new_box_l_x] = "[";
        $map[$new_box_r_y][$new_box_r_x] = "]";
        return $map;
    }
}