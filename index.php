<?php 

session_start();

if (isset($_GET["categ"])) {
	$categ = $_GET["categ"];
	$_SESSION['categ']=$categ;
}

if (!isset($_SESSION['categ'])) {
	$categ = "Adultes"; 	
	$_SESSION['categ']= "Adultes"; 	
}



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="content-type" content="application/xhtml+xml; charset=utf-8" />
	<meta content="FredJust" name="author">    
    <title>Feuille de match dynamique</title>
    <link type="text/css" rel="stylesheet" media="screen" href="css/jqvmap.css" />
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script type="text/javascript" src="js/jquery.vmap.js"></script>
    <script type="text/javascript" src="js/jquery.vmap.france.js"></script>
    <script type="text/javascript" src="js/jquery.vmap.colorsFrance.js"></script>
    <script type="text/javascript">
	$(document).ready(function() {
		$('#francemap').vectorMap({
		    map: 'france_fr',
			hoverOpacity: 0.5,
			hoverColor: false,
			backgroundColor: "#ffffff",
			colors: couleurs,
			borderColor: "#000000",
			selectedColor: "#EC0000",
			enableZoom: true,
			showTooltip: true,
		    onRegionClick: function(element, code, region)
		    {
		        var message = 'ListClubDep.php?dep='
		            + code;
             
		        document.location.href=message;
		    }
		});
	});
	</script>
  </head>
 <body background="images/fond.png";>
    <h1>Création d'une feuille de match dynamique</h1>
	Pour les  <?php echo $_SESSION['categ']?> (
	<a href="index.php?categ=Adultes" TITLE="Remplir une feuille Adultes">Adultes</a> / 
	<a href="index.php?categ=Jeunes" TITLE="Remplir une feuille Jeunes">Jeunes</a> / 
	<a href="index.php?categ=Criterium" TITLE="Remplir une feuille Criterium">Criterium</a>
	)
	</br>
    Choix du département :  <br />
	<table>
	<tr>
	<td>
    <div style="width: 700px; height: 600px;" id="francemap"></div>
	</td>
	<td>
	Aide :
	</td>
	</tr>
	</table>
    <a href="ListClubDep.php?Dep=99"><i>Papeete et Nouméa</i></a> <br />
    Date du fichier papi utilisé : 30/10/2015 (les joueurs non licenciés à cette
    date ne sont pas affichables)<br />
    <a href="historique.html"><i>Version 2.5 &beta; du 24/10/2015</i></a><br />
  </body>
</html>
