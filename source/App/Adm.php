<?php

namespace Source\App;

use League\Plates\Engine;
use Source\Models\User;
use Source\Models\Filme;
use CoffeeCode\Uploader\Image;

class Adm{
    private $view;

    public function __construct(){
        $this->view = new Engine(CONF_VIEW_ADMIN,'php');
    }

    public function home () : void{
        //echo $this->view->render("home");

        $filme = new Filme();
        $filmes = $filme->selectAll();

        echo $this->view->render(
            "home",["filmes" => $filmes]
        );
    }

    public function adcfilme(array $data) : void{
        if(!empty($data)){
            $data = filter_var_array($data,FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if(!empty($_FILES['foto']['tmp_name'])) {
                $upload = uploadImage($_FILES['foto']);
            } else {
                $upload = $_SESSION["filmes"]["foto"];
            }

            $filmes = new Filme(
                null,
                $data["nome"],
                $data["genero"],
                $data["ano"],
                $data["sinopse"],
                $upload
            );

            $filmes->insert();

            $json = [
                "message" => "",
                "type" => ""
            ];

            echo json_encode($json);
            return;
        }
        echo $this->view->render("adcfilme",["filmes" => CONF_SITE_NAME]);
    }

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

    public function list () : void 
    {
        require __DIR__ . "/../../themes/adm/list.php";
    }

    public function createPDF () : void{
       require __DIR__ . "/../../themes/adm/create-pdf.php";
    }
}