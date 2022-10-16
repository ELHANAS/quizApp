<?php
session_start();
require_once "../conix.php";
require_once "../modules/formateur.php";
require_once "../modules/competence.php";
require_once "../modules/examen.php";
$user = unserialize($_SESSION["user"]);
$db = new Connection();
$pdo = $db->connect();
$comp_ce = $_GET["competence"];
$mod_le = $_GET["module"];
$fil_re = $_GET["filier"];
$message ="";
$style = "";
if(isset($_GET["message"])){
    $message = $_GET["message"];
    $style = $_GET["style"];
}

if(isset($_GET["valider"]) && isset($_GET["competence"])){
    if(!empty($_GET["libExamen"]) && !empty($_GET["datePass"])){
        $lib =  $_GET["libExamen"];
        $date =  $_GET["datePass"];
        $comp =  $_GET["competence"];
        $insert = $user->AjouterExamen($pdo,$comp,$lib,$date);
        if($insert){
            $examen = $user->getExamenParId($pdo,$insert);
        }
        if(!empty($_GET["Quest"])){
            $questions = $_GET["Quest"];
            $insertQ = $examen->AjouterQuestion($pdo,$questions);
            if($insertQ){
                header("location:Ajouter.php?style=bg-success text-white&message=Examen ajouté avec succès&filier=$fil_re&module=$mod_le&competence=$comp_ce");
            }else{
                header("location:Ajouter.php?style=bg-danger text-white&message=Error pour ajouté Questions&filier=$fil_re&module=$mod_le&competence=$comp_ce");
            } 
        }
        header("location:Ajouter.php?style=bg-success text-white&message=Examen ajouté avec succès&filier=$fil_re&module=$mod_le&competence=$comp_ce");
    }else{
        header("location:Ajouter.php?style=bg-danger text-white&message=toute les champ obligatoire&filier=$fil_re&module=$mod_le&competence=$comp_ce");
    }
}
require "header.html";
?>
<a href="gererExamen.php?&filier=<?php echo $fil_re ; 
        ?>&module=<?php echo $mod_le ; 
        ?>&competence=<?php echo $comp_ce ; ?>" class="btn btn-dark">Gérer Examen</a>
<div class=" w-50 container bg-info p-5 my-5 rounded">
    <?php echo "<h3 class='h3 text-center py-4 $style'>$message</h3>";?>
    <form action="">
        <input type="hidden" value="<?php echo $fil_re; ?>" name="filier">    
        <input type="hidden" value="<?php echo $mod_le; ?>" name="module">    
        <input type="hidden" value="<?php echo $comp_ce; ?>" name="competence">  
        <label for="" class="form-label">Titre de examen :</label>
        <input type="text" class="form-control" name="libExamen" placeholder="EXAMEN"><br>
        <label for="date" class="form-label">Date de Passastion :</label>
        <input type="date" class="form-control" name="datePass"><br>
        <div class="cont border">
            <table class="table table-striped">
                <tr>
                    <td>#</td>
                    <td>Questions</td>
                    <td>Choisir</td>
                </tr>
                <?php
                $competence = Competence::createObject($pdo,$comp_ce);
                $objetQue = $competence->getQuestion($pdo);
                foreach($objetQue  as $qst){
                ?>
                <tr onclick="clik(this)">
                    <td><?php echo $qst->id ?></td>
                    <td><?php echo $qst->lib ?></td>
                    <td><input value="<?php echo  $qst->id ;?>" class="form-check-input" type="checkbox" name="Quest[]"></td>
                </tr>
                <?php
                }
                ?>
            </table>
        </div>
        <button type="submit" name="valider" class="btn btn-dark mt-4">Ajouter</button>
    </form>
</div>


<script>
   
    function clik(e){
        var inp = e.lastElementChild.firstElementChild;
        if(inp.checked){
            inp.checked = false;
        }else{
            inp.checked = true;
        }
        
    }
</script>
<?php 
require "footer.html";
?>