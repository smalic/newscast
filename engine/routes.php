<?php
/**
* In this file, we will define all routes that our app uses.
* This might include, for example, our admin area.
* Bear in mind: routes for the frontend are not and will not be defined in this file.
* However, those routes will utilize the same routing engine.
*/

use Newscast\Facades\RouteFacade as Route;
use Newscast\Facades\ViewFacade as View;
use Newscast\Models\User;
use Newscast\Models\UserRole;
use Newscast\Kernel\Container;
use Newscast\Memory\Cookie;
use Newscast\Services\RequestService as Request;

Route::get( '/', function() {
    View::make( 'homepage.html.twig' );
} );

Route::get( '/get-param/{id}/another/{slug}', function( $id, $slug ) {
    View::make( 'twig.html.twig', [ 'id' => $id, 'slug' => $slug ] );
} );

Route::get( '/hello', function() {
    echo "hai from callback";
} );

Route::get( '/hello2', [ Newscast\App\Dummy::class, 'show' ] );

Route::get('/my-protected-route', function(){
    echo "this is a protected route";
})->middleware( "Restrict to logged in users with the editor role" );

Route::post( '/login', function() {
    if ( Request::auth() ) {
        echo 'You were successfully logged in Meg the Egg!';
    }
} );

Route::post( '/login2', [ Newscast\App\Dummy::class, 'store' ] );

// echo '<pre>';
// var_dump( User::find(1)->user_roles()->role_name );
// echo '</pre>';

// Cookie::set( 'cookie-key', 'cookie-value' );