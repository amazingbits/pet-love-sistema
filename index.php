<?php

date_default_timezone_set("America/Sao_Paulo");

use CoffeeCode\Router\Router;

require_once "./config.php";
require_once "./vendor/autoload.php";

$router = new Router(BASE_PATH);
$router->namespace("App\Controller");

$router->group(null);
$router->get("/", "HomeController:index");

// Auth
$router->group("auth");
$router->get("/", "AuthController:login");

// User
$router->group("user");
$router->get("/new", "UserController:new");
$router->post("/save", "UserController:save");
$router->get("/forgotpassword", "UserController:forgotPassword");
$router->get("/changepassword/{idUser}/{code}", "UserController:changePassword");
$router->get("/myaccount", "UserController:myAccount");
$router->post("/changeimage/{imgName}", "UserController:updateUserImg");

// Image
$router->group("image");
$router->get("/erase/{imgName}/{folderName}", "ImageController:erase");

// Services
$router->group("services");
$router->get("/", "ServiceController:index");

// Schedules
$router->group("schedule");
$router->get("/", "ScheduleController:index");

// Blocks
$router->group("blocks");
$router->get("/", "BlockController:index");

$router->dispatch();

if($router->error()) {
    $router->redirect("/");
}