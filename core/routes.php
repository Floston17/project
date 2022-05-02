<?php

$router->get('', 'MoviesController@index');
$router->get('movie', 'MoviesController@show');
$router->post('addFavouriteMovie', 'MoviesController@store');
$router->post('delete', 'MoviesController@destroy');


$router->get('login', 'SessionsController@create');
$router->post('login', 'SessionsController@store');

$router->get('logout', 'SessionsController@destroy');

$router->get('register', 'RegisterController@create');
$router->post('register', 'RegisterController@store');

$router->post('addComment', 'CommentsController@store');
$router->post('deleteComment', 'CommentsController@destroy');



