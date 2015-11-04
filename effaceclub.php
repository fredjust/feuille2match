<?php

session_start();

//récupère les club de la ligue passée en paramètre
$dep = isset($_GET["dep"]) ? $_GET["dep"] : ""; 

//arret s'il manque la ligue 
if ($dep=="") { die('Département manquant'); };

$_SESSION['club1'] = 0;
$_SESSION['club2'] = 0;
$_SESSION['nom1'] = "";
$_SESSION['nom2'] = "";

header("Location: ListClubDep.php?dep=$dep");      

?>