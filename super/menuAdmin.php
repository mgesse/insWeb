<?php
	//Plana Web de PHP que ens permetrà mostrar sense molestar gaire els diferents tipus de Menu que conformen el lloc web.
	
	function menu_indexAdmin($usuari){
		
		echo "
				<form action='' method='post'>
					<div align='left'>
						Benvingut Administrador/a $usuari, tria una acció: <input type='submit' name='tancaSessio' value='Tanca la Sessió'>
					</div>
				</form>
		";
	}
	
	function menu_consultes($usuari){
		
		echo "
				<form action='' method='post'>
					<div align='left'>
						Benvingut $usuari, tria una acció: <input type='submit' name='tancaSessio' value='Tanca la Sessió'>
						<input type='submit' name='torna' value='Enrere'>
					</div>
				</form>
		";
	}
	
	function menuBasic(){
		
		echo "
				<form action='' method='post'>
					<div align='left'>
						Benvingut a la plana de gestió, tria una acció: <input type='submit' name='torna' value='Enrere'>
					</div>
				</form>
		";
		
	}
?>