<?php
	//Plana Web de PHP que ens permetrà mostrar sense molestar gaire els diferents tipus de Menu que conformen el lloc web.
	
	function cap(){
		echo '<div id="header"></div>';
	}
	
	//Només per la pàgina d'index.
	function menuInicial(){
		echo '<div id="menu">
				<ul>
					<li>Benvingut Usuari:  </li>
					<li><button class="boton"><a href="loginTutors.php">Tutoria</a></button></li>						
				</ul>
			</div>';
	}
	
	function menu_indexTutors($usuari){
		
		echo "<div id='menu'>
				<form action='' method='post'>
					<ul>
						<li>Benvingut/da $usuari, tria una acció: </li>
						<li><button type='submit' name='tancaSessio' class='boton'>Tanca la Sessió</button></li>					
					</ul>
				</form>
			</div>";
	}
	
	function menu_consultes($usuari){
		echo "<div id='menu'>
				<form action='' method='post'>
					<ul>
						<li>Benvingut/da $usuari, tria una acció: </li>
						<li><button type='submit' name='tancaSessio' class='boton'>Tanca la Sessió</button></li>
						<li><button type='submit' name='torna' class='boton'>Enrere</button></li>
					</ul>
				</form>
			</div>";		
	}
	
	function menuBasic(){
		
		echo '<div id="menu">
				<ul>
					<li>Benvingut Usuari:  </li>
					<li><button class="boton"><a href="index.php">Enrere</a></button></li>						
				</ul>
			</div>';
		
	}
?>