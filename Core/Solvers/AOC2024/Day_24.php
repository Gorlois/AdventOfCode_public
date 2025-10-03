<?php
namespace Core\Solvers\AOC2024;

use Core\Solvers\Day;
use Core\Helper\Splitter;

class Day_24 extends Day {
    protected function part_1() {
        [$input, $gates_raw] = Splitter::splitOnEmpty($this->input);
        foreach (Splitter::splitOnLinebreak($input) as $inp) {
            [$n, $b] = explode(": ", $inp);
            $wires[$n] = (int) $b;
        }
        
        foreach (Splitter::splitOnLinebreak($gates_raw) as $gate_raw) {
            [$in, $out] = explode(" -> ", $gate_raw);
            [$w1, $op, $w2] = explode(" ", $in);
            $gates[$out] = [$w1, $w2, $op];
        }

        $gates_try = $gates;
        while ($gates_try) {
            $gates_unused = [];
            foreach ($gates_try as $out => [$in_1, $in_2, $operation]) {
                if (isset($wires[$in_1]) && isset($wires[$in_2])) {
                    $inp_1 = $wires[$in_1];
                    $inp_2 = $wires[$in_2];
                    $wires[$out] = match($operation) {
                        "XOR" => $inp_1^$inp_2,
                        "AND" => $inp_1&$inp_2,
                        "OR" => $inp_1|$inp_2,
                        default =>null
                    };
                } else {
                    $gates_unused[$out] = [$in_1, $in_2, $operation];
                }
            }
            $gates_try = $gates_unused;
        }

        $ans = "";
        foreach ($wires as $wire => $signal) {
            if (str_starts_with($wire, "z")) {
                $wires_z[$wire] = $signal;
            }
        }
        krsort($wires_z);
        foreach ($wires_z as $sig) {
            $ans.=$sig;
        }
        $ans = bindec($ans);        
        
        return "the program put out the number $ans";
    }
    
    protected function part_2() {
        [$input, $gates_raw] = Splitter::splitOnEmpty($this->input);
        foreach (Splitter::splitOnLinebreak($input) as $inp) {
            [$n, $b] = explode(": ", $inp);
            $wires[$n] = (int) $b;
        }
        
        $highest_z = "z00";
        foreach (Splitter::splitOnLinebreak($gates_raw) as $gate_raw) {
            [$in, $out] = explode(" -> ", $gate_raw);
            [$w1, $op, $w2] = explode(" ", $in);
            if ($out[0] == "z" && (int)substr($highest_z, 1) < (int)substr($out, 1)) {
                $highest_z = $out;
            }
            $gates[$out] = [$w1, $w2, $op];
        }

        foreach ($gates as $out => [$in1, $in2, $op]) {
            if ($out[0] == "z" && $op != "XOR" && $out != $highest_z) {
                $wrong_wires[] = $out;
                continue;
            }
            if ($op == "XOR" && $out[0] != "z" && !in_array($in1[0], ["x", "y"]) && !in_array($in2[0], ["x", "y"])) {
                $wrong_wires[] = $out;
                continue;
            }
            if ($op == "AND" && !in_array("x00", [$in1, $in2])) {
                foreach ($gates as [$sub_in_1, $sub_in_2, $sub_op]) {
                    if (($out == $sub_in_1 || $out == $sub_in_2) && $sub_op != "OR") {
                        $wrong_wires[] = $out;
                        continue 2;
                    }
                }
            }
            if ($op == "XOR") {
                foreach ($gates as [$sub_in_1, $sub_in_2, $sub_op]) {
                    if (($out == $sub_in_1 || $out == $sub_in_2) && $sub_op == "OR") {
                        $wrong_wires[] = $out;
                        continue 2;
                    }
                }
            }
        }
        sort($wrong_wires);
        $ans=implode(",", $wrong_wires);


        return "so the wires\r\n$ans\nwhere considered wrong";
    }
}