<?php
require_once "../conix.php";
require "../Controller/loginControl.php";
require "../modules/formateur.php";
require "../modules/stagiaire.php";

if(!empty($_POST["email"]) && !empty($_POST["password"]) && !empty($_POST["type"])){
    $email = $_POST["email"];
    $password = $_POST["password"];
    $type = $_POST["type"];
    $lg = new login();
    $user = $lg->store($email,$password,$type);

}
if(empty($_POST["email"]) || empty($_POST["password"]) || empty($_POST["type"])){
    header("location:../authontification.php?message=toutes les champs est obligatoire");
}

?>