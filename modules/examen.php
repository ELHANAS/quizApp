<?php

class Examen{
    private int $id;
    private int $idCompetence;
    private string $libExamen;
    private string $dateCreation;
    private string $datePassation;
    private array $Question;
    public function  __construct($id,$idCompetence,$libExamen,$dateCreation,$datePassation)
    {
        $this->id = $id;
        $this->idCompetence = $idCompetence;
        $this->libExamen = $libExamen;
        $this->dateCreation = $dateCreation;
        $this->datePassation = $datePassation;
    }
    public static function createObject($db,$id){
        $ex = $db->query("SELECT * FROM examen where id = $id");
        $examen = $ex->fetch();
        return new self(
            $examen->id,
            $examen->idCompetence,
            $examen->lib,
            $examen->dateCreation,
            $examen->datePassation
        );
    }
    #getters
    public function getId(){
        return $this->id ;
    }
    public function getIdCompetence(){
        return $this->idCompetence ;
    }
    public function getLibExamen(){
        return $this->libExamen ;
    }
    public function getDateCreation(){
        return $this->dateCreation ;
    }
    public function getDatePassation(){
        return $this->datePassation ;
    }
    #setters
    public function setId($var){
        $this->id = $var; 
    }
    public function setIdCompetence($var){
        $this->idCompetence = $var; 
    }
    public function setLibExamen($var){
        $this->libExamen = $var; 
    }
    public function setDateCreation($var){
        $this->dateCreation = $var; 
    }
    public function setDatePassation($var){
        $this->datePassation = $var; 
    }
    public function getQuestionId($db,$id){
        $qst = $db->query("SELECT * FROM QUESTION where id = $id");
        $question = $qst->fetch();
        return $question ;
    }
    public function AjouterQuestion($db,$ques){
        try{
            foreach($ques as $qst){
                $db->exec("INSERT INTO `pour` (`idExamen`, `idQuestion`) VALUES ($this->id, $qst)");
            }
            return true;
        }catch(ErrorException){
            return false;
        }
    }
    public function getQuestion(){
        return $this->Question ;
    }
    public function modifierExamen($db,$lib,$date){
        try{
             $db->query("UPDATE `examen` SET `lib` = '$lib', 
            `datePassation` = '$date' WHERE (`id` = $this->id)");
         return true;
        }
        catch(ErrorException){
            return false;
        }
    }
    public function getEvaluation($db){
        $eva = $db->query("SELECT e.id db,s.nom ,s.prenom ,score,date,ev.id ,e.lib libExamen from evaluation ev
        inner join examen e
        on e.id =ev.idExamen
        inner join stagiaire s
        on s.id = ev.idStagiaire
        where e.id = $this->id");
        $tableEva = $eva->fetchAll();
        return $tableEva;
    }
}
?>