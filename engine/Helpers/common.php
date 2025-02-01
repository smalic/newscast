<?php

/**
* Here we will place all functions that we commonly use during development.
* Any special helpers will have to be invoked from their own classes, such as Arr, Str, etc.
*/

if ( ! function_exists( 'dd' ) ) {
    /**
     * Dump and die
     */
    function dd( ...$args ) {
        echo '<pre>';
        var_dump( $args );
        echo '</pre>';
        
        die();
    }
    
}