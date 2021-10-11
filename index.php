<?php

use CoffeeCode\Router\Router;

require_once "./config.php";
require_once "./vendor/autoload.php";

$router = new Router(BASE_PATH);
$router->namespace("App\Controller");

$router->group(null);
$router->get("/", "HomeController:index");

$router->dispatch();

if($router->error()) {
    $router->redirect("/");
}