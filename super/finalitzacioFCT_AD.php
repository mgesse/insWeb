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
		<title> Finalització de les FCT de l'Alumne - INS Esteve Terradas i Illa </title>
		<?php menu_consultes($usuari); ?>
	</HEAD>
	
	<BODY>
		<h1> Finalització de les FCT de l'Alumne - INS Esteve Terradas i Illa </h1>
			<form name='formulariFinalAlumnePeticio' id='formulari' action='finalitzacioFCT_AD.php' method='post' onsubmit=''>
				<h2>Finalització de l'Alumne a una Empresa d'FCT:</h2>
				<p> Aquí pots indicar que un alumne ha finalitzat les FCT a l'empresa que te assignada. Per fer-ho has de triar el cicle formatiu de l'alumne 
				, i tot seguit cercar la relació de FCT amb l'Alumne desitjat que apareix a la taula. Caldrà fer clic al botó de l'inici de la fila
				on apareigui l'alumne que volem donar de baixa. <br>
				<b><u>Abans de fer clic al botó d'assignar per executar els canvis, verifica visualment que has triat les dades correctes a modificar.</b></u>
				Al fer clic, el programa gestionarà el tràmit automàticament i s'aplicaràn els canvis necessaris. Si has executat alguna cosa
				per error i no pots desfer els canvis mitjançant la resta d'opcions del lloc web, exposa el cas a l'administrador! </p>
				<br><br> Tria el Cicle Formatiu del grup al que vols assignar l'alumne. <br><br>
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
				<input type='submit' name='cerca' value='Cerca Alumnes Cicle'><br>
				
				
				<?php
					
					if(isset($_POST["cerca"])){
						
						//Obtenim el Cicle Formatiu demanat
						$idCicle = $_POST["cicles"];
						
						//En funció del cicle, hem d'obtenir el gremi al que pertany.
						$idGremi = getIDGremi($idCicle);
						
						//Si no troba gremi.....							Hauriem de fer un if
					
						$arrayDades = array();
						$arrayDades = obtenirRelacioAlumFCT_ID($idCicle);
					
						echo "<br><br>
						<table border='1'>
							<tr>
								<td style='text-align:center;'>Tria l'alumne</td>
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
										echo "<td style='text-align:center;'><input type='radio' name='idAlumne' value='".$valor."'></td>";
									}else if($index == 1){
										$nom = utf8_encode($valor);
									}else if($index == 2){
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
							echo "<br><input type='submit' name='modifica' value='Finalitza les FCT'>";
						}else{
							echo "<tr><td style='text-align:center;' colspan='8'> No hi ha alumnes al teu curs que pugin finalitzar les FCT </td></tr>";
							echo "</table>";
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