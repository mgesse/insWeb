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
		<title> Modifica Professor - FCT del Centre - INS Esteve Terradas i Illa </title>
		<script src="modificaDadesAlumne.js"> </script>
		<?php menu_consultes($usuari); ?>
	</HEAD>
	
	<BODY>
		<h1> Modifica els Professors - INS Esteve Terradas i Illa </h1>
			<form name='formulariModificarDadesAlumnes' id='formulari' action='modificaDadesMestre.php' method='post' onsubmit=''>
				<h2>Modifica les Dades dels Professors de l'Institut:</h2>
				<p> Aquí pots trobar la llista de professors del centre. Per a canviar les dades cal triar el professor i apareixerà una graella amb 
				les dades que poden ser modificades.
				El Nom de Pas i la Clau de Pas corresponen a les credencials d'accés al lloc web. Un cop modificat, fem clic al botó d'actualitzar.
				</p>
				<br>				
				<table border='1'>
					<tr>
						<td style='text-align:center;' colspan='2'>Tria el Professor:
							<select name='mestres' id='mestres'>
								<?php
									unset($_SESSION['diccionari']);	//Esborrem la variable de Sessió si n'hi ha.
									$arrayMestres = array();	//Obtenir la llista de mestres.
									$arrayMestres = getMestres();
									
									$valorSelect = -1;		//Servei per a poder atorgar un valor al Select.
									foreach($arrayMestres as $fila){
										$index = 0;			//Controla la fila que s'extreu de la BBDD.
										$nom;				//Contindrà el nom de l'alumne per concatenar-lo amb el cognom.
										foreach($fila as $valor){
												if($index == 0){
													$_SESSION["diccionari"][] = $valor;	//Desem cada valor dins d'una variable de sessió amb array.
												}else if($index == 1){
													$nom = $valor;
												}else if($index == 2){
													$nom = $nom.' '.$valor;
													echo "<option value='$valorSelect'>".utf8_encode($nom)."</option>";
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
							$_SESSION['alumne'] = $idMestre;
							//Obtenim les dades de l'Alumne que voldrem modificar.
							$arrayDadesMestre = array();
							$arrayDadesMestre = getDadesMestreModificar($idMestre);
							
							echo "<table border='1'>";
							foreach($arrayDadesMestre as $fila){
								$columna = 0;
								foreach($fila as $valor){
									echo "<tr>";
									if($columna === 0){
										echo '
											<td style="text-align:center;"> Nom del Mestre: </td>
											<td style="text-align:center;"> <input type="text" name="nom" value="'.utf8_encode($valor).'"> </td>
										';
									}else if($columna === 1){
										echo '
											<td style="text-align:center;"> Cognom del Mestre: </td>
											<td style="text-align:center;"> <input type="text" name="cognom" value="'.utf8_encode($valor).'"> </td>
											<!-- <td style="text-align:center;"> <input type="text" name="cognom" value="'.$valor.'"> </td> -->
										';
									}else if($columna === 2){
										echo '
											<td style="text-align:center;"> Email del Mestre: </td>
											<td style="text-align:center;"> <input type="text" name="mail" value="'.utf8_encode($valor).'"> </td>
										';
									}else if($columna === 3){
										echo '
											<td style="text-align:center;"> Telèfon del Mestre: </td>
											<td style="text-align:center;"> <input type="text" name="telefon" value="'.utf8_encode($valor).'"> </td>
										';
									}else if($columna === 4){
										echo '
											<td style="text-align:center;"> Nom de Pas pel Web del Mestre: </td>
											<td style="text-align:center;"> <input type="text" name="nomDePas" value="'.utf8_encode($valor).'"> </td>
										';
									}else if($columna === 5){
										echo '
											<td style="text-align:center;"> Clau de Pas pel Web del Mestre: </td>
											<td style="text-align:center;"> <input type="text" name="clauDePas" value="'.utf8_encode($valor).'"> </td>
										';
									}
									
									$columna = $columna + 1;
									echo "</tr>";
								}
							}
							echo "</table>";
							echo '<button onClick="return revisaModificaDadesAlumne()" type="submit" name="actualitza" title="Consulta les Dades"> Actualitza les Dades </button>';
						}
						//echo "<br> ID DE L'ALUMNE: $idAlumne";
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
				$nomDePas;
				$clauDePas;
				$idAlumne = $_SESSION['alumne'];
				
				if(!empty($_POST["nom"])){
					$nomAlumne = utf8_decode($_POST["nom"]);
				}
				if(!empty($_POST["cognom"])){
					$cognomAlumne = utf8_decode($_POST["cognom"]);
				}
				if(!empty($_POST["mail"])){
					$correu = utf8_decode($_POST["mail"]);
				}
				if(!empty($_POST["telefon"])){
					$telefon = utf8_decode($_POST["telefon"]);
				}
				if(!empty($_POST["nomDePas"])){
					$nomDePas = utf8_decode($_POST["nomDePas"]);
				}
				if(!empty($_POST["clauDePas"])){
					$clauDePas = utf8_decode($_POST["clauDePas"]);
				}
				unset($_SESSION['diccionari']);
				unset($_SESSION['alumne']);
				
				//Fem les modificacions a la BBDD.
				$resultat = modificaDadesMestre($idAlumne,$nomAlumne,$cognomAlumne,$correu,$telefon,$nomDePas,$clauDePas);
				
				if($resultat == true){
					echo "<br><br> La Modificació s'ha Realitzat Correctament.";
					header("Location: modificaDadesMestre.php");
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