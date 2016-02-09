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
		<title>Modifica l'estat de l'Alumne - INS Esteve Terradas i Illa </title>
		<link rel="stylesheet" href="style.css" type="text/css" media="screen" />
	</HEAD>
	
	<BODY>
		<div id="wrapper">
			<?php 
				cap(); 
				menu_consultes($usuari);
			?>
			<h1> Modifica l'estat de les FCT dels Alumnes - INS Esteve Terradas i Illa </h1>
			<div id="content">
				<form name='modificaAlumne' id='formulari' action='modificaEstatAlumne.php' method='post' onsubmit=''>
					<div class="entry">
						<h2>Gestiona l'estat actual dels Alumnes:</h2>
						<p>En aquesta taula només apareixeran els alumnes del teu grup <b>que no estiguin cursant</b> ara mateix les FCT. A aquests els hi pots canviar
						el seu estat actual sobre les pràctiques de les FCT.
						Per fer-ho has de triar l'alumne disponible del teu grup que apareix a la taula fent clic al botó de l'inici de cada fila, i finalment
						has de triar el motiu del canvi, aquests són:<br>
						- <b>Pendents de Realitzar</b>: Indica que l'alumne ha de realitzar les FCT.<br>
						- <b>Es Espera de Confirmació</b>: Indica que l'alumne està esperant resposta d'una possible empresa per a fer les FCT.<br>
						- <b>Convalidades</b>: Indica que l'alumne te la exempció total sobre les FCT i no ha de realitzar-les.<br>
						- <b>No les realitza</b>: L'alumne no vol realitzar les FCT.<br>
						- <b>Signada Autorització Enderreriment</b>: L'alumne pot voler deixar de fer les FCT optant per endarrerir-les signant el document oficial.
						<br><br>
						<b><u>Abans de fer clic al botó d'assignar per executar els canvis, verifica visualment que has triat les dades correctes a modificar.</b></u>
						Al fer clic, el programa gestionarà el tràmit automàticament i s'aplicaràn els canvis necessaris. Si has executat alguna cosa
						per error i no pots desfer els canvis mitjançant la resta d'opcions del lloc web, exposa el cas a l'administrador! </p>
						<?php
							$arrayDades = array();
							$arrayDades = modificaEstatsAlumnes($idTutor);
							
							echo "
							<table border='1'>
								<tr>
									<td style='text-align:center;'>Tria la petició</td>
									<td style='text-align:center;'>Nom de l'Alumne</td>
									<td style='text-align:center;'>Cognoms de l'Alumne</td>
									<td style='text-align:center;'>Correu Electrònic</td>
									<td style='text-align:center;'>Telèfon</td>
									<td style='text-align:center;'>Estat FCT</td>
								</tr>"
							;
							
							if($arrayDades){
								foreach($arrayDades as $fila){
									echo "<tr>";
									$index = 0;
									foreach($fila as $valor){
										if($index == 0){
											echo "<td style='text-align:center;'><input type='radio' class='rdButton' name='idAlumne' value='".$valor."'></td>";
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
								Assigna l'estat que vols modificar: 
								<select name='estatPeticions' id='peticions'>
									<option value='10'>Pendents de Realitzar</option>
									<option value='2'>En Espera de Confirmació</option>
									<option value='4'>Convalidades</option>
									<option value='5'>NO les Realitza</option>
									<option value='6'>Signada Autorització Endarreriment</option>
								</select>
								&nbsp; <button class='submit' name='modifica' type='submit'> Assigna </button>"
								;
							}else{
								echo "<tr><td colspan='8'> No tens Alumnes als qui poder canviar l'estat actualment. </td></tr>";
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
							
							if(!empty($_POST["estatPeticions"]) ){
						
								//Hem d'Obtenir el ID de la petició.
								$idAlumne = $_POST["idAlumne"];
								$estatPeticio = $_POST["estatPeticions"];
								
								//Realitzem aquest pas per burlar el empty ja que un possible valor de estatPeticio es 0 i per empty es indicatiu de ser buit
								if($estatPeticio == 10){
									$estatPeticio = 0;
								}
								if($idAlumne > 0){
									$estatPeticioOK = modificaEstatAlumne($idAlumne,$estatPeticio);
									
									if($estatPeticioOK == true){
										echo "<br>Canvi d'estat de l'Alumne s'ha modifict correctament!";
										sleep(3);
										header("Location: modificaEstatAlumne.php");
									}else{
										echo "<br><b>Error: No s'ha pogut modificar l'estat de l'alumne, revisa les dades i/o contacta amb l'administrador.</b>";
									}
								}else{
									echo "<br><b>Error: No s'ha pogut obtenir el valor de l'alumne.</b>";
								}
							}else{
								echo "<br><b>Error: No has fet clic a cap estat, verifica visualment les dades abans de fer clic!</b>";
							}
						}else{
							echo "<br><b>Error: No has fet clic a cap alumne, verifica visualment les dades abans de fer clic!</b>";
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