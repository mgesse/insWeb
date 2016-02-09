<?php
	@ob_start("ob_gzhandler");
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
			<h1> Consulta les Ofertes Disponibles de FCT - INS Esteve Terradas i Illa </h1>
			<div id="content">
				<form name='formulariConsultaOfertes' id='formulari' action='consultaPeticionsFCT.php' method='post' onsubmit=''>
					<div class="entry">
						<h2>Empreses de FCT Disponibles:</h2>
						<p>En aquesta taula podràs trobar el llsitat de peticions d'ofertes d'empreses per a desenvolupar les 
						FCT. En aquesta només apareixen a nivell informatiu les ofertes vàlides que poden assignar-se actualment
						als alumnes del teu grup.</p>
						<?php
							$arrayDades = array();
							$arrayDades = obtenirPeticionsFCT($idTutor,1);
						
							echo "
								<table border='1'>
									<tr>
										<td style='text-align:center;'>Nom de l'Empresa</td>
										<td style='text-align:center;'>Estat de la oferta</td>
										<td style='text-align:center;'>Nom del Contacte</td>
										<td style='text-align:center;'>Correu Electrònic Empresa</td>
										<td style='text-align:center;'>Tasques</td>
										<td style='text-align:center;'>Telèfon</td>
										<td style='text-align:center;'>Direcció</td>
									</tr>"
							;
							if($arrayDades){
								foreach($arrayDades as $fila){
									echo "<tr>";
									$index = 0;
									foreach($fila as $valor){
										if($index != 0){
											echo "<td style='text-align:center;'>".utf8_encode($valor)."</td>";
										}
										$index = $index + 1;
									}
									echo "</tr>";
								}
							}else{
								echo "<tr><td style='text-align:center;' colspan='7'> No hi ha cap oferta vàlida actualment. </td></tr>";
							}
							echo "</table>";
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
						header('Location: indexTutors.php');
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