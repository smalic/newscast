<?php
/**
* Service for handling route creation
*/

namespace Newscast\Services;

use \Newscast\Kernel\Container;

final class RouteService extends Service {
   public string $route = '';

   private ?RouterService $router = null;

   public function __construct() {
      $this->router = $this->router ?: Container::get_instance( 'router' );
   }

   public function handle_http_methods( string $method, string $route, mixed $parameters ): void {
      $this->route = $route;
      $this->router->add_route( $method, $route, $parameters );
   }

   public function middleware( string $middleware_name ): RouteService {
      $this->router->attach_middleware( $this->route, $middleware_name );

      return $this;
   }

   public function __call( string $method, mixed $parameters = null ): mixed {
      $http_methods = [ 'get', 'post' ];

      if ( ! in_array( $method, $http_methods ) ) {
         throw new Exception( 'Sir, SIR! You can\'t do that here!' );
      }

      $this->handle_http_methods( $method, $parameters[0], $parameters[1] );

      return $this;
   }
}