function revisaInserirAlumne(){
	var nom = document.formulariInserirAlumnes.nomAlumne.value;
	var cognom = document.formulariInserirAlumnes.cognomsAlumne.value;
	var email = document.formulariInserirAlumnes.email.value;
	var telefon = document.formulariInserirAlumnes.telefon.value;
	var gremis = document.formulariInserirAlumnes.gremis.value;
	var cicles = document.formulariInserirAlumnes.cicles.value;
	
	var missatge = '';
	var validacio = true;
	
	if( nom == null || nom.length == 0 || /^\s+$/.test(nom)){
	  missatge = missatge+'- El camp del Nom de l\'alumne no pot estar buit, és obligatori! \n \n';
	  validacio = false;
	}else{
		if(nom.length > 25){
			missatge = missatge+'- El Nom de l\'alumne inserit és massa gran, ha de contenir un màxim de 25 caràcters! \n \n';
			validacio = false;
		}
	}
	
	if( cognom == null || cognom.length == 0 || /^\s+$/.test(cognom)){
	  missatge = missatge+'- El camp del cognom de l\'alumne no pot estar buit, és obligatori! \n \n';
	  validacio = false;
	}else{
		if(cognom.length > 60){
			missatge = missatge+'- El cognom de l\'alumne inserit és massa gran, ha de contenir un màxim de 60 caràcters! \n \n';
			validacio = false;
		}
	}
	
	if( email == null || email.length == 0 || /^\s+$/.test(email) ) {
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
	
	if(telefon.length > 0){		
		//Si disposa de dades, cal comprovar que siguin del format correcte.
		if( !(/^\d{9}$/.test(telefon)) ) {
			missatge = missatge+'- El número de telèfon introduit no es correcte! \n \n';
			validacio = false;
		}		
	}
	
	if(gremis < 1){
		missatge = missatge+'- Has de triar un gremi per a la petició, és obligatori! \n \n';
		validacio = false;
	}
	
	if(cicles < 1){
		missatge = missatge+'- Has de triar un gremi per a la petició, és obligatori! \n \n';
		validacio = false;
	}
	
	if(validacio === false){
		alert(missatge);
	}
	
	return validacio;
}