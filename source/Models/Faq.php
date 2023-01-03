<?php

namespace Source\Models;

use Source\Core\Connect;

class Faq{
    private $question;
    private $answer;

    public function __construct($question = null, $answer = null){
        $this->question = $question;
        $this->answer = $answer;
    }

    public function getQuestion(){
        return $this->question;
    }

    public function setQuestion($question): void{
        $this->question = $question;
    }

    public function getAnswer(){
        return $this->answer;
    }

    public function setAnswer($answer): void{
        $this->answer = $answer;
    }

    public function selectAll(){
        $query = "SELECT * FROM faqs";
        $stmt = Connect::getInstance()->prepare($query);
        $stmt->execute();

        if($stmt->rowCount() == 0){
            return false;
        } else {
            return $stmt->fetchAll();
        }
    }
}