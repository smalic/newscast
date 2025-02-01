<?php
namespace Newscast\Services;

final class HelperService {
    private array $helpers = [
        'helpers/common' => ENGINE_PATH . '/Helpers/common.php',
    ];

    public function boot(): void {
        foreach ( $this->helpers as $helper ) {
            if ( file_exists( $helper ) ) {
                require_once $helper;
            }
        } 
    }
}