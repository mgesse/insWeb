<?php
	ob_start();
	require_once("classeSessions.php");
	include('menu.php');
	include('footer.php');
	$sesion = new sesion();
	$usuari = $sesion->get("NomMestre");
	
	if($usuari == false){	
		header("Location: loginTutors.php");
	}else{
?>
<!DOCTYPE HTML>
<HTML>
	<HEAD>
		<meta charset='utf-8'/>
		<title> Plana d'Inici de les Tutories - INS Esteve Terradas i Illa </title>
		<link rel="stylesheet" href="style.css" type="text/css" media="screen" />		
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
						<table border='0' style="margin: 0 auto;">
							<tr>
								<td style='text-align:center;' colspan='6'><h3>Consulta els Alumnes</h3></td>
								
							</tr>
							<tr>
								<td style='text-align:center;' colspan='3' width="50%"> Tots els Alumnes del teu grup: </td>
								<td style='text-align:center;' colspan='3' width="50%"> Alumnes assignats a una Empresa: </td>								
							</tr>
							<tr>
								<td style='text-align:center;' colspan='3' width="50%"> <button type='submit' name='getTutoria' class='submit'>Tutoria</button></td>
								<td style='text-align:center;' colspan='3' width="50%"> <button type='submit' name='llistaAlPe' class='submit'>Llista Alumnes - FCT</button></td>
							</tr>
							<tr>
								<td style='text-align:center;' height="20px" colspan='1'></td>								
							</tr>
							<tr>
								<td style='text-align:center;' colspan='6' width="100%"><h3>Consulta les Empreses</h3></td>
							</tr>
							<tr>
								<td style='text-align:center;' colspan='3' width="50%"> Empreses de FCT Disponibles: </td>
								<td style='text-align:center;' colspan='3' width="50%"> Estat de la resta d'Empreses de FCT: </td>
							</tr>
							<tr>
								<td style='text-align:center;' colspan='3' width="50%"> <button type='submit' name='getPeticions' class='submit'>Ofertes Disponibles FCT</button></td>
								<td style='text-align:center;' colspan='3' width="50%"> <button type='submit' name='getAltresPeticions' class='submit'>Altres Ofertes FCT</button></td>
							</tr>
							<tr>
								<td style='text-align:center;' height="20px" colspan='1'></td>								
							</tr>
							<tr>
								<td style='text-align:center;' colspan='6'><h3>Gestió de les FCT dels Alumnes</h3></td>
							</tr>
							<tr>
								<td style='text-align:center;' colspan='2'> Assigna un Alumne a una Empresa d'FCT: </td>
								<td style='text-align:center;' colspan='2'> Finalització de l'Alumne a una Empresa d'FCT: </td>
								<td style='text-align:center;' colspan='2'> Anul·lació de l'Alumne a una Empresa d'FCT: </td>
							</tr>
							<tr>			
								<td style='text-align:center;' colspan='2'> <button type='submit' name='relacionaAlPe' class='submit'>Assigna Alumne a FCT</button> </td>
								<td style='text-align:center;' colspan='2'> <button type='submit' name='finalFCT' class='submit'>Finalitza FCT</button> </td>
								<td style='text-align:center;' colspan='2'> <button type='submit' name='anulaFCT' class='submit'>Anul·la FCT</button> </td>
							</tr>
							<tr>
								<td style='text-align:center;' height="20px" colspan='1'></td>								
							</tr>
							<tr>
								<td style='text-align:center;' colspan='6'><h3>Gestió dels Alumnes</h3></td>
							</tr>
							<tr>
								<td style='text-align:center;' colspan='6'> Gestiona l'estat actual dels Alumnes: </td>								
							</tr>
							<tr>
								<td style='text-align:center;' colspan='6'> <button type='submit' name='modificaEstatAlumne' class='submit'>Modifica l'estat Alumne</button> </td>
							</tr>
							<tr>
								<td style='text-align:center;' height="20px" colspan='1'></td>								
							</tr>
							<tr>
								<td style='text-align:center;' colspan='6'><h3>Gestió de les FCT</h3></td>
							</tr>
							<tr>
								<td style='text-align:center;' colspan='3' width="50%"> Gestiona l'estat de les peticions d'FCT: </td>
								<td style='text-align:center;' colspan='3' width="50%"> Envia correus a les Empreses d'FCT: </td>
							</tr>
							<tr>
								
								<td style='text-align:center;' colspan='3' width="50%"> <button type='submit' name='modificaPeticioFCT' class='submit'>Modifica l'estat</button> </td>
								<td style='text-align:center;' colspan='3' width="50%"> <button type='submit' name='enviaCorreu' class='submit'>Enviar un Correu</button> </td>
							</tr>
							
							<tr>
								<td style='text-align:center;' colspan='1'></td>
								<td style='text-align:center;' colspan='1'></td>
								<td style='text-align:center;' colspan='1'></td>
								<td style='text-align:center;' colspan='1'></td>
								<td style='text-align:center;' colspan='1'></td>
								<td style='text-align:center;' colspan='1'></td>
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
		<?php
			footer();
		?>
	</BODY>
</HTML>
<?php
	}
?>