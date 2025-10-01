<?php
namespace Core\Solvers\AOC2024;

use Core\Helper\Splitter;

class Day_05 extends Day
{
    protected function part_1() {
        $ans = 0;
        $input = Splitter::splitOnEmpty($this->input);
        $inp_inst = Splitter::splitOnLinebreak($input[0]);
        foreach ($inp_inst as $inp) {
            $inst[] = explode("|", $inp);
        }
        $inp_seq = Splitter::splitOnLinebreak($input[1]);
        foreach ($inp_seq as $inp) {
            $sequence = explode(",", $inp);
            if($this->checkInstructions($sequence, $inst)) {
                $m = (count($sequence)-1) / 2;
                $ans+=(int)$sequence[$m];
            }
        }
        return "all middle page numbers of correctly ordered sequences added up to $ans";
    }

    protected function part_2() {
        $ans = 0;
        $input = Splitter::splitOnEmpty($this->input);
        $inp_inst = Splitter::splitOnLinebreak($input[0]);
        foreach ($inp_inst as $inp) {
            $inst[] = explode("|", $inp);
        }
        $inp_seq = Splitter::splitOnLinebreak($input[1]);
        foreach ($inp_seq as $inp) {
            $sequence = explode(",", $inp);
            if(!$this->checkInstructions($sequence, $inst)) {
                $c = count($sequence);
                $sequence = $this->orderSequence($sequence, $inst, $c);
                $m = ($c-1) / 2;
                $ans+=(int)$sequence[$m];
            }
        }

        return "the new answer was $ans";
    }

    private function checkInstructions(array $sequence, array $instruction) {
        $c = count($sequence);
        foreach ($instruction as $inst) {
            for ($i = 0; $i < $c; $i++) {
                if ($sequence[$i] == $inst[0]) {
                    for($i_b = $i; $i_b >= 0; $i_b--) {
                        if ($sequence[$i_b] == $inst[1]) {
                            return false;
                        }
                    }
                }
            }
        }
        return true;
    }

    private function orderSequence(array $sequence, array $instruction, int $seq_c) {
        foreach ($instruction as $inst) {
            for ($i = 0; $i < $seq_c; $i++) {
                if ($sequence[$i] == $inst[0]) {
                    for ($iterator_2 = $i; $iterator_2 >= 0; $iterator_2--) {
                        if ($sequence[$iterator_2] == $inst[1]) {
                            $sequence[$i] = $inst[1];
                            $sequence[$iterator_2] = $inst[0];
                            return $this->orderSequence($sequence, $instruction, $seq_c);
                        }
                    }
                }
            }
        }
        return $sequence;
    }
}