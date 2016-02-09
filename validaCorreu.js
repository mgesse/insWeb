function valida(){
	var emailOrigen = document.formulariCorreuFCT.emailOrigen.value;
	var emailDesti = document.formulariCorreuFCT.emailDesti.value;
	var text = document.formulariCorreuFCT.missatge.value;
	var titol = document.formulariCorreuFCT.titol.value;	
	
	var missatge = '';
	var validacio = true;
	//Controlem que el emailOrigen sigui vàlid.
	
	if( emailOrigen == null || emailOrigen.length == 0 || /^\s+$/.test(emailOrigen) ) {
		missatge = missatge+'- El correu electrònic d\'origen no pot estar buit, és obligatori! \n \n';
		validacio = false;
	}else{		
		//Hem de comprovar que el email disposa d' @
		var expRegCorreu = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		if (!expRegCorreu.test(emailOrigen)){
			missatge = missatge+'- El correu electrònic d\'origen no és vàlid! \n \n';
			validacio = false;
		}		
	}
	
	if( emailDesti == null || emailDesti.length == 0 || /^\s+$/.test(emailDesti) ) {
		missatge = missatge+'- El correu electrònic de destí no pot estar buit, és obligatori! \n \n';
		validacio = false;
	}else{		
		//Hem de comprovar que el email disposa d' @
		var expRegCorreu = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		if (!expRegCorreu.test(emailDesti)){
			missatge = missatge+'- El correu electrònic de destí no és vàlid! \n \n';
			validacio = false;
		}		
	}
	
	if( titol == null || titol.length == 0 || /^\s+$/.test(titol) ){
	  missatge = missatge+'- El títol del correu no pot estar buit, és obligatori! \n \n';
	  validacio = false;
	}else{
		if(titol.length > 80){
			missatge = missatge+'- El títol del correu inserit és massa gran, ha de contenir un màxim de 80 caràcters! \n \n';
			validacio = false;
		}
	}	
	
	if( text == null || text.length == 0 || /^\s+$/.test(text) ) {
		missatge = missatge+'- El camp del missatge no pot estar buit, és obligatori! \n \n';
		validacio = false;
	}
	
	if(validacio === false){
		alert(missatge);
	}
	
	return validacio;
}