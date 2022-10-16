<?php
require "examen.php";
class Formateur
{
    private string $nom;
    private string $prenom;
    private int $id;
    private string $email;
    private string $password;
    private array $Examen;
    private array $filieres ;
    public function __construct($id,$prenom,$nom,$email,$password)
    {
        $this->id = $id;
        $this->prenom = $prenom;
        $this->nom = $nom;
        $this->email = $email;
        $this->password = $password;
    }
    #getters
    public function getNom(){
        return $this->nom;
    }
    public function getPrenom(){
        return $this->prenom;
    }
    public function getId(){
        return $this->id;
    }
    public function getPassword(){
        return $this->password;
    }
    public function getEmail(){
        return $this->email;
    }
    #setters
    public function setNom($var){
        $this->nom = $var ;
    }
    public function setPrenom($var){
        $this->prenom = $var ;
    }
    public function setEmail($var){
        $this->email = $var ;
    }
    public function setPassword($var){
        $this->password = $var ;
    }
    public static function login($db,$email,$password)
    {
        try {
            $query = "SELECT * FROM `FORMATEUR` WHERE `email` = ? ";
            $pdoS = $db->prepare($query);

            $pdoS->execute([
                $email
            ]);


            if ($pdoS->rowCount() > 0) {
                $formateur_row = $pdoS->fetch();

                if ($formateur_row->password == $password) {
                    return new self(
                        $formateur_row->id,
                        $formateur_row->prenom,
                        $formateur_row->nom,
                        $formateur_row->email,
                        $formateur_row->password
                    );
                }
            }
            return false;
        } catch (\Throwable $th) {
            return false;
        }
        
        }
        public function presonte(){
                return "formateur  ".$this->nom ."  ".$this->prenom." ;";
        }
        public function getFilier($db){
                $fil = $db->query("SELECT * FROM filiere fl 
            where fl.id in (SELECT  FF.idFiliere 
            FROM formateur_filiere FF
            WHERE FF.idFormateur = $this->id)");
            $filiere = $fil->fetchALL();
            return $filiere;
        }

        public function getModules($db,$filier){
            $module = $db->query("SELECT f.id db,fr.id codFiliere,m.id,m.lib FROM formateur f
                inner join module_assurer a
                on f.id = a.idFormateur
                inner join module m
                on m.id = a.idModule
                inner join groupe gr
                on gr.id = a.idGroup
                inner join filiere fr
                on fr.id = gr.idFiliere
                group by m.id
                HAVING  fr.id = $filier AND f.id = $this->id");
            $tablModul = $module->fetchAll();
            return $tablModul;
        }
        public function getFilierParId($db,$id){
            $FL = $db->query("SELECT * FROM FILIERE where id = $id ");
            $fil = $FL->fetch();
            return $fil ;
        }
        public function getModuleParId($db,$id){
            $md = $db->query("SELECT * FROM MODULE where id =$id");
            $mod = $md->fetch();
            return $mod ;
        }
        public function getCompetenceParId($db,$id){
        $comp = $db->query("SELECT * FROM COMPETENCE where id = $id");
        $competence = $comp->fetch();
        return $competence;
        }

        public function getCompetences($db,$MODUL){
            $comp = $db->query("SELECT F.id db,M.id codModule,C.id,c.lib from competence C
                inner join module M
                on C.idModule = M.id
                inner join module_assurer a
                on a.idModule = M.id
                inner join formateur F
                on F.id = a.idFormateur
                group by C.id
                having M.id  = $MODUL and F.id = $this->id ");
            $competences = $comp->fetchAll();
            return $competences;
        }
        public function ModifierDatePassation($db,$date,$id){
            $dt = $db->query("UPDATE `EXAMEN` SET `datePassation` = '$date' WHERE (`id` = '$id')");
            return $dt;
        }
        public function getExamen($db,$comp){
            $exam = $db->query("SELECT f.id idFor,ex.id,c.id idComp,ex.lib libExamen ,c.lib libCompetence,dateCreation,datePassation FROM FORMATEUR f
                                    inner join module_assurer a
                                    on f.id = a.idFormateur
                                    inner join module m
                                    on m.id = a.idModule
                                    inner join competence  c
                                    on c.idModule = m.id
                                    inner join examen ex
                                    on ex.idCompetence = c.id
                                    inner join groupe gr
                                    on gr.id = a.idGroup
                                    inner join filiere fr
                                    on fr.id = gr.idFiliere
                                    GROUP BY ex.id
                                    having f.id = $this->id and c.id = $comp") ;
            $examen = $exam->fetchAll();
            return  $examen;
        }
        public function getToutExamens($db){
            $exam = $db->query("SELECT f.id idFor,ex.id,c.id idComp,ex.lib libExamen ,c.lib libCompetence,dateCreation,datePassation FROM FORMATEUR f
                                    inner join module_assurer a
                                    on f.id = a.idFormateur
                                    inner join module m
                                    on m.id = a.idModule
                                    inner join competence  c
                                    on c.idModule = m.id
                                    inner join examen ex
                                    on ex.idCompetence = c.id
                                    inner join groupe gr
                                    on gr.id = a.idGroup
                                    inner join filiere fr
                                    on fr.id = gr.idFiliere
                                    GROUP BY ex.id
                                    having f.id = $this->id") ;
            $examen = $exam->fetchAll();
            return  $examen;
        }
        public function suprExamen($db,$id){
            try{
                $db->exec("DELETE from examen  where id=$id");
                return true;
            }catch(ErrorException){
                return false;
            }
        }
        public function AjouterExamen($db,$comp,$lib,$date){
            try{
                $id = $db->query("SELECT max(id) maxId FROM examen ");
                $max = $id->fetch()->maxId + 1;
                $db->query("INSERT INTO `examen` (`id`, `idCompetence`, `lib`, `dateCreation`, `datePassation`) 
                   VALUES ('$max', '$comp', '$lib',now(),'$date')");
             return $max;
            }catch(ErrorException ){
                    return false;
            }
        }
        public function getExamenParId($db,$id){
            $ex = $db->query("SELECT * FROM examen where id = $id");
            $exam = $ex->fetch();
            $Ex = new Examen($exam->id,$exam->idCompetence,$exam->lib,$exam->dateCreation,$exam->datePassation);
            return $Ex;      
        }
}
?>
