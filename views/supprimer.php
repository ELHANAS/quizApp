<?php
session_start();
require_once "../conix.php";
require "../modules/formateur.php";
require "../modules/stagiaire.php";
$db = new Connection();
$pdo = $db->connect();
$id = $_GET["id"];
$user =unserialize($_SESSION["user"]) ;
$user->suprExamen($pdo,$id);
header("location:gererExamen.php");

?>