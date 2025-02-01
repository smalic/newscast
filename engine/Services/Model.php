<?php
namespace Newscast\Services;

use Newscast\Models\Model;
use Newscast\Repositories\Repository;

class ModelService extends Service {
   private ?Model $model = null;
   
   private ?Repository $repository = null;

   private string $table = '';

   private string $caller;

   public function __construct( string $caller, array $attributes, string $table = '' ) {
      $this->repository = new Repository( $table );
      $this->table = $table;
      $this->caller = $caller;

      $this->model = isset( $attributes[0] ) && is_int( $attributes[0] ) ? $this->find( $attributes[0] ) : $this->create( $attributes[0] );
   }
   
   public function create( array $attributes ): Model {
      $model = new ( $this->caller )();

      $model->fill_attributes( $attributes );

      if ( isset( $attributes[0] ) || isset( $attributes['id'] ) ) {
         $model->id = isset( $attributes[0] ) ? intval( $attributes[0] ) : intval( $attributes['id'] );
      }
      else {
         $this->repository = $this->repository ?: new Repository( $this->table );
         $this->repository->save_or_update( $model );
      }

      $this->model = $model;
      
      return $model;
   }
   
   public function find( mixed $id ): Model {
      if ( is_array( $id ) ) {
         $id = $id[0];
      }

      return $this->create( $this->repository->fetch( $id ) );
   }
   
   public function get( string $attribute = '' ): mixed {
      return $this->model->$attribute ?? null;
   }
   
   public function set( string $attribute = '', mixed $value ): Model {
      if ( property_exists( $this->model, $attribute ) ) {
         $this->model->$attribute = $value;
      }
      
      return $this->model;
   }
   
   public function save(): Model {
      $this->repository->save_or_update( $this->model );
      
      return $this->model;
   }
   
   public function delete(): Model {
      // $this->repository->delete( $id );
      
      return $this->model;
   }
}