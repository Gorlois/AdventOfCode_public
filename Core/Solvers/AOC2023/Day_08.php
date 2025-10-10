<?php
namespace Core\Solvers\AOC2023;

use Core\Helper\Math;
use Core\Helper\Splitter;
use Core\Solvers\Day;

class Day_08 extends Day {
    protected function part_1() {
        [$instructions, $nodes] = Splitter::splitOnEmpty($this->input);
        $nodes = Splitter::splitOnLinebreak($nodes);
        foreach($nodes as $node) {
            [$currentNode, $navigationInstruction] = explode(" = (", $node, 2);
            [$leftNode, $rightNode] = explode(", ", $navigationInstruction);
            $rightNode = substr($rightNode, 0, 3);
            $nextNodes[$currentNode] = [$leftNode, $rightNode];
        }

        $steps = 0;
        $instructions = str_split($instructions);
        $instructionQueue = $instructions;
        $current="AAA";
        
        while($steps < 1000000) {
            if ($current === "ZZZ") {
                break;
            }

            $current = match(array_shift($instructionQueue)) {
                'L' => $nextNodes[$current][0],
                'R' => $nextNodes[$current][1],
                default => null
            };

            if(empty($instructionQueue)) {
                $instructionQueue = $instructions;
            }
            $steps++;
        }
        return "you got to ZZZ in $steps steps";
    }

    protected function part_2() {
        [$instructions, $nodes] = Splitter::splitOnEmpty($this->input);
        $instructions = str_split($instructions);
        foreach (Splitter::splitOnLinebreak($nodes) as $node) {
            [$currentNode, $navigationInstruction] = explode(" = (", $node);
            [$leftNode, $rightNode] = explode(", ", $navigationInstruction);
            $rightNode = substr($rightNode, 0, 3);
            $nextNodes[$currentNode] = [$leftNode, $rightNode];
            if ($currentNode[2] == "A") {
                $startingNodes[] = $currentNode;
            }
        }

        foreach ($startingNodes as $startingNode) {
            $loopLengths[] = $this->findLoop($nextNodes, $startingNode, $instructions);
        }

        $currentLCM = array_shift($loopLengths);
        while ($loopLengths) {
            $nextMultiple = array_shift($loopLengths);
            $currentLCM = Math::leastCommonMultiple($currentLCM, $nextMultiple);
        }

        return "in the end we have $currentLCM as the least common multiple";
    }

    private function findLoop(array $nodes, string $start, array $instructions) {
        $path = [];
        $t = 0;
        $cur = $start;
        $inst_queue = $instructions;
        while (true) {
            $c = count($inst_queue);

            if(!isset($path["$cur,$c"])) {
                $path["$cur,$c"] = $t;
            } else {
                return $t-$path["$cur,$c"];
            }

            // take step
            
            $cur = match(array_shift($inst_queue)) {
                'L' => $nodes[$cur][0],
                'R' => $nodes[$cur][1]
            };
            $t++;
            if ($t > 10000000) {
                throw new \Exception("the number became kinda big");
            }
            
            if($c-1 === 0) {
                $inst_queue = $instructions;
            }   
        }
    }
}