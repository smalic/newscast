# Newscast

## About

Newscast was an exercise in understanding how popular PHP MVC frameworks function.
My idea was to build a few basic features commonly shared by frameworks such as Laravel, Symfony, Code Igniter, and others.

## Features

Newscast supports:

- Routes - we can define routes in several different ways
- Views - powered by the Twig templating language
- Models - allow querying the database using the RedBean ORM

## Routes

We can define routes by specifying the controller name and method, or by supplying a callback function.

Examples:

### Using a callback
`Route::get( '/about', function() {
    View::make( 'about.html.twig' );
} );`

### Using a class/method approach
`Route::get( '/blog', [ Newscast\App\Blog::class, 'index' ] );`

Routes are stored in *engine/routes.php*

## Views

As mentioned above, we use Twig for our views, and to call a view, we simply do:
`View::make('template.html.twig');`

Views are stored in *app/views/public*.

## Models

The most basic model looks something like this:
`class Book extends Model {
    protected static string $table = 'book';
}`

And querying this model would look like this:
`\Newscast\Models\Book::find(1)->attributes['author']`

## Conclusion

At some point I hope to revisit this project and make some changes.

Specifically:
- I want to ditch snake case wherever possible and use camel case
- In the model table declaration, I want to ditch the "static" keyword
- I want to create the ability to add middlewares
- Change the folder structure a bit. I think I made things way too complex early on without a clear goal

In an ideal world, I would have enough time and money to make this into a real framework, or rather a platform, for news publishing. 
Sadly, it is doomed to be a mere exercise in writing MVC in PHP.