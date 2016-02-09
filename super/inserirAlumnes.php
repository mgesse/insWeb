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
		<title> Inserció d'Alumnes - INS Esteve Terradas i Illa </title>
		<?php menu_consultes($usuari);?>
		<script src="inserirAlumnes.js"> </script>
		<script src="carregaSelect.js"> </script>		
	</HEAD>
	
	<BODY>
		<h1> Inserció Peticions FCT - INS Esteve Terradas i Illa </h1>		
			<form name='formulariInserirAlumnes' id='formulari' action='inserirAlumnes.php' method='post' onsubmit=' return revisaInserirAlumne();false;'>
				<h1></h1>
				Els camps marcats amb asterisc (*) són obligatoris! <br>
				
				Nom de l'Alumne (*): &nbsp; <input type="text" name="nomAlumne"> <br><br>
				
				Cognoms de l'Alumne (*): &nbsp; <input type="text" name="cognomsAlumne"> <br><br>
				
				Correu Electrònic de contacte (*): &nbsp; <input type="text" name="email"> <br><br>
				
				Telèfon de Contacte: &nbsp; <input type="text" name="telefon"> <br><br>
				
				<!-- Part on accedim a la BBDD a rescatar les dades sobre els gremis i CF's  -->
				Tria el gremi (*): &nbsp; 
				<select name='gremis' id='gremis'>
				<?php
					$arrayGremis = array();
					$arrayGremis = getGremis();
					$index = 1;
					echo"<option value='0'>Sense Especificar</option>";
					foreach($arrayGremis as $valor){
						echo "<option value='$index'>".utf8_encode($valor)."</option>";
						$index = $index + 1;
					}
				?>
				</select>
				<br><br> Tria el Cicle Formatiu (*): &nbsp;
				<select name='cicles' id='cicles'>
					<option value='0'>Sense Especificar</option>
				</select>
				<input type="submit" name="Envia" value="Tramet les Dades">
				
				<?php
					if(isset($_POST["Envia"])){
						
						//Un JS que ocultes la part alta del formualri no estaria pas malament!
						
						//Tractament de les dades
						unset($_SESSION['dadesAlumne']);
						$_SESSION["dadesAlumne"][0] = utf8_decode($_POST["nomAlumne"]);
						$_SESSION["dadesAlumne"][1] = utf8_decode($_POST["cognomsAlumne"]);
						$_SESSION["dadesAlumne"][2] = utf8_decode($_POST["email"]);
						$_SESSION["dadesAlumne"][3] = utf8_decode($_POST["telefon"]);
						$_SESSION["dadesAlumne"][4] = $_POST["gremis"];
						$_SESSION["dadesAlumne"][5] = $_POST["cicles"];
					
						//Obtenim la llista de mestres assignat a un curs.
						$arrayMestres = array();
						$arrayMestres = getMestresCurs($_POST["cicles"]);
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
						echo '<br><br><button type="submit" name="tramet" title="Insereix"> Insereix l\'Alumne </button>';
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
			}else if(isset($_POST["tramet"])){				
				$retorn = false;
				$_SESSION["dadesAlumne"][6] = $_POST["tutors"];			
				
				$id = -1;
				if($_POST["tutors"] > 0){
					$retorn = insereixNouAlumne($_SESSION["dadesAlumne"][0],$_SESSION["dadesAlumne"][1],$_SESSION["dadesAlumne"][2],$_SESSION["dadesAlumne"][3],
					$_SESSION["dadesAlumne"][5],$_SESSION["dadesAlumne"][6]);
				}else{
					"<br><br><b>No s'ha pogut obtenir el tutor. </b>";
				}
				unset($_SESSION['dadesAlumne']);
				if($retorn == true){
					echo "<br><br>Alumne afegit correctament</br></br>";
					sleep(3);
					header("Location: inserirAlumnes.php");
				}else{
					echo "<br><br>Hi ha hagut un error!</br></br>";
				}
			}			
			?>	
	</BODY>
</HTML>
	<?php
	}
	ob_end_flush();
?>