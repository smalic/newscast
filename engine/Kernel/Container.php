<?php
namespace Newscast\Kernel;

final class Container {
    private static array $aliases = [
        'orm' => \RedBeanPHP\R::class,
        'db' => \Newscast\Services\DbService::class,
        'view' => \Newscast\Services\ViewService::class,
        'app' => \Newscast\Services\AppService::class,
        'router' => \Newscast\Services\RouterService::class,
        'route' => \Newscast\Services\RouteService::class,
        'url' => \Newscast\Services\UrlService::class,
        'helper' => \Newscast\Services\HelperService::class,
    ];

    private static array $instances = [];

    public static function get_instance( string $class_name, array $parameters = [] ): object {
        $class_name = self::resolve_instance_name( $class_name );

        if ( array_key_exists( $class_name, self::$instances ) ) {
            return self::$instances[ $class_name ];
        }

        self::make( $class_name, $parameters );

        return self::$instances[ $class_name ];
    }

    public static function make( string $class_name, array $parameters = [] ): object {
        $class_name = self::resolve_instance_name( $class_name );

        $instance = count( $parameters ) > 0 ? new $class_name( $parameters ) : new $class_name();
    
        self::$instances[ $class_name ] = $instance;

        return $instance;
    }

    public static function get_all_instances(): array {
        return self::$instances;
    }

    private static function resolve_instance_name( string $name ): string {
        return array_key_exists( $name, self::$aliases ) ? self::$aliases[ $name ] : $name;
    }

    public static function release(): void {
        foreach ( self::$instances as &$instance ) {
            unset( $instance );
        }

        self::$instances = [];
    }
}