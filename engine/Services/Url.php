<?php
/**
* Service for handling route creation
*/

namespace Newscast\Services;

use Newscast\Services\RequestService as Request;

class UrlService extends Service {
    protected static function strip_root_from_request(): string {
        $request = $_SERVER['REQUEST_URI'] ?? '';
    
        if ( empty( APP_ROOT ) || APP_ROOT === '/' ) {
            return $request;
        }
    
        $root = parse_url( APP_ROOT, PHP_URL_PATH );
        $root_length = strlen( $root );
    
        if ( substr( $request, 0, $root_length ) === $root ) {
            return substr( $request, $root_length );
        }
    
        return $request;
    }
    
    public static function create_url_route( string $route, array $options ): void {
        if ( !self::does_route_match_request( $route ) ) {
            return;
        }
    
        $parameters = $options['resolve'];
        $http_method = $options['method'];
    
        if ( $http_method === 'post' && ! empty( $options['request'] ) ) {
            $_POST = $options['request'];
        }
    
        if ( is_callable( $parameters ) ) {
            $params = [];
            
            if ( self::get_route_type( $route ) === 'regex' ) {
                $params = self::extract_regex_parameters( $route );
            }
    
            call_user_func_array( $parameters, $params );
        } elseif ( is_array( $parameters ) && count($parameters) === 2 ) {
            [$class, $method] = $parameters;
            $object_instance = new $class();
    
            if ( $http_method === 'post' ) {
                $request = Request::load( $_POST );
                $object_instance->$method( $request );
            } else {
                $object_instance->$method();
            }
        }
    }

    protected static function strip_preceding_slash( string $route ): string {
        return ltrim( $route, '/' );
    }

    protected static function get_route_type( string $route ): string {
        return strpos( $route, '{' ) !== false ? 'regex' : 'normal';
    }

    public static function does_route_match_request( string $route ): bool {
        $request = self::strip_preceding_slash( self::strip_root_from_request() );
        $route = self::strip_preceding_slash( $route );

        $route_type = self::get_route_type( $route );

        if ( $route_type === 'normal' && $request !== $route ) {
            return false;
        }

        if ( $route_type === 'regex' ) {
            $route = preg_replace( '/\{.+?\}/i', '.+?', $route );
            $route = str_replace( '/', '\/', $route );

            if ( ! preg_match( '/' . $route . '/i', $request, $matches ) ) {
                return false;
            }
        }

        return true;
    }

    protected static function extract_regex_parameters( string $route ): array {
        $request = self::strip_root_from_request();

        $route = preg_replace( '/\{.+?\}/i', '(.+)?', $route );
        $route = str_replace( '/', '\/', $route );

        preg_match( '/' . $route . '/i', $request, $matches );
        
        if ( count( $matches ) <= 1 ) {
            return [];
        }

        unset( $matches[0] );

        return array_values( $matches );
    }
}