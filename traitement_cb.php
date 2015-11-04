<?php
session_start();

include("_connect.php");

$c1 = isset($_SESSION['club1']) ? $_SESSION["club1"] : "0";

echo "<ul>\n";

 $debut = $_REQUEST["debut"];

if($debut!="")
{
	$nbligne=0;

	$query ="SELECT Ref,Nom,Prenom,elo_s,NrFFE,NeLe FROM joueur WHERE ClubRef=$c1 AND (Nom LIKE '$debut%' OR Prenom LIKE '$debut%') LIMIT 0,10";
	$ressource=mysqli_query ($link,$query); 
		
	while($row=mysqli_fetch_assoc ( $ressource )) {
		echo("<li>".$row["Nom"]." ".$row["Prenom"]."
		<span class='informal' style='display:none'> #n#".$row["Nom"]." ".$row["Prenom"]."#n#</span> 
		<span class='informal' style='display:none'> #i#".$row["Ref"]."#i#</span> 
		<span class='informal' style='display:none'> #e#".$row["Elo"]."#e#</span> 
		<span class='informal' style='display:none'> #f#".$row["NrFFE"]."#f#</span>
		<span class='informal' style='display:none'> #d#".$row["NeLe"]."#d#</span>
		</li>\n");
		$nbligne++;
	};
	if ($nbligne==10)
	{
		echo("<li>(plus de 10 ...)</li>\n");
	};
	if ($nbligne==0)
	{
		echo("<li>(Aucun résultat)</li>\n");
	};	
}
echo "</ul>";

 ?>