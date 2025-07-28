<?php

if (!function_exists('dump')) {
    function dump($var)
    {
        echo '<pre style="background:#222;color:#68ff74;padding:10px;border-radius:5px;font-size:14px;">';
        var_export($var);
        echo '</pre>';
    }
}

if (!function_exists('dd')) {
    function dd(...$vars)
    {
        foreach ($vars as $var) {
            echo '<pre style="background:#222;color:#68ff74;padding:10px;border-radius:5px;font-size:14px;">';
            var_export($var);
            echo "</pre>\n";
        }
        die(1);
    }
}

if (!function_exists('env')) {
    function env($key, $default = null)
    {
        static $env = null;
        if ($env === null) {
            $env = [];
            $envPath = __DIR__ . '/../.env';

            if (file_exists($envPath)) {
                foreach (file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
                    if (strpos(trim($line), '#') === 0) continue;
                    [$k, $v] = array_map('trim', explode('=', $line, 2) + [1 => null]);
                    if ($k !== '' && $v !== null) {
                        $env[$k] = $v;
                    }
                }
            }
        }
        return $env[$key] ?? $default;
    }
}