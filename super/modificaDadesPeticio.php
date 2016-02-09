<?php
	ob_start();
	require_once("classeSessions.php");
	include('menuAdmin.php');
	include('dadesServer.php');
	include('funcionsAdmin.php');
	$sesion = new sesion();
	$usuari = $sesion->get("NomMestre");
	$idTutor = $sesion->get("Mestre");
	
	if($usuari == false){
		header("Location: ../loginTutors.php");
	}else{
?>
<!DOCTYPE HTML>
<HTML>
	<HEAD>
		<meta charset='utf-8'/>
		<title>Modifica les dades de les peticions de FCT - INS Esteve Terradas i Illa </title>
		<?php menu_consultes($usuari); ?>
	</HEAD>

	<BODY>
		<h1> Modifica les dades de les peticions de FCT - INS Esteve Terradas i Illa </h1>
			<form name='modificaPeticio' id='formulari' action='modificaDadesPeticio.php' method='post' onsubmit=''>
				<p>En aquesta taula només apareixeran les peticions de FCT assignades al curs triat i <b>que no estiguin sent cursades</b> per un alumne. 
				Aquí podràs canviar l'estat actual de les peticions.
				Per fer-ho, primer has de triar el Cicle Formatiu en Concret per a visualitzar les peticions d'aquest, que un cop triat, 
				apareixeran a la taula on hauras de fer clic al botó de l'inici de cada fila per a modificar la petició desitjada. 
				Finalment has de triar el motiu del canvi, i aquests són:<br>
				- <b>Per Validar</b>: Indica que una petició de FCT s'ha de determinar si es adqueada o no per l'alumnat.<br>
				- <b>Disponible</b>: Indica que la petició de FCT segons els criteris establerts pel professorat es apta per a ser cursada.<br>
				- <b>Anul·lada</b>: Indica que la petició de FCT ha estat anul·lada per diverses raons i no es pot cursar.<br>
				<br><br>
				<b><u>Abans de fer clic al botó d'assignar per executar els canvis, verifica visualment que has triat les dades correctes a modificar.</b></u>
				Al fer clic, el programa gestionarà el tràmit automàticament i s'aplicaràn els canvis necessaris. Si has executat alguna cosa
				per error i no pots desfer els canvis mitjançant la resta d'opcions del lloc web, exposa el cas a l'administrador de BBDD! </p><br><br>
				<select name='cicles' id='cicles'>
					<option value='0'>Sense Especificar</option>
					<option value='101'>Gestió Administrativa (CFGM)</option>
					<option value='102'>Secretariat (CFGS)</option>
					<option value='103'>Administració i Finances (CFGS)</option>
					<option value='201'>Preimpressió Digital (CFGM)</option>
					<option value='202'>Disseny i Ed. de Publicacions Imp. i Multi. (CFGS)</option>
					<option value='301'>Electromecànica d'Automòbils (CFGM)</option>
					<option value='401'>Sistemes Microinformàtics i Xarxes (CFGM)</option>
					<option value='402'>Desenvolupament d'Aplicacions Web (CFGS)</option>
					<option value='403'>Desenvolupament d'Aplicacions Multiplataforma (CFGS)</option>
					<option value='404'>Administració de Sistemes Informàtics en la Xarxa (CFGS)</option>
					<option value='501'>Instal·lació i Mant. Electrom. i Conducció de Línies (CFGM)</option>
					<option value='502'>Manteniment d'Equips Industrials (CFGS)</option>
					<option value='503'>Prevenció de Riscos Laborals (CFGS)</option>
					<option value='601'>Mecanització (CFGM)</option>
					<option value='602'>Programació de la Producció en Fabricació Mecànica (CFGS)</option>
				</select>
				<input type='submit' name='cerca' value='Cerca Peticions Cicle'><br><br>
				
				<?php
				
					if(isset($_POST['cerca'])){
						
						$idCicle = $_POST['cicles'];
						$arrayDades = array();
						
						$arrayDades = obtenirEmpreses_ID($idCicle);
						//print_r($arrayDades);
						
						unset($_SESSION['diccionari']);	//Esborrem la variable de Sessió si n'hi ha.
						
						echo "
						<table border='1'>
							<tr>
								<td style='text-align:center;'>Tria la petició</td>
								<td style='text-align:center;'>Nom de l'Empresa</td>
								<td style='text-align:center;'>Estat de la Petició</td>
								<td style='text-align:center;'>Nom del Contacte</td>
								<td style='text-align:center;'>Correu Electrònic</td>
								<td style='text-align:center;'>Tasques</td>
								<td style='text-align:center;'>Telèfon</td>
							</tr>"
						;
						
						if($arrayDades){
							$valorSelect = -1;		//Servei per a poder atorgar un valor al Select.
							foreach($arrayDades as $fila){
								//print_r($fila);
								echo "<tr>";
								$index = 0;								
								foreach($fila as $valor){
									if($index == 0){
										$_SESSION["diccionari"][] = $valor;	//Desem cada valor dins d'una variable de sessió amb array.
										echo "<td style='text-align:center;'><input type='radio' name='idPeticio' value='".$valorSelect."'></td>";
									}else{
										echo "<td style='text-align:center;'>$valor</td>";
									}
									$index = $index + 1;
								}
								echo "</tr>";
								//ATENCIÓ: El primer valor de 'valorSelect' és -1 ja que el valor 0 s'interpreta com a buit a l'empty.
								//Al inserir el primer valor com a -1, augmentem a 0 el valor per a que continui amb l'assignació correctament.								
								if($valorSelect === -1){
									$valorSelect = 1;
								}else{
									$valorSelect = $valorSelect + 1;
								}
							}
							echo "</table>";
							echo "
							<br>
							Assigna l'estat que vols modificar.
							<select name='estatPeticions' id='peticions'>
								<option value='10'>Per Validar</option>
								<option value='1'>Disponible</option>
								<option value='4'>Anul·lada</option>
							</select>
							<input type='submit' name='modifica' value='Assigna'>"
							;
						}else{
							echo "<tr><td style='text-align:center;' colspan='8'> No hi ha Peticions de FCT que puguis modificar per al teu curs </td></tr>";
							echo "</table>";
						}
					}
				?>				
			</form>
		
		<?php
			//Validem que ha fet clic
			if(isset($_POST["tancaSessio"])){
				$usuario = $sesion->get("NomMestre");
				$sesion->termina_sesion();
				header("location: ../loginTutors.php");
			}else if(isset($_POST["torna"])){
				//Redirigim a la plana web de tria d'opció a l'empresa.
				header('Location: indexAdmin.php');
			}else if(isset($_POST["modifica"])){
				
				if(!empty($_POST["idPeticio"])){
				
					if(!empty($_POST["estatPeticions"])){
						$estatPeticio = $_POST["estatPeticions"];
						//Realitzem aquest pas per burlar el empty ja que un possible valor de estatPeticio es 0 i per empty es indicatiu de ser buit
						if($estatPeticio == 10){
							$estatPeticio = 0;
						}
						
						$index = $_POST["idPeticio"];
						if($index == -1){
							$index = 0;
						}
						
						$idPeticio =  $_SESSION['diccionari'][$index];	//Assignem l'ID de l'alumne desat a l'array accedint a la posició.
						
						if($idPeticio > 0){
							$estatPeticioOK = modificaEstatPeticio($idPeticio,$estatPeticio);
							
							if($estatPeticioOK == true){
								echo "<br>Canvi d'estat de la petició modificada correctament!";
								sleep(3);
								header("Location: modificaPeticioFCT_AD.php");
							}else{
								echo "<br><b>Error: No s'ha pogut modificar l'estat de la petició, revisa les dades i/o contacta amb l'administrador.</b>";
							}
						}else{
							echo "<br><b>Error: No s'ha pogut obtenir dades de la petició!</b>";
						}
					}else{
						echo "<br><b>Error: No has fet clic a cap estat, verifica visualment les dades abans de fer clic!</b>";
					}
				}else{
					echo "<br><b>Error: No has fet clic a cap petició, verifica visualment les dades abans de fer clic!</b>";
				}
			}
		?>		
	</BODY>
</HTML>
<?php
	}
?>