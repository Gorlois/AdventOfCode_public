<?php
namespace Core\Traits;

trait Memoizable {
    private array $memoizeCache = [];

    protected function memoize(string $key, callable $callback) {
        if (!array_key_exists($key, $this->memoizeCache)) {
            $this->memoizeCache[$key] = $callback();
        }
        return $this->memoizeCache[$key];
    }
}