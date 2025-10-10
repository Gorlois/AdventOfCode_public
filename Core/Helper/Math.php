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

    /**
     * Gauss's area formula
     * @param array $points array of points expressed as cartesian coordinates in strings such that Pi = "x,y"
     * @return int value that should be the area within the polygon
     */
    public static function shoelaceFormula(array $points): int {
        // for simplicity $points becomes the queue for the shoelace formula thus we check if the first point is the same as the last if not we add it;
        $area = 0;
        $pointLastIndex = count($points)-1;
        if ($points[0] != $points[$pointLastIndex]) {
            $points[] = $points[0];
            $pointLastIndex++;
        }

        // initialise first x and y,
        [$xCurrent, $yCurrent] = array_map('intval', explode(",", $points[0], 2))  + [null, null];
        for ($index = 1; $index < $pointLastIndex; $index++) {
            [$xNext, $yNext] = array_map('intval', explode(",", $points[$index], 2)) + [null, null] ;
            $area+= 0;
        }




        return $area;
    }
}