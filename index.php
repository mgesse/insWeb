<?php
	include('footer.php');
	include('menu.php');
?>
<!DOCTYPE HTML>
<HTML>
	<HEAD>
		<meta charset='utf-8'/>
		<title> Plana d'Inici Institut i Empresa - INS Esteve Terradas i Illa </title>
		<link rel="stylesheet" href="style.css" type="text/css" media="screen" />
	</HEAD>
	
	<BODY>
		<div id="wrapper">
			<?php 
				cap(); 
				menuInicial();
			?>
			
			
			<h1> Plana Inici Empresa - INS Esteve Terradas i Illa </h1>
				
			<div id="content">
				<div id="ad-top">
					<!-- Insert 468x60 banner advertisement -->
				</div>
				<div class="entry">
					<div class="entry-title">Índex per a les empreses</div>
						<p id="paragrafExplicacio">
						<<< Aquí tens la opció de triar entre posar ofertes per a les pràctiques en empresa (FCT) a "Petició d'Alumnes per a la Realització
						de les pràctiques en Empresa!" o bé deixar-nos peticions per a la nostra Borsa de Treball (BT) a "Ofertes de Treball".>>
						</p>
					<div class="taula">
						<table id="conTaula" bgcolor="#ffffff">
							<tr>
								<td width="245" height="100">
									<a href="insertarPeticionsFCT.php"><img border="0" height="80" src="images/calendari_general.png" alt="cal"></a>
								</td>
								<td width="245" height="100">
									<a href="insertarOfertesBT.php"><img border="0" height="80" src="images/calendari_general.png" alt="cal"></a>
								</td>
							</tr>
							<tr>
								<td id="liniaA">
									<b>Petició d'Alumnes per a la FCT!</b>
								</td>
								<td>
									<b>Ofertes de Treball!</b>
								</td>
							</tr>
						</table>
					</div>
				</div>
			</div>		
		</div>
		<?php
			footer();
		?>
		
		
	</BODY>
</HTML>