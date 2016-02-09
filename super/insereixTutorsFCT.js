function valida(){
	var nomMestre = document.formulariInserirTutorsFCT.nomMestre.value;
	var cognomMestre = document.formulariInserirTutorsFCT.cognomMestre.value;
	var email = document.formulariInserirTutorsFCT.email.value;
	var telefon = document.formulariInserirTutorsFCT.telefon.value;
	var nomPas = document.formulariInserirTutorsFCT.nomPas.value;
	var clauPas = document.formulariInserirTutorsFCT.clauPas.value;
	var gremi = document.formulariInserirTutorsFCT.gremis.value;
	console.log('Caràcters del nomMestre:'+nomMestre.length);

	var missatge = '';
	var validacio = true;
	//Controlem que es un nomMestre vàlid. (7 Caràcters Empreses - 8 Caràcters Empreses).
	//-- Hem de comprovar que siguin de 8 car. Màx. --\\

	if( nomMestre == null || nomMestre.length == 0 || /^\s+$/.test(nomMestre)){
	  missatge = missatge+'- El camp del nom del Mestre no pot estar buit, és obligatori! \n \n';
	  validacio = false;
	}else{
		if(nomMestre.length > 25){
			missatge = missatge+'- El nom del Mestre inserit no és vàlid, ha de contenir 25 caràcters! \n \n';
			validacio = false;
		}
	}
	
	if( cognomMestre == null || cognomMestre.length == 0 || /^\s+$/.test(cognomMestre)){
	  missatge = missatge+'- El camp del cognom del mestre no pot estar buit, és obligatori! \n \n';
	  validacio = false;
	}else{
		if(cognomMestre.length > 60){
			missatge = missatge+'- El camp del cognom del mestre inserit és massa gran, ha de contenir un màxim de 60 caràcters! \n \n';
			validacio = false;
		}
	}
	
	if( email == null || email.length == 0 || /^\s+$/.test(email)){
		missatge = missatge+'- El correu electrònic no pot estar buit, és obligatori! \n \n';
		validacio = false;
	}else{
		if(email.length > 60){
			missatge = missatge+'- El Correu Electrònic inserit és massa gran, ha de contenir un màxim de 60 caràcters! \n \n';
			validacio = false;
		}else{
			//Hem de comprovar que el email disposa d' @
			var expRegCorreu = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			if (!expRegCorreu.test(email)){
				missatge = missatge+'- El correu electrònic no és vàlid! \n \n';
				validacio = false;
			}
		}
	}
	
	//Primer cal comrpovar que s'han introduit dades.
	if(telefon.length > 0){
		//Si disposa de dades, cal comprovar que siguin del format correcte.
		if( !(/^\d{9}$/.test(telefon))){
			missatge = missatge+'- El número de telèfon introduit no es correcte! \n \n';
			validacio = false;
		}
	}
	
	if(nomPas.length > 0){		
		if(/^\s+$/.test(nomPas)){
			missatge = missatge+'- Les dades introduides al camp del nom de pas no són vàlides! \n \n';
			validacio = false;
		}else{
			if(nomPas.length > 45){
				missatge = missatge+'- El nom de pas inserit es massa llarg, ha de contenir un màxim de 45 caràcters! \n \n';
				validacio = false;
			}
		}
	}
	
	if(clauPas.length > 0){		
		if(/^\s+$/.test(clauPas)){
			missatge = missatge+'- Les dades introduides al camp de la clau de pas, no són vàlides! \n \n';
			validacio = false;
		}else{
			if(clauPas.length > 45{
				missatge = missatge+'- La clau de pas inserida es massa llarga, ha de contenir un màxim de 45 caràcters! \n \n';
				validacio = false;
			}
		}
	}
	
	if(gremi < 1){
		missatge = missatge+'- Has de triar un gremi per a la petició, és obligatori! \n \n';
		validacio = false;
	}
	
	if(validacio === false){
		alert(missatge);
	}
	
	return validacio;
}