<?php

namespace Source\Models;

use Source\Core\Connect;

class User{
    private $id;
    private $name;
    private $email;
    private $password;
    private $document;
    private $message;
    private $photo;
    private $cpf;

    
    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    

    public function getCpf(): ?string{
        return $this->cpf;
    }

    public function setCpf(?string $cpf): void{
        $this->cpf = $cpf;
    }
    public function getPhoto(): ?string{
        return $this->photo;
    }

    public function setPhoto(?string $photo): void{
        $this->photo = $photo;
    }
    public function getMessage(){
        return $this->message;
    }
    
    public function getName(): ?string{
        return $this->name;
    }
    public function setName(?string $name): void{
        $this->name = $name;
    }
    public function getEmail(): ?string{
        return $this->email;
    }
    public function setEmail(?string $email): void{
        $this->email = $email;
    }
    public function getPassword(): ?string{
        return $this->password;
    }
    public function setPassword(?string $password): void{
        $this->password = $password;
    }
    public function getDocument(): ?string{
        return $this->document;
    }
    public function setDocument(?string $document): void{
        $this->document = $document;
    }
    public function __construct(
        int $id = NULL,
        string $name = NULL,
        string $email = NULL,
        string $password = NULL,
        string $photo = NULL,
        string $cpf = NULL
    ){
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->photo = $photo;
        $this->cpf = $cpf;
    }
    public function selectAll (){
        $query = "SELECT * FROM users";
        $stmt = Connect::getInstance()->prepare($query);
        $stmt->execute();
        if($stmt->rowCount() == 0){
            return false;
        } else {
            return $stmt->fetchAll();
        }
    }
    public function findById() : bool{
        $query = "SELECT * FROM users WHERE id = :id";
        $stmt = Connect::getInstance()->prepare($query);
        $stmt->bindParam(":id",$this->id);
        $stmt->execute();
        if($stmt->rowCount() == 0){
            return false;
        } else {
            $user = $stmt->fetch();
            $this->name = $user->name;
            $this->email = $user->email;
            return true;
        }
    }
    public function findByEmail(string $email) : bool{
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = Connect::getInstance()->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        if($stmt->rowCount() == 1){
            return true;
        } else {
            return false;
        }
    }
    public function validate (string $email, string $password) : bool{
        $query = "SELECT * FROM users WHERE email LIKE :email";
        $stmt = Connect::getInstance()->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        if($stmt->rowCount() == 0){
            $this->message = "Usuário ou senha não cadastrados!";
            return false;
        } else {
            $user = $stmt->fetch();
            if(!password_verify($password, $user->password)){
                $this->message = "Usuário ou senha não cadastrados!";
                return false;
            }
        }
        $this->id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->photo = $user->photo;
        $this->cpf = $user->cpf;
        $this->message = "Bem-vindo!";

        $arrayUser = [
            "id" => $this->id,
            "name" => $this->name,
            "email" => $this->email,
            "photo" => $this->photo,
            "cpf" => $this->cpf
        ];

        $_SESSION["user"] = $arrayUser;
        setcookie("user","Logado",time()+60*60*60,"/");
        return true;
    }
    public function insert() : bool{
        $query = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
        $stmt = Connect::getInstance()->prepare($query);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindValue(":password", password_hash($this->password,PASSWORD_DEFAULT));
        $stmt->execute();
        $this->message = "Usuário cadastrado!";
        return true;
    }

    public function update(){
        $query = "UPDATE users SET name = :name, email = :email, photo = :photo, cpf = :cpf WHERE id = :id";
        $stmt = Connect::getInstance()->prepare($query);
        $stmt->bindParam(":name",$this->name);
        $stmt->bindParam(":email",$this->email);
        $stmt->bindParam(":photo",$this->photo);
        $stmt->bindParam(":cpf",$this->cpf);
        $stmt->bindParam(":id",$this->id);
        $stmt->execute();
        $arrayUser = [
            "id" => $this->id,
            "name" => $this->name,
            "email" => $this->email,
            "photo" => $this->photo,
            "cpf" => $this->cpf
        ];
        $_SESSION["user"] = $arrayUser;
        $this->message = "Usuário alterado com sucesso!";
    }

    public function getJSON() : string{
        return json_encode(
            ["user" => [
                "id" => $this->getId(),
                "name" => $this->getName(),
                "email" => $this->getEmail()
            ]], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        );
    }

    public function getArray() : array
    {
        return ["user" => [
            "id" => $this->getId(),
            "name" => $this->getName(),
            "email" => $this->getEmail(),
            "document" => $this->getDocument(),
            "photo" => $this->getPhoto()
        ]];
    }
}