<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Symfony\Component\Yaml\Parser;
use Symfony\Component\Yaml\Dumper;

if( !file_exists("../config.yml" )){
	// No existe nuestro archivo de configuración creamos uno.
	exit("configuracion no encontrada");

}



$yaml = new Parser();

$config = $yaml->parse(file_get_contents('../config.yml'));




$environments = $config['environments'];


$default = $environments['default_database'];

if(isset($_GET['unittest']) ){
	$default = "test";

	
}

$capsule = new Capsule();

$capsule->addConnection( $environments[$default ] );



// Set the event dispatcher used by Eloquent models... (optional)
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;


$Container = new Container();

$capsule->setEventDispatcher(new Dispatcher( $Container ));

// Make this Capsule instance available globally via static methods... (optional)
$capsule->setAsGlobal();

// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
$capsule->bootEloquent();



$app = new \Slim\Slim(array( 

	'log.writer' => new \Phemer\Utils\PhemerLog( '../logs/', \Slim\Log::DEBUG    ),
    
	)
  );
$app -> config = $config ;

$app->container->singleton('Validator', function () use ($Container,$capsule) {
    
    $t = new \Symfony\Component\Translation\IdentityTranslator();

    $factory = new \Illuminate\Validation\Factory( $t  , $Container);

    $db = new  \Illuminate\Validation\DatabasePresenceVerifier($capsule->getDatabaseManager() );

    $factory->setPresenceVerifier(  $db  );

    return $factory;
});


$cache = new Phemer\Utils\Cache();

$app->Cache = $cache;

$app->Cache->setCachePath("../cache/");



?>