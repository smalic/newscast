<?php
namespace Newscast\Models;

use \RedBeanPHP\SimpleModel as RedBeanModel;
use \Newscast\Kernel\Container;
use \Newscast\Services\ModelService;

class Model extends RedBeanModel {
    private static ?ModelService $model_service = null;
    
    protected static string $table = '';
    
    public int $id = 0;
    
    public int $publish_date = 0;
    
    public int $modified_date = 0;

    public array $attributes = [];
    
    public function __construct() {}
    
    public function fill_attributes(array $attributes): void {
        if (empty($attributes)) {
            return;
        }

        foreach ($attributes as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }

        $this->attributes = $attributes;
        $this->publish_date = $this->modified_date = time();
    }

    public function to_array(): array {
        $properties = get_object_vars( $this );
        $model_array = [];
    
        foreach ( $properties as $name => $value ) {
            $model_array[$name] = $value;
        }
    
        return $model_array;
    }
    
    public static function __callStatic( string $method, mixed $parameters ) {
        $instance = ! static::$model_service ? new ModelService( get_called_class(), $parameters, static::$table ) : static::$model_service;
        
        return $instance->$method( $parameters );
    }
}