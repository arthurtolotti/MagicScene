<?php
namespace Source\App;
use Source\Models\User;
use Source\Models\Filme;

class Api{

   
    public function __construct()
    {
        header('Content-Type: application/json; charset=UTF-8');
        $headers = getallheaders();
        if(empty($headers["Email"]) || empty($headers["Password"])){
            $response = [
                "code" => 400,
                "type" => "bad_request",
                "message" => "Informe E-mail, Senha e Tipo de Usuário para acessar"
            ];
            echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            return;
        }

        $this->user = new User();
        $this->filme = new Filme();
        if(!$this->user->validate($headers["Email"],$headers["Password"])){
            $response = [
                "code" => 401,
                "type" => "unauthorized",
                "message" => "E-mail ou Senha inválidos"
            ];
            echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            return;
        }
    }

  
 public function getUser(){
          // Só mostra quando encontrar
          if($this->user->getId() != null){
            echo json_encode($this->user->getArray(),JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }
 }

 public function createUser(array $data)
  {

      if($this->user->findByEmail($data["email"])){
          $response = [
              "code" => 400,
              "type" => "bad_request",
              "message" => "E-mail já cadastrado"
          ];
          echo json_encode($response,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
          return;
      }

      $this->user->setName($data["name"]);
      $this->user->setEmail($data["email"]);
      $this->user->setPassword($data["password"]);
      $this->user->insert();
      $response = [
          "code" => 200,
          "type" => "success",
          "message" => "Usuário cadastrado com sucesso"
      ];
      echo json_encode($response,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
  }

  public function updateUser(array $data) : void
    {
        if($this->user->getId() != null){
            $this->user->setName($data["name"]);
            $this->user->setEmail($data["email"]);
            $this->user->setDocument($data["document"]);
            $this->user->update();
            $response = [
                "code" => 200,
                "type" => "success",
                "message" => "Usuário alterado com sucesso!"
            ];
            echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }
    }

}