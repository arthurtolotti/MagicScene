<?php

namespace Source\App;

use League\Plates\Engine;
use Source\Models\User;
use Source\Models\Faq;
use Source\Models\Filme;

class Web{
    private $view;

    public function __construct(){
        $this->view = new Engine(CONF_VIEW_WEB,'php');
    }
    public function home() : void{
        $user = new User(2);
        $user->findById();

        $filme = new Filme();
        $filmes = $filme->selectAll();

        echo $this->view->render(
            "home",["user" => $user,
            "filmes" => $filmes]
        );
    }

    public function sobre() : void{

        echo $this->view->render(
            "sobre",["user"]
        );
    }
    public function duvidas(){
        $faq = new Faq();
        $faqs = $faq->selectAll();

        echo $this->view->render(
            "duvidas",["faqs" => $faqs]
        );
    }
    public function cadastrar(?array $data) : void{
        if(!empty($data)){
            if(in_array("", $data)) {
                $json = [
                    "message" => "Preencha todos os campos!",
                    "type" => "warning"
                ];
                echo json_encode($json);
                return;
            }
            if(!is_email($data["email"])){
                $json = [
                    "message" => "Informe um email válido!",
                    "type" => "warning"
                ];
                echo json_encode($json);
                return;
            }
            $user = new User();
            if($user->findByEmail($data["email"])){
                $json = [
                    "message" => "Email cadastrado!",
                    "type" => "warning"
                ];
                echo json_encode($json);
                return;
            }
            $user = new User(
                null,
                $data["name"],
                $data["email"],
                $data["password"]
            );
            if(!$user->insert()){
                $json = [
                    "message" => $user->getMessage(),
                    "type" => "error"
                ];
                echo json_encode($json);
                return;
            } else {
                $json = [
                    "name" => $data["name"],
                    "message" => $user->getMessage(),
                    "type" => "success"
                ];
                echo json_encode($json);
                return;
            }
            return;
        }
        echo $this->view->render("cadastrar",["eventName" => CONF_SITE_NAME]);
    }
    public function entrar(?array $data) : void{
        if(!empty($data)){
            if(in_array("",$data)){
                $json = [
                    "message" => "Preencha todos os campos para entrar!",
                    "type" => "warning"
                ];
                echo json_encode($json);
                return;
            }
            if(!is_email($data["email"])){
                $json = [
                    "message" => "Informe um email válido!",
                    "type" => "warning"
                ];
                echo json_encode($json);
                return;
            }
            $user = new User();
            if(!$user->validate($data["email"],$data["password"])){
                $json = [
                    "message" => $user->getMessage(),
                    "type" => "error"
                ];
                echo json_encode($json);
                return;
            }
            $json = [
                "name" => $user->getName(),
                "email" => $user->getEmail(),
                "message" => $user->getMessage(),
                "type" => "success"
            ];
            echo json_encode($json);
            return;
        }
        echo $this->view->render("entrar",["eventName" => CONF_SITE_NAME]);
    }
    public function error(array $data) : void{
//      echo "<h1>Erro {$data["errcode"]}</h1>";
//      include __DIR__ . "/../../themes/web/404.php";
        echo $this->view->render("404", [
            "title" => "Erro {$data["errcode"]} | " . CONF_SITE_NAME,
            "error" => $data["errcode"]
        ]);
    }
}