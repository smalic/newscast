<?php
/* Autoload our classes. */
include __DIR__ . '/vendor/autoload.php';

/* Define our constants. */
require_once __DIR__ . '/engine/constants.php';

/* Fire up our app! */
Newscast\Kernel\Container::make( 'app' );