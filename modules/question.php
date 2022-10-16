<?php
class Question{
    private int $id ;
    private int $idReponse ;
    private string $libQuestion ;
    public function __construct($id,$idReponse,$libQuestion){
        $this->id  = $id ;
        $this->idReponse = $idReponse ;
        $this->libQuestion = $libQuestion ;
    }
    #getters
    public function getId(){
        return $this->id;
    }
    public function getIdReponse(){
        return $this->idReponse;
    }
    public function getLibQuestion(){
        return $this->libQuestion;
    }
    #setters
    public function setId($var){
        $this->id = $var;
    }
    public function setIdReponse($var){
        $this->idReponse = $var;
    }
    public function setLibQuestion($var){
        $this->libQuestion = $var;
    }
}

?>