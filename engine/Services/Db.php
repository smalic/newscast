<?php
namespace Newscast\Services;

use Newscast\Kernel\Container;

class DbService extends Service {
   public ?object $connection;
   
   public function __construct() {
      $this->connection = null;
   }
   
   public function boot(): void {
      $orm = Container::get_instance( 'orm' );
      
      $orm::ext( 'get_table', function( $type ) use ( $orm ) { 
         return $orm::getRedBean()->dispense( $type ); 
      } );
      
      // grab from config
      $host = 'localhost';
      $db = 'newscast';
      $user = 'root';
      $password = '';
      
      $orm::setup( 'mysql:host=' . $host . ';dbname=' . $db, $user, $password );
      
      $this->connection = $orm;
   }
   
   public function shutdown(): void {
      $this->connection::close();
   }
}