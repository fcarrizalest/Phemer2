<?php
require "../vendor/autoload.php";

require "init.php";

$mainController = new \Phemer\Controllers\MainController();
$clientController = new \Phemer\Controllers\ClientController();


//$cache->eraseExpired();

//$cache -> store("algo" ,"algo" );
$app->get('/',function() use ( $app ) {  


	$app->render('home.php');
	
});


$app->get('/install', function () use ($app,$capsule ){


    $capsule->schema()->dropIfExists('users');

	$capsule->schema()->create('users', function($table)
{
    $table->increments('id');
    $table->string('email')->unique();
    $table->timestamps();

});

    $capsule->schema()->dropIfExists('clients');
	$capsule->schema()->create('clients', function($table)
{
    $table->increments('id');
    $table->string('title')->unique();
    $table->string('firstname');
    $table->string('lastname')->unique();
    $table->timestamps();

});


echo 'ok';

} );

$app->post('/api/dologin', $mainController->doLogin() );


$app->group('/api/client', $clientController->routes() );





$app->run();

?>