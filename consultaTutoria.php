<?php
	ob_start();
	require_once("classeSessions.php");
	include('menu.php');
	include('footer.php');
	include('dadesServer.php');
	include('funcionsTutoria.php');
	$sesion = new sesion();
	$usuari = $sesion->get("NomMestre");
	$idTutor = $sesion->get("Mestre");
	
	if($usuari == false){	
		header("Location: loginTutors.php");		
	}else{
?>
<!DOCTYPE HTML>
<HTML>
	<HEAD>
		<meta charset='utf-8'/>
		<title> Consulta la Tutoria - INS Esteve Terradas i Illa </title>
		<link rel="stylesheet" href="style.css" type="text/css" media="screen" />
	</HEAD>
	
	<BODY>
		<div id="wrapper">
			<?php 
				cap(); 
				menu_consultes($usuari);
			?>
			<h1> Plana d'Inici de les Tutories - INS Esteve Terradas i Illa </h1>
			<div id="content">
				<form name='formulariConsultaTutoria' id='formulari' action='consultaTutoria.php' method='post' onsubmit=''>
					<div class="entry">
						<h2>Tots els Alumnes del teu grup:</h2>
						<p> A la taula apareixen tots els alumnes que pertanyen al teu grup, amb les dades bàsiques de contacte i l'estat actual 
						de les seves FCT.</p>
						<br>
						<?php
							$arrayDades = array();
							$arrayDades = obtenirAlumnesTutoria($idTutor);
							//print_r($arrayDades);
							
							echo "
							 <table border='1' style='margin: 0 auto;'>
								<tr>
									<td style='text-align:center;'>Nom de l'Alumne</td>
									<td style='text-align:center;'>Correu de l'Alumne</td>
									<td style='text-align:center;'>Telèfon de l'Alumne</td>
									<td style='text-align:center;'>Estat de les FCT de l'Alumne</td>
								</tr>"
							;
							
							if($arrayDades){
								foreach($arrayDades as $fila){
									//print_r($fila);
									echo "<tr>";
									$index = 0;
									$nom;
									foreach($fila as $valor){
										if($index != 0){
											if($index == 1){
												$nom = utf8_encode($valor);
											}else if($index == 2){
												$nom = $nom.' '.utf8_encode($valor);
												echo "<td style='text-align:center;'>$nom</td>";
											}
											if($index != 1 && $index != 2){
												echo "<td style='text-align:center;'>".utf8_encode($valor)."</td>";
											}
										}
										$index = $index + 1;
									}
									echo "</tr>";									
								}
								echo "</table>";
							}else{
								echo "<tr><td style='text-align:center;' colspan='4'>No hi ha alumnes assignats al teu grup.</td></td>";
								echo "</table>";
							}
						?>
					</div>
				</form>		
				<?php
					//Validem que ha fet clic
					if(isset($_POST["tancaSessio"])){			
						$usuario = $sesion->get("NomMestre");
						$sesion->termina_sesion();
						header("location: loginTutors.php");
					
					}else if(isset($_POST["torna"])){
						//Redirigim a la plana web de tria d'opció a l'empresa.
						header('Location: indexTutors.php');
					}
				?>
			</DIV>
		</div>
		<?php
			footer();
		?>
	</BODY>
</HTML>
<?php
	}
ob_end_flush();
?>