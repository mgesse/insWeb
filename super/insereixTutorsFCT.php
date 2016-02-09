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
		<title> Inserció Tutors - INS Esteve Terradas i Illa </title>
		<?php menu_consultes($usuari); ?>
		<script src="insereixTutorsFCT.js"> </script>
		<script src="carregaSelect.js"> </script>		
	</HEAD>
	
	<BODY>
		<h1> Inserció Tutors FCT - INS Esteve Terradas i Illa </h1>
			<form name='formulariInserirTutorsFCT' id='formulari' action='insereixTutorsFCT.php' method='post' onsubmit=' return valida();'>
				<h1></h1>
				Els camps marcats amb asterisc (*) són obligatoris! <br>
				
				Nom del Mestre (*): &nbsp; <input type="text" name="nomMestre">	<br><br>
				
				Cognoms del Mestre (*): &nbsp; <input type="text" name="cognomMestre"> <br><br>
				
				Correu Electrònic de contacte (*): &nbsp; <input type="text" name="email"> <br><br>
				
				Telèfon del Mestre (*): &nbsp; <input type="text" name="telefon"> <br><br>
				
				Tipus de Rol del Mestre: (*): &nbsp; 
				<select name='rol'>
					<option value='1'>Tutoria</option>
					<option value='2'>Administració</option>
					<option value='10'>Sense Accés</option>
				</select>  <br><br>
				
				Nom de Pas pel Web del Mestre: &nbsp; <input type="text" name="nomPas"> <br><br>
				
				Clau de Pas pel Web del Mestre: &nbsp; <input type="text" name="clauPas"> <br><br>
				
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
						//echo"<option value='$index'>".$valor."</option>";
						$index = $index + 1;
					}
				?>
				</select>
				<br><br> Filtra el Cicle Formatiu de la petició (*): &nbsp;  
				<select name='cicles' id='cicles'>
					<option value='0'>Sense Especificar</option>
				</select>
				<br><br>
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
				$dades = new dades();				
				//Tractament de les dades
				if(!empty($_POST["nomMestre"])){
					$nomMestre = utf8_decode($_POST["nomMestre"]);					
				}
				if(!empty($_POST["cognomMestre"])){
					//$cognomMestre = utf8_decode($_POST["cognomMestre"]);
					$cognomMestre = utf8_decode($_POST["cognomMestre"]);
				}
				if(!empty($_POST["email"])){
					$email = utf8_decode($_POST["email"]);
				}
				if(!empty($_POST["telefon"])){
					$telefon = utf8_decode($_POST["telefon"]);
				}
				if(!empty($_POST["rol"])){
					$rol = $_POST["rol"];
				}
				if(!empty($_POST["nomPas"])){
					$nomPas = utf8_decode($_POST["nomPas"]);
				}
				if(!empty($_POST["clauPas"])){
					$clauPas = utf8_decode($_POST["clauPas"]);
				}
				if(!empty($_POST["cicles"])){
					$cicle = $_POST["cicles"];
				}				
				
				if($rol == 10){
					$rol = 0;
				}			
				$retorn = false;				
				$idNouMestre = insereixMestre($nomMestre,$cognomMestre,$email,$telefon,$rol,$nomPas,$clauPas,$cicle);
				
				if($idNouMestre > 0){
					//Hem d'assignar la relació entre el mestre acabat de fer i el cicle triat.
					$retorn = insereixRelacioMestreCicle($idNouMestre,$cicle);
				}else{
					echo "<br><br>No s'ha pogut inserir el mestre, contacta amb l'administrador de BBDD. </br></br>";
				}
				
				if($retorn == true){
					echo "<br><br>REGISTRE INSERIT CORRECTAMENT</br></br>";
					sleep(3);
					header("location: insereixTutorsFCT.php");
				}else{
					echo "<br><br>Hi ha hagut algun error.</br></br>";
				}
			}
			?>	
	</BODY>
</HTML>
	<?php
	}
?>