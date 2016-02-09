<?php
	
?>
<!DOCTYPE HTML>
<HTML>
	<HEAD>
		<meta charset='utf-8'/>
		<LINK href='provaCSS.css' type=text/css rel=stylesheet> 
		<title> Plana d'Inici de l'Empresa - INS Esteve Terradas i Illa </title>
	</HEAD>
	
	<BODY style="font-family: Calibri" bgcolor="#efefff">
		<h1> 
		<center><img src="img/logoINS.png" class="flr" alt="INS - Esteve Terradas i Illa"></center><br>
		<!-- Plana d'Inici de l'Empresa - INS Esteve Terradas i Illa --> </h1>
		
			<form name='formulariIndexEmpresa' id='formulari' action='indexEmpresa.php' method='post' onsubmit=''>
				<div id="blocQuadre">					
					<table bgcolor="#ffffff">
						<tr>
							<td width="245" height="100" >
								<center><a href="insertarPeticionsFCT.php"><img border="0" height="80" src="img/calendari_general.png" alt="cal"></a></center>
							</td>
							<td width="245" height="100">
								<center><a href="insertarOfertesBT.php"><img border="0" height="80" src="img/calendari_general.png" alt="cal"></a></center>
							</td>
							<td width="245" height="100">
								<center><a href="insertarPeticionsFCT.php"><img border="0" height="80" src="img/calendari_general.png" alt="cal"></a></center>
							</td>
						</tr>
						<tr>
							<td id="liniaA">
								<b>Petició d'Alumnes per a la realització <br> &nbsp; &nbsp; &nbsp; de les Pràctiques en Empresa!</b>
							</td>
							<td>
								<center><b>Ofertes de Treball!</b></center>
							</td>
							<td>
								<center><b>Formulari de Contacte!<b></center>
							</td>
						</tr>
					</table>								
				</div>
				<br><br>
				<p>
				<<< Aquí tens la opció de triar entre posar ofertes per a les pràctiques en empresa (FCT) a "Petició d'Alumnes per a la Realització
				de les pràctiques en Empresa!" o bé deixar-nos peticions per a la nostra Borsa de Treball (BT) a "Ofertes de Treball".>>
				</p>
				<input type="submit" name="FCT" value="Formació Centres Treball">
				
				
				
				
				<br><br>
				<input type="submit" name="OT" value="Ofertes Treball">
				
				
				<<< TEXT EXPLICATIU >>
				<br><br>
				<input type="submit" name="contacte" value="Contacta amb Nosaltres!">
				
				
			</form>
		
		<?php			
			//Validem que ha fet clic
			if(isset($_POST["FCT"])){
				
				//Redirigm a la plana de login per als tutors.
				header('Location: insertarPeticionsFCT.php');
				
			}else if(isset($_POST["OT"])){
				
				//Redirigim a la plana web de tria d'opció a l'empresa.
				header('Location: insertarOfertesBT.php');
				
			}		
		?>
		
		
	</BODY>
</HTML>