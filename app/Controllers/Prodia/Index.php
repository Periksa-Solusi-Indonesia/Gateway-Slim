<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$app->get('/external-prodia/{end-prodia}', function (Request $request, Response $response, array $args) {
    $response->getBody()->write("Hello, $name");
    return $response;
});

$app->run();

function index($url, $paramter, $method, $validasi){

    if($method = 'get'){

    }
    if($method = 'post'){

    }
    if($method = 'put'){

    }
    
}