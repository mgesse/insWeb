<?php
	ob_start();
	require_once("classeSessions.php");
	include('menu.php');
	include('footer.php');
	include('funcionsTutoria.php');
	include 'dadesServer.php';
	$sesion = new sesion();
?>
<!DOCTYPE HTML>
<HTML>
	<HEAD>
		<meta charset='utf-8'/>
		<title> Plana d'Inici de les Tutories - INS Esteve Terradas i Illa </title>
		<link rel="stylesheet" href="style.css" type="text/css" media="screen" />		
	</HEAD>	
	<BODY>		
		<div id="wrapper">
			<?php 
				cap(); 
				menuBasic();
			?>
			
			<h1> Accés per als Tutors - INS Esteve Terradas i Illa </h1>
			
			<div id="content">
				<form name='formulariLogin' id='formulari' action='loginTutors.php' method='post' onsubmit=''>
					<div class="entry">
						<h2>Introdueix les credencials d'accés!</h2>
						
						<p> Assegura't d'introduïr les dades correctes per validar la sessió.</p>
						Nom d'Usuari: <input type="text" name="username"> <br> <br>
						Clau de Pas: <input type="text" name="clau"> <br> <br>
						<button class="submit" name="valida" type="submit"> Connecta! </button>
						<!-- <input type="submit" name="valida" value="Connecta!"> -->
					</div>
				</form>
	
				<?php			
					//Validem que ha fet clic
					if(isset($_POST["valida"])){
						echo "Hola!";
						//Redirigm a la plana de login per als tutors.
						//header('Location: insertarPeticionsFCT.php');
						$usuari = $_POST["username"];
						$password = $_POST["clau"];
						
						//En funció de si es ADMN o Tutor, anirà a una plana o altre
						$dadesArray = array();
						$dadesArray = validaUsuari($usuari,$password);
						$index = 0;
						if($dadesArray[0] == true){
							
							//1- ID del Mestre
							$sesion->set("Mestre",$dadesArray[1]);
							
							//2- Nom i Cognom del Mestre
							$sesion->set("NomMestre",$dadesArray[2]);
							
							//3- Tipus de Rol del Mestre.
							$sesion->set("RolMestre",$dadesArray[3]);
							
							if($dadesArray[3] == 1){
								header("location: indexTutors.php");
							}else if($dadesArray[3] == 2){
								header("location: super/indexAdmin.php");
							}else{
								//Accés Invàlid, retorna a l'inici.
								echo "Login incorrete, no disposes d'accés al sistema!";
							}
						}else{
							echo "Login incorrete, varifica les dades inntroduides!";
						}
					}
				?>
			</div>
		</div>
		<?php
			footer();
		?>
	</BODY>
</HTML>