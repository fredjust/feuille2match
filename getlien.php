<?

session_start();

// Recuperation des ID 
$blanc_id[1] = isset($_REQUEST["joueur1_id"]) ? $_REQUEST["joueur1_id"] : 0;
$blanc_id[2] = isset($_REQUEST["joueur2_id"]) ? $_REQUEST["joueur2_id"] : 0;
$blanc_id[3] = isset($_REQUEST["joueur3_id"]) ? $_REQUEST["joueur3_id"] : 0;
$blanc_id[4] = isset($_REQUEST["joueur4_id"]) ? $_REQUEST["joueur4_id"] : 0;
$blanc_id[5] = isset($_REQUEST["joueur5_id"]) ? $_REQUEST["joueur5_id"] : 0;
$blanc_id[6] = isset($_REQUEST["joueur6_id"]) ? $_REQUEST["joueur6_id"] : 0;
$blanc_id[7] = isset($_REQUEST["joueur7_id"]) ? $_REQUEST["joueur7_id"] : 0;
$blanc_id[8] = isset($_REQUEST["joueur8_id"]) ? $_REQUEST["joueur8_id"] : 0;

$noir_id[1] = isset($_REQUEST["noir1_id"]) ? $_REQUEST["noir1_id"] : 0;
$noir_id[2] = isset($_REQUEST["noir2_id"]) ? $_REQUEST["noir2_id"] : 0;
$noir_id[3] = isset($_REQUEST["noir3_id"]) ? $_REQUEST["noir3_id"] : 0;
$noir_id[4] = isset($_REQUEST["noir4_id"]) ? $_REQUEST["noir4_id"] : 0;
$noir_id[5] = isset($_REQUEST["noir5_id"]) ? $_REQUEST["noir5_id"] : 0;
$noir_id[6] = isset($_REQUEST["noir6_id"]) ? $_REQUEST["noir6_id"] : 0;
$noir_id[7] = isset($_REQUEST["noir7_id"]) ? $_REQUEST["noir7_id"] : 0;
$noir_id[8] = isset($_REQUEST["noir8_id"]) ? $_REQUEST["noir8_id"] : 0;

$c1 = isset($_REQUEST["c1"]) ? $_REQUEST["c1"] : 0;
$c2 = isset($_REQUEST["c2"]) ? $_REQUEST["c2"] : 0;

$numronde = isset($_REQUEST["numronde"]) ? $_REQUEST["numronde"] : 0;

$params="?nbj=#NBJ#";

$params.="&c1=$c1&c2=$c2";

if ($numronde!=0) { $params.="&rd=".$numronde; };

$nbj=0;

for ($i=1; $i<=8; $i++) 
{
	if ($blanc_id[$i]!=0)
	{
		$params.="&b$i=".$blanc_id[$i];
		$nbj=$i;
	}
	
	if ($noir_id[$i]!=0)
	{
		$params.="&n$i=".$noir_id[$i];
		$nbj=max($i,$nbj);
	}
}

$params=str_replace('#NBJ#',$nbj,$params);
?>
<h1>Création d'une feuille de match dynamique</h1>
<a href="index.php">Choix du département</a> > lien de la feuille
<br>
<br>

ATTENTION la feuille n'est pas sauvegardée sur le serveur !<br>
Si vous souhaitez la retrouver, vous devez conserver ce lien (ou même l'envoyer).<br>
Il permet d'afficher une feuille de match contenant les infos des joueurs sélectionnés.<br>
<br>
<input onClick="select();" type="text" value="http://www.echecs95.com/feuille2match/<?php echo $_SESSION['cat']?>.php<?=$params?>" style="width:500px;"/> 
 <A href="http://www.echecs95.com/feuille2match/<?php echo $_SESSION['cat']?>.php<?=$params?>"> Tester ce lien</a>
<br>
<br>
<i>Vous pouvez copier le texte en cliquant dans la zone puis CTRL+C</i>
<hr>

