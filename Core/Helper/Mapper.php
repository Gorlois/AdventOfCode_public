<?php
namespace Core\Helper;

class Mapper {
    
    public const UP = [0, -1];
    public const RIGHT = [1, 0];
    public const DOWN = [0, 1];
    public const LEFT = [-1, 0];

    public const DIRECTIONS = [
        self::LEFT,
        self::UP,
        self::RIGHT,
        self::DOWN
    ];
    
    public static function map(array $strings): array {
        $map = [];
        foreach ($strings as $y_index => $string) {
            foreach (str_split($string) as $x_index => $tile) {
                $map[$y_index][$x_index] = $tile;
            }
        }
        return $map;
    }
}