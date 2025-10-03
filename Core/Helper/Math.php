<?php
namespace Core\Helper;

class Math {
    public static function greatestCommonDivisor(int $a, int $b): int {
        if ($b == 0) {
            return $a;
        }
        return Math::greatestCommonDivisor($b, $a%$b);
    }

    public static function leastCommonMultiple(int $a, int $b): float|int {
        return $a / Math::greatestCommonDivisor($a, $b) * $b;
    }
}