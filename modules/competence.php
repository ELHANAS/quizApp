<?php
class Competence {
    private int $id;
    private int $idModule;
    private string $lib;
    public function __construct($id,$idModule,$lib)
    {
        $this->id = $id;
        $this->idModule = $idModule;
        $this->lib =$lib ;
    }
    public static function  createObject($db,$id){
        $comp = $db->query("SELECT * FROM competence where id = $id");
        $competence = $comp->fetch();
        return new self(
            $competence->id,
             $competence->idModule,
            $competence->lib
        );

    }
    #getters
    public function getId(){
        return $this->id ;
    }
    public function getIdModule(){
        return $this->idModule ;
    }
    public function getLibCompetence(){
        return $this->lib ;
    }
    #setters
    public function setId($var){
        $this->id = $var;
    }
    public function setIdModule($var){
        $this->iidModule = $var;
    }
    public function setgetLibCompetence($var){
        $this->lib = $var;
    }
    public function getQuestion($db){
        $question = $db->query("SELECT * from question where idCompetence = $this->id");
        $tableQuestion  = $question->fetchAll();
        return  $tableQuestion;
    }
}


?>