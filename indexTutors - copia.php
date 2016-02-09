<?php
	require_once("classeSessions.php");
	include('menu.php');
	include('footer.php');
	$sesion = new sesion();
	$usuari = $sesion->get("NomMestre");
	
	if($usuari == false){	
		header("Location: loginTutors.php");		
		//header("Location: index.php");
		
	}else{
?>
<!DOCTYPE HTML>
<HTML>
	<HEAD>
		<meta charset='utf-8'/>
		<title> Plana d'Inici de les Tutories - INS Esteve Terradas i Illa </title>
		<link rel="stylesheet" href="style.css" type="text/css" media="screen" />
		<!-- <link rel="stylesheet" href="style.css" type="text/css" media="screen" /> -->
		<?php //menu_indexTutors($usuari); ?>
	</HEAD>
	
	<BODY>
		<div id="wrapper">
			<?php
				cap(); 
				menu_indexTutors($usuari);
			
			?>
			<h1> Plana d'Inici de les Tutories - INS Esteve Terradas i Illa </h1>
			<div id="content">
				<form name='formulariIndexTutors' id='formulari' action='indexTutors.php' method='post' onsubmit=''>
					<div class="entry">
						<table border='1'>
							<tr>
								<td style='text-align:center;' colspan='2'><h3>Consulta els Alumnes</h3></td>
							</tr>
							<tr>
								<td style='text-align:center;'> Tots els Alumnes del teu grup: </td>
								<td style='text-align:center;'> <!-- <input type="submit" name="getTutoria" value="Tutoria"> --> 
																<button type='submit' name='getTutoria' class='submit'>Tutoria</button></td>
							</tr>
							<tr>
								<td style='text-align:center;'> Alumnes assignats a una Empresa: </td>
								<td style='text-align:center;'> <!-- <input type="submit" name="llistaAlPe" value="Llista Alumnes - FCT"> -->
																<button type='submit' name='llistaAlPe' class='submit'>Llista Alumnes - FCT</button></td>
							</tr>
							<tr>
								<td style='text-align:center;' colspan='2'><h3>Consulta les Empreses</h3></td>
							</tr>
							<tr>
								<td style='text-align:center;'> Empreses de FCT Disponibles: </td>
								<td style='text-align:center;'> <input type="submit" name="getPeticions" value="Ofertes Disponibles FCT"> </td>
							</tr>
							<tr>
								<td style='text-align:center;'> Estat de la resta d'Empreses de FCT: </td>
								<td style='text-align:center;'> <input type="submit" name="getAltresPeticions" value="Altres Ofertes FCT"> </td>
							</tr>
							<tr>
								<td style='text-align:center;' colspan='2'><h3>Gestió de les FCT dels Alumnes</h3></td>
							</tr>
							<tr>
								<td style='text-align:center;'> Assigna un Alumne a una Empresa d'FCT: </td>
								<td style='text-align:center;'> <input type="submit" name="relacionaAlPe" value="Assigna Alumne a FCT"> </td>
							</tr>
							<tr>
								<td style='text-align:center;'> Finalització de l'Alumne a una Empresa d'FCT: </td>
								<td style='text-align:center;'> <input type="submit" name="finalFCT" value="Finalitza FCT"> </td>
							</tr>
							<tr>
								<td style='text-align:center;'> Anul·lació de l'Alumne a una Empresa d'FCT: </td>
								<td style='text-align:center;'> <input type="submit" name="anulaFCT" value="Anul·la FCT"> </td>
							</tr>
							<tr>
								<td style='text-align:center;' colspan='2'><h3>Gestió dels Alumnes</h3></td>
							</tr>
							<tr>
								<td style='text-align:center;'> Gestiona l'estat actual dels Alumnes: </td>
								<td style='text-align:center;'> <input type="submit" name="modificaEstatAlumne" value="Modifica l'estat Alumne"> </td>
							</tr>
							<tr>
								<td style='text-align:center;' colspan='2'><h3>Gestió de les FCT</h3></td>
							</tr>
							<tr>
								<td style='text-align:center;'> Gestiona l'estat de les peticions d'FCT: </td>
								<td style='text-align:center;'> <input type="submit" name="modificaPeticioFCT" value="Modifica l'estat"> </td>
							</tr>
							<tr>
								<td style='text-align:center;'> Envia correus a les Empreses d'FCT: </td>
								<td style='text-align:center;'> <input type="submit" name="enviaCorreu" value="Enviar un Correu"> </td>
							</tr>
						
						</table>		
					</div>
				</form>
			
				<?php			
					//Validem que ha fet clic
					if(isset($_POST["tancaSessio"])){
						
						$usuario = $sesion->get("NomMestre");	
						$sesion->termina_sesion();	
						header("location: loginTutors.php");
						
					}else if(isset($_POST["getTutoria"])){
						header('Location: consultaTutoria.php');
					}else if(isset($_POST["getPeticions"])){
						header('Location: consultaPeticionsFCT.php');
					}else if(isset($_POST["relacionaAlPe"])){
						header('Location: afegirPetAlu.php');
					}else if(isset($_POST["getAltresPeticions"])){
						header('Location: consultaAltresPeticionsFCT.php');
					}else if(isset($_POST["llistaAlPe"])){
						header('Location: relacioAlumneEmpresa.php');
					}else if(isset($_POST["finalFCT"])){
						header('Location: finalitzacioFCT.php');
					}else if(isset($_POST["anulaFCT"])){
						header('Location: anulaFCT.php');
					}else if(isset($_POST["modificaPeticioFCT"])){
						header('Location: modificaPeticioFCT.php');
					}else if(isset($_POST["modificaEstatAlumne"])){
						header('Location: modificaEstatAlumne.php');
					}else if(isset($_POST["enviaCorreu"])){
						header('Location: enviarCorreuFCT.php');
					}
					
				?>	
			</div>
		</div>
		
	</BODY>
</HTML>
<?php
	}
?>