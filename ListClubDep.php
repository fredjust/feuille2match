<?php 

session_start();

//récupère les club de la ligue passée en paramètre
$dep = isset($_GET["dep"]) ? $_GET["dep"] : ""; 

//arret s'il manque la ligue 
if ($dep=="") { die('Département manquant'); };

include("_connect.php");

$_SESSION['dep']=$dep;

if (!isset($_SESSION['nom1'])) {
	$_SESSION['nom1']='';
}
if (!isset($_SESSION['nom2'])) {
	$_SESSION['nom2']='';
}

$sup8 = isset($_REQUEST["all"]) ? $_REQUEST["all"] : '1';

if ($sup8=='0') {	
	$sup8='AND nba>8'; }
else {
	$sup8=''; }

?>

<!DOCTYPE html>
<html>
  <head>
    <meta content="text/html; charset=iso-8859-15" http-equiv="content-type">
    <title>Liste des clubs du département</title>
    <meta content="FredJust" name="author">    
	<link rel="stylesheet" href="css/pv.css"  type="text/css">
  </head>
 <body background="images/fond.png";>

<h1>Création d'une feuille de match dynamique</h1>
<a href="index.php">Choix du département</a> > <?php echo $dep." ".$_SESSION['categ'] ?> > <a href="effaceclub.php?dep=<?php echo $dep ?>" TITLE="Effacer ces clubs">Choix des clubs</a> : 
 <?php if ($_SESSION['nom1']!="") { echo ("<a href=\"effaceclub.php?dep=$dep\" TITLE=\"Effacer les clubs\">".$_SESSION['nom1']."</a>"); ?> <img src="images/rb25.gif"><?php } ?>   
  <?php if ($_SESSION['nom2']!="") { ?> <img src="images/rn25.gif"> <?php echo("<a href=\"effaceclub.php?dep=$dep\" TITLE=\"Effacer les clubs\">".$_SESSION['nom2']."</a>");} ?>  </br></br>

  <br>
  
<table>
	<tr>
	<td width=50% valign=top>
  
	<table>
	<?php

	$query="SELECT * FROM club WHERE dep='$dep' $sup8 ORDER BY Commune";
	$ressource=mysqli_query ($link,$query); 

	$nbc=0;
	while($row=mysqli_fetch_assoc( $ressource )) {

	$nbc++;
	?>
	<tr>
	<td><?php echo $nbc?></td>
	<td><?php echo ucwords(strtolower($row["Commune"]))?></td>
	<td align="center"><A href=<?php echo $_SESSION['categ']?>.php?c1=<?php echo $row["Ref"]?> TITLE="<?php echo $row["Nom"]?> a les blancs"><img src="images/rb25.gif"></a>
	<?php echo $row["Nom"]?> <A href=<?php echo $_SESSION['categ']?>.php?c2=<?php echo $row["Ref"]?>  TITLE="<?php echo $row["Nom"]?> a les noirs"><img src="images/rn25.gif"></a></td>
	<td><a href=ListJoueur.php?idc=<?php echo $row["Ref"]?>&iframe=1 target="lstjou" TITLE="Liste des joueurs <?php if ($_SESSION['categ']=="Jeunes") {echo 'jeunes';}; ?> - <?php echo $row["Nom"]?>"><img src="images/joueur2.gif">
	(<?php echo $row["nba"]?> / <?php echo $row["nbj"]?>)
	</td>
	</tr>

	<?php
	};
	mysqli_close ($link);
	?> 
	</table>
</td>
	<td width=50% valign=top>
	<iframe name="lstjou" width=700 height=600 frameborder=0>
	</iframe>
</td>
</tr>
</table>
</br>
<i>Si votre club a les blancs cliquez sur <img src="images/rb25.gif">, s'il a les noirs cliquez sur <img src="images/rn25.gif"><br>
Cliqez sur <img src="images/joueur2.gif"> pour obtenir la liste des joueurs <?php if ($_SESSION['categ']=="Jeunes") {echo 'jeunes';}; ?> du club</i>
<br><br>
<?php if ($sup8=='') { ?>
<a href="ListClubDep.php?dep=<?php echo $dep ?>&all=0">Masquer les clubs ayant moins de 8 joueurs</a>
<?php } else {  ?>
<a href="ListClubDep.php?dep=<?php echo $dep ?>&all=1">Afficher tous les clubs</a>
<?php }  ?>
  </body>
</html>



