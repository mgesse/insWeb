var peticio = null;
function inicialitza_xhr(){
	if(window.XMLHttpRequest){
		return new XMLHttpRequest();
	}else if(window.ActiveXObject){
		return new ActiveXObject("Microsoft.XMLHTTP");
	}	
}

/* Mostra Gremis m'ho salto, no ho veig d'utilitat  */

function carregaCicles(){
	var llista = document.getElementById("gremis");
	//var llista = document.getElementById("cicles2");
	
	var gremis = llista.options[llista.selectedIndex].value;
	//alert("Nom del gremi: "+gremis);
	if(!isNaN(gremis)){
		peticio = inicialitza_xhr();
		if(peticio){
			peticio.onreadystatechange = mostraCicles;
			peticio.open("POST", "http://localhost/WebGestio/carregaCiclesJSON.php?nocache=" + Math.random(), true);
			peticio.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
			peticio.send("gremi="+gremis);
		}		
	}
}

function mostraCicles(){
	if(peticio.readyState == 4){
		if(peticio.status == 200){
			var llista = document.getElementById("cicles");
			var cicles = eval('('+peticio.responseText+')');
			llista.options.length = 0;
			var i=0;
			for(var codi in cicles){
				llista.options[i] = new Option(cicles[codi],codi);
				i++;
			}
		}
	}
}

window.onload = function() {
	document.getElementById("gremis").onchange = carregaCicles;
	/*var lista = document.getElementById("cicles");
	var gre = lista.options[lista.selectedIndex].value;
	alert("Nom del cicle: "+gre);*/
	//document.getElementById("cicles2").onchange = carregaCicles;
}