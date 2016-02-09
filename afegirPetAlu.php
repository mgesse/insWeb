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
		<title> Assignar Alumnes a FCT - INS Esteve Terradas i Illa </title>
		<link rel="stylesheet" href="style.css" type="text/css" media="screen" />
	</HEAD>

	<BODY>
		<div id="wrapper">
			<?php 
				cap(); 
				menu_consultes($usuari);
			?>
			<h1> Assignació d'Alumnes a FCT - INS Esteve Terradas i Illa </h1>
			<div id="content">
				<form name='formulariAfegirAlumnePeticio' id='formulari' action='afegirPetAlu.php' method='post' onsubmit=''>
					<div class="entry">
						<h2>Assigna un Alumne a una Empresa d'FCT:</h2>
						<p>Aquí pots fer l'assignació d'una petició de FCT a un Alumne. Per fer-ho has de triar l'alumne disponible del teu grup que apareix
						al menú desplegable de sota. Per triar la oferta, cal prémer al cercle a l'inici de cada fila de la taula. <br>
						<b><u>Abans de fer clic al botó d'assignar per executar els canvis, verifica visualment que has triat les dades correctes a modificar.</b></u>
						Al fer clic, el programa gestionarà el tràmit automàticament i s'aplicaràn els canvis necessaris. Si has executat alguna cosa
						per error i no pots desfer els canvis mitjançant la resta d'opcions del lloc web, exposa el cas a l'administrador!</p>
						<?php
							$arrayDades = array();
							$arrayDades = obtenirPeticionsFCT($idTutor,1);
							
							echo "
							<table border='1'>
								<tr>
									<td style='text-align:center;'>Tria l'oferta a Assignar</td>
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
										}else{
											echo "<td style='text-align:center;'><input type='radio' class='rdButton' name='triaPeticio' value='".$valor."'></td>";
										}
										$index = $index + 1;
									}
									echo "</tr>";
								}
								echo "</table>";
							}else{
								echo "<tr><td style='text-align:center;' colspan='8'> No hi ha cap oferta vàlida que pugui ser assignada actualment. </td></tr>";
								echo "</table>";
							}
							
							if($arrayDades){
								//obtenim en un select la llista d alumnes disponibles
								$arrayAlumnes = array();
								//1- Obtenim el ID del cicle formatiu al que està assignat el tutor. (CON professorsCicles amb idProf)
								$idCicle = getIdCicleTutor($idTutor);
								
								if($idCicle != false && $idCicle >= 0){
									$arrayAlumnes = getAlumnesDisponibles($idTutor,$idCicle);
								
									if($arrayAlumnes){
										echo "<br> Tria l'Alumne: ";
										echo "<select name='alumnesDisp' id='alumnesDisp'>";
										foreach($arrayAlumnes as $fila){
											$filaID = $fila["idAlumne"];
											$filaNom = utf8_encode($fila["nomAlumne"]).' '.utf8_encode($fila["cognomsAlumne"]);
											echo"<option value='$filaID'>$filaNom</option>";
										}
										echo "</select>";
										
										echo "&nbsp; <button class='submit' name='modifica' type='submit'> Assigna </button>";
									}else{
										echo "<br><b>Error: No s'han pogut obtenir els alumnes del teu grup, o no en disposes d'aquests!</b>";
									}
								}else{
									echo "<b>Error: No s'ha pogut obtenir el Cicle del Tutor </b>";							
								}
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
					}else if(isset($_POST["modifica"])){
						//En curs Directament o Pendents de Confirmació
						$tipusEstat = 1;								//Indica que l'Alumne passarà a estar "En Curs".
						
						if(!empty($_POST["triaPeticio"])){
							
							if(!empty($_POST["alumnesDisp"])){
								//Creem la relació entre l'alumne i la petició.
								$idAlumne = $_POST["alumnesDisp"];
								$idPeticio = $_POST["triaPeticio"];
							
								if($tipusEstat == 1){
									$peticioOK = creaRelacioAlumPet($idAlumne, $idPeticio);	//Cremm la petició relacionada.
									
									if($peticioOK == true){
										$estatAlumneOK = modificaEstatAlumne($idAlumne,$tipusEstat);
									
										if($estatAlumneOK == true){
											$estatPeticioOK = modificaEstatPeticio($idPeticio,2);
										
											if($estatPeticioOK == true){
												echo "<br>Inserció de la Relació i Canvis a l'Alumne i l'Empresa realitzats correctament!<br>Sortint....";
												sleep(3);
												header("Location: afegirPetAlu.php");
											}else{
												echo "<b>Error: No s'ha pogut modificar l'estat de la petició, contacta amb l'administrador!</b>";
											}
										}else{
											echo "<b>Error: No s'ha pogut modificar l'estat de l'alumne, contacta amb l'administrador!</b>";
										}
									}else{
										echo "<b>Error: No s'ha pogut establir la relació entre l'Alumne i la Empresa, revisa les dades i torna a intentar-ho.</b>";
									}
								}else{
									echo "<br><b>Error: El tipus d'estat inserit no es vàlid, verifica visualment les dades abans de fer clic!</b>";
								}
							}else{
								echo "<br><b>Error: No has a cap alumne per assignar, verifica visualment les dades abans de fer clic!</b>";
							}
						}else{
							echo "<br><b>Error: No has fet clic a cap petició de les FTC, verifica visualment les dades abans de fer clic!</b>";
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
<?php
	}
?>