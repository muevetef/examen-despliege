<?php
require __DIR__ . '/../vendor/autoload.php';
require '../helpers.php';

//Creamos un router
use Core\Router;
use Core\Session;

Session::start();
// inspect(Session::get('user'));

$router = new Router();
//traemos el archivo con las rutas
$routes = require basePath('routes.php');

//mirar la uri de la peticion http
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$router->route($uri);
