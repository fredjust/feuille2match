Procédure de mise à jour MANUELLE des joueurs depuis la base papi
==
  
**BUT**  
  
Mettre à jour l’ensemble des Elo pour les joueurs présents  
Ajouter les nouveaux joueurs licenciés  
Supprimer les joueurs qui ne sont plus dans la base  
  
Les Elo d’octobre sont à conserver  
  
**SUR LE SITE FFE**  
Télécharger la base papi sur le site de la FFE  
http://www.echecs.asso.fr/Papi/PapiData.zip  
  
**DANS AXBASE**   
Décompresser la base et l’ouvrir avec AxBase  
http://sourceforge.net/projects/axbase/  
Effacer les joueurs qui ne sont pas licence A  
DELETE FROM joueur WHERE AffType<>'A'  
Exporter les joueurs restant en XLS  
  
**DANS EXCEL**  
Ouvrir le fichier avec excel  
les dates ne sont pas reconnues  
enregistrer le fichier en CSV séparateur point virgule  
ré-ouvrir le fichier avec EXCEL  
supprimer la ligne d’entête   
Modifier le format des date de naissance en aaaa-mm-jj  
enregistrer le fichier (en CSV séparateur point virgule)  
zipper ce fichier  
  
**DANS PHPMYADMIN**  
Créer une table joueurTEMPO (en copiant la structure de joueur)  
supprimer la colonne elo_s  
importer le fichier CSV (zippé) utf8 CSV  
ajouter une colonne elo_s après elo (format INT) default = 0  
Récupérer les elo_s de la table joueur  
UPDATE joueurTEMPO,joueur SET joueurTEMPO.elo_s=joueur.elo_s WHERE joueur.NrFFE=joueurTEMPO.NrFFE  
Attention 245 sec sans index ! 0.17 sec avec index !  
Ajouter une colonne dep varchar 2 default NULL  
UPDATE joueurTEMPO j,club c SET j.dep=c.dep WHERE j.ClubRef=c.Ref  
Renommer la table joueur en joueurOLD  
Renommer la table joueurTEMPO en joueur  
Supprimer la table joueurOLD   
   
**POUR LA TABLE CLUB**  
Exporter en XLS  
ouvrir avec EXCEL  
exporter en CSV  
ouvrir avec NOTEPAD++  
convertir en UTF8  
supprimer les  doubles cotes   
remplacer les ‘ par des \’  
supprimer la ligne entete  
Importer dans clubTEMPO  
ajouter une colonne dep VARCHAR 2  
remplir la colonne dep avec :  
UPDATE clubTEMPO SET dep=substring(NrFFE,2,2)  
UPDATE clubTEMPO SET dep='99' WHERE dep='9E'  
UPDATE clubTEMPO SET dep='99' WHERE dep='9F'  
Rajouter une maj de type DATE  
  





