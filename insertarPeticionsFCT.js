function valida(){
	var nif = document.formulariPeticioFCT.nif.value;
	var nomEmpresa = document.formulariPeticioFCT.nomEmpresa.value;
	var nomContacte = document.formulariPeticioFCT.nomContacte.value;
	var email = document.formulariPeticioFCT.email.value;
	var tasques = document.formulariPeticioFCT.tasques.value;
	var telefon = document.formulariPeticioFCT.telefon.value;
	var direccio = document.formulariPeticioFCT.direccio.value;
	var gremi = document.formulariPeticioFCT.gremis.value;
	var nombre = document.formulariPeticioFCT.nombre.value;
	//console.log('Caràcters del nif:'+nif.length);
	//console.log('Gremi triat:'+gremi);
	
	
	
	var missatge = '';
	var validacio = true;
	//Controlem que es un NIF vàlid. (7 Caràcters Empreses - 8 Caràcters Empreses).
	//-- Hem de comprovar que siguin de 8 car. Màx. --\\
	//Falta determinar si els caràcters poden ser vàlids o no (NNNNNNX)
	if( nif == null || nif.length == 0 || /^\s+$/.test(nif) ) {
	  missatge = missatge+'- El camp del NIF no pot estar buit, és obligatori! \n \n';
	  validacio = false;
	}else{
		if(nif.length < 7){		
			missatge = missatge+'- El Nif inserit no és vàlid, ha de contenir 7 caràcters! \n \n';
			validacio = false;
		}
		if(nif.length > 9){
			missatge = missatge+'- El Nif inserit no és vàlid, ha de contenir 9 caràcters! ?? \n \n';
			validacio = false;
		}
	}
	
	if( nomEmpresa == null || nomEmpresa.length == 0 || /^\s+$/.test(nomEmpresa) ) {
	  missatge = missatge+'- El camp del Nom de l\'empresa no pot estar buit, és obligatori! \n \n';
	  validacio = false;
	}else{
		if(nomEmpresa.length > 80){
			missatge = missatge+'- El Nom de l\'empresa inserit és massa gran, ha de contenir un màxim de 80 caràcters! \n \n';
			validacio = false;
		}
	}
	
	if( nomContacte == null || nomContacte.length == 0 || /^\s+$/.test(nomContacte) ) {
	  missatge = missatge+'- El Nom del Contacte no pot estar buit, és obligatori! \n \n';
	  validacio = false;
	}else{
		if(nomContacte.length > 60){
			missatge = missatge+'- El Nom del Contacte inserit és massa gran, ha de contenir un màxim de 60 caràcters! \n \n';
			validacio = false;
		}
	}
	
	if( email == null || email.length == 0 || /^\s+$/.test(email) ) {
		missatge = missatge+'- El correu electrònic no pot estar buit, és obligatori! \n \n';
		validacio = false;
	}else{
		if(email.length > 45){
			missatge = missatge+'- El Correu Electrònic inserit és massa gran, ha de contenir un màxim de 45 caràcters! \n \n';
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
	
	if( tasques == null || tasques.length == 0 || /^\s+$/.test(tasques) ) {
		missatge = missatge+'- El camp de les tasques a realitzar per l\'alumne no pot estar buit, és obligatori! \n \n';
		validacio = false;
	}else{
		if(tasques.length > 900){
			missatge = missatge+'- El camp de les tasques a realitzar per l\'alumne és massa gran, ha de contenir un màxim de 900 caràcters! \n \n';
			validacio = false;
		}
	}
	
	//Primer cal comrpovar que s'han introduit dades.
	if(telefon.length > 0){		
		//Si disposa de dades, cal comprovar que siguin del format correcte.
		if( !(/^\d{9}$/.test(telefon)) ) {
			missatge = missatge+'- El número de telèfon introduit no es correcte! \n \n';
			validacio = false;
		}		
	}	
	
	if(direccio.length > 0){
		
		if(/^\s+$/.test(direccio)){
			missatge = missatge+'- Les dades introduides al camp de la direcció, no són vàlides! \n \n';
			validacio = false;
		}else{
			if(direccio.length > 60){
				missatge = missatge+'- La direcció inserida es massa llarga, ha de contenir un màxim de 60 caràcters! \n \n';
				validacio = false;
			}
		}
	}
	
	if(gremi == 0){
		missatge = missatge+'- El gremi introduït no es vàlid, tria un gremi existent! \n \n';
		validacio = false;
	}
	
	if(validacio === false){
		alert(missatge);
	}
	
	return validacio;
}