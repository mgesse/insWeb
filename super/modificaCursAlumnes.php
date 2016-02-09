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
		<title> Modifica el Curs de l'alumne - FCT del Centre - INS Esteve Terradas i Illa </title>
		<script src="modificaDadesAlumne.js"> </script>
		<?php menu_consultes($usuari); ?>
	</HEAD>
	
	<BODY>
		<h1> Modifica el curs de l'alumne - INS Esteve Terradas i Illa </h1>
			<form name='formulariModificarDadesAlumnes' id='formulari' action='modificaCursAlumnes.php' method='post' onsubmit=''>
				<h2>Modifica les Dades de Matricula de l'Alumne:</h2>
				<p> Aquí pots trobar la llista de alumnes del centre. Disposes de 2 filtres a poder trobar les dades ràpidament.<br>
				- <b>Alumnes del Cicle: </b>Surten llistats tots els alumnes que pertanyen a un cicle en concret. Cal triar el cicle al desplegable de sota. <br>
				- <b>Alumnes No Assignats: </b>Surten llistats els alumnes del centre que no estan adscrits a un gremi i/o cicle. <br>
				</p>
				Apareixerà la llista d'alumnes del Cicle Formatiu triat i caldrà seleccionar l'alumne a modificar les dades. Fet això sortirà una graella
				amb les dades de la matricula de l'Alumne (Nom, CF i Tutor) que tingui actualment. <br>
				<b> Per a realitzar el canvis cal triar primer a quin Cicle Formatiu l'assignem des de la llista desplegable i validar les dades </b>. 
				Fet això, sortirà un nou desplegable amb el (o els) tutor(s) que hi hagi assignats al grup triat. <b> Cal triar el tutor i fer clic
				al botó d'actualitzar! </b>
				<br><br>
				
				<table border='1'>
					<tr>
						<td style='text-align:center;' colspan='4'>Tria un tipus de Cerca:</td>
					</tr>
					<tr>
						<td style='text-align:center;'><input type='radio' name='TriaTipusConsulta' value='3'> Alumnes del Cicle</td>
						<td style='text-align:center;'><input type='radio' name='TriaTipusConsulta' value='4'> Alumnes No Assignats</td>
					</tr>
					<tr>
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
						//Hem d'obtenir els alumnes del curs o opció que ha demanat.
						$triaTipus = false;
						$cicle = false;
						unset($_SESSION['diccionari']);
						
						if(!empty($_POST["TriaTipusConsulta"])){
							$triaTipus = $_POST["TriaTipusConsulta"];
						}
						
						if(!empty($_POST["cicles"])){
							$cicle = $_POST["cicles"];
						}
						
						echo "<br><br>";
						if($triaTipus != false){
							$arrayDades = array();
							if($triaTipus == 4){
								$arrayDades = obtenirAlumnesCentre_ID($triaTipus, false);
							}else if($triaTipus == 3){
								$arrayDades = obtenirAlumnesCentre_ID($triaTipus, $cicle);
							}else{
								$arrayDades = false;
							}
					
							if($arrayDades){
								echo "<select name='alumnes' id='alumnes'>";
								$valorSelect = -1;		//Servei per a poder atorgar un valor al Select.
								foreach($arrayDades as $fila){
									$index = 0;			//Controla la fila que s'extreu de la BBDD.
									$nom;				//Contindrà el nom de l'alumne per concatenar-lo amb el cognom.
									foreach($fila as $valor){
											if($index == 0){												
												$_SESSION["diccionari"][] = $valor;	//Desem cada valor dins d'una variable de sessió amb array.
											}else if($index == 1){
												$nom = utf8_encode($valor);
											}else if($index == 2){
												$nom = $nom.' '.utf8_encode($valor);
												echo "<option value='$valorSelect'>$nom</option>";
											}
										$index = $index + 1;
									}
									
									//ATENCIÓ: El primer valor de 'valorSelect' és -1 ja que el valor 0 s'interpreta com a buit a l'empty.
									//Al inserir el primer valor com a -1, augmentem a 0 el valor per a que continui amb l'assignació correctament.									
									if($valorSelect === -1){
										$valorSelect = 1;
									}else{
										$valorSelect = $valorSelect + 1;
									}
								}
								echo "</select>";
								echo "<br><br><input type='submit' name='obteAlumne' value='Tria l Alumne'>";
							}else{
								echo "<br><b>No hi ha alumnes per aquesta cerca.</b>";
							}
						}else{
							echo "<br><b>No has fet clic a cap botó de tria!</b>";
						}
					}
					
					if(isset($_POST["obteAlumne"])){
						$idAlumne = '';
						
						if(!empty($_POST["alumnes"])){
							$index = $_POST["alumnes"];	//Recuperem la posició de l'index dins el select on ha fet clic l'usuari.
							if($index == -1){
								$index = 0;
							}
							
							$idAlumne = $_SESSION['diccionari'][$index];	//Assignem l'ID de l'alumne desat a l'array accedint a la posició.
							$_SESSION['alumne'] = $idAlumne;
							//Obtenim les dades de l'Alumne que voldrem modificar.
							$arrayDadesAlumne = array();
							$arrayDadesAlumne = getDadesRelacioAlumneModificar($idAlumne);
							
							//Fem la taula
							echo "<br><br> Dades Actuals de l'Alumne! <br><br>";
							echo "<table border='1'>";
							foreach($arrayDadesAlumne as $fila){
								$columna = 0;
								foreach($fila as $valor){
									echo "<tr>";
									if($columna === 0){
										$nom = utf8_encode($valor);
									}else if($columna === 1){
										$nom = $nom.' '.utf8_encode($valor);
										echo '<td style="text-align:center;"> Nom de l\'Alumne: </td>
											  <td style="text-align:center;"> '.$nom.' </td>';
									}else if($columna === 2){
										echo '
											<td style="text-align:center;"> Cicle Formatiu Actual: </td>
											<td style="text-align:center;"> '.utf8_encode($valor).' </td>
										';
									}else if($columna === 3){
										$tutor = utf8_encode($valor);
									}else if($columna === 4){
										$tutor = $tutor.' '.utf8_encode($valor);
										echo '
											<td style="text-align:center;"> Nom del Tutor Assignat: </td>
											<td style="text-align:center;"> '.$tutor.' </td>
										';
									}
									$columna = $columna + 1;
									echo "</tr>";
								}
							}
							echo "</table><br><br>";
							
							echo "Tira el Cicle Formatiu al que vols assignar l'alumne: ";
							echo "
							<select name='cicles2' id='cicles2'>
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
							</select>";
							
							echo "Valida el Cicle: ";							
							echo '<button type="submit" name="obteMestres" title="Valida les Dades"> Valida les Dades </button>';							
						}
					}
					
					if(isset($_POST["obteMestres"])){
						$idAlumne = '';
						$idCicle = $_POST['cicles2'];
						
						$_SESSION['cicle'] = $idCicle;
						//Obtenim la llista de mestres assignat a un curs.
						$arrayMestres = array();
						$arrayMestres = getMestresCurs($idCicle);
						echo "<br><br> Tria el Tutor Assignat del Grup: ";
						echo "<select name='tutors' id='tutors'>";
						foreach($arrayMestres as $fila){
							$columnes = 0;
							
							foreach($fila as $valor){
								if($columnes == 0){
									$idMestre = $valor;
								}else if($columnes == 1){
									$nom = utf8_encode($valor);
								}else if($columnes == 2){
									$nom = $nom.' '.utf8_encode($valor);
									echo '<option value='.$idMestre.'>'.$nom.'</option>';
								}
								$columnes = $columnes + 1;
							}
						}
						echo "</select>";						
						unset($_SESSION['diccionari']);		//Esborrem la variable de sessió.
						echo '<br><br><button type="submit" name="actualitza" title="Consulta les Dades"> Actualitza les Dades </button>';
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
			}else if(isset($_POST["actualitza"])){
				
				$idMestre = $_POST['tutors'];
				$idAlumne = $_SESSION['alumne'];
				$idCicle = $_SESSION['cicle'];
				
				//Borrem Sessions 
				unset($_SESSION['diccionari']);
				unset($_SESSION['tutors']);
				unset($_SESSION['alumne']);
				unset($_SESSION['cicle']);
			
				//Fem les modificacions a la BBDD.
				$resultat = modificaRelacioCursAlumne($idMestre, $idCicle, $idAlumne);
				
				if($resultat == true){
					echo "<br><br> La Modificació s'ha Realitzat Correctament.";
					sleep(3);
					header("Location: modificaCursAlumnes.php");
				}else{
					echo "<br><b> ERROR: No s'han pogut modificar les dades, revisa-les o contacta amb l'adminidtrador.";
				}
			}
		?>
	</BODY>
</HTML>
<?php
	}
ob_end_flush();
?>