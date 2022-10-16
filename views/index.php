<?php
session_start();
require_once "../modules/stagiaire.php";
require_once "../modules/formateur.php";
$user =unserialize($_SESSION["user"]) ;
if(!isset($_SESSION["user"])){
  header("Location: ../authontification.php");
}

$type = null;
if ($user instanceof  Formateur) {
  $type = 'formateur';
} elseif ($user instanceof  Stagiaire) {
  $type = 'stagaire';
}
require "header.html";
?>
  <nav class="navbar navbar-expand-lg navbar-light bg-info">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">
          <?php
              echo $type;
          ?>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <img class="w-25" src="images/ofppt-logo-B2CAD4E136-seeklogo.com.png" alt="logo">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Accueil</a>
          </li>
          <?php if($user->type ="formateur"){   ?>
            <li class="nav-item">
            <a class="nav-link" href="gererExamen.php">Gérer Examen</a>
          </li>  
          <li class="nav-item">
            <a class="nav-link" href="listEvaluation.php">Évaluation</a>
          </li>  
          <?php }elseif($user->type == "stagiaire"){?>
          <li class="nav-item">
            <a class="nav-link" href="passerExamen.php">Passer Examen</a>
          </li>  
            <?php } ?>  
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="../router/logoutControl.php">Deconnecter</a>
          </li>
        </ul>    
      </div>
    </div>
  </nav>
<?php require "footer.html" ;?>