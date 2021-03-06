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
		<title> Eliminar Oferta de Treball - INS Esteve Terradas i Illa </title>
		<?php menu_consultes($usuari); ?>
	</HEAD>
	
	<BODY>
		<h1> Eliminar Oferta de Treball - INS Esteve Terradas i Illa </h1>
			<form name='formulariFinalAlumnePeticio' id='formulari' action='finalitzacioFCT_AD.php' method='post' onsubmit=''>
				<p> Aquí pots trobar la llistat d'Ofertes de Treball que hagin arribat a la Base de Dades. Dispopses de 4 filtres a poder trobar les dades ràpidament.<br>
				- <b>Totes les Ofertes: </b>Surten llistats totes les peticions del centre que estan adscrites a un grup. <br>
				- <b>Ofertes d'un Gremi: </b>Surten llistats totes les peticions que pertanyen a un gremi en concret. Cal triar el gremi al desplegable de sota. <br>
				- <b>Ofertes d'un Cicle: </b>Surten llistats totes les peticions que pertanyen a un cicle en concret. Cal triar el cicle al desplegable de sota. <br>
				- <b>Ofertes No Assignades: </b>Surten llistats les peticions que no són adscrites a cap gremi i/o cicle. <br>
				</p>
				<br>				
				<table border='1'>
					<tr>
						<td style='text-align:center;' colspan='4'>Tria un tipus de Cerca:</td>
					</tr>
					<tr>
						<td style='text-align:center;'><input type='radio' name='TriaTipusConsulta' value='1'> Tots les Ofertes</td>
						<td style='text-align:center;'><input type='radio' name='TriaTipusConsulta' value='2'> Ofertes d'un Gremi</td>
						<td style='text-align:center;'><input type='radio' name='TriaTipusConsulta' value='3'> Ofertes d'un Cicle</td>
						<td style='text-align:center;'><input type='radio' name='TriaTipusConsulta' value='4'> Ofertes No Assignades</td>
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
				<input type='submit' name='cerca' value='Cerca les Peticions'><br>
				<?php
					//Validem que ha fet clic
					if(isset($_POST["consulta"])){
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
							if($triaTipus == 1){
								$sql = "SELECT ot.idOferta, em.nomEmpresa, em.NIF, ot.email, ot.tasques, ot.requisits, ot.direccio, ot.telefon, cf.nomCicle, gr.nomGremi
										FROM ofertesBT as ot
										INNER JOIN Empresa AS em ON ot.idEmpresa = em.idEmpresa
										INNER JOIN ofertesCicles AS oc ON ot.idOferta = oc.idOferta
										INNER JOIN ciclesFormatius AS cf ON oc.idCicle = cf.idCicle
										INNER JOIN gremis AS gr ON oc.idGremi = gr.idGremi
										ORDER BY (oc.idCicle);";
								$arrayDades = obtenirOfertesCentre($triaTipus, false, $sql);
							}else if($triaTipus == 2){
								$sql = "SELECT ot.idOferta, em.nomEmpresa, em.NIF, ot.email, ot.tasques, ot.requisits, ot.direccio, ot.telefon, cf.nomCicle, gr.nomGremi
										FROM ofertesBT as ot
										INNER JOIN Empresa AS em ON ot.idEmpresa = em.idEmpresa
										INNER JOIN ofertesCicles AS oc ON ot.idOferta = oc.idOferta
										INNER JOIN ciclesFormatius AS cf ON oc.idCicle = cf.idCicle
										INNER JOIN gremis AS gr ON oc.idGremi = gr.idGremi
										WHERE oc.idGremi = ? ORDER BY (oc.idCicle);";
								$arrayDades = obtenirOfertesCentre($triaTipus, $gremi, $sql);
							}else if($triaTipus == 3){
								$sql = "SELECT ot.idOferta, em.nomEmpresa, em.NIF, ot.email, ot.tasques, ot.requisits, ot.direccio, ot.telefon, cf.nomCicle, gr.nomGremi
										FROM ofertesBT as ot
										INNER JOIN Empresa AS em ON ot.idEmpresa = em.idEmpresa
										INNER JOIN ofertesCicles AS oc ON ot.idOferta = oc.idOferta
										INNER JOIN ciclesFormatius AS cf ON oc.idCicle = cf.idCicle
										INNER JOIN gremis AS gr ON oc.idGremi = gr.idGremi
										WHERE oc.idCicle = ? ORDER BY (oc.idCicle);";
								$arrayDades = obtenirOfertesCentre($triaTipus, $cicle, $sql);
							}else if($triaTipus == 4){
								$sql = "SELECT ot.idOferta, em.nomEmpresa, em.NIF, ot.email, ot.tasques, ot.requisits, ot.direccio, ot.telefon, cf.nomCicle, gr.nomGremi
										FROM ofertesBT as ot
										INNER JOIN Empresa AS em ON ot.idEmpresa = em.idEmpresa
										INNER JOIN ofertesCicles AS oc ON ot.idOferta = oc.idOferta
										INNER JOIN ciclesFormatius AS cf ON oc.idCicle = cf.idCicle
										INNER JOIN gremis AS gr ON oc.idGremi = gr.idGremi
										WHERE (oc.idGremi = 0 OR oc.idCicle = 0) ORDER BY (oc.idCicle);";
								$arrayDades = obtenirOfertesCentre($triaTipus, $cicle, $sql);
							}else{
								$arrayDades = false;
							}
							
							echo "
							 <table border='1'>
								<tr>
									<td style='text-align:center;'>Nom de l'Empresa</td>
									<td style='text-align:center;'>Estat de la Petició</td>
									<td style='text-align:center;'>Nom del Contacte</td>
									<td style='text-align:center;'>Correu Electrònic</td>
									<td style='text-align:center;'>Tasques</td>
									<td style='text-align:center;'>Telèfon</td>
									<td style='text-align:center;'>Direcció</td>
									<td style='text-align:center;'>Cicle Formatiu de la Petició</td>
									<td style='text-align:center;'>Gremi de la Petició</td>
								</tr>"
							;
							
							if($arrayDades){
								foreach($arrayDades as $fila){
									echo "<tr>";
									$index = 0;
									foreach($fila as $valor){
										if($index == 0){
											echo "<td style='text-align:center;'><input type='radio' name='idOferta' value='".$valor."'></td>";
										}else{
											echo "<td style='text-align:center;'>".utf8_encode($valor)."</td>";
										}
									}
									echo "</tr>";
								}	/// Ho hem deixat per aquí. 
							}else{
								echo "<tr><td style='text-align:center;' colspan='9'>No hi ha peticions per aquesta cerca.</td></td>";
								echo "</table>";
							}
						}else{
							echo "No has fet clic a cap botó de tria!";
						}
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
				header("Location: indexAdmin.php");
			}else if(isset($_POST["modifica"])){
				
				if(!empty($_POST["idAlumne"])){
					//Obtenim l'ID de l'alumne.
					$idAlumne = $_POST["idAlumne"];
				
					//Hem d'Obtenir el ID de la petició.
					$idPeticio = getIdPeticio($idAlumne);
				
					if($idPeticio > 0){
						$estatAlumneOK = modificaEstatAlumne($idAlumne,3);
						
						if($estatAlumneOK == true){
							$estatPeticioOK = modificaEstatPeticio($idPeticio,3);
						
							if($estatPeticioOK == true){
								echo "<br>Els canvis d'estat de l'alumne i la petició s'han modificat correctament!";
								sleep(3);
								header("Location: finalitzacioFCT_AD.php");
							}else{
								echo "<br><b>Error: No s'ha pogut modificar l'estat de la petició de FCT, contacta amb l'administrador.</b>";
							}
						}else{
							echo "<br><b>Error: No s'ha pogut modificar l'estat de l'alumne, contacta amb l'administrador.</b>";
						}
					}else{
						echo "<br><b>Error: No s'ha pogut obtenir la petició de FCT requerida.</b>";
					}
				}else{
					echo "<br><b>Error: No has fet clic a cap alumne en curs, verifica visualment les dades abans de fer clic!</b>";
				}
			}
		?>
	</BODY>
</HTML>
<?php
	}
?>