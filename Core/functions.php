<?php
function dumpDie($value)
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";

    die();
}

function consoleLog($input)
{
    echo "<script>console.log('";
    echo (is_array($input)) ? implode(', ', $input) : (string) $input;
    echo "');</script>";
}

function urlIs($value)
{
    return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) === $value;
}

function base_path($path)
{
    return BASE_PATH . $path;
}

function view($path, $attributes = [])
{
    extract($attributes);
    require base_path("resources/views/{$path}");
}

function renderStylesheets(array $paths): string {
    $html = '';
    foreach ($paths as $path) {
        $html .= '<link rel="stylesheet" href="'.htmlspecialchars($path).'">'.PHP_EOL;
    }
    return $html;
}