<?php
namespace Newscast\Facades;

use Newscast\Kernel\Container;

class Facade {
    public static function __callStatic( string $method, mixed $parameters ) {
        $instance = Container::get_instance( static::resolve_to() );
        return $instance->$method( ...$parameters );
    }
    
    public static function resolve_to(): string {
        return '';
    }
}