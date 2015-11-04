<?php

header("Content-type: application/x-javascript");




?>
var init = function ()
{
    
	
<?php
for ($i=1; $i<=8; $i++) 
{
?>
    new Ajax.Autocompleter(
        "joueur<?=$i?>",   // id du champ de formulaire
        "joueur<?=$i?>_propositions",  // id de l'élément utilisé pour les propositions
        "traitement_jb.php",  // URL du script côté serveur
        {
            paramName: 'debut',  // Nom du paramètre reçu par le script serveur
            minChars: 2 ,  // Nombre de caractères minimum avant que des appels serveur ne soient effectués
			afterUpdateElement: ac_return
        });
	
    // Instanciation de la classe Autocompleter, pour le champ de saisie "noir1"
    new Ajax.Autocompleter(
        "noir<?=$i?>",   // id du champ de formulaire
        "noir<?=$i?>_propositions",  // id de l'élément utilisé pour les propositions
        "traitement_jn.php",  // URL du script côté serveur
        {
            paramName: 'debut',  // Nom du paramètre reçu par le script serveur
            minChars: 2 ,  // Nombre de caractères minimum avant que des appels serveur ne soient effectués
			afterUpdateElement: ac_return
        });
	
<?php
}
?> 
		
}; 
