<?php
	include 'dadesServer.php';
	include('footer.php');
	include('menu.php');
	include('funcionsEmpresa.php');
?>
<!DOCTYPE HTML>
<HTML>
	<HEAD>
		<meta charset='utf-8'/>
		<title> Inserció Peticions FCT - INS Esteve Terradas i Illa </title>
		<link rel="stylesheet" href="style.css" type="text/css" media="screen" />	
		<script src="insertarOfertesBT.js"> </script>
		<script src="carregaSelect.js"> </script>
		
	</HEAD>
	
	<BODY>
		<div id="wrapper">
			<?php 
				cap(); 
				menuBasic();
			?>
			<h1> Inserció d'Ofertes a la Borsa de Treball - INS Esteve Terradas i Illa </h1>
			<div id="content">
				<form name='formulariPeticioFCT' id='formulari' action='insertarOfertesBT.php' method='post' onsubmit='return valida();'>
					<div class="entry">
						<h2>Emplena els camps per enviar una oferta de Treball.</h2>	
						Els camps marcats amb asterisc (*) són obligatoris! <br>
						
						CIF (*): &nbsp; <input type="text" name="nif" placeholder="aaa" required>	<br><br>			
						
						Nom de l'Empresa (*): &nbsp; <input type="text" name="nomEmpresa" placeholder="Empresa Anònima, S.A" required> <br><br>				
						
						Correu Electrònic de contacte (*): &nbsp; <input type="email" name="email" placeholder="direccio@correu.com" required> <br><br>
						
						Direcció (*): &nbsp; <input type="text" name="direccio" placeholder="Carrer Sant Nom, 1 , 1º 1º, Ciutat"> <br><br>
						
						<!-- Part on accedim a la BBDD a rescatar les dades sobre els gremis i CF's  -->
						Tria l'especialitat de la petició (*): &nbsp; 
						<select class="nomsEstudis" id="gremis" name='gremis' id='gremis'>
						<option value='0'>Sense Especificar</option>
						<?php 
							$arrayGremis = array();
							$arrayGremis = getGremis();
							$index = 1;					
							foreach($arrayGremis as $valor){
								$valor = utf8_encode($valor);
								echo"<option value='$index'>$valor</option>";
								$index = $index + 1;
							}										
						?>	
						</select>
					
						<br><br> Filtra el Cicle Formatiu de la petició: &nbsp;  
						<select class="nomsEstudis" name='cicles' id='cicles'>
							<option value='0'>Sense Especificar</option>
						</select>
						
						<br><br> Requisits de l'aspirant (*): <br>
						<textarea name="requisits" rows='7' cols='80' placeholder="Requereix títol superior de Desenvolupament Aplicacions Web. Java, PHP. " required></textarea> <br><br>
					
						Tasques a realitzar per part de l'aspirant: <br>
						<textarea name="tasques" rows='7' cols='80' ></textarea> <br><br>
						
						Telèfon de Contacte: &nbsp; <input type="text" name="telefon"> <br><br>			
						
						<button class="submit" name="Envia" type="submit"> Tramet les Dades </button>
						<!-- <input type="submit" name="Envia" value="Tramet les Dades">  -->
					</div>
				</form>
			
				<?php			
					//Validem que ha fet clic
					if(isset($_POST["Envia"])){
						
						$dades = new dades();
						
						//Tractament de les dades
						$nif = utf8_decode($_POST["nif"]);
						$nomEmpresa = utf8_decode($_POST["nomEmpresa"]);				
						$email = utf8_decode($_POST["email"]);
						$tasques = utf8_decode($_POST["tasques"]);
						$telefon = $_POST["telefon"];
						$direccio = utf8_decode($_POST["direccio"]);	
						$requisits = utf8_decode($_POST["requisits"]);
						$gremi = $_POST["gremis"];
						$cicle = $_POST["cicles"];
					
						$retorn = false;
						//echo "Valor de la direcció: $direccio";
						//Cal determinar si l'Empresa ja havia aportat dades amb anterioritat.
						$id = comprovaEmpresa($nif,$nomEmpresa);
						//$id = -2;
						if($id > 0){					
							//"<br> <br> Empresa inserida o verificada correctament: $id";
						
							//Realitzem la petició cridant a la funció.
							$estatPeticio = 0;	//0 Indica que cal validar-la manualment). 
							$retorn = tramitaPeticioEmp($id, $tasques, $requisits, $direccio, $email, $telefon, $gremi, $cicle);
						}else{
							//"<br> <br> Valor de l'ID: $id";
						}	

						if($retorn == true){
							echo "<br><br>La petició s'ha enviat satisfactòriament!</br></br>";
						}else{
							echo "<br><br>Hi ha hagut un problema, torna-ho a intentar o contacta amb el institut.</br></br>";
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