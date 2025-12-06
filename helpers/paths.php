<?php
// Helpers de rutas: devuelven la base del sitio y construyen URLs internas
if (!function_exists('site_base')) {
    function site_base(): string {
        $base = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/\\');
        if ($base === '' || $base === '.') return '';
        return $base;
    }
}

if (!function_exists('site_url')) {
    function site_url(string $path = ''): string {
        $base = site_base();
        $path = ltrim($path, '/');
        return ($base === '' ? '/' : $base . '/') . $path;
    }
}
