<?php

function base_url(): string
{
    return 'http://localhost/tienda_virtual-main/';
}

function site_url(string $path = ''): string
{
    return base_url() . ltrim($path, '/');
}
