<?php
use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;


header('Access-Control-Allow-Origin:*'); 
header('Access-Control-Allow-Headers:X-Request-With');

header('Access-Control-Allow-Methods: GET, POST,PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');


require __DIR__ . '/../vendor/autoload.php';
require '../src/config/db.php';


$app = AppFactory::create();


//En este caso puede cambiar dependiendo de tu directorio
$app->setBasePath("/php/public");

require '../src/routes/libros.php';

$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});


$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write("This is a page for Slim 4");
    return $response;
});

$app->run();