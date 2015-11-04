<?php 

session_start();

if (!isset($_SESSION['categ'])) { header("Location: index.php");  };

include("_connect.php");

//r�cup�re le club pass�e en param�tre
$idc = isset($_GET["idc"]) ? $_GET["idc"] : ""; 

//r�cup�re le club pass�e en param�tre
$iframe = isset($_GET["iframe"]) ? $_GET["iframe"] : "0"; 

//arret s'il manque la ligue 
if ($idc=="") { die('Id Club manquant'); };

$dep=$_SESSION['dep'];

//arret 
if ($dep=="") { header("Location: index.php");  };

?>

<!DOCTYPE html>
<html>
  <head>
    <meta content="text/html; charset=iso-8859-15" http-equiv="content-type">
    <title>Liste des joueurs du club</title>
    <meta content="FredJust" name="author">   
	<link rel="stylesheet" href="css/pv.css"  type="text/css">	
  </head>
 <body <?php if ($iframe==0) { ?> background="images/fond.png"; >

 <h1>Cr�ation d'une feuille de match dynamique</h1>
<a href="index.php">Choix du d�partement</a> > <?php echo $dep." ".$_SESSION['categ'] ?> > <a href="ListClubDep.php?dep=<?php echo $dep ?>">Choix du club</a> > Club <?php echo $idc ?> :
</br>
<?php } else { ?> > <?php } ?>

</br>
<a href="http://www.echecs.asso.fr/FicheClub.aspx?Ref=<?php echo $idc ?>" target='_blank'>Voir la Page FFE du club</a>
</br>
</br>
<table>

<tr>
<td>N�</td>
<td>Nom</td>
<td>Pr�nom</td>
<td>Cat</td>
<td>Elo</td>
<td>du 10/2015</td>
</tr>


<?php

if ($_SESSION['categ']=="Adultes") 
{
$query="SELECT * FROM joueur WHERE ClubRef='$idc' ORDER BY Elo DESC";	
};
if ($_SESSION['categ']=="Jeunes") {
	$query="SELECT * FROM joueur WHERE ClubRef='$idc' AND (NeLe>='2000-01-01') ORDER BY NeLe";	
};

$ressource=mysqli_query ($link,$query); 

$nbc=0;

while($row=mysqli_fetch_assoc ( $ressource )) {
$nbc++;
?>

<tr>
<td><?php echo $nbc?></td>
<td><?php echo ucwords(strtolower($row["Nom"]))?></td>
<td><?php echo $row["Prenom"]?></td>
<td><?php echo $row["Cat"]?></td>
<td><?php echo $row["Elo"]?></td>
<td align=right><?php echo $row["elo_s"]?></td>
</tr>
<?php 
};

mysqli_close ($link);
?>
</table>
</br>

 </body>
</html>

