<?php
session_start();
require_once "../conix.php";
require_once "../modules/formateur.php";
require_once "../modules/examen.php";
require_once "../modules/Evaluation.php";
$user = unserialize($_SESSION["user"]);
$db = new Connection();
$pdo = $db->connect();

$evaluation = [];   
$examens = $user->getToutExamens($pdo);
foreach($examens as $examen){
   $ex = Examen::createObject($pdo,$examen->id);
   $evals = $ex->getEvaluation($pdo);
   foreach($evals as $eval){
        array_push($evaluation,$eval);
   }
}
require "header.html";
?>
<a href="index.php" class="btn btn-dark">menu</a>
<div class="container bg-info p-5 my-5 rounded">
    <h2 class="h2 text-center p-3">Evaluation</h2>
    <form action="">
            <input type="search" class="form-control" name="search" id="chercher" placeholder="chercher par ...">
    </form>
    <div  >
        <table data-bs-spy="scroll" style="height:200px;" data-bs-offset="10" class="table table-primary table-hover">
            <thead class="table-dark">
                <tr>
                    <td>#</td> 
                    <td>Date</td>
                    <td>Score</td>
                    <td>Nom de stagiaire</td>
                    <td>Examen</td>
                </tr>
    
            </thead>
            <tbody>
        <?php
            foreach($evaluation as $eval){
                ?>
                <tr>
                    <td><?php echo $eval->id ; ?></td>
                    <td><?php echo $eval->date ; ?></td>
                    <td><?php echo $eval->score ; ?></td>
                    <td><?php echo $eval->nom," ",$eval->prenom; ?></td>
                    <td><?php echo $eval->libExamen ; ?></td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</div>


<?php require "footer.html" ; ?>