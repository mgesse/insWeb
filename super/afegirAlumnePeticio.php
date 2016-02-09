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
		<title> Assignar Alumnes a FCT - INS Esteve Terradas i Illa </title>
		<?php menu_consultes($usuari); ?>
	</HEAD>

	<BODY>
		<h1> Assignació d'Alumnes a FCT - INS Esteve Terradas i Illa </h1>
			<form name='formulariAfegirAlumnePeticio' id='formulari' action='afegirAlumnePeticio.php' method='post' onsubmit=''>
				<h2>Assigna un Alumne a una Empresa d'FCT:</h2>
				<p>Aquí pots fer l'assignació d'una petició de FCT a un Alumne. Primer cal que facis la tria del Cicle Formatiu del que vols fer el tràmit
				i fer-hi clic. Si el cicle disposa de peticions, apareixerà la llista d'aquestes a sota. Hauràs de fer clic al cercle que apareix
				a l'inici de cada línia per triar la petició desitjada. Tot seguit cal triar l'alumne del cicle formatiu al que voldrem assignar
				la petició de FCT.<br>
				<b><u>Abans de fer clic al botó d'assignar per executar els canvis, verifica visualment que has triat les dades correctes a modificar.</b></u>
				Al fer clic, el programa gestionarà el tràmit automàticament i s'aplicaràn els canvis necessaris. Si has executat alguna cosa
				per error i no pots desfer els canvis mitjançant la resta d'opcions del lloc web, exposa el cas a l'administrador!</p>
				<br><br> Tria el Cicle Formatiu del grup al que vols assignar l'alumne. <br><br>
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
				<input type='submit' name='cerca' value='Cerca Alumnes Cicle'><br>
				<?php
					
					if(isset($_POST["cerca"])){
						
						//Obtenim el Cicle Formatiu demanat
						$idCicle = $_POST["cicles"];
						
						//En funció del cicle, hem d'obtenir el gremi al que pertany.
						$idGremi = getIDGremi($idCicle);
						
						//Si no troba gremi..... (caldria fer un if)
						
						$arrayDades = array();
						$arrayDades = obtenirPeticionsDisponibles($idGremi, $idCicle);
						
						echo "
						<br>
						<table border='1'>
							<tr>
								<td style='text-align:center;'>Tria l'oferta a Assignar</td>
								<td style='text-align:center;'>Nom de l'Empresa</td>
								<td style='text-align:center;'>Estat de la oferta</td>
								<td style='text-align:center;'>Nom del Contacte</td>
								<td style='text-align:center;'>Correu Electrònic Empresa</td>
								<td style='text-align:center;'>Tasques</td>
								<td style='text-align:center;'>Telèfon</td>
								<td style='text-align:center;'>Direcció</td>
							</tr>"
						;
					
						if($arrayDades){
							foreach($arrayDades as $fila){
								echo "<tr>";
								$index = 0;		
								foreach($fila as $valor){
									if($index != 0){
										echo "<td style='text-align:center;'>".utf8_encode($valor)."</td>";
									}else{
										echo "<td style='text-align:center;'><input type='radio' name='triaPeticio' value='".$valor."'></td>";
									}
									$index = $index + 1;
								}
								echo "</tr>";
							}
							echo "</table>";
						}else{
							echo "<tr><td style='text-align:center;' colspan='8'> No hi ha cap oferta vàlida que pugui ser assignada actualment. </td></tr>";
							echo "</table>";
						}
					
						if($arrayDades){
							//obtenim en un select la llista d alumnes disponibles
							$arrayAlumnes = array();
							
							if($idCicle != false && $idCicle >= 0){
								$arrayAlumnes = getAlumnesDisponibles($idCicle);
							
								if($arrayAlumnes){
									echo "<br> Tria l'Alumne: ";
									echo "<select name='alumnesDisp' id='alumnesDisp'>";
									foreach($arrayAlumnes as $fila){
										$filaID = $fila["idAlumne"];
										$filaNom = utf8_encode($fila["nomAlumne"]).' '.utf8_encode($fila["cognomsAlumne"]);
										echo"<option value='$filaID'>$filaNom</option>";
									}
									echo "</select>";
									
									echo "&nbsp; <input type='submit' name='modifica' value='Assigna'>";									
								}else{
									echo "<br><b>Error: No s'han pogut obtenir els alumnes del grup cercat, o no en disposes d'aquests!</b>";
								}
							}else{
								echo "<b>Error: No s'ha pogut obtenir el Cicle del Curs especificat </b>";
							}
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
				header("Location: indexAdmin.php");
			}else if(isset($_POST["modifica"])){
				//En curs Directament o Pendents de Confirmació
				$tipusEstat = 1;								//Indica que l'Alumne passarà a estar "En Curs".
				
				if(!empty($_POST["triaPeticio"])){
					
					if(!empty($_POST["alumnesDisp"])){
						//Creem la relació entre l'alumne i la petició.
						$idAlumne = $_POST["alumnesDisp"];
						$idPeticio = $_POST["triaPeticio"];
					
						if($tipusEstat == 1){
							$peticioOK = creaRelacioAlumPet($idAlumne, $idPeticio);	//Cremm la petició relacionada.
							
							if($peticioOK == true){
								$estatAlumneOK = modificaEstatAlumne($idAlumne,$tipusEstat);
							
								if($estatAlumneOK == true){
									$estatPeticioOK = modificaEstatPeticio($idPeticio,2);
								
									if($estatPeticioOK == true){
										echo "<br>Inserció de la Relació i Canvis a l'Alumne i l'Empresa realitzats correctament!<br>Sortint....";
										sleep(3);
										header("Location: afegirAlumnePeticio.php");
									}else{
										echo "<b>Error: No s'ha pogut modificar l'estat de la petició, contacta amb l'administrador!</b>";
									}
								}else{
									echo "<b>Error: No s'ha pogut modificar l'estat de l'alumne, contacta amb l'administrador!</b>";
								}
							}else{
								echo "<b>Error: No s'ha pogut establir la relació entre l'Alumne i la Empresa, revisa les dades i torna a intentar-ho.</b>";
							}							
						}else{
							echo "<br><b>Error: El tipus d'estat inserit no es vàlid, verifica visualment les dades abans de fer clic!</b>";
						}
					}else{
						echo "<br><b>Error: No has triat cap alumne per assignar, verifica visualment les dades abans de fer clic!</b>";
					}
				}else{
					echo "<br><b>Error: No has fet clic a cap petició de les FTC, verifica visualment les dades abans de fer clic!</b>";
				}
			}
		?>
	</BODY>
</HTML>
<?php
	}
?>