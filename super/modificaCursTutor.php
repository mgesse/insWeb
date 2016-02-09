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
		<title> Modifica el Curs del Tutor - Professor - FCT del Centre - INS Esteve Terradas i Illa </title>
		<script src="modificaDadesAlumne.js"> </script>
		<?php menu_consultes($usuari); ?>
	</HEAD>
	
	<BODY>
		<h1> Modifica els curs dels Professors - INS Esteve Terradas i Illa </h1>
			<form name='formulariModificarDadesAlumnes' id='formulari' action='modificaCursTutor.php' method='post' onsubmit=''>
				<h2>Modifica l'assignació de Tutories dels Professors i Cursos de l'Institut:</h2>
				<p> Aquí pots trobar la llista de professors del centre. Per a canviar les dades cal triar el professor i li especifiquem a continuació
				a quin Cicle Formatiu l'assignem. Cal tenir en compte que els Cicles Formatius que apareixeràn seran els del mateix gremi que tenia
				assignat el professor respecte el darrer cicle assignat.
				</p>
				<br>
				
				<table border='1'>
					<tr>
						<td style='text-align:center;' colspan='2'>Tria el Professor:
							<select name='mestres' id='mestres'>
								<?php
									unset($_SESSION['diccionari']);	//Esborrem la variable de Sessió si n'hi ha.									
									$arrayMestres = array();		//Obtenir la llista de mestres.
									$arrayMestres = getMestres();
									
									$valorSelect = -1;		//Servei per a poder atorgar un valor al Select.
									foreach($arrayMestres as $fila){
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
								?>
							</select>
						</td>
					</tr>
				</table>
				<br>
				<input type='submit' name='obteMestre' value='Consulta les Dades'>
				<?php
					
					if(isset($_POST["obteMestre"])){
						$idMestre = '';
						
						if(!empty($_POST["mestres"])){
							$index = $_POST["mestres"];	//Recuperem la posició de l'index dins el select on ha fet clic l'usuari.
							if($index == -1){
								$index = 0;
							}
						
							$idMestre = $_SESSION['diccionari'][$index];	//Assignem l'ID de l'alumne desat a l'array accedint a la posició.
							$_SESSION['mestre'] = $idMestre;
							//Obtenim les dades de l'Alumne que voldrem modificar.
							$arrayDadesMestre = array();
							$arrayDadesMestre = getDadesMestreCurs($idMestre);
						
							//Fem la taula
							echo "<table>";
							foreach($arrayDadesMestre as $fila){
								$columna = 0;
								foreach($fila as $valor){
									if($columna == 0){
										$nom = utf8_encode($valor);
									}else if($columna == 1){
										$nom = $nom.' '.utf8_encode($valor);
									}else{
										echo "<tr>";
										echo '<td style="text-align:center;"> Cicle Formtatiu actual del professor/a '.$nom.': '.utf8_encode($valor).'</td>';
										echo "</tr>";
									}
									$columna = $columna + 1;
								}
							}
							echo "</table>";
							echo "<br><br>";
							
							//Hem d'inserir el Select amb els Cicles Formatius. (Cal cercar-los a la BBDD).
							$arrayLlista = array();
							$arrayLlista = getLlistaCiclesPerMestre($idMestre);
							//Posem les dades dins d'un select.
							echo "<select name='cicles' id='cicles'>";
							foreach($arrayLlista as $fila){
								$columna = 0;
								foreach($fila as $valor){
									if($columna == 0){
										$idCicle = $valor;
									}else if($columna == 1){	
										echo "<option value='$idCicle'>".utf8_encode($valor)."</option>";
									}
									$columna = $columna + 1;
								}
							}
							echo "</select><br><br>";
							echo '<button type="submit" name="actualitza" title="Consulta les Dades"> Actualitza les Dades </button>';
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
				
				$idMestre = $_SESSION['mestre'];
				$idCicle = $_POST['cicles'];
				
				unset($_SESSION['diccionari']);
				unset($_SESSION['mestre']);
				
				//Fem les modificacions a la BBDD.
				$resultat = modificaRelacioCursMestre($idMestre, $idCicle);
				
				if($resultat == true){
					echo "<br><br> La Modificació s'ha Realitzat Correctament.";
					header("Location: modificaCursTutor.php");
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