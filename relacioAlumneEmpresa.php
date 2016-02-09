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
		<title> Consulta les ofertes de FCT - INS Esteve Terradas i Illa </title>
		<link rel="stylesheet" href="style.css" type="text/css" media="screen" />
	</HEAD>
	
	<BODY>
		<div id="wrapper">
			<?php 
				//menu_consultes($usuari); 
				cap(); 
				menu_consultes($usuari);
			?>
			<h1> Relació Petició FCT amb l'Alumne - INS Esteve Terradas i Illa </h1>
			<div id="content">
				<form name='formulariAlumneEmpresa' id='formulari' action='relacioAlumneEmpresa.php' method='post' onsubmit=''>
					<div class="entry">
						<h2>Alumnes assignats a una Empresa:</h2>
						<p>En aquesta taula hi trobaràs els alumnes que han estat assignats a una empresa d'FCT.
						A la taula hi consta els noms de l'Alumne i l'Empresa i l'estat actual de la l'alumne a la Empresa.</p>
						
						<?php
							$arrayDades = array();
							$arrayDades = obtenirRelacioAlumFCT($idTutor);
							//print_r($arrayDades);
							
							echo "
							<table border='1' style='margin: 0 auto;'>
								<tr>
									<td style='text-align:center;'>Nom de l'Alumne</td>
									<td style='text-align:center;'>Estat de les FCT</td>
									<td style='text-align:center;'>Nom de l'Empresa</td>
								</tr>"
							;
							
							if($arrayDades){
								foreach($arrayDades as $fila){
									echo "<tr>";
									$index = 0;
									$nom;
									foreach($fila as $valor){
										if($index == 0){
											$nom = utf8_encode($valor);
										}else if($index == 1){
											$nom = $nom.' '.utf8_encode($valor);
											echo "<td style='text-align:center;'>$nom</td>";
										}else{
											echo "<td style='text-align:center;'>".utf8_encode($valor)."</td>";
										}
										$index = $index + 1;
									}
									echo "</tr>";
								}
								echo "</table>";
							}else{
								echo "<tr><td colspan='8'> No hi ha cap alumne del teu curs que hagi realitzat les FCT. </td></tr>";
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
						header("Location: indexTutors.php");
					}
				?>	
			</div>
		</div>
		<?php
			footer();
		?>
	</BODY>
</HTML>
<?php
	}
?>