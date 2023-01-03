<?php

namespace Source\Models;

use Source\Core\Connect;

class Filme{
    private $id;
    private $nome;
    private $genero;
    private $ano;
    private $sinopse;
    private $foto;
    private $message;

    public function __construct(int $id = null, string $nome = null, string $genero = null, int $ano = null, string $sinopse = null, string $foto = NULL, string $message = null){
        $this->id = $id;
        $this->nome = $nome;
        $this->genero = $genero;
        $this->ano = $ano;
        $this->sinopse = $sinopse;
        $this->foto = $foto;
        $this->message = $message;
    }

    public function getId(): ?int{
        return $this->id;
    }
    public function setId(?int $id): void{
        $this->id = $id;
    }

    public function getNome(): ?string{
        return $this->nome;
    }
    public function setNome(?string $nome): void{
        $this->nome = $nome;
    }

    public function getGenero(): ?string{
        return $this->genero;
    }
    public function setGenero(?string $genero): void{
        $this->genero = $genero;
    }

    public function getAno(): ?int{
        return $this->ano;
    }
    public function setAno(?int $ano): void{
        $this->ano = $ano;
    }

    public function getSinopse(): ?string{
        return $this->sinopse;
    }
    public function setSinopse(?string $sinopse): void{
        $this->sinopse = $sinopse;
    }

    public function getFoto(): ?string{
        return $this->foto;
    }

    public function setFoto(?string $foto): void{
        $this->foto = $foto;
    }

    public function getMessage(): ?string{
        return $this->message;
    }
    public function setMessage(?string $message): void{
        $this->message = $message;
    }

    public function selectAll(){
        $query = "SELECT * FROM filmes";
        $stmt = Connect::getInstance()->prepare($query);
        $stmt->execute();

        if($stmt->rowCount() == 0){
            return false;
        } else {
            return $stmt->fetchAll();
        }
    }

    public function findById() : bool{
        $query = "SELECT * FROM filmes WHERE id = :id";
        $stmt = Connect::getInstance()->prepare($query);
        $stmt->bindParam(":id",$this->id);
        $stmt->execute();
        if($stmt->rowCount() == 0){
            return false;
        } else {
            $filmes = $stmt->fetch();
            $this->nome = $filmes->nome;
            $this->genero = $filmes->genero;
            $this->ano = $filmes->ano;
            $this->sinopse = $filmes->sinopse;
            return true;
        }
    }

    public function findFilmId() : bool
    {
        $query = "SELECT * FROM flmes WHERE id = :id";
        $stmt = Connect::getInstance()->prepare($query);
        $stmt->bindParam(":id",$this->id);
        $stmt->execute();

        if($stmt->rowCount() == 0){
            return false;
        } else {
            $task = $stmt->fetch();
            $this->text = $task->text;
            return true;
        }
    }

    public function insert() : bool
    {
        $query = "INSERT INTO filmes (id, nome, genero, ano, sinopse, foto) VALUES (NULL, :nome, :genero, :ano, :sinopse, :foto)";
        // var_dump($query, $this->genero);
        $stmt = Connect::getInstance()->prepare($query);
        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":genero", $this->genero);
        $stmt->bindValue(":ano", $this->ano);
        $stmt->bindValue(":sinopse", $this->sinopse);
        $stmt->bindValue(":foto", $this->foto);
        $stmt->execute();
        $this->id = Connect::getInstance()->lastInsertId();
        $this->message = "Filme cadastrado!";
        return true;
    }
/*
    public function update(){
        $query = "UPDATE filmes SET nome = :nome, genero = :genero, ano = :ano, sinopse = :sinopse, foto = :foto WHERE id = :id";
        $stmt = Connect::getInstance()->prepare($query);
        $stmt->bindParam(":nome",$this->nome);
        $stmt->bindParam(":genero",$this->genero);
        $stmt->bindParam(":ano",$this->ano);
        $stmt->bindParam(":sinopse",$this->sinopse);
        $stmt->bindParam(":foto",$this->foto);
        $stmt->bindParam(":id",$this->id);
        $stmt->execute();
        $arrayFilmes = [
            "id" => $this->id,
            "nome" => $this->nome,
            "genero" => $this->genero,
            "ano" => $this->ano,
            "sinopse" => $this->sinopse,
            "foto" => $this->foto
        ];
        $_SESSION["filmes"] = $arrayFilmes;
        $this->message = "Filme alterado com sucesso!";
    }
*/
    public function getJSON() : string{
        return json_encode(
            ["filmes" => [
                "id" => $this->getId(),
                "nome" => $this->getNome(),
                "genero" => $this->getGenero(),
                "ano" => $this->getAno(),
                "sinopse" => $this->getSinopse()
            ]], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        );
    }

    public function getArray() : array
    {
        return ["filmes" => [
            "id" => $this->getId(),
            "nome" => $this->getNome(),
            "genero" => $this->getGenero(),
            "ano" => $this->getAno(),
            "sinopse" => $this->getSinopse()
        ]];
    }

    public function findByidUser(int $idUser){
        $query = "SELECT * FROM filmes WHERE idUser = :idUser";
        $stmt = Connect::getInstance()->prepare($query);
        $stmt->bindParam(":idUser", $idUser);
        $stmt->execute();

        if($stmt->rowCount() == 0){
            return false;
        } else {
            return $stmt->fetchAll();
        }
    }
}