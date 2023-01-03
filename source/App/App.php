<?php

namespace Source\App;

use League\Plates\Engine;
use Source\Models\User;
use Source\Models\Filme;
use CoffeeCode\Uploader\Image;

class App{
    private $view;

    public function __construct(){
        if(empty($_SESSION["user"]) || empty($_COOKIE["user"])){
            header("Location:http://www.localhost/films/");
        }
        $this->view = new Engine(CONF_VIEW_APP,'php');
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
/*
    public function upfilme(array $data) : void{
        if(!empty($data)){
            $data = filter_var_array($data,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if(in_array("",$data)){
                $json = [
                    "message" => "Preencha todos os campos!.",
                    "type" => "alert-danger"
                ];
                echo json_encode($json);
                return;
            }
            if(!empty($_FILES['foto']['tmp_name'])) {
                $upload = uploadImage($_FILES['foto']);
            } else {
                $upload = $_SESSION["filmes"]["foto"];
            }

            $filmes = new Filme(
                $_SESSION["filmes"]["id"],
                $data["nome"],
                $data["genero"],
                $data["ano"],
                $data["sinopse"],
                $upload
            );
            $filmes->update();
            $json = [
                "message" => $filmes->getMessage(),
                "type" => "alert-success",
                "nome" => $filmes->getNome(),
                "genero" => $filmes->getGenero(),
                "ano" => $filmes->getAno(),
                "sinopse" => $filmes->getSinopse(),
                "foto" => url($filmes->getFoto())
            ];
            echo json_encode($json);
        }
    }
*/
    
    public function perfil(array $data) : void
    {
        echo $this->view->render("perfil",
            [
                "user" => $_SESSION["user"]
            ]);

    }

    public function profileUpdate(array $data) : void
    {
        if(!empty($data)){
            $data = filter_var_array($data,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if(in_array("",$data)){
                $json = [
                    "message" => "Preencha todos os campos!.",
                    "type" => "alert-danger"
                ];
                echo json_encode($json);
                return;
            }
            if(!is_email($data["email"])){
                $json = [
                    "message" => "Informe um e-mail válido...",
                    "type" => "alert-danger"
                ];
                echo json_encode($json);
                return;
            }
            if(!empty($_FILES['photo']['tmp_name'])) {
                $upload = uploadImage($_FILES['photo']);
                //unlink($_SESSION["user"]["photo"]);
            } else {
                $upload = $_SESSION["user"]["photo"];
            }

            $user = new User(
                $_SESSION["user"]["id"],
                $data["name"],
                $data["email"],
                null,
                $upload,
                $data["cpf"]
            );
            $user->update();
            $json = [
                "message" => $user->getMessage(),
                "type" => "alert-success",
                "name" => $user->getName(),
                "email" => $user->getEmail(),
                "photo" => url($user->getPhoto()),
                "cpf" => $user->getCpf()
            ];
            echo json_encode($json);
        }
    }

    public function logout(){
        session_destroy();
        setcookie("user","Logado",time() - 3600,"/");
        header("Location:http://www.localhost/films/");
    }
}
?>