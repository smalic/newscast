<?php
namespace Newscast\Facades;

class ViewFacade extends Facade {
    public static function resolve_to(): string {
        return 'view';
    }
}