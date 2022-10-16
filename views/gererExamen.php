<?php
session_start();
require_once "../conix.php";
require "../modules/formateur.php";
require "../modules/stagiaire.php";
$user = unserialize($_SESSION["user"]);
$db = new Connection();
$pdo = $db->connect();
$tabl = NULL;
$filieres = [];
$modules = [];
$competences = [];
$examen = [];
$message = "";
$style ="";
if(isset($_GET["message"])){
    $message = $_GET["message"];
    $style = $_GET["style"];
}

if(isset($_GET["competence"])){
    if(!empty($_GET["competence"])){
        $comp_ce = $_GET["competence"];
        $mod_le = $_GET["module"];
        $fil_re = $_GET["filier"];
        $examen = $user->getExamen($pdo,$comp_ce);
        $tabl = "<a class='btn btn-dark p-3 shadow '
         href='Ajouter.php?competence=$comp_ce&filier=$fil_re&module=$mod_le'>Ajouter</a>";
    }}
if(isset($_GET["idsuppr"])){
$id = $_GET["idsuppr"];
$supprimer = $user->suprExamen($pdo,$id);
if(!$supprimer){
    header("location:gererExamen.php?style=bg-danger&message=Vous ne pouvez pas supprimer cet examen&competence=$comp_ce&filier=$fil_re&module=$mod_le");
}else{
    header("location:gererExamen.php?style=bg-success&message=L'examen a été supprimé avec succès&competence=$comp_ce&filier=$fil_re&module=$mod_le");

}
}
if(isset($_GET["Modifier"])){
        $id = $_GET['idExamen'];
        $lib = $_GET["libExamen"];
        $date = $_GET["date"];
        $ex = $user->getExamenParId($pdo,$id);
        $ex->modifierExamen($pdo,$lib,$date);
}
$filieres = $user->getFilier($pdo);
require "header.html";

if(isset($_GET["filier"]) && !empty($_GET["filier"])){
    $fil = $_GET["filier"];
    $modules = $user->getModules($pdo,$fil);
}
if(isset($_GET["module"]) && !empty($_GET["module"])){
    $idM = $_GET["module"];
    $competences = $user->getCompetences($pdo,$idM);
}
?>
<a href="index.php" class="btn btn-dark">menu</a>
<div class="container bg-info p-5 my-5 rounded">
<?php echo "<h4 class='h4 $style text-white p-3 text-center'> $message</h4>"; ?>
    <form action="" method="get">
        <label for="filier">Filier</label>
        <select onchange="this.form.submit()" class="form-control mb-4"  name="filier" id="filier">
            <option value="" hidden>Choisir un filiere</option>
            <?php
            if(isset($_GET["filier"]) && !empty($_GET["filier"])){
                $idFiliere = $_GET["filier"];
                $f = $user->getFilierParId($pdo,$idFiliere);
                echo "<option value='$f->id' hidden selected>$f->lib</option>";
                
            }
            foreach($filieres as $filiere){
                echo "<option value='$filiere->id'>$filiere->lib</option>";
            }
            ?>
        </select><br>
        <label for="module">Module :</label>
        <select class="form-control mb-4" onchange="this.form.submit()" name="module" id="md">
            <option value="" hidden>Choisir un module</option>
            <?php
            if(isset($_GET["module"]) && !empty($_GET["module"])){
                $idModule = $_GET["module"];
                $mod = $user->getModuleParId($pdo,$idModule);
                echo "<option value='$mod->id' hidden selected>$mod->lib</option>";
            }
            foreach($modules as $module){
                echo "<option value='$module->id'>$module->lib</option>";
            }
            ?>
        </select><br>
        <label for="competence">Compètence</label>
        <select class="form-control mb-4" onchange="this.form.submit()"  name="competence" id="com">
            <option value="" hidden>Choisir un compétence</option>
                <?php
               if(isset($_GET["competence"]) && !empty($_GET["competence"])){
                $idCompetence = $_GET["competence"];
                $comp = $user->getCompetenceParId($pdo,$idCompetence);
                echo "<option value='$comp->id' hidden selected>$comp->lib</option>";
              }
            foreach($competences as $competence){
                echo "<option value='$competence->id'>$competence->lib</option>";
            }
                ?>
        </select>
    </form>
    <a class='btn btn-primary' href="gererExamen.php">réinitialiser</a>
</div>
<div>
    <?php echo $tabl ; ?>
    <table class="table table-dark table-striped table-hover">
            <tr>
                <td>#</td>
                <td>Examen</td>
                <td>compétence</td>
                <td>Date de passation</td>
                <td>date de creation</td>
                <td></td>
                <td></td>
            </tr>
            <?php
                foreach($examen as $ex){
            ?>
                <form action="" method="get">
                            <tr>
                                <td>
                                <input type="hidden" value="<?php echo $ex->id; ?>" name="idExamen">    
                                <input type="hidden" value="<?php echo $fil_re; ?>" name="filier">    
                                <input type="hidden" value="<?php echo $mod_le; ?>" name="module">    
                                <input type="hidden" value="<?php echo $comp_ce; ?>" name="competence">    
                                <?php echo  $ex->id ;?>
                                 </td>
                                <td>
                                    <input type="text" class="form-control bg-dark text-white" value=" <?php echo  $ex->libExamen ; ?>" name="libExamen">
                                   </td>
                                <td><?php echo  $ex->libCompetence ; ?></td>
                             <td >
                                <input type="date" class="form-control bg-dark text-white" value="<?php echo  $ex->datePassation ; ?>"  name="date">     
                            </td>
                            <td><?php echo  $ex->dateCreation ;?></td>
                            <td><button type="submit" name="Modifier" onclick="modifier(event)"  class='btn btn-info shadow'>Modifier</button></td>
                            <td><a class='btn btn-danger shadow' onclick="sprm(event)" 
                            href="gererExamen.php?idsuppr=<?php echo $ex->id ;
                             ?>&filier=<?php echo $fil_re ; 
                             ?>&module=<?php echo $comp_ce ; 
                             ?>&competence=<?php echo $fil_re ; ?>"
                              >Supprimer</a></td>
                            </tr>
                 </form>
            <?php  
                }
           ?>
    </table>
</div>

<script>
    function sprm(e){
            var conf=confirm("Voulez-vous supprimer cet examen !!");
            if(!conf){
                e.preventDefault();
            }
        }
        function modifier(e){
            var conf=confirm("Voulez-vous modifier cet examen !!");
            if(!conf){
                e.preventDefault();
            }
        }
</script>


<?php 
require "footer.html";
?>