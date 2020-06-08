<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require('vendor/autoload.php');
require_once('conn/dbconn.php');

$app = new \Slim\App;

/**/
//http://localhost/srvr_jwd/datum/apiserver/hello/fabricio

$app->get('/hello/{name}', function (Request $request, Response $response, array $args) {
    $name = $args['name'];
    $response->getBody()->write("Hello, $name");

    return $response;
});

/**/

require_once('endpoints.php');


$app->run();