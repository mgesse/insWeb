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
		<title> Inserir Empresa - INS Esteve Terradas i Illa </title>
		<?php menu_consultes($usuari); ?>
		<script src="insertarPeticionsFCT.js"> </script>
	</HEAD>
	
	<BODY>
		<h1> Inserció d'una Empresa - INS Esteve Terradas i Illa </h1>		
			<form name='formulariPeticioFCT' id='formulari' action='novaEmpresa.php' method='post' onsubmit=' return valida();'>
				<h1></h1>
				Els camps marcats amb asterisc (*) són obligatoris! <br>
				
				NIF (*): &nbsp; <input type="text" name="nif">	<br><br>
				
				Nom de l'Empresa (*): &nbsp; <input type="text" name="nomEmpresa"> <br><br>
				
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
				$nif = $_POST["nif"];
				$nomEmpresa = $_POST["nomEmpresa"];
				
				$retorn = false;
				
				//Cal determinar si l'Empresa ja havia aportat dades amb anterioritat.
				$id = comprovaEmpresa($nif,$nomEmpresa);
				
				if($id > 0){					
					echo "<br><br>Empresa Registrada Correctament</br></br>";
					sleep(3);
					header('Location: novaEmpresa.php');
				}else{
					echo "<br> L'Empresa que vols inserir ja existeix, revisa les dades.";
				}			
			}			
			?>
	</BODY>
</HTML>
	<?php
	}
?>