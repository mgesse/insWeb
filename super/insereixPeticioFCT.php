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
		<title> Inserció Peticions FCT - INS Esteve Terradas i Illa </title>
		<?php menu_consultes($usuari); ?>
		<script src="insertarPeticionsFCT.js"> </script>
		<script src="carregaSelect.js"> </script>		
	</HEAD>
	
	<BODY>
		<h1> Inserció Peticions FCT - INS Esteve Terradas i Illa </h1>		
			<form name='formulariPeticioFCT' id='formulari' action='insereixPeticioFCT.php' method='post' onsubmit=' return valida();'>
				<h1></h1>
				Els camps marcats amb asterisc (*) són obligatoris! <br>
				
				NIF (*): &nbsp; <input type="text" name="nif">	<br><br>
				
				Nom de l'Empresa (*): &nbsp; <input type="text" name="nomEmpresa"> <br><br>
				
				Nom de Contacte (*): &nbsp; <input type="text" name="nomContacte"> <br><br>
				
				Correu Electrònic de contacte (*): &nbsp; <input type="text" name="email"> <br><br>
				
				<!-- Part on accedim a la BBDD a rescatar les dades sobre els gremis i CF's  -->
				Tria l'especialitat de la petició (*): &nbsp; 
				<select name='gremis' id='gremis'>
				<?php
					$arrayGremis = array();
					$arrayGremis = getGremis();
					$index = 1;
					echo"<option value='0'>Sense Especificar</option>";
					foreach($arrayGremis as $valor){
						echo"<option value='$index'>".utf8_encode($valor)."</option>";
						$index = $index + 1;
					}
				?>
				</select>
				<br><br> Filtra el Cicle Formatiu de la petició: &nbsp;
				<select name='cicles' id='cicles'>
					<option value='0'>Sense Especificar</option>
				</select>
				
				<br><br> Quantitat d'Alumnes als que pot anar dirigida l'oferta (*): &nbsp;
				<select name='nombre'>
					<option value='1'>1</option>
					<option value='2'>2</option>
					<option value='3'>3</option>
					<option value='4'>4</option>
					<option value='5'>5</option>
				</select> 
				
				<br><br> Tasques a Realitzar de l alumne (*): <br>
				<textarea name="tasques" rows='7' cols='80'> </textarea> <br><br>
				
				Telèfon de Contacte: &nbsp; <input type="text" name="telefon"> <br><br>
				
				Direcció del centre de treball: &nbsp; 	<input type="text" name="direccio"> <br><br>
				
				<input type="submit" name="Envia" value="Tramet les Dades">
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
			}else if(isset($_POST["Envia"])){
				
				//Tractament de les dades
				$nif = $_POST["nif"];
				$nomEmpresa = utf8_decode($_POST["nomEmpresa"]);
				$nomContacte = utf8_decode($_POST["nomContacte"]);
				$email = utf8_decode($_POST["email"]);
				$tasques = utf8_decode($_POST["tasques"]);
				$telefon = utf8_decode($_POST["telefon"]);
				$direccio = utf8_decode($_POST["direccio"]);	
				$nombre = $_POST["nombre"];
				$gremi = $_POST["gremis"];
				$cicle = $_POST["cicles"];				
				$retorn = false;
				
				//Cal determinar si l'Empresa ja havia aportat dades amb anterioritat.
				$id = comprovaEmpresa($nif,$nomEmpresa);
				
				if($id > 0){					
					do{	//Controlar el nombre de peticions per a alumnes.
						//Realitzem la petició cridant a la funció tantes vegades com peticions hagi triat.
						$estatPeticio = 0;	//0 Indica que cal validar-la manualment. 
						$retorn = tramitaPeticio($id, $estatPeticio, $nomContacte, $email, $tasques, $telefon, $direccio, $gremi, $cicle);
						$nombre = $nombre - 1;
					}while($nombre > 0);					
				}else{
					"<br><br><b>No s'ha pogut inserir o validar l'empresa. </b>";
				}
				
				if($retorn == true){
					echo "<br><br>Petició Inserida correctament</br></br>";
					sleep(3);
					header("Location: insereixPeticioFCT.php");
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