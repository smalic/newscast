<?php
namespace Newscast\Memory;

abstract class Cookie {
    private static string $cookie_prefix = 'nc_';

    public static function set( string $key, mixed $value, int $expires = 0, string $path = '', string $domain = '' ): void {
        setcookie( static::$cookie_prefix . $key, $value, $expires, $path, $domain );
    }

    public static function get( string $key ): mixed {
        $key = static::$cookie_prefix . $key;
        
        return isset( $_COOKIE[$key] ) ? $_COOKIE[$key] : '';
    }
}