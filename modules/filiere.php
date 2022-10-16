<?php
class Filiere{
    private int $id;
    private string $libFiliere;
    public function __construct($id,$libFiliere)
    {
        $this->id = $id;
        $this->libFiliere = $libFiliere;
    }
    #getters
    public function getId(){
        return $this->id ;
    }
    public function getLibFilier(){
        return $this->libFiliere ;
    }
    #setters
    public function setId($var){
        $this->id = $var;
    }
    public function setLibFilier($var){
        $this->LibFiliere = $var;
    }
}
?>