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
		<title> Contactes Empreses FCT - INS Esteve Terradas i Illa </title>
		<link rel="stylesheet" href="style.css" type="text/css" media="screen" />
		<script src="validaCorreu.js"></script>
	</HEAD>
	
	<BODY>
		<div id="wrapper">
			<?php 
				cap(); 
				menu_consultes($usuari);
			?>
			<h1> Contactes Empreses FCT - INS Esteve Terradas i Illa </h1>
			<div id="content">
				<form name='formulariCorreuFCT' id='formulari' action='enviarCorreuFCT.php' method='post' onsubmit=' return valida();'>
					<div class="entry">
						Els camps marcats amb asterisc (*) són obligatoris! <br>
						
						Correu Electrònic de contacte Origen: &nbsp; <input type="email" name="emailOrigen" placeholder="correuOrigen@correu.cat" required> <br><br>
						
						Tria a qui enviaràs el correu: <br>
						
						- Grup de classe: <input type='radio' class='rdButton' name='triaGrup' value=0> <br>
						- Grup d'empreses FCT: <input type='radio' class='rdButton' name='triaGrup' value=1> <br><br>
						
						
						Títol: &nbsp; <input type="text" name="titol" placeholder="Títol del Correu" required>	<br><br>			
						
						<br> Missatge: <br>
						<textarea name="missatge" rows='7' cols='80' placeholder="Contingut del Correu" required></textarea> <br>
						
						Correu Electrònic de contacte Destí (*): &nbsp; <input type="email" name="emailDesti" placeholder="correuDestí@correu.cat" required> <br><br>
						
						<button class="submit" name="Envia" type="submit"> Tramet les Dades </button>
						
						
						
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
					}else if(isset($_POST["Envia"])){			
						
						//Tractament de les dades
						$missatge = $_POST["missatge"];
						$titol = $_POST["titol"];
						$emailOrigen = $_POST["emailOrigen"];
						$emailDesti = $_POST["emailDesti"];
						$grup = $_POST["triaGrup"];
						
						//Hem d'obtenir el correu del tutor.
						
						
						
						//Contingut del missatge
						$missatge = $_POST["missatge"];
						//Titol
						$titol = $_POST["titol"];
						//capçalera
						$headers = "MIME-Version: 1.0\r\n"; 
						$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
						//dirección del remitente 
						$headers .= "From:  <".$emailOrigen.">\r\n";
						//$headers .= "From: NOM <mgessebernadas@iesesteveterradas.cat>\r\n";
						//Enviamos el mensaje a info@geekytheory.com 
						//$bool = mail("platacat@gmail.com",$titol,$missatge,$headers);
						
						//Obtenim el Cicle
						$idCicle = getIdCicleTutor($idTutor);
						if($idCicle > 0 && $idTutor > 0){
							//Cerquem els correus de l'alumne
							if($grup == 0){
								$arrayCorreus = getCorreuAlumnesCicle($idTutor, $idCicle);
							}else if($grup == 1){
								$arrayCorreus = getCorreuEmpresesFCTCicle($idCicle);
							}
							
							
							foreach($arrayCorreus as $fila){
								foreach($fila as $emailDesti){
									//echo "<br> Correu: $emailDesti";
									$bool = mail($emailDesti,$titol,$missatge,$headers);
						
									if($bool){
										echo "<br>Missatge Enviat a $emailDesti";
									}else{
										echo "Missatge no Enviat";
									}
								}								
							}							
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