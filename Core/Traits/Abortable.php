<?php
namespace Core\traits;

trait Abortable
{
    protected function abort($code = 404)
    {
        http_response_code($code);
        require base_path("resources/views/{$code}.php");
        die();
    }
}