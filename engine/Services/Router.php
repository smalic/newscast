<?php
namespace Newscast\Services;

class RouterService extends Service {
   private array $routes = [];
   
   public function __construct() {}
   
   public function add_route( string $method, string $route, mixed $resolve ): void {
      if ( ! UrlService::does_route_match_request( $route ) ) {
         return;
      }

      $this->routes[ $route ] = [
         'resolve' => $resolve,
         'middleware' => false,
         'request' => array(),
         'method' => $method,
      ];

      $this->set_request( $route );

      $this->reboot();
   }
   
   public function attach_middleware( string $route, string $middleware ): void {
      $this->routes[ $route ]['middleware'] = $middleware;
   }
   
   public function set_request( string $route ): void {
      $this->routes[ $route ]['request'] = $_REQUEST;
   }
   
   public function reboot(): void {
      foreach ( $this->routes as $route => $options ) {
         if ( ! UrlService::does_route_match_request( $route ) ) {
            continue;
         }
         
         UrlService::create_url_route( $route, $options );
      }
   }
}