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
		<script src="../insertarOfertesBT.js"> </script>
		<script src="carregaSelect.js"> </script>		
	</HEAD>
	
	<BODY>
		<h1> Inserció d'Ofertes a la Borsa de Treball! - INS Esteve Terradas i Illa </h1>
		
			<form name='formulariPeticioFCT' id='formulari' action='insereixPeticioBT.php' method='post' onsubmit='return valida();'>
				<h1></h1>
				Els camps marcats amb asterisc (*) són obligatoris! <br>
				
				NIF (*): &nbsp; <input type="text" name="nif">	<br><br>			
				
				Nom de l'Empresa (*): &nbsp; <input type="text" name="nomEmpresa"> <br><br>				
				
				Correu Electrònic de contacte (*): &nbsp; <input type="text" name="email"> <br><br>
				
				Direcció (*): &nbsp; <input type="text" name="direccio"> <br><br>
				
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
				
				<br><br> Requisits de l'aspirant (*): <br>
				<textarea name="requisits" rows='7' cols='80'> </textarea> <br><br>
			
				Tasques a realitzar per part de l'aspirant: <br>
				<textarea name="tasques" rows='7' cols='80'> </textarea> <br><br>
				
				Telèfon de Contacte: &nbsp; <input type="text" name="telefon"> <br><br>			
				
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
				//
				$dades = new dades();
				
				//Tractament de les dades
				$nif = utf8_decode($_POST["nif"]);
				$nomEmpresa = utf8_decode($_POST["nomEmpresa"]);
				$email = utf8_decode($_POST["email"]);
				$tasques = utf8_decode($_POST["tasques"]);
				$telefon = utf8_decode($_POST["telefon"]);
				$direccio = utf8_decode($_POST["direccio"]);
				$requisits = utf8_decode($_POST["requisits"]);
				$gremi = $_POST["gremis"];
				$cicle = $_POST["cicles"];
				$retorn = false;
				
				//Cal determinar si l'Empresa ja havia aportat dades amb anterioritat.
				$id = comprovaEmpresa_BT($nif,$nomEmpresa);
				
				if($id > 0){
					//Realitzem la petició cridant a la funció.
					$estatPeticio = 0;	//0 Indica que cal validar-la manualment
					$retorn = tramitaPeticio_BT($id, $tasques, $requisits, $direccio, $email, $telefon, $gremi, $cicle);
				}else{
					"<br> <br> No s'ha pogut inserir o validar correctament l'empresa";
				}

				if($retorn == true){
					echo "<br><br> Oferta inserida correctament </br></br>";
					sleep(3);
					header("Location: insereixPeticioBT.php");
				}else{
					echo "<br><br>Hi ha hagut un Error</br></br>";
				}
			}
		?>		
	</BODY>
</HTML>
<?php
	}
?>