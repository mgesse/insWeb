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
		<title> Baixa Alumne - INS Esteve Terradas i Illa </title>
		<?php menu_consultes($usuari); ?>
	</HEAD>
	
	<BODY>
		<h1> Formulari de Baixes d'Alumnes. - INS Esteve Terradas i Illa </h1>
			<form name='formulariConsultaAlumnes' id='formulari' action='baixaAlumne.php' method='post' onsubmit=''>
				<h2>Tots els Alumnes del Centre:</h2>
				<p> Aquí pots trobar la llista d'Alumnes del centre. Dispopses de 4 filtres a poder trobar les dades ràpidament.<br>
				- <b>Tots els Alumnes: </b>Surten llistats tots els alumnes del centre que estan adscrits a un grup. <br>
				- <b>Alumnes del Gremi: </b>Surten llistats tots els alumnes que pertanyen a un gremi en concret. Cal triar el gremi al desplegable de sota. <br>
				- <b>Alumnes del Cicle: </b>Surten llistats tots els alumnes que pertanyen a un cicle en concret. Cal triar el cicle al desplegable de sota. <br>
				- <b>Alumnes No Assignats: </b>Surten llistats els alumnes del centre que no estan adscrits a un gremi i/o cicle. <br>
				</p>
				<br>
				
				<table border='1'>
					<tr>
						<td style='text-align:center;' colspan='4'>Tria un tipus de Cerca:</td>
					</tr>
					<tr>
						<td style='text-align:center;'><input type='radio' name='TriaTipusConsulta' value='1'> Tots els Alumnes</td>
						<td style='text-align:center;'><input type='radio' name='TriaTipusConsulta' value='2'> Alumnes del Gremi</td>
						<td style='text-align:center;'><input type='radio' name='TriaTipusConsulta' value='3'> Alumnes del Cicle</td>
						<td style='text-align:center;'><input type='radio' name='TriaTipusConsulta' value='4'> Alumnes No Assignats</td>
					</tr>
					<tr>
						<td style='text-align:center;' colspan='2'>Tria el Gremi:
							<select name='gremis' id='gremis'>
								<option value='0'>Sense Especificar</option>
								<option value='1'>Administració d'Empreses</option>
								<option value='2'>Arts Gràfiques</option>
								<option value='3'>Automoció</option>
								<option value='4'>Informàtica</option>
								<option value='5'>Manteniment Industrial</option>
								<option value='6'>Fabricació Mecànica</option>
							</select>
						</td>
						<td style='text-align:center;' colspan='2'>Tria el Cicle:
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
						</td>
					</tr>				
				</table>
				<br>
				<input type='submit' name='consulta' value='Consulta les Dades'>
				
				<?php
					if(isset($_POST["consulta"])){
						$triaTipus = false;
						$gremi = false;
						$cicle = false;
				
						unset($_SESSION['diccionari']);	//Esborrem la variable de Sessió si n'hi ha.	
					
						if(!empty($_POST["TriaTipusConsulta"])){
							$triaTipus = $_POST["TriaTipusConsulta"];
						}
						
						if(!empty($_POST["gremis"])){
							$gremi = $_POST["gremis"];
						}
						
						if(!empty($_POST["cicles"])){
							$cicle = $_POST["cicles"];
						}
					
						echo "<br>";
						if($triaTipus != false){
							$arrayDades = array();
							if($triaTipus == 1 || $triaTipus == 4){
								$arrayDades = obtenirAlumnesCentreBaixa($triaTipus, false);
							}else if($triaTipus == 2){
								$arrayDades = obtenirAlumnesCentreBaixa($triaTipus, $gremi);
							}else if($triaTipus == 3){
								$arrayDades = obtenirAlumnesCentreBaixa($triaTipus, $cicle);
							}else{
								$arrayDades = false;
							}							
							echo "
							 <table border='1'>
								<tr>
									<td style='text-align:center'>Tria l'Alumne</td>
									<td style='text-align:center;'>Nom de l'Alumne</td>
									<td style='text-align:center;'>Correu de l'Alumne</td>
									<td style='text-align:center;'>Telèfon de l'Alumne</td>
									<td style='text-align:center;'>Estat de les FCT de l'Alumne</td>
									<td style='text-align:center;'>Cicle Formatiu de l'Alumne</td>
									<td style='text-align:center;'>Nom del Gremi de l'Alumne</td>
								</tr>"
							;
						
							if($arrayDades){
								$valorID = -1;	//La usem com a Índex per a convertir aquest Index al ID corresponent.
								foreach($arrayDades as $fila){
									echo "<tr>";
									$index = 0;
									$nom;
									foreach($fila as $valor){
										if($index == 0){
											$_SESSION["diccionari"][] = $valor;	//Desem cada valor dins d'una variable de sessió amb array.
											echo "<td style='text-align:center;'><input type='radio' name='triaAlumne' value='".$valorID."'></td>";
										}else if($index == 1){
											$nom = $valor;
										}else if($index == 2){
											$nom = $nom.' '.$valor;
											echo "<td style='text-align:center;'>".utf8_encode($nom)."</td>";
										}else{
											echo "<td style='text-align:center;'>".utf8_encode($valor)."</td>";
										}
										$index = $index + 1;
									}
									
									if($valorID == -1){
										$valorID = 1;
									}else{
										$valorID = $valorID + 1;										
									}
									echo "</tr>";
								}
							}else{
								echo "<tr><td style='text-align:center;' colspan='6'>No hi ha alumnes per aquesta cerca.</td></td>";
							}
							echo "</table><br>";
							echo "<b>L'alumne a eliminar continuarà el curs vinent en el mateix o un altre cicle formatiu? <br>";
							echo "<input type='radio' name='continua' value='0'> Sí <input type='radio' name='continua' value='1'> No <br></b>";
							echo "<input type='submit' name='baixa' value='Dona l de Baixa'>";
						}else{
							echo "No has fet clic a cap botó de tria!";
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
			}else if(isset($_POST["baixa"])){
				//Recuperem via POST el valor del RadioButton.
				if(!empty($_POST["triaAlumne"])){
					$valor = $_POST["triaAlumne"];	//Index que ens permetrà trobar l'ID.
					if($valor == -1){
						$valor = 0;
					}
					
					$continua = $_POST["continua"];
					$idAlumne = $_SESSION["diccionari"][$valor];				
					
					//echo "<b> L'ID de l'Alumne és: $idAlumne </b>";
					
					//Procediment de Baixa d'un Alumne.
					$arrayDades = array();
					$arrayDades = getDadesAlumneTransferencia($idAlumne);
					
					if($arrayDades != false){
						//Procedim a la Inserció de les dades a la nova taula.
						foreach($arrayDades as $fila){							
							$index = 0;
							foreach($fila as $valor){
								switch($index){
									case 0: $nomAlumne = utf8_encode($valor);
											break;
									case 1: //$cognomAlumne = utf8_encode($valor);
											$cognomAlumne = $valor;
											break;
									case 2: $email = utf8_encode($valor);
											break;
									case 3: $telefon = utf8_encode($valor);
											break;
									case 4: $cicleFormatiu = $valor;
											break;
								}
								$index = $index + 1;
							}
						}
						//Hem de comprovar abans que NO existeix cap alumne amb l'ID especificat.
						$idExalumne = comprovaExistenciaAlumne($idAlumne);
						
						//Si retorna fals, indica que no hi ha hagut coincidència, i per tant s'ha de crear el registre. Cas contrari, ha de fer la relació.
						if($idExalumne == false){
							$idExalumne = setNouExalumne($idAlumne,utf8_decode($nomAlumne),$cognomAlumne,$email,$telefon);							
						}
						
						if($idExalumne != false){
							$relacioOK = setRelacioExAlumneCicle($idExalumne, $cicleFormatiu);							
							if($relacioOK != false){
								
								//Abans cal determinar si l'alumne ha tingut contracte en FCT.
								$comprovaRel = comprovaExistenciaRelacioAlumneFCT($idAlumne);
								if($comprovaRel > 0){	//Eliminem relacions ja que en te d'assignades.
									$deleteRelacioOk = eliminaAlumnePeticio($idAlumne);
								}else if($comprovaRel == 0){	//Posem a cert la variable de control per a poder continuar tot i no tenir FCT assignades.
									$deleteRelacioOk = true;
								}								
								
								if($deleteRelacioOk != false){
									//A partir d'aquí, hauriem de decidir si eliminar l'alumne del curs actual o no.
									if($continua == 1){	//Si es 1, eborrem permanentment l'alumne.
										$deleteAlumneOk = eliminaAlumne($idAlumne);
										if($deleteAlumneOk != false){
											sleep(3);
											header('Location: baixaAlumne.php');
										}else{
											echo "<b>ERROR: No s'han pogut esborrar el ja Exalumne $nomAlumne $cognomAlumne!";
										}
									}else if($continua == 0){ // Si es 0, mantenim l'alumne però li assignem un CF sense especificar a la espera de la confirmació.
										$canviCicleOK = resetCicle($idAlumne);
										if($canviCicleOK == true){
											echo "Canvi de Cicle realitzat correctament";
											sleep(3);
											header('Location: baixaAlumne.php');
										}else{
											echo "<br>Error: No s'han pogut canviar les dades del curs de l'alumne!!";
										}
									}
								}else{
									echo "<b>ERROR: No s'han pogut esborrar les relacions de FCT de l'Exalumne $nomAlumne $cognomAlumne!";
								}
							}else{
								echo "<b>ERROR: No s'ha pogut establir la relació amb el Cicle Formatiu de l'Exalumne $nomAlumne $cognomAlumne!";
							}							
						}else{
							echo "<b>ERROR: No s'ha pogut realitzar la conversió a ExAlumne de l'Alumne $nomAlumne $cognomAlumne!";
						}						
					}					
				}else{
					echo "<b>ERROR: No has fet clic a cap alumne!</b>";
				}			
				unset($_SESSION["diccionari"]);
			}
		?>
	</BODY>
</HTML>
<?php
	}
ob_end_flush();
?>