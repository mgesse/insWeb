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
		<title> Anul·la les FCT a l'Alumne - INS Esteve Terradas i Illa </title>
		<link rel="stylesheet" href="style.css" type="text/css" media="screen" />
	</HEAD>
	
	<BODY>
		<div id="wrapper">
			<?php 
				cap(); 
				menu_consultes($usuari);
			?>
			<h1> Anul·la les FCT a l'Alumne - INS Esteve Terradas i Illa </h1>
			<div id="content">
				<form name='formulariAnulaAlumnePeticio' id='formulari' action='anulaFCT.php' method='post' onsubmit=''>
					<div class="entry">
						<h2>Anul·lació de l'Alumne a una Empresa d'FCT:</h2>
						<p> Aquí pots indicar que un alumne ha hagut de finalitzar l'estada a l'empresa de les FCT <b>ABANS</b> de la finalització completa
						de les hores establertes al conveni.
						Per fer-ho has de triar l'alumne disponible del teu grup que apareix a la taula fent clic al botó de l'inici de cada fila, i finalment
						has de triar el motiu de l'anul·lació, aquests són:<br>
						- Pendents de Realitzar: Pot donar-se el cas que l'alumne hagi de marxar de l'empresa i ha de cercar empresa novament, els motius de la 
													baixa pot ser voluntari per part de l'alumne, l'empresa el pot acomiadar o fins i tot tancar.<br>
						- No les vol Realitzar: L'alumne pot voler deixar de voler realitzar les FCT en l'empresa actual.<br>
						- Signada Autorització Enderreriment: L'alumne pot voler deixar de fer les FCT i finalment opta per endarrerir-les signant el document oficial.
						<br>
						<b><u>Abans de fer clic al botó d'assignar per executar els canvis, verifica visualment que has triat les dades correctes a modificar.</b></u>
						Al fer clic, el programa gestionarà el tràmit automàticament i s'aplicaràn els canvis necessaris. Si has executat alguna cosa
						per error i no pots desfer els canvis mitjançant la resta d'opcions del lloc web, exposa el cas a l'administrador! </p>
						<?php
							$arrayDades = array();
							$arrayDades = obtenirRelacioAlumFCT_ID($idTutor);
						
							echo "
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
											echo "<td style='text-align:center;'><input type='radio' class='rdButton' name='idAlumne' value='".$valor."'></td>";
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
								
								echo "<br><button class='submit' name='modifica' type='submit'> Assigna </button>";
								echo "&nbsp; <select name='estatPeticions' id='peticions'>
										<option value='0'>Pendents de Realitzar</option>
										<option value='5'>No les vol Realitzar</option>
										<option value='6'>Signada Autorització Endarreriment</option>
										</select>"
								;
							}else{
								echo "<tr><td style='text-align:center;' colspan='8'> No hi ha Peticions de FCT Disponibles per al teu curs </td></tr>";
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
					}else if(isset($_POST["modifica"])){
						if(!empty($_POST["idAlumne"])){				
							if(!empty($_POST["estatPeticions"])){
								$idAlumne = $_POST["idAlumne"];
								$estatPeticio = $_POST["estatPeticions"];
								//Hem d'Obtenir el ID de la petició.
								$idPeticio = getIdPeticio($idAlumne);					
								if($idPeticio > 0){
									$estatAlumneOK = modificaEstatAlumne($idAlumne,$estatPeticio);
									
									if($estatAlumneOK == true){
										$estatPeticioOK = modificaEstatPeticio($idPeticio,4);
										
										if($estatPeticioOK == true){
											echo "<br>Els canvis d'estat de l'alumne i la petició s'han modificat correctament!";
											sleep(3);
											header("Location: anulaFCT.php");
										}else{
											echo "<br><b>Error: No s'ha pogut modificar l'estat de la petició de FCT, contacta amb l'administrador.</b>";
										}
									}else{
										echo "<br><b>Error: No s'ha pogut modificar l'estat de l'alumne, contacta amb l'administrador.</b>";
									}
								}else{
									echo "<br><b>Error: No s'ha pogut obtenir dades de la petició!</b>";
								}
							}else{
								echo "<br><b>Error: No has fet clic a cap estat, verifica visualment les dades abans de fer clic!</b>";
							}
						}else{
							echo "<br><b>Error: No has fet clic a cap alumne en curs, verifica visualment les dades abans de fer clic!</b>";
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