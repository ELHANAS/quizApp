<?php
class Evaluation
{
    private int $id;
    private string $date;
    private int $score;
    private int $idStagiaire;
    private int $idExamen;
    public function __construct($id,$date,$score,$idStagiaire,$idExamen)
    {
        $this->id = $id;
        $this->date = $date;
        $this->score = $score;
        $this->idStagiaire = $idStagiaire;
        $this->idExamen = $idExamen;
    }
    #getters
    public function getId(){
        return $this->id;
    }
    public function getDate(){
        return $this->date;
    }
    public function getScore(){
        return $this->score;
    }
    public function getIdStagiaire(){
        return $this->idStagiaire;
    }
    public function getIdExamen(){
        return $this->idExamen;
    }
    #setters
    public function setId($var){
        $this->id = $var;
    }
    public function setDate($var){
        $this->date = $var;
    }
    public function setScore($var){
        $this->score = $var;
    }
    public function setIdStagiaire($var){
        $this->idStagiaire = $var;
    }
    public function setIdExamen($var){
        $this->idExamen = $var;
    }
#function createobject pour create un objet facil par un id
    public static function createObjet($db,$id){
        $eva = $db->query("SELECT * FROM evaluation WHERE id = $id");
        $tableEva = $eva->fetchAll();
        return new self(
            $tableEva->id,
            $tableEva->date,
            $tableEva->score,
            $tableEva->idStagiaire,
            $tableEva->idExamen
        );
    }
}
?>