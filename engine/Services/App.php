<?php
/**
* Service for handling application booting
*/

namespace Newscast\Services;

use \Newscast\Kernel\Container;

class AppService extends Service {
    private array $system_dependencies = [
        'routes' => ENGINE_PATH . '/routes.php',
    ];

    private array $boot_services = [
        'helper',
        'orm',
        'db',
        'view',
        'router',
    ];
    
    public function __construct() {
        $this->boot();
        $this->load_system_dependencies();
    }
    
    /**
     * This function will load the dependencies necessary for Newscast to function.
     * Conversely, we will separately load user dependencies that may or may not be defined.
     */
    private function load_system_dependencies(): void {
        foreach ( $this->system_dependencies as $dependency ) {
            if ( file_exists( $dependency ) ) {
                require_once $dependency;
            }
        }
    }
    
    /**
    * Boot up all of our services!
    */
    public function boot(): void {
        foreach ( $this->boot_services as $service ) {
            $service = Container::make( $service );

            if ( method_exists( $service, 'boot' ) ) {
                $service->boot();
            }
        }
    }
}