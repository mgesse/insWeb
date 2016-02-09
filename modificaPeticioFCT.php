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
		<title>Modifica l'estat de les peticions de FCT - INS Esteve Terradas i Illa </title>
		<link rel="stylesheet" href="style.css" type="text/css" media="screen" />
	</HEAD>

	<BODY>
		<div id="wrapper">
			<?php 
				cap(); 
				menu_consultes($usuari);
			?>
			<h1> Modifica l'estat de les peticions de FCT - INS Esteve Terradas i Illa </h1>
			<div id="content">
				<form name='modificaPeticio' id='formulari' action='modificaPeticioFCT.php' method='post' onsubmit=''>
					<div class="entry">
						<p>En aquesta taula només apareixeran les peticions de FCT assignades al teu curs <b>que no estiguin sent cursades</b> per un alumne. 
						A aquests els hi pots canviar el seu estat actual en funció del que es preveu fer amb la petició.
						Per fer-ho has de triar la petició disponible del teu grup que apareix a la taula fent clic al botó de l'inici de cada fila, i finalment
						has de triar el motiu del canvi, aquests són:<br>
						- <b>Per Validar</b>: Indica que una petició de FCT s'ha de determinar si es adqueada o no per l'alumnat.<br>
						- <b>Disponible</b>: Indica que la petició de FCT segons els criteris establerts pel professorat es apta per a ser cursada.<br>
						- <b>Anul·lada</b>: Indica que la petició de FCT ha estat anul·lada per diverses raons i no es pot cursar.<br>
						<br><br>
						<b><u>Abans de fer clic al botó d'assignar per executar els canvis, verifica visualment que has triat les dades correctes a modificar.</b></u>
						Al fer clic, el programa gestionarà el tràmit automàticament i s'aplicaràn els canvis necessaris. Si has executat alguna cosa
						per error i no pots desfer els canvis mitjançant la resta d'opcions del lloc web, exposa el cas a l'administrador! </p>
						<?php
							$arrayDades = array();
							$arrayDades = obtenirEmpreses_ID($idTutor);
							
							echo "
							<table border='1'>
								<tr>
									<td style='text-align:center;'>Tria la petició</td>
									<td style='text-align:center;'>Nom de l'Empresa</td>
									<td style='text-align:center;'>Estat de la Petició</td>
									<td style='text-align:center;'>Nom del Contacte</td>
									<td style='text-align:center;'>Correu Electrònic</td>
									<td style='text-align:center;'>Tasques</td>
									<td style='text-align:center;'>Telèfon</td>
								</tr>"
							;
							
							if($arrayDades){
								foreach($arrayDades as $fila){
									echo "<tr>";
									$index = 0;
									$nom;
									foreach($fila as $valor){
										if($index == 0){
											echo "<td style='text-align:center;'><input type='radio' class='rdButton' name='idPeticio' value='".$valor."'></td>";
										}else{
											echo "<td style='text-align:center;'>".utf8_encode($valor)."</td>";
										}
										$index = $index + 1;
									}
									echo "</tr>";
								}
								echo "</table>";
								echo "
								<br>
								Assigna l'estat que vols modificar.
								<select name='estatPeticions' id='peticions'>
									<option value='10'>Per Validar</option>
									<option value='1'>Disponible</option>
									<option value='4'>Anul·lada</option>
								</select>
								<button class='submit' name='modifica' type='submit'> Assigna </button>"
								;
							}else{
								echo "<tr><td style='text-align:center;' colspan='8'> No hi ha Peticions de FCT que puguis modificar per al teu curs </td></tr>";
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
						
						if(!empty($_POST["idPeticio"])){
						
							if(!empty($_POST["estatPeticions"])){
								$estatPeticio = $_POST["estatPeticions"];
								//Realitzem aquest pas per burlar el empty ja que un possible valor de estatPeticio es 0 i per empty es indicatiu de ser buit
								if($estatPeticio == 10){
									$estatPeticio = 0;
								}						
								$idPeticio = $_POST["idPeticio"];						
								
								if($idPeticio > 0){
									$estatPeticioOK = modificaEstatPeticio($idPeticio,$estatPeticio);
									
									if($estatPeticioOK == true){
										echo "<br>Canvi d'estat de la petició modificada correctament!";
										sleep(3);
										header("Location: modificaPeticioFCT.php");
									}else{
										echo "<br><b>Error: No s'ha pogut modificar l'estat de la petició, revisa les dades i/o contacta amb l'administrador.</b>";
									}
								}else{
									echo "<br><b>Error: No s'ha pogut obtenir dades de la petició!</b>";
								}
							}else{
								echo "<br><b>Error: No has fet clic a cap estat, verifica visualment les dades abans de fer clic!</b>";
							}
						}else{
							echo "<br><b>Error: No has fet clic a cap petició, verifica visualment les dades abans de fer clic!</b>";
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