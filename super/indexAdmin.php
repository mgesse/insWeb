<?php
	ob_start();
	require_once("classeSessions.php");
	include('menuAdmin.php');
	$sesion = new sesion();
	$usuari = $sesion->get("NomMestre");
	
	if($usuari == false){
		header("Location: ../loginTutors.php");
	}else{
?>
<!DOCTYPE HTML>
<HTML>
	<HEAD>
		<meta charset='utf-8'/>
		<title> Administració - INS Esteve Terradas i Illa </title>
		<?php menu_indexAdmin($usuari); ?>
		
	</HEAD>
	
	<BODY>
		<h1> Plana d'Inici de l'Administració - INS Esteve Terradas i Illa </h1>
		
			<form name='formulariIndexAdmin' id='formulari' action='indexAdmin.php' method='post' onsubmit=''>
				
				<table border='1'>
					<tr>
						<td style='text-align:center;' colspan='2'><h3>Consulta els Alumnes</h3></td>
					</tr>
					<tr>
						<td style='text-align:center;'> Tots els Alumnes del centre, d'un gremi o d'un grup: </td>
						<td style='text-align:center;'> <input type="submit" name="llistatAlumnes" value="Llista d'Alumnes"></td>
					</tr>
					<tr>
						<td style='text-align:center;'> Tots els Alumnes assignats a una Empresa: </td>
						<td style='text-align:center;'> <input type="submit" name="llistatAlumnesFCT" value="Llista Alumnes - FCT"></td>
					</tr>
					<tr>
						<td style='text-align:center;' colspan='2'><h3>Consulta les Empreses</h3></td>
					</tr>
					<tr>
						<td style='text-align:center;'> Consulta les Peticions de FCT del Centre: </td>
						<td style='text-align:center;'> <input type="submit" name="llistatPeticionsFCT" value="Ofertes Disponibles FCT"> </td>
					</tr>
					<tr>
						<td style='text-align:center;' colspan='2'><h3>Gestió de les FCT dels Alumnes</h3></td>
					</tr>
					<tr>
						<td style='text-align:center;'> Assigna un Alumne a una Empresa d'FCT: </td>
						<td style='text-align:center;'> <input type="submit" name="relacionaAlumneFCT" value="Assigna Alumne a FCT"></td>
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
						<td style='text-align:center;'> Modifica les Dades Personales d'un Alumne: </td>
						<td style='text-align:center;'> <input type="submit" name="modificaDadesAlumne" value="Modifica les Dades de l'Alumne"> </td>
					</tr>
					<tr>
						<td style='text-align:center;'> Modifica el Curs/Gremi/Professor d'un Alumne: </td>
						<td style='text-align:center;'> <input type="submit" name="modificaCursAlumne" value="Modifica la Matricula de l'Alumne"> </td>
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
						<td style='text-align:center;'> <!-- <input type="submit" name="enviaCorreu" value="Enviar un Correu">--> En Desenvolupament </td>
					</tr>
					<tr>
						<td style='text-align:center;'> Insereix Noves Peticions d'FCT: </td>
						<td style='text-align:center;'> <input type="submit" name="novaPeticio" value="Nova Petició FCT"> </td>
					</tr>
					<!-- <tr>
						<td style='text-align:center;'> Modifica les Dades de la Petició d'FCT: </td>
						<td style='text-align:center;'> <input type="submit" name="modificaDadesPeticio" value="Modifica les Dades"> En Desenvolupament </td>
					</tr> -->
					<tr>
						<td style='text-align:center;' colspan='2'><h3>Gestió dels Professors</h3></td>
					</tr>
					<tr>
						<td style='text-align:center;'> Insereix Nous Tutors o Professors: </td>
						<td style='text-align:center;'> <input type="submit" name="nouTutor" value="Insereix un nou tutor"> </td>
					</tr>
					<tr>
						<td style='text-align:center;'> Assigna el Gremi/Curs d'un Professor: </td>
						<td style='text-align:center;'> <input type="submit" name="canviaCicleMestre" value="Canvia el Cicle del Professor"> </td>
					</tr>
					<tr>
						<td style='text-align:center;'> Modifica les Dades del Professor: </td>
						<td style='text-align:center;'> <input type="submit" name="modificaDadesMestre" value="Canvia les Dades del Professor"> </td>
					</tr>
					<tr>
						<td style='text-align:center;' colspan='2'><h3>Gestió de les Ofertes de Treball</h3></td>
					</tr>
					<tr>
						<td style='text-align:center;'> Insereix Noves Ofertes de Treball: </td>
						<td style='text-align:center;'> <input type="submit" name="insertaOferta" value="Insereix Oferta de Treball"> </td>
					</tr>
					<tr>
						<td style='text-align:center;'> Consulta les Ofertes de Treball: </td>
						<td style='text-align:center;'> <input type="submit" name="consultaOferta" value="Consulta Oferta de Treball"> </td>
					</tr>
					<tr>
						<td style='text-align:center;' colspan='2'><h3>Gestió de les Empreses</h3></td>
					</tr>
					<tr>
						<td style='text-align:center;'> Insereix una Nova Empresa: </td>
						<td style='text-align:center;'> <input type="submit" name="novaEmpresa" value="Nova Empresa FCT"> </td>
					</tr>
					<tr>
						<td style='text-align:center;' colspan='2'><h3>Altes i Baixes</h3></td>
					</tr>
					<tr>
						<td style='text-align:center;'> Dona d'alta un Alumne: </td>
						<td style='text-align:center;'> <input type="submit" name="altaAlumne" value="Alta d'Alumne"></td>
					</tr>
					<tr>
						<td style='text-align:center;'> Dona de Baixa un Alumne: </td>
						<td style='text-align:center;'> <input type="submit" name="baixaAlumne" value="Baixa d'Alumne"></td>
					</tr>
					<tr>
						<td style='text-align:center;' colspan='2'><h3>Ex Alumnes</h3></td>
					</tr>
					<tr>
						<td style='text-align:center;'> Consulta els Ex-Alumnes: </td>
						<td style='text-align:center;'> <input type="submit" name="consultaExAlumne" value="Consulta els Ex-Alumnes"></td>
					</tr>					
				</table>		
				
			</form>
		
		<?php			
			//Validem que ha fet clic
			if(isset($_POST["tancaSessio"])){
				
				$usuario = $sesion->get("NomMestre");	
				$sesion->termina_sesion();
				header("location: ../loginTutors.php");
				//header("location: http://127.0.0.1/WebGestio/loginTutors.php"); Format IP
				
			}else if(isset($_POST["llistatAlumnes"])){
				header('Location: llistaAlumnes.php');
			}else if(isset($_POST["llistatAlumnesFCT"])){
				header('Location: llistaAlumnesFCT.php');
			}else if(isset($_POST["llistatPeticionsFCT"])){
				header('Location: llistaPeticionsFCT.php');
			}else if(isset($_POST["relacionaAlumneFCT"])){
				header('Location: afegirAlumnePeticio.php');
			}else if(isset($_POST["llistaAlPe"])){
				header('Location: relacioAlumneEmpresa.php');
			}else if(isset($_POST["finalFCT"])){
				header('Location: finalitzacioFCT_AD.php');
			}else if(isset($_POST["anulaFCT"])){
				header('Location: anul-laFCT_AD.php');
			}else if(isset($_POST["modificaPeticioFCT"])){
				header('Location: modificaPeticioFCT_AD.php');
			}else if(isset($_POST["modificaEstatAlumne"])){
				header('Location: modificaEstatAlumne_AD.php');
			}else if(isset($_POST["modificaDadesAlumne"])){
				header('Location: modificaDadesAlumne.php');
			}else if(isset($_POST["modificaCursAlumne"])){
				header('Location: modificaCursAlumnes.php');
			}/*else if(isset($_POST["modificaMatriculaAlumne"])){
				header('Location: modificaMatriculaAlumne.php');
			}*/else if(isset($_POST["novaPeticio"])){
				header('Location: insereixPeticioFCT.php');
			}else if(isset($_POST["modificaDadesPeticio"])){
				header('Location: modificaDadesPeticio.php');
			}else if(isset($_POST["novaEmpresa"])){
				header('Location: novaEmpresa.php');
			}else if(isset($_POST["nouTutor"])){
				header('Location: insereixTutorsFCT.php');
			}else if(isset($_POST["modificaDadesMestre"])){
				header('Location: modificaDadesMestre.php');
			}else if(isset($_POST["canviaCicleMestre"])){
				header('Location: modificaCursTutor.php');
			}else if(isset($_POST["insertaOferta"])){
				header('Location: insereixPeticioBT.php');
			}else if(isset($_POST["consultaOferta"])){
				header('Location: llistaOfertesBT.php');
			}else if(isset($_POST["baixaAlumne"])){
				header('Location: baixaAlumne.php');
			}else if(isset($_POST["altaAlumne"])){
				header('Location: inserirAlumnes.php');
			}else if(isset($_POST["consultaExAlumne"])){
				header('Location: llistaExAlumnes.php');
			}
			
		?>	
		
	</BODY>
</HTML>
<?php
	}
?>