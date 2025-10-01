<?php
namespace Core\Lists;

class YearList
{
    private const LIST = [
        '2024' => 'Advent of Code'
    ];

    public function list() {
        return self::LIST;
    }
}
