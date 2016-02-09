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
		<title> Modifica Alumnes - FCT del Centre - INS Esteve Terradas i Illa </title>
		<script src="modificaDadesAlumne.js"> </script>
		<?php menu_consultes($usuari); ?>
	</HEAD>
	
	<BODY>
		<h1> Modifica Alumnes de l'Institut - INS Esteve Terradas i Illa </h1>
			<form name='formulariModificarDadesAlumnes' id='formulari' action='modificaDadesAlumne.php' method='post' onsubmit=''>
				<h2>Modifica les Dades dels Alumnes de l'Institut:</h2>
				<p> Aquí pots trobar la llista d'Alumnes del centre que tenen o han tingut un contracte de FCT. Dispopses de 2 filtres per a poder trobar les dades ràpidament.<br>
				- <b>Alumnes del Cicle: </b>Surten llistats tots els alumnes que pertanyen a un cicle en concret. Cal triar el cicle al desplegable de sota. <br>
				- <b>Alumnes No Assignats: </b>Surten llistats els alumnes del centre que no estan adscrits a un gremi i/o cicle. <br>
				Apareixerà la llista d'alumnes de la cerca triada, de la llista cal triar l'alumne que volem modificar i fer clic al botó de "tria l'alumne". <br>
				Fet això sortirà una taula amb els camps que poden ser modificats, en acabat desem les dades al botó corresponent.				
				</p>				
				<br>				
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
							$arrayDadesAlumne = getDadesAlumneModificar($idAlumne);
							
							echo "<br><br><table border='1'>";
							foreach($arrayDadesAlumne as $fila){
								$columna = 0;
								foreach($fila as $valor){
									echo "<tr>";
									if($columna === 0){
										echo '
											<td style="text-align:center;"> Nom de l\'Alumne: </td>
											<td style="text-align:center;"> <input type="text" name="nom" value="'.utf8_encode($valor).'"> </td>
										';
									}else if($columna === 1){
										echo '
											<td style="text-align:center;"> Cognom de l\'Alumne: </td>
											<td style="text-align:center;"> <input type="text" name="cognom" value="'.utf8_encode($valor).'"> </td>
										';
									}else if($columna === 2){
										echo '
											<td style="text-align:center;"> Email de l\'Alumne: </td>
											<td style="text-align:center;"> <input type="text" name="mail" value="'.utf8_encode($valor).'"> </td>
										';
									}else if($columna === 3){
										echo '
											<td style="text-align:center;"> Telèfon de l\'Alumne: </td>
											<td style="text-align:center;"> <input type="text" name="telefon" value="'.utf8_encode($valor).'"> </td>
										';
									}
									$columna = $columna + 1;
									echo "</tr>";
								}
							}
							echo "</table>";
							echo '<br><button onClick="return revisaModificaDadesAlumne()" type="submit" name="actualitza" title="Consulta les Dades"> Actualitza les Dades </button>';
						}						
						unset($_SESSION['diccionari']);		//Esborrem la variable de sessió.
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
				$nomAlumne;
				$cognomAlumne;
				$correu;
				$telefon;
				$idAlumne = $_SESSION['alumne'];
				
				if(!empty($_POST["nom"])){
					$nomAlumne = $_POST["nom"];
				}
				if(!empty($_POST["cognom"])){
					$cognomAlumne = $_POST["cognom"];
				}
				if(!empty($_POST["mail"])){
					$correu = $_POST["mail"];
				}
				if(!empty($_POST["telefon"])){
					$telefon = $_POST["telefon"];
				}
				unset($_SESSION['diccionari']);
				unset($_SESSION['alumne']);
				
				//Fem les modificacions a la BBDD.
				$resultat = modificaDadesAlumne($idAlumne, utf8_decode($nomAlumne),utf8_decode($cognomAlumne),utf8_decode($correu),utf8_decode($telefon));
				
				if($resultat == true){
					echo "<br><br> La Modificació s'ha Realitzat Correctament.";
					sleep(3);
					header("Location: modificaDadesAlumne.php");
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