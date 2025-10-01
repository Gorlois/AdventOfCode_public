<?php

namespace Core\Helper;

class Splitter {

    public static function splitOnEmpty(string $string): array {
        return explode("\r\n\r\n", $string);
    }

    public static function splitOnLinebreak(string $string): array {
        return explode("\r\n", $string);
    }

    public static function mergeOnLinebreak(string $string): string{
        return str_replace("\r\n", "", $string);
    }
}

trait Splitable {
    public static function splitOnEmpty(string $string): array {
        return explode("\r\n\r\n", $string);
    }

    public static function splitOnLinebreak(string $string): array {
        return explode("\r\n", $string);
    }

    public static function mergeOnLinebreak(string $string): string{
        return str_replace("\r\n", "", $string);
    }
}