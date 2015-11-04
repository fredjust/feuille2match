function setCookie(sName, sValue) {
        var today = new Date(), expires = new Date();
        expires.setTime(today.getTime() + (30*24*60*60*1000));
        document.cookie = sName + "=" + encodeURIComponent(sValue) + ";expires=" + expires.toGMTString();
}

function ac_return(field, item){
	// on met en place l'expression régulière
	var regex = new RegExp('#i#(.*)#i#', 'gi');
	// on l'applique au contenu
	var id = regex.exec($(item).innerHTML);	
	// et on l'affecte au champ caché
	$(field.name+'_id').value = id[1];
	
	var regex = new RegExp('#e#(.*)#e#', 'gi');
	var elo = regex.exec($(item).innerHTML);	
	$(field.name+'_elo').innerHTML = elo[1];
	
	var regex = new RegExp('#f#(.*)#f#', 'gi');
	var ffe = regex.exec($(item).innerHTML);	
	$(field.name+'_ffe').innerHTML = ffe[1];
	
	var regex = new RegExp('#d#(.*)#d#', 'gi');
	var nele = regex.exec($(item).innerHTML);	
	$(field.name+'_nele').innerHTML = nele[1];		
	
		
	var regex = new RegExp('#n#(.*)#n#', 'gi');
	var nomprenom = regex.exec($(item).innerHTML);	
	$(field.name).value = nomprenom[1];		
	
	
	
}

function ac_groupe(field, item){
	// on met en place l'expression régulière
	var regex = new RegExp('[0123456789]*-idequipe', 'i');
	// on l'applique au contenu
	var nomimage = regex.exec($(item).innerHTML);
	//on récupère l'id
	id = nomimage[0].replace('-idequipe', '');
	// et on l'affecte au champ caché
	$(field.name+'_id').value = id;
	
	
	
	var regex = new RegExp('#d#(.*)#d#', 'gi');
	var division = regex.exec($(item).innerHTML);
	
	var regex = new RegExp('#g#(.*)#g#', 'gi');
	var groupe = regex.exec($(item).innerHTML);
	
	var regex = new RegExp('#e#(.*)#e#', 'gi');
	var eqnom = regex.exec($(item).innerHTML);
	
	$(field.name).value = eqnom[1];
	
	// et on l'affecte au champ 
	$('groupe').value = division[1] + " - " + groupe[1];	
	
	
	
}