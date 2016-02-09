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
		<title> Alumnes - FCT del Centre - INS Esteve Terradas i Illa </title>
		<?php menu_consultes($usuari); ?>
	</HEAD>
	
	<BODY>
		<h1> Alumnes amb FCT de l'Institut - INS Esteve Terradas i Illa </h1>
			<form name='formulariConsultaAlumnesFCT' id='formulari' action='llistaAlumnesFCT.php' method='post' onsubmit=''>
				<h2>Tots els Alumnes del Centre que han iniciat les FCT:</h2>
				<p> Aquí pots trobar la llista d'Alumnes del centre que tenen o han tingut un contracte de FCT. Dispopses de 4 filtres a poder trobar les dades ràpidament.<br>
				- <b>Tots els Alumnes: </b>Surten llistats tots els alumnes del centre que estan adscrits a un grup. <br>
				- <b>Alumnes del Gremi: </b>Surten llistats tots els alumnes que pertanyen a un gremi en concret. Cal triar el gremi al desplegable de sota. <br>
				- <b>Alumnes del Cicle: </b>Surten llistats tots els alumnes que pertanyen a un cicle en concret. Cal triar el cicle al desplegable de sota. <br>
				- <b>Alumnes No Assignats: </b>Surten llistats els alumnes del centre que no estan adscrits a un gremi i/o cicle. <br>
				</p>
				<br>
				
				<table border='1'>
					<tr>
						<td style='text-align:center;' colspan='4'>Tria un tipus de Cerca:</td>
					</tr>
					<tr>
						<td style='text-align:center;'><input type='radio' name='TriaTipusConsulta' value='1'> Tots els Alumnes</td>
						<td style='text-align:center;'><input type='radio' name='TriaTipusConsulta' value='2'> Alumnes del Gremi</td>
						<td style='text-align:center;'><input type='radio' name='TriaTipusConsulta' value='3'> Alumnes del Cicle</td>
						<td style='text-align:center;'><input type='radio' name='TriaTipusConsulta' value='4'> Alumnes No Assignats</td>
					</tr>
					<tr>
						<td style='text-align:center;' colspan='2'>Tria el Gremi:
							<select name='gremis' id='gremis'>
								<option value='0'>Sense Especificar</option>
								<option value='1'>Administració d'Empreses</option>
								<option value='2'>Arts Gràfiques</option>
								<option value='3'>Automoció</option>
								<option value='4'>Informàtica</option>
								<option value='5'>Manteniment Industrial</option>
								<option value='6'>Fabricació Mecànica</option>
							</select>
						</td>
						<td style='text-align:center;' colspan='2'>Tria el Cicle:
							<select name='cicles' id='cicles'>
								<option value='0'>Sense Especificar</option>
								<option value='101'>Gestió Administrativa (CFGM)</option>
								<option value='102'>Secretariat (CFGS)</option>
								<option value='103'>Administració i Finances (CFGS)</option>
								<option value='201'>Preimpressió Digital (CFGM)</option>
								<option value='202'>Disseny i Ed. de Publicacions Imp. i Multi. (CFGS)</option>
								<option value='301'>Electromecànica d'Automòbils (CFGM)</option>
								<option value='401'>Sistemes Microinformàtics i Xarxes (CFGM)</option>
								<option value='402'>Desenvolupament d'Aplicacions Web (CFGS)</option>
								<option value='403'>Desenvolupament d'Aplicacions Multiplataforma (CFGS)</option>
								<option value='404'>Administració de Sistemes Informàtics en la Xarxa (CFGS)</option>
								<option value='501'>Instal·lació i Mant. Electrom. i Conducció de Línies (CFGM)</option>
								<option value='502'>Manteniment d'Equips Industrials (CFGS)</option>
								<option value='503'>Prevenció de Riscos Laborals (CFGS)</option>
								<option value='601'>Mecanització (CFGM)</option>
								<option value='602'>Programació de la Producció en Fabricació Mecànica (CFGS)</option>
							</select>
						</td>
					</tr>
				</table>
				<br>
				<input type='submit' name='consulta' value='Consulta les Dades'>
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
			}else if(isset($_POST["consulta"])){
				$triaTipus = false;
				$gremi = false;
				$cicle = false;
				
				if(!empty($_POST["TriaTipusConsulta"])){
					$triaTipus = $_POST["TriaTipusConsulta"];
				}
				
				if(!empty($_POST["gremis"])){
					$gremi = $_POST["gremis"];
				}
				
				if(!empty($_POST["cicles"])){
					$cicle = $_POST["cicles"];
				}
				
				echo "<br>";
				if($triaTipus != false){
					$arrayDades = array();
					if($triaTipus == 1 || $triaTipus == 4){
						$arrayDades = obtenirAlumnesFCTCentre($triaTipus, false);
					}else if($triaTipus == 2){
						$arrayDades = obtenirAlumnesFCTCentre($triaTipus, $gremi);
					}else if($triaTipus == 3){
						$arrayDades = obtenirAlumnesFCTCentre($triaTipus, $cicle);
					}else{
						$arrayDades = false;
					}			
					
					echo "
					 <table border='1'>
						<tr>
							<td style='text-align:center;'>Nom de l'Alumne</td>
							<td style='text-align:center;'>Correu de l'Alumne</td>
							<td style='text-align:center;'>Estat de les FCT de l'Alumne</td>
							<td style='text-align:center;'>Nom de l'empresa de les FCT</td>
							<td style='text-align:center;'>Cicle Formatiu de l'Alumne</td>
							<td style='text-align:center;'>Nom del Gremi de l'Alumne</td>
							
						</tr>"
					;
					
					if($arrayDades){
						foreach($arrayDades as $fila){
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
					}else{
						echo "<tr><td style='text-align:center;' colspan='9'>No hi ha alumnes per aquesta cerca.</td></td>";
						echo "</table>";
					}
				}else{
					echo "No has fet clic a cap botó de tria!";
				}
			}
		?>
	</BODY>
</HTML>
<?php
	}
ob_end_flush();
?>