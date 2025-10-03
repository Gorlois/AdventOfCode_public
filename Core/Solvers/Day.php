<?php
namespace Core\Solvers;

class Day{
    protected string $input;
    protected int $part;

    public function __construct(string $input, int|string $part)
    {
        $this->input = $input;
        $this->part = (int) $part;
    }

    public function run()
    {
        $time_start = microtime(true);
        $solution = match ($this->part) {
            1 => $this->part_1(),
            2 => $this->part_2(),
            default => "the solution for part $this->part has not been implemented yet"
        };
        $runtime = microtime(true) - $time_start;
        $solution .= "\r\n the problem was solved in $runtime seconds";
        return $solution;
    }

    protected function part_1() {
        return "";
    }

    protected function part_2() {
        return "";
    }
}

