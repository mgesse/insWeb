<?php
	
	//Funció que utilitzem a mode de camí guiat per obtenir la resta d'Alumnes d'una Tutoria assignada a un mestre en concret.
	//La usem a: consultaTutoria.php
	function obtenirAlumnesTutoria($idTutor){					/// Actualitzada \\\
		//1- Obtenim el ID del cicle formatiu al que està assignat el tutor. (CON professorsCicles amb idProf)
		$idCicle = false;
		$idCicle = getIdCicleTutor($idTutor);
		
		//2- Obtenir les dades de tots els alumnes que coincideixen amb l'idCicle i l'idProf de la taula alumnesCicles.
		if($idCicle != false && $idCicle >= 0){
			$arrayDades = array();
			$arrayDades = getAlumnesCicle($idTutor, $idCicle);
			
			if($arrayDades != false){
				return $arrayDades;
			}
		}else{
			echo "<b>ERROR: No s'ha pogut obtenir el ID del teu cicle. </b>";			
		}
	}
	
	//Funció que usem per obtenir el llistat d'Alumnes del cicle i tutor demanats.
	//La usem a: consultaTutoria.php
	function getAlumnesCicle($idTutor, $idCicle){				/// Actualitzada \\\
		$dades = new dades();
		$bd = $dades->connecta();
		$retorn = false;
		if($bd != false){
			$sql = $bd->prepare("SELECT al.idAlumne, al.nomAlumne, al.cognomsAlumne, al.emailAlumne, al.telefonAlumne, es.descripcio
								 FROM alumnes AS al
								 INNER JOIN estatfct AS es ON al.idEstatFCT = es.idEstatFCT								 
								 WHERE al.idCicle = ? AND al.idProf = ?;");
			$sql->bindParam(1, $idCicle, PDO::PARAM_INT);
			$sql->bindParam(2, $idTutor, PDO::PARAM_INT);
			$sql->execute();			
			$resultat = $sql->fetchAll(PDO::FETCH_ASSOC);			
			if($resultat){
				$retorn = $resultat;
			}else{
				$retorn = false;
			}
		
		}
		$bd = null;
		return $retorn;
	}	
	
	//Funció que usarem per obtenir el ID del cicle al que està assignat un tutor.
	//La usem a: consultaTutoria.php, consultaPeticionsFCT.php, consultaAltresPeticionsFCT.php, afegirPetAlu.php, relacioAlumneEmpresa.php
	function getIdCicleTutor($idTutor){							/// Actualitzada \\\
		$dades = new dades();
		$bd = $dades->connecta();
		
		if($bd != false){
			$sql= $bd->prepare("SELECT idCicle FROM professorscicles WHERE idProf = ?;");
			$sql->bindParam(1, $idTutor, PDO::PARAM_INT);
			$sql->execute();
			$resultat = $sql->fetchAll(PDO::FETCH_ASSOC);
			
			if($resultat){			//Si l'ha trobat, també obtenim l'ID de l'emrpesa.
				//print_r($resultat);
				foreach ($resultat as $fila){
					
					foreach($fila as $valor){
						$idCicle = $valor;
					}
					
					//$idCicle = $fila["idCicle"];
				}
			}else{
				$idCicle = false;
				//echo "No ha trobat el Cicle... >> ID del tutor: $idTutor << <br>";
			}
		}else{
			//echo "Problema de connexió a BBDD!";
		}
		$bd = null;
		return $idCicle;
	}
	
	//Funció que utilitzem a mode de camí guiat per obtenir les peticions de FCT assignades a un grup/tutor.
	//La usem a: consultaPeticionsFCT.php, consultaAltresPeticionsFCT.php, afegirPetAlu.php
	function obtenirPeticionsFCT($idTutor,$tipusConsulta){		/// Actualitzada \\\
		//1- Obtenim el ID del cicle formatiu al que està assignat el tutor. (CON professorsCicles amb idProf)
		$idCicle = getIdCicleTutor($idTutor);
		$idGremi = getGremiTutor($idTutor);
	
		//2- Obtenir les ofertes de les peticions de FCT.
		if($idGremi != false && $idGremi >= 0){
			if($idCicle != false && $idCicle >= 0){
				$arrayDades = array();
				if($tipusConsulta == 1){
					$arrayDades = getPeticionsFCT($idGremi, $idCicle);
				}else if($tipusConsulta == 2){
					$arrayDades = getAltresPeticionsFCT($idGremi, $idCicle);
				}
				
				if($arrayDades != false){
					return $arrayDades;
				}			
			}else{
				echo "<b>Error: No s'ha pogut obtenir el Cicle del Tutor </b>";				
			}
		}else{
			echo "<b>Error: No s'ha pogut obtenir el Gremi del Tutor </b>";
		}
	}
	
	//Funció que usem per obtenir les peticions de FCT que pertanyin a un gremi i cicles en concret, i que estiguin Disponibles per a la seva assignació.
	//La usem a: consultaPeticionsFCT.php, afegirPetAlu.php
	function getPeticionsFCT($idGremi, $idCicle){				/// Actualitzada \\\
		$dades = new dades();
		$bd = $dades->connecta();
		
		if($bd != false){
			$sql = $bd->prepare
			("SELECT pe.idPeticio, em.nomEmpresa, es.descripcio, pe.nomContacte, pe.email, pe.tasques, pe.telefon, pe.direccio
			FROM peticionsfct AS pe 
			INNER JOIN empresa AS em ON pe.idEmpresa = em.idEmpresa 
			INNER JOIN estatpeticions AS es ON pe.idEstatPeticio = es.idEstatPeticio 
			INNER JOIN peticionscicles AS pc ON pe.idPeticio = pc.idPeticio 
			WHERE es.idEstatPeticio = 1 AND pc.idGremi = ? AND (pc.idCicle = 0 OR pc.idCicle = ?);");
			$sql->bindParam(1, $idGremi, PDO::PARAM_INT);
			$sql->bindParam(2, $idCicle, PDO::PARAM_INT);
			$sql->execute();
			
			$resultat = $sql->fetchAll(PDO::FETCH_ASSOC);
			$retorn = false;
			if($resultat){
				$retorn = $resultat;
			}else{
				$retorn = false;
			}			
		}
		$bd = null;
		return $retorn;
	}
	
	//Funció que usarem per obtenir les peticions de FCT que pertanyin a un gremi i cicles en concret, i que aparegui qualsevol que NO SIGUI Disponible.
	//La usem a: consultaAltresPeticionsFCT.php
	function getAltresPeticionsFCT($idGremi, $idCicle){			/// Actualitzada \\\
		$dades = new dades();
		$bd = $dades->connecta();
		
		if($bd != false){
			$sql = $bd->prepare
			("SELECT pe.idPeticio, em.nomEmpresa, es.descripcio, pe.nomContacte, pe.email, pe.tasques, pe.telefon, pe.direccio
			FROM peticionsfct AS pe 
			INNER JOIN empresa AS em ON pe.idEmpresa = em.idEmpresa 
			INNER JOIN estatPeticions AS es ON pe.idEstatPeticio = es.idEstatPeticio 
			INNER JOIN peticionsCicles AS pc ON pe.idPeticio = pc.idPeticio 
			WHERE es.idEstatPeticio != 1 AND pc.idGremi = ? AND (pc.idCicle = 0 OR pc.idCicle = ?);");
			$sql->bindParam(1, $idGremi, PDO::PARAM_INT);
			$sql->bindParam(2, $idCicle, PDO::PARAM_INT);
			$sql->execute();
			$resultat = $sql->fetchAll(PDO::FETCH_ASSOC);
			$retorn = false;
			if($resultat){
				$retorn = $resultat;
			}else{
				$retorn = false;
			}			
		}
		$bd = null;
		return $retorn;
	}
	
	//Funció que usarem per obtenir el ID del gremi al que pertany un tutor.
	//La usem a: consultaPeticionsFCT.php, consultaAltresPeticionsFCT.php, afegirPetAlu.php
	function getGremiTutor($idTutor){							/// Actualitzada \\\
		$dades = new dades();
		$bd = $dades->connecta();
		
		if($bd != false){
			$sql= $bd->prepare
			("SELECT cf.idGremi 
			FROM ciclesformatius AS cf 
			INNER JOIN professorscicles AS pc ON cf.idCicle = pc.idCicle 
			INNER JOIN professors AS pr ON pc.idProf = pr.idProf 
			WHERE pr.idProf = ?");
			$sql->bindParam(1, $idTutor, PDO::PARAM_INT);
			$sql->execute();
			$resultat = $sql->fetchAll(PDO::FETCH_ASSOC);
			if($resultat){
				foreach ($resultat as $fila){
					foreach($fila as $valor){
						$idGremi = $valor;
					}					
				}
			}else{
				$idGremi = false;
			}			
		}
		$bd = null;
		return $idGremi;
	}
	
	//Funció que usarem per obtenir la llista d'Alumnes que estan assignats a un gremi i curs del mestre, que tinguin les pràctiques pendents.
	//La usem a: afegirPetAlu.php
	function getAlumnesDisponibles($idTutor, $idCicle){			/// Actualitzada \\\
		$dades = new dades();
		$bd = $dades->connecta();
		$retorn = false;
		if($bd != false){
			$sql = $bd->prepare
			("SELECT al.idAlumne, al.nomAlumne, al.cognomsAlumne
			FROM alumnes AS al
			INNER JOIN estatfct AS es ON al.idEstatFCT = es.idEstatFCT
			WHERE al.idCicle = ? AND al.idProf = ? AND es.idEstatFCT = 0;");
			$sql->bindParam(1, $idCicle, PDO::PARAM_INT);
			$sql->bindParam(2, $idTutor, PDO::PARAM_INT);
			$sql->execute();
			$resultat = $sql->fetchAll(PDO::FETCH_ASSOC);
			if($resultat){
				$retorn = $resultat;
			}else{
				$retorn = false;
			}
		}
		$bd = null;
		return $retorn;
	}
	
	//Funció que usarem per inserir una relació entre un alumne i una petició de FCT
	//La usem a: afegirPetAlu.php
	function creaRelacioAlumPet($idAlumne, $idPeticio){			/// Actualitzada \\\
		$dades = new dades();
		$bd = $dades->connecta();
		$retorn = false;
		
		if($bd != false){
			$sql= $bd->prepare("INSERT INTO `alumnepeticio`(`idAlumne`, `idPeticio`) VALUES (?,?);");
			$sql->bindParam(1, $idAlumne, PDO::PARAM_INT);
			$sql->bindParam(2, $idPeticio, PDO::PARAM_INT);
			$sql->execute();
			$filesAfectades = $sql->rowCount();
			
			if($filesAfectades > 0){
				$retorn = true;
			}else{
				$retorn = false;
			}			
		}
		$bd = null;
		return $retorn;
	}
	
	//Funció que usarem per modificar l'estat de les FCT dels alumnes.
	//La usem a: afegirPetAlu.php, modificaEstatAlumne.php
	function modificaEstatAlumne($idAlumne,$estat){				/// Actualitzada \\\
		$dades = new dades();
		$bd = $dades->connecta();
		$retorn = false;	
		if($bd != false){
			$sql= $bd->prepare("UPDATE `alumnes` SET `idEstatFCT`= ? WHERE `idAlumne`= ?;");
			$sql->bindParam(1, $estat, PDO::PARAM_INT);
			$sql->bindParam(2, $idAlumne, PDO::PARAM_INT);
			$sql->execute();
			$filesAfectades = $sql->rowCount();
			
			if($filesAfectades > 0){
				$retorn = true;
			}else{
				$retorn = false;
			}			
		}
		$bd = null;
		return $retorn;
	}
	
	//Funció que usarem per modificar l'estat de les peticions de FCT.
	//La usem a: afegirPetAlu.php, modificaPeticioFTC.php
	function modificaEstatPeticio($idPeticio,$estat){			/// Actualitzada \\\
		$dades = new dades();
		$bd = $dades->connecta();
		$retorn = false;		
		if($bd != false){
			$sql= $bd->prepare("UPDATE `peticionsfct` SET `idEstatPeticio`= ? WHERE `idPeticio`= ?;");
			$sql->bindParam(1, $estat, PDO::PARAM_INT);
			$sql->bindParam(2, $idPeticio, PDO::PARAM_INT);
			$sql->execute();
			$filesAfectades = $sql->rowCount();
		
			if($filesAfectades > 0){
				$retorn = true;
			}else{
				$retorn = false;
			}			
		}
		$bd = null;
		return $retorn;
	}
	
	//Funció que usarem per obtenir la relació entre un alumne i una petició de FCT de tots alumnes d'un curs.
	//relacioAlumneEmpresa.php
	function obtenirRelacioAlumFCT($idTutor){					/// Actualitzada \\\
		//Obtenir el cicle del tutor.
		$idCicle = null;
		$idCicle = getIdCicleTutor($idTutor);
		
		if($idCicle){
			$dades = new dades();
			$bd = $dades->connecta();
			$retorn = false;
			if($bd != false){
				$sql = $bd->prepare
				("SELECT al.nomAlumne, al.cognomsAlumne, es.descripcio, em.nomEmpresa
				FROM alumnes As al
				INNER JOIN estatfct AS es ON al.idEstatFCT = es.idEstatFCT									
				INNER JOIN alumnepeticio AS ap ON al.idAlumne = ap.idAlumne
				INNER JOIN peticionsfct AS pe ON ap.idPeticio = pe.idPeticio
				INNER JOIN empresa AS em ON pe.idEmpresa = em.idEmpresa
				WHERE al.idCicle = ?;");
				$sql->bindParam(1, $idCicle, PDO::PARAM_INT);
				$sql->execute();				
				$resultat = $sql->fetchAll(PDO::FETCH_ASSOC);				
				if($resultat){
					$retorn = $resultat;
				}else{
					$retorn = false;
				}				
			}
			$bd = null;
			return $retorn;
		}else{
			echo "<b>ERROR: No s'ha pogut determinar el cicle del Tutor </b>";
			return false;
		}
	}
	
	//Funció que usarem per obtenir la relació entre un alumne i una petició de FCT de tots alumnes d'un curs.
	//relacioAlumneEmpresa.php
	function obtenirRelacioAlumFCT_ID($idTutor){				/// Actualitzada \\\
		//Obtenir el cicle del tutor.
		$idCicle = getIdCicleTutor($idTutor);
		
		if($idCicle != false && $idCicle >= 0){
			$dades = new dades();
			$bd = $dades->connecta();		
			if($bd != false){
				$sql = $bd->prepare
				("SELECT al.idAlumne, al.nomAlumne, al.cognomsAlumne, es.descripcio, em.nomEmpresa
				FROM alumnes As al
				INNER JOIN estatfct AS es ON al.idEstatFCT = es.idEstatFCT
				INNER JOIN alumnepeticio AS ap ON al.idAlumne = ap.idAlumne
				INNER JOIN peticionsfct AS pe ON ap.idPeticio = pe.idPeticio
				INNER JOIN empresa AS em ON pe.idEmpresa = em.idEmpresa
				WHERE al.idCicle = ? AND al.idEstatFCT = 1;");
				$sql->bindParam(1, $idCicle, PDO::PARAM_INT);
				$sql->execute();
				
				$resultat = $sql->fetchAll(PDO::FETCH_ASSOC);
				$retorn = false;
				if($resultat){
					$retorn = $resultat;
				}else{
					$retorn = false;
				}				
			}
			$bd = null;
			return $retorn;
		}else{
			echo "<b>ERROR: No s'ha pogut determinar el cicle del Tutor </b>";
		}
	}

	//Funció que usarem per obtenir la relació entre un alumne i una petició de FCT de tots alumnes d'un curs, amb els ID de l'alumne.
	//modificaPeticioFTC.php
	function obtenirEmpreses_ID($idTutor){						/// Actualitzada \\\
		
		//Obtenir el cicle del tutor.
		$idCicle = getIdCicleTutor($idTutor);
		//Obtenir el gremi del tutor.
		$idGremi = getGremiTutor($idTutor);
		
		if($idCicle != false && $idCicle >= 0){
			
			if($idGremi != false && $idGremi >= 0){
				$dades = new dades();
				$bd = $dades->connecta();
				
				if($bd != false){
					$sql = $bd->prepare
					("SELECT pe.idPeticio, em.nomEmpresa, ep.descripcio, pe.nomContacte, pe.email, pe.tasques, pe.telefon
					FROM peticionsfct AS pe
					INNER JOIN estatpeticions AS ep ON pe.idEstatPeticio = ep.idEstatPeticio
					INNER JOIN empresa AS em ON pe.idEmpresa = em.idEmpresa
					INNER JOIN peticionscicles AS pc ON pe.idPeticio = pc.idPeticio
					WHERE pc.idGremi = ? AND (pc.idCicle = 0 OR pc.idCicle = ?) AND (pe.idEstatPeticio = 0 OR pe.idEstatPeticio = 1 OR pe.idEstatPeticio = 4)");
					$sql->bindParam(1, $idGremi, PDO::PARAM_INT);
					$sql->bindParam(2, $idCicle, PDO::PARAM_INT);
					$sql->execute();
					
					$resultat = $sql->fetchAll(PDO::FETCH_ASSOC);
					$retorn = false;
					if($resultat){						
						$retorn = $resultat;
					}else{
						$retorn = false;
					}
				}
				$bd = null;
				return $retorn;
			}else{
				echo "<b>Error: No s'ha pogut obtenir el Gremi del Tutor </b>";				
			}
		}else{
			echo "<b>Error: No s'ha pogut obtenir el Cicle del Tutor </b>";			
		}
	}
	
	//Funció que usarem per obtenir el ID de la petició en curs que te assignat un alumne.
	//La usem a: consultaTutoria.php, consultaPeticionsFCT.php, consultaAltresPeticionsFCT.php
	function getIdPeticio($idAlumne){							/// Actualitzada \\\
		$dades = new dades();
		$bd = $dades->connecta();
		$idPeticio = false;
		if($bd != false){
			$sql= $bd->prepare
			("SELECT ap.idPeticio
			FROM alumnes As al
			INNER JOIN alumnepeticio AS ap ON al.idAlumne = ap.idAlumne
			INNER JOIN peticionsfct AS pe ON ap.idPeticio = pe.idPeticio
			WHERE ap.idAlumne = ? AND pe.idEstatPeticio = 2");
			$sql->bindParam(1, $idAlumne, PDO::PARAM_INT);
			$sql->execute();
		
			$resultat = $sql->fetchAll(PDO::FETCH_ASSOC);
		
			if($resultat){
				foreach ($resultat as $fila){
					foreach($fila as $valor){
						$idPeticio = $valor;
					}
				}
			}else{
				$idPeticio = false;
			}
		}
		$bd = null;
		return $idPeticio;
	}
	
	//Funció que usarem per obtenir el ID de la petició en curs que te assignat un alumne.
	//La usem a: modificaEstatAlumne.php
	function modificaEstatsAlumnes($idTutor){					/// Actualitzada \\\
		//Obtenim el Cicle que està assignat el tutor.
		$idCicle = getIdCicleTutor($idTutor);
		$retorn = false;
		if($idCicle != false && $idCicle >= 0){			
			$arrayDades = getAlumnesCicleEstatsAturats($idTutor, $idCicle);
			if($arrayDades){				
				$retorn = $arrayDades;
			}else{
				$retorn = false;
			}
		}else{
			echo "<br><b>Error: No s'ha pogut obtenir cicle del Tutuor.</b>";
		}
		return $retorn;
	}
	
	//Obté els alumnes que NO tenen les FCT en Curs, convalidades o finalitzades
	//modificaEstatAlumne.php
	function getAlumnesCicleEstatsAturats($idTutor, $idCicle){	/// Actualitzada \\\
		$dades = new dades();
		$bd = $dades->connecta();
		
		if($bd != false){
			$sql = $bd->prepare
			("SELECT al.idAlumne, al.nomAlumne, al.cognomsAlumne, al.emailAlumne, al.telefonAlumne, es.descripcio
			FROM alumnes AS al
			INNER JOIN estatfct AS es ON al.idEstatFCT = es.idEstatFCT								 
			WHERE al.idCicle = ? AND al.idProf = ? AND NOT (al.idEstatFCT = 1 OR al.idEstatFCT = 3 OR al.idEstatFCT = 4);");
			$sql->bindParam(1, $idCicle, PDO::PARAM_INT);
			$sql->bindParam(2, $idTutor, PDO::PARAM_INT);
			$sql->execute();			
			$resultat = $sql->fetchAll(PDO::FETCH_ASSOC);
			$retorn = false;
			if($resultat){
				$retorn = $resultat;
			}else{
				$retorn = false;
			}			
		}
		$bd = null;
		return $retorn;
	}	
	
	//Funció que determina el login d'un mestre o administrador.
	function validaUsuari($usuari,$password){
		$dades = new dades();
		
		$bd = $dades->connecta();
		$arrayDades = array();
		
		if($bd != false){
			$sql= $bd->prepare("SELECT idProf, nomProf, cognomProf, idTipusRol, nomDePas, clauDePas FROM professors WHERE nomDePas = ? AND clauDePas = ? AND idTipusRol > 0");
			$sql->bindParam(1, $usuari, PDO::PARAM_STR);
			$sql->bindParam(2, $password, PDO::PARAM_STR);
			$sql->execute();
			
			$resultat = $sql->fetchAll(PDO::FETCH_ASSOC);				
			
			$validaNom;
			$validaClau;
			if($resultat){			
				echo "<br>Login Correcte!<br>";
				print_r($resultat);
				
				foreach ($resultat as $fila){
					$arrayDades[0] = false;
					$arrayDades[1] = $fila["idProf"];
					$arrayDades[2] = $fila["nomProf"].' '.$fila["cognomProf"];
					$arrayDades[3] = $fila["idTipusRol"];							
					$validaNom = $fila["nomDePas"];
					$validaClau = $fila["clauDePas"];
				}

				if($validaNom == $usuari && $validaClau == $password){
					$arrayDades[0] = true;
				}else{
					$arrayDades[1] = '';
					$arrayDades[2] = '';
					$arrayDades[3] = '';
				}						
			}else{	
				echo "<br>???<br>";
				$arrayDades[0] = false;						
			}						
		}else{
			echo "<br>!!!<br>";
			$arrayDades[0] = false;
		}
		$bd = null;	
		return $arrayDades;
	}			
	
	//Funcions per al correu.
	function getCorreuAlumnesCicle($idTutor, $idCicle){				/// Actualitzada \\\
		$dades = new dades();
		$bd = $dades->connecta();
		$retorn = false;
		if($bd != false){
			$sql = $bd->prepare("SELECT al.emailAlumne
								 FROM alumnes AS al
								 INNER JOIN estatfct AS es ON al.idEstatFCT = es.idEstatFCT								 
								 WHERE al.idCicle = ? AND al.idProf = ?;");
			$sql->bindParam(1, $idCicle, PDO::PARAM_INT);
			$sql->bindParam(2, $idTutor, PDO::PARAM_INT);
			$sql->execute();			
			$resultat = $sql->fetchAll(PDO::FETCH_ASSOC);			
			if($resultat){
				$retorn = $resultat;
			}else{
				$retorn = false;
			}
		
		}
		$bd = null;
		return $retorn;
	}
	
	function getCorreuEmpresesFCTCicle(/*$idTutor, */$idCicle){				/// Actualitzada \\\
		$dades = new dades();
		$bd = $dades->connecta();
		$retorn = false;
		if($bd != false){
			$sql = $bd->prepare("SELECT DISTINCT(pe.email)
								 FROM peticionsfct AS pe
								 INNER JOIN peticionscicles AS pc ON pe.idPeticio = pc.idPeticio
								 WHERE pc.idCicle = ?;");
			$sql->bindParam(1, $idCicle, PDO::PARAM_INT);
			//$sql->bindParam(2, $idTutor, PDO::PARAM_INT);
			$sql->execute();			
			$resultat = $sql->fetchAll(PDO::FETCH_ASSOC);			
			if($resultat){
				$retorn = $resultat;
			}else{
				$retorn = false;
			}
		
		}
		$bd = null;
		return $retorn;
	}	
	
?>