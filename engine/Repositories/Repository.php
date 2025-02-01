<?php
namespace Newscast\Repositories;

use Newscast\Kernel\Container;
use Newscast\Services\DbService as DB;
use Newscast\Models\Model;

class Repository {
    private ?object $db;

    private ?object $table;

    private string $table_name = '';
    
    public function __construct( string $table ) {
        $db = Container::get_instance( 'db' );

        $this->db = property_exists( $db, 'connection' ) ? $db->connection : null;
        $this->table = $this->db ? $this->db::get_table( $table ) : null;
        $this->table_name = $table;
    }

    public function fetch( mixed $value ): array {
        $result = $this->db::load( $this->table_name, $value );

        $result = $result->export();

        foreach ( $result as $column => $value ) {
            if ( ! preg_match( '/(?P<column_name>\w+?_\w+?)_id/i', $column, $matches ) ) {
                continue;
            }

            unset( $result[$column] );
            $result[ $matches['column_name'] ] = $this->db::load( $matches['column_name'], $value );
        }

        return $result;
    }

    public function delete( mixed $value ): void {
        $this->db->delete( $this->table, 'id', $value );
    }

    public function save_or_update( Model $model ): void {
        $values = $model->to_array();

        foreach ( $values as $key => $value ) {
            $this->table->$key = $value;
        }

        $this->db::store( $this->table );
    }
}