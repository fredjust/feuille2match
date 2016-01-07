<?php
// ****************************************************************************
// REALISER PAR JUST FRED pour le CVOE FredJust@gmail.com 
// ****************************************************************************
// permet de créer une feuille de match rapidement
// fonctionnalités 
// - autocompletion : propose les noms/prénoms commencant aux premières lettres saisies
// - affiche automatiquement le numéro FFE et le Elo à jour
// - nombre de ligne variable pour des équipes de 4 à 8 joueurs
// - recherche sur un club blanc et/ou un club noir
// - affiche par defaut la date du dimanche suivant

session_start();

$_SESSION['categ']= "Adultes"; 	

// ****************************************************************************
// LA FEUILLE EST ELLE PRE REMPLIE
// ****************************************************************************
// Recuperation des ID blancs
$blanc_id[1] = isset($_REQUEST["b1"]) ? $_REQUEST["b1"] : 0;
$blanc_id[2] = isset($_REQUEST["b2"]) ? $_REQUEST["b2"] : 0;
$blanc_id[3] = isset($_REQUEST["b3"]) ? $_REQUEST["b3"] : 0;
$blanc_id[4] = isset($_REQUEST["b4"]) ? $_REQUEST["b4"] : 0;
$blanc_id[5] = isset($_REQUEST["b5"]) ? $_REQUEST["b5"] : 0;
$blanc_id[6] = isset($_REQUEST["b6"]) ? $_REQUEST["b6"] : 0;
$blanc_id[7] = isset($_REQUEST["b7"]) ? $_REQUEST["b7"] : 0;
$blanc_id[8] = isset($_REQUEST["b8"]) ? $_REQUEST["b8"] : 0;

// Recuperation des ID noirs
$noir_id[1] = isset($_REQUEST["n1"]) ? $_REQUEST["n1"] : 0;
$noir_id[2] = isset($_REQUEST["n2"]) ? $_REQUEST["n2"] : 0;
$noir_id[3] = isset($_REQUEST["n3"]) ? $_REQUEST["n3"] : 0;
$noir_id[4] = isset($_REQUEST["n4"]) ? $_REQUEST["n4"] : 0;
$noir_id[5] = isset($_REQUEST["n5"]) ? $_REQUEST["n5"] : 0;
$noir_id[6] = isset($_REQUEST["n6"]) ? $_REQUEST["n6"] : 0;
$noir_id[7] = isset($_REQUEST["n7"]) ? $_REQUEST["n7"] : 0;
$noir_id[8] = isset($_REQUEST["n8"]) ? $_REQUEST["n8"] : 0;

// Recuperation des ID clubs
// en variable de session
$c1 = isset($_SESSION['club1']) ? $_SESSION["club1"] : 0;
$c2 = isset($_SESSION['club2']) ? $_SESSION["club2"] : 0;
//ou en parametre URL
$c1 = isset($_GET["c1"]) ? $_GET["c1"] : $c1;
$c2 = isset($_GET["c2"]) ? $_GET["c2"] : $c2;

// Recuperation du nombre de ronde
$numronde = isset($_REQUEST["rd"]) ? $_REQUEST["rd"] : "";
// Recuperation du nombre de joueur
$nbj = isset($_GET["nbj"]) ? $_GET["nbj"] : 8; 		

// connexion pour récupérer les infos a partir des id s'ils sont passés en paramètre
include("_connect.php");

// pour alterner les lettre B et N suivant les lignes
$couleur[0]="N";
$couleur[1]="B";

// passage de l'id des club en paramètre du traitement s'il existe 
// pour restreindre la recherche aux seuls joueurs de ce club
if (($c1==0)&&($c2==0))
{
	die('Id Club manquant');
}

//pour stocker le nom des clubs
$NomBlanc="";
$NomNoir="";

//le club1 est connu
if ($c1>0)
{	
	$_SESSION['club1'] = $c1;
	$parametre="?c1=$c1";
	$query ="SELECT Nom FROM club WHERE Ref='$c1'";
	$ressource=mysqli_query ($link,$query);
	$row=mysqli_fetch_assoc ( $ressource );
	//on stocke le nom
	$NomBlanc=$row["Nom"];
	$_SESSION['nom1'] = $NomBlanc;	
};

//le club2 est connu
if ($c2>0)
{
	$_SESSION['club2'] = $c2;
	if ($c1==0) {$parametre="?c2=$c2";} else {$parametre.="&c2=$c2";};
	$query ="SELECT Nom FROM club WHERE Ref='$c2'";
	$ressource=mysqli_query ($link,$query);
	$row=mysqli_fetch_assoc ( $ressource );
	//on stocke le nom
	$NomNoir=$row["Nom"];
	$_SESSION['nom2'] = $NomNoir;
};

	//sauvegarde de la visite
	
	
	
	$ipvisit=$_SERVER["REMOTE_ADDR"];
	$aujourdhui=date('Y-m-d');
	$heure = date("H:i:s");
	$query ="INSERT INTO usages (club1,club2,adulte,maj,heure,ipvisite) VALUES($c1,$c2,1,'$aujourdhui','$heure','$ipvisit')";
	$ressource=mysqli_query ($link,$query);
	
	
	
// REPRISE DU CODE HTML D UN PROCES VERBAL VIERGE
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Feuille de match dynamique</title>
	<link rel="stylesheet" href="css/pv.css"  type="text/css">	
	<!-- On appel le fichier de CSS -->
	<link rel="stylesheet" href="css/styles.css" type="text/css" />	
	<!-- On appel les fichiers javascript nécessaires -->
	<script type="text/javascript" src="lib/prototype.js"></script>
	<script type="text/javascript" src="lib/effects.js"></script>
	<script type="text/javascript" src="lib/controls.js"></script>
	<script type="text/javascript" src="lib/autocompletion.js"></script>
	<!-- On appel notre fichier javascript avec l idc s'il existe -->
	<script type="text/javascript" src="fonction.js.php<?php echo $parametre?>"></script>	
</head>

<!-- FORMULAIRE pour récupérer les id joueurs et envoyer un lien -->
<FORM METHOD=POST ACTION="getlien.php" name="feuille">

<!-- Champs cachés des ID club -->
<input type="hidden" name="c1" id="c1" value="<?php echo $c1 ?>" />
<input type="hidden" name="c2" id="c2" value="<?php echo $c2 ?>" />

<body id="ThisPage" bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" bottommargin="0">
<div align="center">

<table width="1000" border="0" cellspacing="0" cellpadding="2">
  <tbody>
  <tr><td width="1000" align="center" class="Titre"><a href="index.php" TITLE="Sélectionner un autre club">FEUILLE DE MATCH DYNAMIQUE</a></td></tr>
</tbody>
</table>

<table cellspacing="0" width="1000" style="border-collapse:collapse;">
  <tbody>
  <tr height="10"><td></td></tr>
  <tr height="30">
    <td width="100" align="center" class="cadre"><p class="Infos">DATE</p></td>
    <td width="400" align="center" class="cadre"><p class="Infos">LIEU</p></td>
    <td width="400" align="center" class="cadre"><p class="Infos">COMPETITION</p></td>
    <td width="100" align="center" class="cadre"><p class="Infos">RONDE</p></td>
  </tr>
  <tr height="30">
	
    <td width="100" align="center" class="cadre">
	<!-- date du prochain dimanche par defaut -->
	<input type="text" id="dimanche" name="dimanche>" tabindex="300" value="<?php if (date('N', time())==7) {echo(strftime('%d/%m/%Y'));} else {echo(strftime('%d/%m/%Y', strtotime('next sunday')));} ?>" style="width:90px;  Text-ALIGN:center;" AUTOCOMPLETE=OFF/>
	</td>
    <td width="400" align="center" class="cadre">
	<input type="text" id="lieu" name="lieu" tabindex="400" value="" style="width:390px; Text-ALIGN:center;" AUTOCOMPLETE=OFF /></td>
	<td width="400" align="center" class="cadre">
	<!-- proposition du champ compétition -->
	<div class="select1">
	<select>
		<option selected="selected" value="0"> </option>
		<option value="2">Interclubs </option>
		<option value="2">Interclubs Top 12</option>
		<option value="2">Interclubs N 1</option>
		<option value="2">Interclubs N 2</option>
		<option value="2">Interclubs N 3</option>
		<option value="2">Interclubs N 4</option>
		<option value="7">Coupe de France</option>
		<option value="8">Coupe Jean-Claude Loubatiere</option>
		<option value="9">Coupe 2000</option>
		<option value="10">Interclubs Feminins</option>
		<option value="10">Interclubs Feminins Top 12</option>
		<option value="10">Interclubs Feminins N 1</option>
		<option value="10">Interclubs Feminins N 2</option>
		<option value="18">Ligue d'Alsace</option>
		<option value="19">Ligue d'Aquitaine</option>
		<option value="20">Ligue d'Auvergne</option>
		<option value="5">Ligue de Basse Normandie</option>
		<option value="21">Ligue de Bourgogne</option>
		<option value="12">Ligue de Bretagne</option>
		<option value="22">Ligue du Centre Val de Loire</option>
		<option value="17">Ligue de Champagne Ardenne</option>
		<option value="24">Ligue de Cote d'Azur</option>
		<option value="25">Ligue du Dauphine Savoie</option>
		<option value="26">Ligue de Franche Comte</option>
		<option value="14">Ligue de Haute Normandie</option>
		<option value="6">Ligue de l'Ile de France</option>
		<option value="35">Ligue de la Reunion</option>
		<option value="27">Ligue du Languedoc Roussillon</option>
		<option value="34">Ligue du Limousin</option>
		<option value="28">Ligue de Lorraine</option>
		<option value="15">Ligue du Lyonnais</option>
		<option value="13">Ligue de Midi Pyrenees</option>
		<option value="16">Ligue du Nord Pas de Calais</option>
		<option value="4">Ligue des Pays de la Loire</option>
		<option value="31">Ligue de Picardie</option>
		<option value="29">Ligue du Poitou-Charentes</option>
		<option value="32">Ligue de Provence</option>
	</select> 
	</div>
	<!-- ancien champ libre a remetre si besoin
	<input type="text" id="groupe" name="groupe>" tabindex="500" value="" style="width:390px; Text-ALIGN:center;"/>	
	-->
	</td>
    <td width="100" align="center" class="cadre">
	<!-- numéro de ronde -->
	<input type="text" id="numronde" name="numronde" tabindex="600" value="<?php echo $numronde?>" style="width:90px; Text-ALIGN:center;"/></td>
  </tr>
  <tr height="10"><td></td></tr>
</tbody>
</table>

<table cellspacing="0" width="1000" style="border-collapse:collapse;">
  <tbody><tr height="30">
    <td align="center" class="cadre" colspan="5"><p class="Clubs">CLUB AYANT LES BLANCS SUR LES ECHIQUIERS IMPAIRS</p></td>

    <td align="center" class="cadre"><p class="Clubs">S</p></td>
    <td></td>
    <td id="CellClubNoir" align="center" class="cadre" colspan="5"><p class="Clubs">CLUB AYANT LES NOIRS SUR LES ECHIQUIERS IMPAIRS</p></td>

    <td align="center" class="cadre"><p class="Clubs">S</p></td>
  </tr>
  <tr height="30">
    <td class="cadre" colspan="5" align="left">	
	<!-- nom du club blanc -->
	<input type="text" id="club1" name="club1" tabindex="700" style="width:400px; Text-ALIGN:center;" value="<?php echo $NomBlanc?>"/>		
	<?php if ($NomBlanc=='') { ?>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	
	<a href="index.php" title='Choisir un club pour les blancs'>...</a>
	<?php } ?>
	</td>	
    <td align="center" class="cadre"><p class="Clubs">&nbsp;</p></td>
    <td></td>
    <td id="CellClubNoirNom" align="left" class="cadre" colspan="5">	
	<!-- nom du club noir -->
	<input type="text" id="club2" name="club2" tabindex="710" style="width:400px; Text-ALIGN:center;" value="<?php echo $NomNoir?>" />		
	<?php if ($NomNoir=='') { ?>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	
	<a href="index.php" title='Choisir un club pour les noirs'>...</a>
	<?php } ?>
	</td>
    <td align="center" class="cadre"><p class="Clubs">&nbsp;</p></td>
  </tr>  
  <tr id="RepeaterAdulte_ctl00_RowMatch" height="30">
	<td width="30" align="center" class="cadre"><p class="JoueursTitre">&nbsp;</p></td>
	<td width="270" align="left" class="cadre"><p class="JoueursTitre">Nom et Prénom</p></td>
	<td width="70" align="center" class="cadre"><p class="JoueursTitre">Code FFE</p></td>
	<td width="60" align="center" class="cadre"><p class="JoueursTitre">Elo</p></td>
	<td width="30" align="center" class="cadre"><p class="JoueursTitre">C*</p></td>
	<td width="30" align="center" class="cadre"><p class="JoueursTitre">R</p></td>
	<td width="20"></td>
	<td width="30" align="center" class="cadre"><p class="JoueursTitre">&nbsp;</p></td>
	<td width="270" align="left" class="cadre"><p class="JoueursTitre">Nom et Prénom</p></td>
	<td width="70" align="center" class="cadre"><p class="JoueursTitre">Code FFE</p></td>
	<td width="60" align="center" class="cadre"><p class="JoueursTitre">Elo</p></td>
	<td width="30" align="center" class="cadre"><p class="JoueursTitre">C*</p></td>
	<td width="30" align="center" class="cadre"><p class="JoueursTitre">R</p></td>
</tr>

<?php 
// ****************************************************************************
// ********************** LA BOUCLE POUR LES LIGNES ***************************
// ****************************************************************************
for ($i=1; $i<=$nbj; $i++) 
{

	//initialisation des variables
	$rowblanc["Nom"]="";
	$rowblanc["Prenom"]="";
	$rowblanc["Ref"]="";
	$rowblanc["NrFFE"]="";
	$rowblanc["Elo"]="";
	
	$rownoir["Nom"]="";
	$rownoir["Prenom"]="";
	$rownoir["Ref"]="";
	$rownoir["NrFFE"]="";
	$rownoir["Elo"]="";
	
	//si un id a été recu en paramètre on récupère les infos du joueur 
	if ($blanc_id[$i]!=0)
	{
		$query ="SELECT Ref,Nom,Prenom,Elo,NrFFE FROM joueur WHERE ClubRef='$c1' AND Ref=$blanc_id[$i]";
		$ressource=mysqli_query ($link,$query);
		$rowblanc=mysqli_fetch_assoc ( $ressource );
		
 
	}
	if ($noir_id[$i]!=0)
	{
		$query ="SELECT Ref,Nom,Prenom,Elo,NrFFE FROM joueur WHERE ClubRef='$c2' AND Ref=$noir_id[$i]";
		$ressource=mysqli_query ($link,$query);
		$rownoir=mysqli_fetch_assoc ( $ressource );
	};

?>
  
  <tr height="30">
    <td width="30" align="center" class="cadre">
	<!-- numéro de table -->
	<p class="Clubs"><A class="nolien" HREF="Adultes.php?c=<?php echo $parametre?>&nbj=<?php if ($i==$nbj) {echo "8";} else {echo $i;} ?>" TITLE="Modifier le nombre de table"><?php echo $i?> <?php echo $couleur[$i % 2]?></a></p></td>
    <td width="270" align="left" class="cadre">
	<!-- nom prenom du joueur blanc -->
	<input type="text" id="joueur<?php echo $i?>" name="joueur<?php echo $i?>" tabindex="<?php echo $i?>0" value="<?php echo(trim($rowblanc["Nom"]." ".$rowblanc["Prenom"])) ?>" AUTOCOMPLETE=OFF/>
	<!-- champ caché id joueur blanc -->
	<input type="hidden" name="joueur<?php echo $i?>_id" id="joueur<?php echo $i?>_id" value="<?php echo $rowblanc["Ref"]?>" />
	<div id="joueur<?php echo $i?>_propositions" class="autocomplete"></div>
	</td>
	<!-- Numero FFE du joueur blanc -->
    <td width="70" align="center" class="cadre" id="joueur<?php echo $i?>_ffe"><?php echo($rowblanc["NrFFE"]) ?></td>
	<!-- ELO du joueur blanc -->
    <td width="60" align="center" class="cadre" id="joueur<?php echo $i?>_elo"><?php echo($rowblanc["Elo"]) ?></td>
    <td width="30" align="center" class="cadre"><p class="Joueurs">&nbsp;</p></td>
    <td width="30" align="center" class="cadre"><p class="Joueurs">&nbsp;</p></td>
    <td width="20"></td> <!-- COTE DROIT -->
	<!-- numéro de table -->
    <td width="30" align="center" class="cadre"><p class="Clubs"><?php echo $i?> <?php echo $couleur[($i+1) % 2]?></p></td>
    <td width="270" align="left" class="cadre">
	<!-- nom prenom du joueur noir -->
	<input type="text" id="noir<?php echo $i?>" name="noir<?php echo $i?>" tabindex="1<?php echo $i?>0" value="<?php echo(trim($rownoir["Nom"]." ".$rownoir["Prenom"])) ?>" AUTOCOMPLETE=OFF/>
	<!-- id joueur noir -->
	<input type="hidden" name="noir<?php echo $i?>_id" id="noir<?php echo $i?>_id" value="<?php echo $rownoir["Ref"]?>" />
	<div id="noir<?php echo $i?>_propositions" class="autocomplete"></div>
	</td>
	<!-- Numero FFE du joueur noir -->
    <td width="70" align="center" class="cadre" id="noir<?php echo $i?>_ffe"><?php echo($rownoir["NrFFE"]) ?></td>
	<!-- ELO du joueur noir -->
    <td width="60" align="center" class="cadre" id="noir<?php echo $i?>_elo"><?php echo($rownoir["Elo"]) ?></td>
    <td width="30" align="center" class="cadre"><p class="Joueurs">&nbsp;</p></td>
    <td width="30" align="center" class="cadre"><p class="Joueurs">&nbsp;</p></td>
  </tr>
  
<?php 
}
// ****************************************************************************
// **************** FIN DE LA FEUILLE DE MATCH ********************************
// ****************************************************************************
?>  
  
  <tr id="RepeaterAdulte_ctl08_RowMessageAdulte">
	<td class="cadre" colspan="6">
      <p class="Remarque">GAIN : 1 - PERTE : 0 - NULL (pas comptabilisé) - Forfait 0 ou -1 suivant le cas (cf. Livre FFE)</p>
    </td>
	<td width="20"></td>
	<td class="cadre" colspan="6">
      <p class="Remarque">GAIN : 1 - PERTE : 0 - NULL (pas comptabilisé) - Forfait 0 ou -1 suivant le cas (cf. Livre FFE)</p>
    </td>
</tr>
  
</tbody></table>
<table border="0">
  <tbody><tr height="40" valign="middle">
    <td width="400" align="center" class="Joueurs">Nom du Capitaine : ....................</td>
    <td width="200" align="center" class="Joueurs">Nom de l'Arbitre : ....................</td>
    <td width="400" align="center" class="Joueurs">Nom du Capitaine : ....................</td>
  </tr>
  <tr height="40" valign="middle">
    <td width="400" align="center" class="Joueurs">Signature</td>
	
	<!-- CLIC SUR LA SIGNATURE CENTRALE POUR R2CUPERER LE LIEN -->
	
    <td width="200" align="center" class="Joueurs"><span onClick=feuille.submit()>Signature</span></td>
    <td width="400" align="center" class="Joueurs">Signature</td>
  </tr>
  <tr height="40" valign="middle">
    <td width="400" align="center" class="Joueurs">Le nom de l'Arbitre doit être inscrit avant le début du match</td>
    <td width="200" align="center" class="Joueurs">C* : contrôle des licences</td>
    <td width="400" align="center" class="Joueurs">L'Arbitre doit cocher cette case afin d'attester le contrôle</td>
  </tr>
  
</tbody></table>


</form>

</div>

<!-- On appel notre fonction javascript -->
<script type="text/javascript">init();</script>


</body></html>