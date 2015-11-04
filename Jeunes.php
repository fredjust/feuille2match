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

// connexion pour récupérer les infos a partir des id s'ils sont passés en paramètre
include("_connect.php");




// pour alterner les lettre B et N suivant les lignes
$couleur[0]="N";
$couleur[1]="B";

// passage de l'id du club en paramètre du traitement s'il existe 
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
	$query ="INSERT INTO usages (club1,club2,adulte,maj,heure,ipvisite) VALUES($c1,$c2,0,'$aujourdhui','$heure','$ipvisit')";
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
	<link rel="stylesheet" href="css/styles_j.css" type="text/css" />	
	<!-- On appel les fichiers javascript nécessaires -->
	<script type="text/javascript" src="lib/prototype.js"></script>
	<script type="text/javascript" src="lib/effects.js"></script>
	<script type="text/javascript" src="lib/controls.js"></script>
	<script type="text/javascript" src="lib/autocompletion_j.js"></script>
	<!-- On appel notre fichier javascript avec les id club s'ils existent -->
	<script type="text/javascript" src="fonction_j.js.php<?php echo $parametre?>"></script>	
</head>

<!-- FORMULAIRE pour récupérer les id joueurs et envoyer un lien -->
<FORM METHOD=POST ACTION="getlien.php" name="feuille">

<input type="hidden" name="c1" id="c1" value="<?php echo $c1 ?>" />
<input type="hidden" name="c2" id="c2" value="<?php echo $c2 ?>" />

<body id="ThisPage" bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" bottommargin="0">
<div align="center">

<table width="1000" border="0" cellspacing="0" cellpadding="2">
  <tbody>
  <tr><td width="1000" align="center" class="Titre"><a href="index.php" TITLE="Sélectionner un autre club">FEUILLE DE MATCH DYNAMIQUE</a></td></tr>
</tbody>
</table>


<table cellspacing=0 width=1000 style="border-collapse:collapse;">
  <tr height=10><td></td></tr>
  <tr height=30>
    <td width="100" align="center" class="cadre"><p class="Infos">DATE</p></td>
    <td width="400" align="center" class="cadre"><p class="Infos">LIEU</p></td>
    <td width="400" align="center" class="cadre"><p class="Infos">COMPETITION JEUNES</p></td>
    <td width="100" align="center" class="cadre"><p class="Infos">RONDE</p></td>
  </tr>
  <tr height=30>
    <!-- date du prochain dimanche par defaut -->
    <td width="100" align="center" class="cadre"><input type="text" id="dimanche" name="dimanche>" tabindex="500" value="<?php if (date('N', time())==7) {echo(strftime('%d/%m/%Y'));} else {echo(strftime('%d/%m/%Y', strtotime('next sunday')));} ?>" style="width:90px;  Text-ALIGN:center;" AUTOCOMPLETE=OFF/></td>
    <td width="400" align="center" class="cadre">	
	<input type="text" id="lieu" name="lieu" tabindex="400" value="" style="width:390px; Text-ALIGN:center;" AUTOCOMPLETE=OFF /></td>
    <td width="400" align="center" class="cadre"><span class="Infos">
	
	<div class="select2">
	
	
	<select>
	<option selected="selected" value="0"> </option>		
	<option value="5">Top Jeunes</option>
	<option value="1">Nationale I</option>
	<option value="2">Nationale II</option>
	<option value="3">Nationale III</option>
	<option value="4">Nationale IV</option>
	</select>
	
	<select>
	<option selected="selected" value="0"> </option>		
	<option value="10">Poule A</option>
	<option value="10">Poule B</option>
	<option value="10">Groupe Est</option>
	<option value="10">Groupe Nord</option>
	<option value="10">Groupe Ouest</option>
	<option value="10">Groupe Sud</option>
	<option value="10">Groupe I</option>
	<option value="11">Groupe II</option>
	<option value="12">Groupe III</option>
	<option value="13">Groupe IV</option>
	<option value="14">Groupe V</option>
	<option value="15">Groupe VI</option>
	<option value="16">Groupe VII</option>
	<option value="17">Groupe VIII</option>
	<option value="18">Groupe IX</option>
	<option value="19">Groupe X</option>
	<option value="20">Groupe XI</option>
	<option value="21">Groupe XII</option>
	</select> 
	
    

	</div>
	
	
	</span></td>
    <td width="100" align="center" class="cadre"><span class="Infos">  
	<input type="text" id="numronde" name="numronde" tabindex="600" value="<?php echo $numronde?>" style="width:90px; Text-ALIGN:center;"/></td>
	</span></td>
  </tr>
  <tr height=10><td></td></tr>
</table>


<table cellspacing="0" width="1000" style="border-collapse:collapse;">


  <tbody>
  
  <tr height="30">
    <td align="center" class="cadre" colspan="6"><p class="Clubs">CLUB AYANT LES BLANCS SUR LES ECHIQUIERS IMPAIRS</p></td>
    <td align="center" class="cadre"><p class="Clubs">S</p></td>
    <td></td>
    <td align="center" class="cadre" colspan="6"><p class="Clubs">CLUB AYANT LES NOIRS SUR LES ECHIQUIERS IMPAIRS</p></td>
    <td align="center" class="cadre"><p class="Clubs">S</p></td>
  </tr>
  <tr height="30">
    <td class="cadre" colspan="6" align="left">	
	<input type="text" id="club1" name="club1" tabindex="700" style="width:400px; Text-ALIGN:center;" value="<?php echo $NomBlanc?>"/>
	<?php if ($NomBlanc=='') { ?>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	
	<a href="index.php" title='Choisir un club pour les blancs'>...</a>
	<?php } ?>
	</td>
    <td align="center" class="cadre"><p class="Clubs">&nbsp;</p></td>
    <td></td>
    <td align="left" class="cadre" colspan="6">	
	<input type="text" id="club2" name="club2" tabindex="710" style="width:400px; Text-ALIGN:center;" value="<?php echo $NomNoir?>" />	
	<?php if ($NomNoir=='') { ?>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	
	<a href="index.php" title='Choisir un club pour les noirs'>...</a>
	<?php } ?>
	</td>
    <td align="center" class="cadre"><p class="Clubs">&nbsp;</p>
	
	</td>
  </tr>

  
  <tr id="RepeaterJeune_ctl00_Tr1" height="30">
	<td width="30" align="center" class="cadre"><p class="JoueursTitre">&nbsp;</p></td>
	<td width="210" align="left" class="cadre"><p class="JoueursTitre">Nom et Prénom</p></td>
	<td width="60" align="center" class="cadre"><p class="JoueursTitre">Code FFE</p></td>
	<td width="70" align="center" class="cadre"><p class="JoueursTitre">Né le</p></td>
	<td width="60" align="center" class="cadre"><p class="JoueursTitre">Elo</p></td>
	<td width="30" align="center" class="cadre"><p class="JoueursTitre">C*</p></td>
	<td width="30" align="center" class="cadre"><p class="JoueursTitre">R</p></td>
	<td width="20"></td>
	<td width="30" align="center" class="cadre"><p class="JoueursTitre">&nbsp;</p></td>
	<td width="210" align="left" class="cadre"><p class="JoueursTitre">Nom et Prénom</p></td>
	<td width="60" align="center" class="cadre"><p class="JoueursTitre">Code FFE</p></td>
	<td width="70" align="center" class="cadre"><p class="JoueursTitre">Né le</p></td>
	<td width="60" align="center" class="cadre"><p class="JoueursTitre">Elo</p></td>
	<td width="30" align="center" class="cadre"><p class="JoueursTitre">C*</p></td>
	<td width="30" align="center" class="cadre"><p class="JoueursTitre">R</p></td>
</tr>

<?php 
// ****************************************************************************
// ********************** LA BOUCLE POUR LES LIGNES ***************************
// ****************************************************************************
for ($i=1; $i<=6; $i++) 
{

	//initialisation des variables
	$rowblanc["Nom"]="";
	$rowblanc["Prenom"]="";
	$rowblanc["Ref"]="";
	$rowblanc["NrFFE"]="";
	$rowblanc["Elo"]="";
	$rowblanc["NeLe"]="";
	
	
	$rownoir["Nom"]="";
	$rownoir["Prenom"]="";
	$rownoir["Ref"]="";
	$rownoir["NrFFE"]="";
	$rownoir["Elo"]="";
	$rownoir["NeLe"]="";
	
	//si un id a été recu en paramètre on récupère les infos du joueur 
	if ($blanc_id[$i]!=0)
	{
		$query ="SELECT Ref,Nom,Prenom,Elo,NeLe,NrFFE FROM joueur WHERE ClubRef='$c1' AND Ref=$blanc_id[$i]";
		$ressource=mysqli_query ($link,$query);
		$rowblanc=mysqli_fetch_assoc ( $ressource );
		$rowblanc["NeLe"]=date("d-m-y", strtotime($rowblanc["NeLe"])); 
		
 
	}
	if ($noir_id[$i]!=0)
	{
		$query ="SELECT Ref,Nom,Prenom,Elo,NeLe,NrFFE FROM joueur WHERE ClubRef='$c2' AND Ref=$noir_id[$i]";
		$ressource=mysqli_query ($link,$query);
		$rownoir=mysqli_fetch_assoc ( $ressource );
		$rownoir["NeLe"]=date("d-m-y", strtotime($rownoir["NeLe"])); 
	};

?>
  
  <tr height="30">
	<!-- Numéro de table -->
    <td width=30 align="center" class="cadre"><p class="Clubs"><?php echo $i?> <?php echo $couleur[$i % 2]?></p></td>
	<td width="210" align="left" class="cadre">
	<!-- nom prenom du joueur blanc -->
		<input width="150" type="text" id="joueur<?php echo $i?>" name="joueur<?php echo $i?>" tabindex="<?php echo $i?>0" value="<?php echo(trim($rowblanc["Nom"]." ".$rowblanc["Prenom"])) ?>" AUTOCOMPLETE=OFF/>
		<!-- id joueur blanc -->
		<input type="hidden" name="joueur<?php echo $i?>_id" id="joueur<?php echo $i?>_id" value="<?php echo $rowblanc["Ref"]?>" />
		<div id="joueur<?php echo $i?>_propositions" class="autocomplete"></div>
	</td>
	<!-- Numero FFE du joueur blanc -->
    <td width="60" align="center" class="cadre" id="joueur<?php echo $i?>_ffe"><?php echo($rowblanc["NrFFE"]) ?></td>
	<!-- Date de Naissance du joueur blanc -->
	<td width="70" align="center" class="cadre" id="joueur<?php echo $i?>_nele"><?php echo($rowblanc["NeLe"]) ?></td>
    <!-- ELO du joueur blanc -->
	<td width="60" align="center" class="cadre" id="joueur<?php echo $i?>_elo"><?php echo($rowblanc["Elo"]) ?></td>
    <!-- C* -->
    <td width="30" align="center" class="cadre"><p class="Joueurs">&nbsp;</p></td>
	<!-- R -->
    <td width="30" align="center" class="cadre"><p class="Joueurs">&nbsp;</p></td>
    <td width="20"></td>
	
	<!-- Numéro de table -->
    <td width=30 align="center" class="cadre"><p class="Clubs"><?php echo $i?> <?php echo $couleur[($i+1) % 2]?></p></td>
	<!-- nom prenom du joueur noir -->
    <td width="210" align="left" class="cadre">
		<input width="150" type="text" id="noir<?php echo $i?>" name="noir<?php echo $i?>" tabindex="1<?php echo $i?>0" value="<?php echo(trim($rownoir["Nom"]." ".$rownoir["Prenom"])) ?>" AUTOCOMPLETE=OFF/>
		<!-- id joueur noir -->
		<input type="hidden" name="noir<?php echo $i?>_id" id="noir<?php echo $i?>_id" value="<?php echo $rownoir["Ref"]?>" />
		<div id="noir<?php echo $i?>_propositions" class="autocomplete"></div>	
	</td>	
	<!-- Numero FFE du joueur noir -->
    <td width="60" align="center" class="cadre" id="noir<?php echo $i?>_ffe"><?php echo($rownoir["NrFFE"]) ?></td>
	<!-- Date de Naissance du joueur noir -->
    <td width="70" align="center" class="cadre" id="noir<?php echo $i?>_nele"><?php echo($rownoir["NeLe"]) ?></td>
	<!-- ELO du joueur noir -->
    <td width="60" align="center" class="cadre" id="noir<?php echo $i?>_elo"><?php echo($rownoir["Elo"]) ?></td>
	<!-- C* -->
    <td width="30" align="center" class="cadre"><p class=Joueurs>&nbsp;</p></td>
	<!-- R -->
    <td width="30" align="center" class="cadre"><p class=Joueurs>&nbsp;</p></td>
  </tr>
  
<?php 
}
// ****************************************************************************
// **************** FIN DE LA FEUILLE DE MATCH ********************************
// ****************************************************************************
?>  
  
  <tr>
	<td class="cadre" colspan="7">
      <p class="Remarque">GAIN : 2 - PERTE : 0 - NULL (pas comptabilisé) - Forfait 0 ou -1 suivant le cas (cf. Livre FFE)</p>
    </td>
	<td width="20"></td>
	<td class="cadre" colspan="7">
      <p class="Remarque">GAIN : 2 - PERTE : 0 - NULL (pas comptabilisé) - Forfait 0 ou -1 suivant le cas (cf. Livre FFE)</p>
    </td>
</tr>


<?php 

$poussin[0]="7 B";
$poussin[1]="7 N";
$poussin[2]="8 B";
$poussin[3]="8 N";
$poussin[4]="7 N";
$poussin[5]="8 B";
$poussin[6]="8 N";
$poussin[7]="7 B";

	$rowblanc7["Nom"]="";
	$rowblanc7["Prenom"]="";
	$rowblanc7["Ref"]="";
	$rowblanc7["NrFFE"]="";
	$rowblanc7["Elo"]="";
	$rowblanc7["NeLe"]="";
	
	
	
	
	$rownoir7["Nom"]="";
	$rownoir7["Prenom"]="";
	$rownoir7["Ref"]="";
	$rownoir7["NrFFE"]="";
	$rownoir7["Elo"]="";
	$rownoir7["NeLe"]="";


for ($i=7;$i<9;$i++)
{
	
	//initialisation des variables
	$rowblanc["Nom"]="";
	$rowblanc["Prenom"]="";
	$rowblanc["Ref"]="";
	$rowblanc["NrFFE"]="";
	$rowblanc["Elo"]="";
	$rowblanc["NeLe"]="";
	
	
	
	
	$rownoir["Nom"]="";
	$rownoir["Prenom"]="";
	$rownoir["Ref"]="";
	$rownoir["NrFFE"]="";
	$rownoir["Elo"]="";
	$rownoir["NeLe"]="";
	
	//si un id a été recu en paramètre on récupère les infos du joueur 
	if ($blanc_id[$i]!=0)
	{
		$query ="SELECT Ref,Nom,Prenom,Elo,NeLe,NrFFE FROM joueur WHERE ClubRef='$c1' AND Ref=$blanc_id[$i]";
		$ressource=mysqli_query ($link,$query);
		$rowblanc=mysqli_fetch_assoc ( $ressource );
		$rowblanc["NeLe"]=date("d-m-y", strtotime($rowblanc["NeLe"])); 
		
		if ($i==7) {$rowblanc7=$rowblanc;};
		
 
	}
	if ($noir_id[$i]!=0)
	{
		$query ="SELECT Ref,Nom,Prenom,Elo,NeLe,NrFFE FROM joueur WHERE ClubRef='$c2' AND Ref=$noir_id[$i]";
		$ressource=mysqli_query ($link,$query);
		$rownoir=mysqli_fetch_assoc ( $ressource );
		$rownoir["NeLe"]=date("d-m-y", strtotime($rownoir["NeLe"])); 
		
		if ($i==7) {$rownoir7=$rownoir;};
	};

?>

  
  <tr height=30>
    <td width=30 align="center" class="cadre"><p class="Clubs"><?php echo $poussin[2*($i-7)]?></p></td>
    <!-- nom prenom du joueur blanc -->
    <td width="210" align="left" class="cadre">
		<input type="text" id="joueur<?php echo $i?>" name="joueur<?php echo $i?>" tabindex="<?php echo $i?>0" value="<?php echo(trim($rowblanc["Nom"]." ".$rowblanc["Prenom"])) ?>" AUTOCOMPLETE=OFF/>
		<!-- id joueur blanc -->
		<input type="hidden" name="joueur<?php echo $i?>_id" id="joueur<?php echo $i?>_id" value="<?php echo $rowblanc["Ref"]?>" />
		<div id="joueur<?php echo $i?>_propositions" class="autocomplete"></div>
	</td>
	<!-- Numero FFE du joueur blanc -->
    <td width="70" align="center" class="cadre" id="joueur<?php echo $i?>_ffe"><?php echo($rowblanc["NrFFE"]) ?></td>
	<!-- Date de Naissance du joueur blanc -->
	<td width="60" align="center" class="cadre" id="joueur<?php echo $i?>_nele"><?php echo($rowblanc["NeLe"]) ?></td>
    <!-- ELO du joueur blanc -->
	<td width="60" align="center" class="cadre" id="joueur<?php echo $i?>_elo"><?php echo($rowblanc["Elo"]) ?></td>
    <!-- C* -->
    <td width=30 align="center" class="cadre"><p class=Joueurs>&nbsp;</p></td>
	<!-- R -->
    <td width=30 align="center" class="cadre"><p class=Joueurs>&nbsp;</p></td>
	
    <td width=20></td>
	
    <td width=30 align="center" class="cadre"><p class="Clubs"><?php echo $poussin[2*($i-7)+1]?></p></td>
    <td width="210" align="left" class="cadre">
		<input type="text" id="noir<?php echo $i?>" name="noir<?php echo $i?>" tabindex="<?php echo ($i+20) ?>0" value="<?php echo(trim($rownoir["Nom"]." ".$rownoir["Prenom"])) ?>" AUTOCOMPLETE=OFF/>
		<!-- id joueur noir -->
		<input type="hidden" name="noir<?php echo $i?>_id" id="noir<?php echo $i?>_id" value="<?php echo $rownoir["Ref"]?>" />
		<div id="noir<?php echo $i?>_propositions" class="autocomplete"></div>	
	</td>	
	<!-- Numero FFE du joueur noir -->
    <td width="70" align="center" class="cadre" id="noir<?php echo $i?>_ffe"><?php echo($rownoir["NrFFE"]) ?></td>
	<!-- Date de Naissance du joueur noir -->
    <td width="60" align="center" class="cadre" id="noir<?php echo $i?>_nele"><?php echo($rownoir["NeLe"]) ?></td>
	<!-- ELO du joueur noir -->
    <td width="60" align="center" class="cadre" id="noir<?php echo $i?>_elo"><?php echo($rownoir["Elo"]) ?></td>
	<!-- C* -->
    <td width=30 align="center" class="cadre"><p class=Joueurs>&nbsp;</p></td>
	<!-- R -->
    <td width=30 align="center" class="cadre"><p class=Joueurs>&nbsp;</p></td>
  </tr>
   
  
  
  <?php
  
  }
  

?>

  
  <tr height="30">
    <td width="30" align="center" class="cadre"><p class="Clubs">7 N</p></td>
    <td width="210" align="left" class="cadre" id="joueur7_bis"><?php echo(trim($rowblanc7["Nom"]." ".$rowblanc7["Prenom"])) ?></td>
	<td width="70" align="center" class="cadre" id="joueur7_ffe_bis"><?php echo($rowblanc7["NrFFE"]) ?></td>
	<td width="60" align="center" class="cadre" id="joueur7_nele_bis"><?php echo($rowblanc7["NeLe"]) ?></td>
    <td width="60" align="center" class="cadre" id="joueur7_elo_bis"><?php echo($rowblanc7["Elo"]) ?></td>
    <td width="30" align="center" class="cadre"></td>
	<td width="30" align="center" class="cadre"></td>
	
    <td width=20></td>
	
    <td width="30" align="center" class="cadre"><p class="Clubs">8 B</p></td>
    <td width="210" align="left" class="cadre" id="noir8_bis"><?php echo(trim($rownoir["Nom"]." ".$rownoir["Prenom"])) ?></td>
	<td width="70" align="center" class="cadre" id="noir8_ffe_bis"><?php echo($rownoir["NrFFE"]) ?></td>
	<td width="60" align="center" class="cadre" id="noir8_nele_bis"><?php echo($rownoir["NeLe"]) ?></td>
    <td width="60" align="center" class="cadre" id="noir8_elo_bis"><?php echo($rownoir["Elo"]) ?></td>
    <td width="30" align="center" class="cadre"></td>
	<td width="30" align="center" class="cadre"></td>
	
  </tr>
  
  <tr height="30">
    <td width="30" align="center" class="cadre"><p class="Clubs">8 N</p></td>
    <td width="210" align="left" class="cadre" id="joueur8_bis"><?php echo(trim($rowblanc["Nom"]." ".$rowblanc["Prenom"])) ?></td>
	<td width="70" align="center" class="cadre" id="joueur8_ffe_bis"><?php echo($rowblanc["NrFFE"]) ?></td>
	<td width="60" align="center" class="cadre" id="joueur8_nele_bis"><?php echo($rowblanc["NeLe"]) ?></td>
    <td width="60" align="center" class="cadre" id="joueur8_elo_bis"><?php echo($rowblanc["Elo"]) ?></td>
    <td width="30" align="center" class="cadre"></td>
	<td width="30" align="center" class="cadre"></td>
	
    <td width=20></td>
	
    <td width="30" align="center" class="cadre"><p class="Clubs">7 B</p></td>
    <td width="210" align="left" class="cadre" id="noir7_bis"><?php echo(trim($rownoir7["Nom"]." ".$rownoir7["Prenom"])) ?></td>
	<td width="70" align="center" class="cadre" id="noir7_ffe_bis"><?php echo($rownoir7["NrFFE"]) ?></td>
	<td width="60" align="center" class="cadre" id="noir7_nele_bis"><?php echo($rownoir7["NeLe"]) ?></td>
    <td width="60" align="center" class="cadre" id="noir7_elo_bis"><?php echo($rownoir7["Elo"]) ?></td>
    <td width="30" align="center" class="cadre"></td>
	<td width="30" align="center" class="cadre"></td>
	
  </tr>
   
  
  
    <tr>
	<td class="cadre" colspan="7">
      <p class="Remarque">GAIN : 1 - PERTE : 0 - NULL (pas comptabilisé) - Forfait 0 ou -1 suivant le cas (cf. Livre FFE)</p>
    </td>
	<td width="20"></td>
	<td class="cadre" colspan="7">
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
</form></div><!-- On appel notre fonction javascript -->
<script type="text/javascript">init();</script></body></html>