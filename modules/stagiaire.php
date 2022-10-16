<?php
class Stagiaire
{
    public int $id;
    public string $id_groupe;
    public string $email;
    public string $password;
    public string $nom;
    public string $prenom;
    public string $type;
    public function __construct($id,$id_groupe,$email,$password,$nom,$prenom)
    {
        $this->id = $id;
        $this->id_groupe = $id_groupe;
        $this->email = $email;
        $this->password = $password;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->type = "stagiaire";
    }
    public static function login($db,$email,$password)
    {
        $pdoO = $db->query("SELECT * from STAGIAIRE 
        where EMAIL = '$email' and PASSWORD ='$password'");
              $pdor = $pdoO->fetchAll();
              if(count($pdor) != 0){
                  $pdo = $pdor[0];
             return new self(
                      $pdo->id,
                      $pdo->id_groupe,
                      $pdo->email,
                      $pdo->password,
                      $pdo->nom,
                      $pdo->prenom,

                  );
              }else{
                  return false;
              }
    }
    public function presonte(){
        return "CEF : ".$this->id ." __group :".$this->id_groupe." ;";
    }
}
