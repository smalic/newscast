<?php
namespace Newscast\Facades;

class RouteFacade extends Facade {
    public static function resolve_to(): string {
        return 'route';
    }
}