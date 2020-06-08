<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

//--- INI :: Routes Examples -------------------------------------------------------------------------
    $app->get('/books/{id}', function ($request, $response, $args){
        // Show book identified by $args['id']
    });

    $app->post('/books', function ($request, $response, $args){
        // Create new book
    });

    $app->put('/books/{id}', function ($request, $response, $args){
        // Update book identified by $args['id']
    });

    $app->delete('/books/{id}', function ($request, $response, $args){
        // Delete book identified by $args['id']
    });
//--- END :: Routes Examples -------------------------------------------------------------------------
