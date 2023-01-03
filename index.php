<?php
session_start();
ob_start();

require __DIR__ . "/vendor/autoload.php";
use CoffeeCode\Router\Router;

$route = new Router(CONF_URL_BASE, ":");

/**
 * Web Routes
 */
$route->namespace("Source\App");
$route->get("/", "Web:home");
$route->get("/sobre", "Web:sobre");
$route->get("/duvidas","Web:duvidas");
$route->get("/cadastrar","Web:cadastrar");
$route->post("/cadastrar","Web:cadastrar");
$route->get("/entrar","Web:entrar");
$route->post("/entrar","Web:entrar");

/**
 * App Routs
 */

$route->group("/app");
$route->get("/","App:home");
$route->get("/perfil","App:perfil");
$route->post("/perfil","App:profileUpdate");
$route->get("/sair","App:logout");
$route->group(null);

/**
 * Admin Routs
 */

$route->group("/adm"); // agrupa em /admin
$route->get("/","Adm:home");
$route->get("/adcfilme","Adm:adcfilme");
$route->post("/adcfilme","Adm:adcfilme");
$route->get("/upfilme","Adm:upfilme");
$route->post("/upfilme","Adm:upfilme");
$route->get("/listar","Adm:list");
$route->get("/pdf","Adm:createPDF");
$route->get("/sair","Adm:logout");
$route->group(null); // desagrupo do /admin


/*
 * Erros Routes
 */

$route->group("error")->namespace("Source\App");
$route->get("/{errcode}", "Web:error");

$route->dispatch();

/*
 * Error Redirect
 */

if ($route->error()) {
    $route->redirect("/error/{$route->error()}");
}

ob_end_flush();