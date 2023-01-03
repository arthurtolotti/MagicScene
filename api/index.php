<?php
ob_start();
require __DIR__ . "/../vendor/autoload.php";
use CoffeeCode\Router\Router;

$route = new Router(url(), ":");
$route->namespace("Source\App");

// users
$route->get("/user","Api:getUser");
// http://www.localhost/acme-manha/api/user/name/Fábio/email/fabio@gmail.com/password/12345678
$route->post("/user/name/{name}/email/{email}/password/{password}", "Api:createUser");
// http://www.localhost/acme-manha/api/user/name/Fábio Santos/email/fabio@gmail.com/document/987654321
$route->put("/user/name/{name}/email/{email}/document/{document}","Api:updateUser");


$route->dispatch();


/**
 * ERROR REDIRECT
 */
if ($route->error()) {
    header('Content-Type: application/json; charset=UTF-8');
    http_response_code(404);
    echo json_encode([
        "errors" => [
            "type " => "endpoint_not_found",
            "message" => "Não foi possível processar a requisição"
        ]
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}
ob_end_flush();