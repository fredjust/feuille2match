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
environ 50 Mo
  
**DANS AXBASE**   
Décompresser la base et l’ouvrir avec AxBase  
http://sourceforge.net/projects/axbase/  
Effacer les joueurs qui ne sont pas licence A  
	DELETE FROM joueur WHERE AffType<>'A'  
Exporter les joueurs restant en XLS  
environ 5Mo en xls
  
**DANS EXCEL**  
Ouvrir le fichier avec excel  
les dates ne sont pas reconnues  
enregistrer le fichier en CSV séparateur point virgule  
ré-ouvrir le fichier avec EXCEL  
supprimer la ligne d’entête   
Modifier le format des date de naissance en aaaa-mm-jj  
enregistrer le fichier (en CSV séparateur point virgule)  
zipper ce fichier 
environ 0.5 Mo soit 100 fois plus petit que le MDB de départ  
  
**DANS PHPMYADMIN**  
Créer une table joueurTEMPO (en copiant la structure de joueur)  
la structure est identique à celle de la base ACCES sauf  
	elo_s contenant le elo d'octobre  
	dep contenant le département du joueur  

importer le fichier CSV (zippé)  
	FORMAT  utf8 CSV  
	colonne séparées par des ;  
	nom des colonnes importées :  
	Ref, NrFFE, Nom, Prenom, Sexe, NeLe, Cat, Federation, ClubRef,  Elo,  Rapide, Fide, FideCode, FideTitre, AffType, Actif


importation des elo d'octobre  
	Récupérer les elo_s de la table joueur  s'ils étaient déjà dedans  
		UPDATE joueurTEMPO,joueur SET joueurTEMPO.elo_s=joueur.elo_s WHERE joueur.NrFFE=joueurTEMPO.NrFFE  
	pour une première installation en 2015-2016  
		les importer depuis le fichier /sql/Ref-elo_s  
			contenant 20983 lignes  
			Ref,elo_s  
	importer les départements  
		UPDATE joueurTEMPO j,club c SET j.dep=c.dep WHERE j.ClubRef=c.Ref  

Renommer la table joueur en joueurOLD  
Renommer la table joueurTEMPO en joueur  
Supprimer la table joueurOLD   
   
**POUR LA TABLE CLUB**  
Exporter en XLS  
ouvrir avec EXCEL  
supprimer la colonne Actif
exporter en CSV  
ouvrir avec NOTEPAD++  
convertir en UTF8  
supprimer les  doubles cotes   
remplacer les ‘ par des \’  
supprimer la ligne entete  
zipper  
Importer dans clubTEMPO  
	FORMAT utf-8 CSV
	colonnes séparées par des ;
	nom des colonnes :  
	Ref,NrFFE,Nom,Ligue,Commune

remplir la colonne dep avec :  
UPDATE clubTEMPO SET dep=substring(NrFFE,2,2)  
UPDATE clubTEMPO SET dep='99' WHERE dep='9E'  
UPDATE clubTEMPO SET dep='99' WHERE dep='9F'  

Les colonnes nba et nbj seront remplis avec le nombre de joueur du club
et le nombre de jeune du club
  





