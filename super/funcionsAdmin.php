<?php
	//La usem per obtenir el registre d'alumnes de l'insititut amb la informació essencial dels alumnes.
	// llistaAlumnes.php
	function obtenirAlumnesCentre($tipus,$filtre){					/// Actualitzat \\\
		$dades = new dades();
		$bd = $dades->connecta();
		
		if($bd != false){
			
			if($tipus == 1){
				$sql = $bd->prepare(
				"SELECT al.nomAlumne, al.cognomsAlumne, al.emailAlumne, al.telefonAlumne, es.descripcio, cf.nomCicle, gr.nomGremi
				FROM alumnes AS al
				INNER JOIN estatfct AS es ON al.idEstatFCT = es.idEstatFCT				
				INNER JOIN ciclesformatius AS cf ON al.idCicle = cf.idCicle
				INNER JOIN gremis AS gr ON cf.idGremi = gr.idGremi
				WHERE al.idCicle > 0
				ORDER BY (cf.idCicle);");
			}else if($tipus == 2){
				$sql = $bd->prepare(
				"SELECT al.nomAlumne, al.cognomsAlumne, al.emailAlumne, al.telefonAlumne, es.descripcio, cf.nomCicle, gr.nomGremi
				FROM alumnes AS al
				INNER JOIN estatfct AS es ON al.idEstatFCT = es.idEstatFCT
				INNER JOIN ciclesformatius AS cf ON al.idCicle = cf.idCicle
				INNER JOIN gremis AS gr ON cf.idGremi = gr.idGremi
				WHERE cf.idGremi = ?
				ORDER BY (cf.idCicle);");
				$sql->bindParam(1, $filtre, PDO::PARAM_INT);
			}else if($tipus == 3){
				$sql = $bd->prepare(
				"SELECT al.nomAlumne, al.cognomsAlumne, al.emailAlumne, al.telefonAlumne, es.descripcio, cf.nomCicle, gr.nomGremi
				FROM alumnes AS al
				INNER JOIN estatfct AS es ON al.idEstatFCT = es.idEstatFCT
				INNER JOIN ciclesformatius AS cf ON al.idCicle = cf.idCicle
				INNER JOIN gremis AS gr ON cf.idGremi = gr.idGremi
				WHERE al.idCicle = ?
				ORDER BY (cf.idCicle);");
				$sql->bindParam(1, $filtre, PDO::PARAM_INT);
			}else if($tipus == 4){
				$sql = $bd->prepare(
				"SELECT al.nomAlumne, al.cognomsAlumne, al.emailAlumne, al.telefonAlumne, es.descripcio, cf.nomCicle, gr.nomGremi
				FROM alumnes AS al
				INNER JOIN estatfct AS es ON al.idEstatFCT = es.idEstatFCT
				INNER JOIN ciclesformatius AS cf ON al.idCicle = cf.idCicle
				INNER JOIN gremis AS gr ON cf.idGremi = gr.idGremi
				WHERE (cf.idGremi = 0 OR al.idCicle = 0)
				ORDER BY (cf.idCicle)");
			}
		
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
	
	//La usem per obtenir el registre d'alumnes de l'institut que han cursat o estan cursant les FCT.
	// llistaAlumnesFCT.php
	function obtenirAlumnesFCTCentre($tipus,$filtre){				/// Actualitzat \\\
		$dades = new dades();
		$bd = $dades->connecta();
		
		if($bd != false){
			
			if($tipus == 1){
				$sql = $bd->prepare(
				"SELECT al.nomAlumne, al.cognomsAlumne, al.emailAlumne, es.descripcio, em.nomEmpresa, cf.nomCicle, gr.nomGremi
				FROM alumnes AS al
				INNER JOIN estatfct AS es ON al.idEstatFCT = es.idEstatFCT
				INNER JOIN ciclesformatius AS cf ON al.idCicle = cf.idCicle
				INNER JOIN gremis AS gr ON cf.idGremi = gr.idGremi
				INNER JOIN alumnepeticio AS ap ON al.idAlumne = ap.idAlumne
				INNER JOIN peticionsfct AS pe ON ap.idPeticio = pe.idPeticio
				INNER JOIN empresa AS em ON pe.idEmpresa = em.idEmpresa
				WHERE al.idCicle > 0
				ORDER BY (cf.idCicle);");
			}else if($tipus == 2){
				$sql = $bd->prepare(
				"SELECT al.nomAlumne, al.cognomsAlumne, al.emailAlumne, es.descripcio, em.nomEmpresa, cf.nomCicle, gr.nomGremi
				FROM alumnes AS al
				INNER JOIN estatfct AS es ON al.idEstatFCT = es.idEstatFCT
				INNER JOIN ciclesformatius AS cf ON al.idCicle = cf.idCicle
				INNER JOIN gremis AS gr ON cf.idGremi = gr.idGremi
				INNER JOIN alumnepeticio AS ap ON al.idAlumne = ap.idAlumne
				INNER JOIN peticionsfct AS pe ON ap.idPeticio = pe.idPeticio
				INNER JOIN empresa AS em ON pe.idEmpresa = em.idEmpresa
				WHERE cf.idGremi = ?
				ORDER BY (cf.idCicle);");
				$sql->bindParam(1, $filtre, PDO::PARAM_INT);
			}else if($tipus == 3){
				$sql = $bd->prepare(
				"SELECT al.nomAlumne, al.cognomsAlumne, al.emailAlumne, es.descripcio, em.nomEmpresa, cf.nomCicle, gr.nomGremi
				FROM alumnes AS al
				INNER JOIN estatfct AS es ON al.idEstatFCT = es.idEstatFCT
				INNER JOIN ciclesformatius AS cf ON al.idCicle = cf.idCicle
				INNER JOIN gremis AS gr ON cf.idGremi = gr.idGremi
				INNER JOIN alumnepeticio AS ap ON al.idAlumne = ap.idAlumne
				INNER JOIN peticionsfct AS pe ON ap.idPeticio = pe.idPeticio
				INNER JOIN empresa AS em ON pe.idEmpresa = em.idEmpresa
				WHERE al.idCicle = ?
				ORDER BY (cf.idCicle);");
				$sql->bindParam(1, $filtre, PDO::PARAM_INT);
			}else if($tipus == 4){
				$sql = $bd->prepare(
				"SELECT al.nomAlumne, al.cognomsAlumne, al.emailAlumne, es.descripcio, em.nomEmpresa, cf.nomCicle, gr.nomGremi
				FROM alumnes AS al
				INNER JOIN estatfct AS es ON al.idEstatFCT = es.idEstatFCT
				INNER JOIN ciclesformatius AS cf ON al.idCicle = cf.idCicle
				INNER JOIN gremis AS gr ON cf.idGremi = gr.idGremi
				INNER JOIN alumnepeticio AS ap ON al.idAlumne = ap.idAlumne
				INNER JOIN peticionsfct AS pe ON ap.idPeticio = pe.idPeticio
				INNER JOIN empresa AS em ON pe.idEmpresa = em.idEmpresa
				WHERE (cf.idGremi = 0 OR al.idCicle = 0)
				ORDER BY (cf.idCicle)");
			}
		
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
	
	//La usem per obtenir la llista de peticions de FCT de l'institut.
	// llistaAlumnesFCT.php
	function obtenirPeticionsFCTCentre($tipus,$filtre){				/// Actualitzat \\\
		$dades = new dades();
		$bd = $dades->connecta();
		
		if($bd != false){
			
			if($tipus == 1){
				$sql = $bd->prepare(
				"SELECT em.nomEmpresa, ep.descripcio, pe.nomContacte, pe.email, pe.tasques, pe.telefon, pe.direccio, cf.nomCicle, gr.nomGremi
				FROM peticionsfct AS pe
				INNER JOIN empresa AS em ON pe.idEmpresa = em.idEmpresa
				INNER JOIN estatpeticions AS ep ON pe.idEstatPeticio = ep.idEstatPeticio
				INNER JOIN peticionscicles AS pc ON pe.idPeticio = pc.idPeticio
				INNER JOIN ciclesformatius AS cf ON pc.idCicle = cf.idCicle
				INNER JOIN gremis AS gr ON pc.idGremi = gr.idGremi
				WHERE pc.idCicle > 0
				ORDER BY(cf.idCicle)");
			}else if($tipus == 2){
				$sql = $bd->prepare(
				"SELECT em.nomEmpresa, ep.descripcio, pe.nomContacte, pe.email, pe.tasques, pe.telefon, pe.direccio, cf.nomCicle, gr.nomGremi
				FROM peticionsfct AS pe
				INNER JOIN empresa AS em ON pe.idEmpresa = em.idEmpresa
				INNER JOIN estatpeticions AS ep ON pe.idEstatPeticio = ep.idEstatPeticio
				INNER JOIN peticionscicles AS pc ON pe.idPeticio = pc.idPeticio
				INNER JOIN ciclesformatius AS cf ON pc.idCicle = cf.idCicle
				INNER JOIN gremis AS gr ON pc.idGremi = gr.idGremi
				WHERE pc.idGremi = ?
				ORDER BY(cf.idCicle)");
				$sql->bindParam(1, $filtre, PDO::PARAM_INT);
			}else if($tipus == 3){
				$sql = $bd->prepare(
				"SELECT em.nomEmpresa, ep.descripcio, pe.nomContacte, pe.email, pe.tasques, pe.telefon, pe.direccio, cf.nomCicle, gr.nomGremi
				FROM peticionsfct AS pe
				INNER JOIN empresa AS em ON pe.idEmpresa = em.idEmpresa
				INNER JOIN estatpeticions AS ep ON pe.idEstatPeticio = ep.idEstatPeticio
				INNER JOIN peticionscicles AS pc ON pe.idPeticio = pc.idPeticio
				INNER JOIN ciclesformatius AS cf ON pc.idCicle = cf.idCicle
				INNER JOIN gremis AS gr ON pc.idGremi = gr.idGremi
				WHERE pc.idCicle = ?
				ORDER BY(cf.idCicle)");
				$sql->bindParam(1, $filtre, PDO::PARAM_INT);
			}else if($tipus == 4){
				$sql = $bd->prepare(
				"SELECT em.nomEmpresa, ep.descripcio, pe.nomContacte, pe.email, pe.tasques, pe.telefon, pe.direccio, cf.nomCicle, gr.nomGremi
				FROM peticionsfct AS pe
				INNER JOIN empresa AS em ON pe.idEmpresa = em.idEmpresa
				INNER JOIN estatpeticions AS ep ON pe.idEstatPeticio = ep.idEstatPeticio
				INNER JOIN peticionscicles AS pc ON pe.idPeticio = pc.idPeticio
				INNER JOIN ciclesformatius AS cf ON pc.idCicle = cf.idCicle
				INNER JOIN gremis AS gr ON pc.idGremi = gr.idGremi
				WHERE (cf.idGremi = 0 OR ac.idCicle = 0)
				ORDER BY (cf.idCicle)");
			}
		
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
	
	//La usem per obtenir la llista de peticions de FCT de l'institut.
	// afegirAlumnePeticio.php
	function obtenirPeticionsDisponibles($idGremi, $idCicle){		/// Actualitzat \\\
		$dades = new dades();
		$bd = $dades->connecta();
		
		if($bd != false){
			$sql = $bd->prepare("
			SELECT pe.idPeticio, em.nomEmpresa, es.descripcio, pe.nomContacte, pe.email, pe.tasques, pe.telefon, pe.direccio
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
	
	//La usem per obtenir el id del gremi en funció del id del Cicle Formatiu.
	// afegirAlumnePeticio.php, anul-laFCT_AD.php, modificaEstatAlumne_AD.php, modificaPeticioFTC.php
	function getIDGremi($idCicle){									/// Actualitzat \\\
		$dades = new dades();
		$bd = $dades->connecta();
		
		if($bd != false){
			$sql = $bd->prepare("SELECT idGremi	FROM ciclesformatius WHERE idCicle = ?;");
			$sql->bindParam(1, $idCicle, PDO::PARAM_INT);
			
			$sql->execute();
			$resultat = $sql->fetchAll(PDO::FETCH_ASSOC);
			$retorn = false;
			if($resultat){
				foreach ($resultat as $fila){
					foreach($fila as $valor){
						$idGremi = $valor;
					}					
				}
			}else{
				$idGremi = false;
			}
			$bd = null;
		}
		return $idGremi;
	}
	
	//Funció que usarem per obtenir la llista d'Alumnes que estan assignats a curs especific, i també que tinguin les pràctiques pendents.
	// afegirAlumnePeticio.php
	function getAlumnesDisponibles($idCicle){						/// Actualitzat \\\
		$dades = new dades();
		$bd = $dades->connecta();
		$retorn = false;
		if($bd != false){
			$sql = $bd->prepare
			("SELECT al.idAlumne, al.nomAlumne, al.cognomsAlumne
			FROM alumnes AS al
			INNER JOIN estatfct AS es ON al.idEstatFCT = es.idEstatFCT
			WHERE al.idCicle = ? AND es.idEstatFCT = 0;");
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
	}
	
	//Funció que usarem per inserir una relació entre un alumne i una petició de FCT
	// afegirAlumnePeticio.php
	function creaRelacioAlumPet($idAlumne, $idPeticio){				/// Actualitzat \\\
		$dades = new dades();
		$bd = $dades->connecta();
		$retorn = false;
		
		if($bd != false){
			$sql= $bd->prepare("INSERT INTO `alumnepeticio`(`idAlumne`, `idPeticio`) VALUES (?,?);");
			$sql->bindParam(1, $idAlumne, PDO::PARAM_INT);
			$sql->bindParam(2, $idPeticio, PDO::PARAM_INT);
			$sql->execute();
			$filesAfectades = $sql->rowCount();	//Per determinar el nombre de files afectades.
			
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
	// afegirAlumnePeticio.php, finalitzacioFCT_AD.php, anul-laFCT_AD.php, modificaEstatAlumne_AD.php
	function modificaEstatAlumne($idAlumne,$estat){					/// Actualitzat \\\
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
	// afegirAlumnePeticio.php, finalitzacioFCT_AD.php, anul-laFCT_AD.php, modificaPeticioFTC.php
	function modificaEstatPeticio($idPeticio,$estat){				/// Actualitzat \\\
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
	// finalitzacioFCT_AD.php, anul-laFCT_AD.php
	function obtenirRelacioAlumFCT_ID($idCicle){					/// Actualitzat \\\
	
		if($idCicle != false && $idCicle >= 0){
			$dades = new dades();
			$bd = $dades->connecta();
		
			if($bd != false){
				$sql = $bd->prepare("SELECT al.idAlumne, al.nomAlumne, al.cognomsAlumne, es.descripcio, em.nomEmpresa
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
	
	//Funció que usarem per obtenir el ID de la petició en curs que te assignat un alumne.
	// finalitzacioFCT_AD.php, anul-laFCT_AD.php
	function getIdPeticio($idAlumne){								/// Actualitzat \\\
		$dades = new dades();
		$bd = $dades->connecta();
		$idPeticio = false;
		if($bd != false){
			$sql= $bd->prepare("SELECT ap.idPeticio
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
	
	//La usem per obtenir les dades dels alumnes que poden tenir un idEstatFCT modificable.
	//modificaEstatAlumne_AD.php
	function getAlumnesCicleEstatsAturats($idCicle){				/// Actualitzat \\\
		$dades = new dades();
		$bd = $dades->connecta();
		
		if($bd != false){
			$sql = $bd->prepare
			("SELECT al.idAlumne, al.nomAlumne, al.cognomsAlumne, al.emailAlumne, al.telefonAlumne, es.descripcio
			FROM alumnes AS al
			INNER JOIN estatfct AS es ON al.idEstatFCT = es.idEstatFCT
			WHERE al.idCicle = ? AND NOT (al.idEstatFCT = 1 OR al.idEstatFCT = 3 OR al.idEstatFCT = 4);");
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
	}

	//La usem per obtenir el registre d'alumnes de l'insititut amb la informació essencial dels alumnes.
	// llistaAlumnes.php, modificaCursAlumnes
	function obtenirAlumnesCentre_ID($tipus,$filtre){				/// Actualitzat \\\
		$dades = new dades();
		$bd = $dades->connecta();
		
		if($bd != false){
			
			if($tipus == 1){
				$sql = $bd->prepare(
				"SELECT al.idAlumne, al.nomAlumne, al.cognomsAlumne, al.emailAlumne, al.telefonAlumne, es.descripcio, cf.nomCicle, gr.nomGremi
				FROM alumnes AS al
				INNER JOIN estatfct AS es ON al.idEstatFCT = es.idEstatFCT
				INNER JOIN ciclesformatius AS cf ON al.idCicle = cf.idCicle
				INNER JOIN gremis AS gr ON cf.idGremi = gr.idGremi
				WHERE al.idCicle > 0
				ORDER BY (cf.idCicle);");
			}else if($tipus == 2){
				$sql = $bd->prepare(
				"SELECT al.idAlumne, al.nomAlumne, al.cognomsAlumne, al.emailAlumne, al.telefonAlumne, es.descripcio, cf.nomCicle, gr.nomGremi
				FROM alumnes AS al
				INNER JOIN estatfct AS es ON al.idEstatFCT = es.idEstatFCT
				INNER JOIN ciclesformatius AS cf ON al.idCicle = cf.idCicle
				INNER JOIN gremis AS gr ON cf.idGremi = gr.idGremi
				WHERE cf.idGremi = ?
				ORDER BY (cf.idCicle);");
				$sql->bindParam(1, $filtre, PDO::PARAM_INT);
			}else if($tipus == 3){
				$sql = $bd->prepare(
				"SELECT al.idAlumne, al.nomAlumne, al.cognomsAlumne, al.emailAlumne, al.telefonAlumne, es.descripcio, cf.nomCicle, gr.nomGremi
				FROM alumnes AS al
				INNER JOIN estatfct AS es ON al.idEstatFCT = es.idEstatFCT
				INNER JOIN ciclesformatius AS cf ON al.idCicle = cf.idCicle
				INNER JOIN gremis AS gr ON cf.idGremi = gr.idGremi
				WHERE al.idCicle = ?
				ORDER BY (cf.idCicle);");
				$sql->bindParam(1, $filtre, PDO::PARAM_INT);
			}else if($tipus == 4){
				$sql = $bd->prepare(
				"SELECT al.idAlumne, al.nomAlumne, al.cognomsAlumne, al.emailAlumne, al.telefonAlumne, es.descripcio, cf.nomCicle, gr.nomGremi
				FROM alumnes AS al
				INNER JOIN estatfct AS es ON al.idEstatFCT = es.idEstatFCT
				INNER JOIN ciclesformatius AS cf ON al.idCicle = cf.idCicle
				INNER JOIN gremis AS gr ON cf.idGremi = gr.idGremi
				WHERE (cf.idGremi = 0 OR al.idCicle = 0)
				ORDER BY (cf.idCicle)");
			}		
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
	
	//Obtenim les dades bàsiques de l'alumne que haurem de modificar.
	// modificaDadesAlumne.php
	function getDadesAlumneModificar($idAlumne){					/// Actualitzat \\\
		$dades = new dades();
		$bd = $dades->connecta();
		
		if($bd != false){
			$sql = $bd->prepare("SELECT nomAlumne, cognomsAlumne, emailAlumne, telefonAlumne FROM alumnes WHERE idAlumne = ?;");			
			$sql->bindParam(1, $idAlumne, PDO::PARAM_INT);
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
	
	//Funció que usarem per modificar les Dades personals de l'alumne
	//La usem a: modificaDadesAlumne.php
	function modificaDadesAlumne($idAlumne, $nomAlumne,$cognomAlumne,$correu,$telefon){ /// Actualitzat \\\
		$dades = new dades();
		$bd = $dades->connecta();
		$retorn = false;	
		if($bd != false){
			$sql= $bd->prepare("UPDATE `alumnes` SET `nomAlumne`= ?,`cognomsAlumne`= ?,`emailAlumne`= ?,`telefonAlumne`= ? WHERE `idAlumne` = ?;");
			$sql->bindParam(1, $nomAlumne, PDO::PARAM_STR);
			$sql->bindParam(2, $cognomAlumne, PDO::PARAM_STR);
			$sql->bindParam(3, $correu, PDO::PARAM_STR);
			$sql->bindParam(4, $telefon, PDO::PARAM_STR);
			$sql->bindParam(5, $idAlumne, PDO::PARAM_INT);
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
	
	//Funció que usarem per obtenir la relació entre un alumne i una petició de FCT de tots alumnes d'un curs, amb els ID de l'alumne.
	//modificaPeticioFTC.php
	function obtenirEmpreses_ID($idCicle){							/// Actualitzat \\\
		
		if($idCicle != false && $idCicle >= 0){			
			$idGremi = getIDGremi($idCicle);	//Obtenim el ID del Gremi del Cicle.
			
			if($idGremi != false){
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
				echo "<b>Error: No s'ha pogut obtenir el Gremi del Cicle </b>";
			}
		}else{
			echo "<b>Error: No s'ha pogut obtenir el Gremi del Tutor </b>";			
		}
	}

	//FUNCIONS INSEREIX PETICIÓ
	//Funció que ens permetrà inserir una petició a la Base de Dades.
	function tramitaPeticio($id, $estatPeticio, $nomContacte, $email, $tasques, $telefon, $direccio, $gremi, $cicle){
		$dades = new dades();
		
		$bd = $dades->connecta();
		$retorn = false;
		$ultimId = false;
		
		if($bd != false){
			
			$sql= $bd->prepare("INSERT INTO `peticionsfct`(`idEmpresa`,`idEstatPeticio`,`nomContacte`,`email`,`tasques`,`telefon`,`direccio`) VALUES (?,?,?,?,?,?,?)");
			$sql->bindParam(1, $id, PDO::PARAM_INT);
			$sql->bindParam(2, $estatPeticio, PDO::PARAM_INT);
			$sql->bindParam(3, $nomContacte, PDO::PARAM_STR);
			$sql->bindParam(4, $email, PDO::PARAM_STR);
			$sql->bindParam(5, $tasques, PDO::PARAM_STR);
			$sql->bindParam(6, $telefon, PDO::PARAM_STR);
			$sql->bindParam(7, $direccio, PDO::PARAM_STR);					
			$sql->execute();		
			$filesAfectades = $sql->rowCount();	//Per determinar el nombre de files afectades.					
			
			if($filesAfectades > 0){			//Si l'ha inserit, hem de inserir la relació.
				echo "<br>INSERIDES CORRECTAMENT";		
				$ultimId = $bd->lastInsertId();	//Obtenim el darrer ID.						
			}else{							//No les ha inserit
				echo "<br>NO S'HA AFEGIT LA PETICIÓ<br>";						
			}
			$bd = null;	
			
			//Si el darrer id es superior a 0, fem la inserició de la petició relacionada.
			if($ultimId > 0){
				$retorn = insereixRelacioPeticio($ultimId, $gremi, $cicle);
			}
		}
		return $retorn;
	}

	//Funció que ens permet obtenir les especialitats que es cursen al centre.
	//insereixPeticio.php
	function getGremis(){											/// Actualitzat \\\
		$dades = new dades();
		$bd = $dades->connecta();
		if($bd != false){
			$sql= $bd->prepare("SELECT nomGremi FROM gremis WHERE idGremi > 0 ");
			$sql->execute();
			$arrayDades = array();
			$i = 0;
			do{
				$resultat = $sql->fetchColumn();
				if($resultat){
					$arrayDades[$i] = $resultat;
					$i = $i+1;
				}
			}while($resultat);
		}
		$bd = null;
		return $arrayDades;
	}		
	
	//Funció que enes permet obtenir els cicles formatius d'un gremi en concret.
	function getCicles($gremi){
		$dades = new dades();
		
		$bd = $dades->connecta();
		
		if($bd != false){
			
			$sql= $bd->prepare("SELECT nomCicle FROM ciclesformatius WHERE idGremi = ?");
			$sql = $bd->bindParam(1,$gremi,PDO::PARAM_INT);
			$sql->execute();
			
			$arrayDades = array();
			$i = 0;
			do{
				$resultat = $sql->fetchColumn();
				
				if($resultat){							
					$arrayDades[$i] = $resultat;
					$i = $i+1;
				}						
			}while($resultat);
			if($arrayDades){
				//print_r($arrayDades);
			}else{
				echo "NO DATA ARRAY";
			}					
			$bd = null;					
		}
		return $arrayDades;
	}		
	
	//Funció que ens comprovarà si l'empresa inserida existeix.
	//insereixPeticio.php
	function comprovaEmpresa($nif, $nomEmpresa){					/// Actualitzat \\\
		$dades = new dades();
		$bd = $dades->connecta();		
		$idEmpresa = false;		
		if($bd != false){			
			$sql= $bd->prepare("SELECT idEmpresa, NIF FROM empresa WHERE NIF = ?;");
			$sql->bindParam(1, $nif, PDO::PARAM_STR, 8);
			$sql->execute();		
			$resultat = $sql->fetchAll(PDO::FETCH_ASSOC);
			if($resultat){				
				foreach ($resultat as $fila){
					$index = 0;
					foreach ($fila as $valor){
						if($index === 0){
							$idEmpresa = $valor;
						}
						$index = $index + 1;
					}
				}				
				$bd = null;
			}else if(!$resultat){	//Si no l'ha trobat, haurem de crear un registre per l'empresa.
				$bd = null;
				$idEmpresa = insereixEmpresa($nif, $nomEmpresa);	//Crida a la funció Inserir empresa.				
			}			
		}
		return $idEmpresa;
	}
	
	//Funció que ens comprovarà si l'empresa inserida existeix.
	//insereixPeticio.php
	function insereixEmpresa($nif, $nomEmpresa){					/// Actualitzat \\\
		$dades = new dades();
		$bd = $dades->connecta();
		if($bd != false){			
			$sql= $bd->prepare("INSERT INTO `empresa`(`nomEmpresa`, `NIF`) VALUES (?,?);");
			$sql->bindParam(1, $nomEmpresa, PDO::PARAM_STR);
			$sql->bindParam(2, $nif, PDO::PARAM_STR);
			$sql->execute();
			$filesAfectades = $sql->rowCount();	//Per determinar el nombre de files afectades.			
			if($filesAfectades > 0){			//Si l'ha trobat, també obtenim l'ID de l'emrpesa.
				$ultimId = $bd->lastInsertId();	//Obtenim el darrer ID.
			}else{								//No les ha inserit
				$ultimId = false;
			}			
		}
		$bd = null;
		return $ultimId;
	}
	
	//Funció que inserirà a la BBDD la relació entre una petició i el gremi (i cicle si escau al que pertany).
	function insereixRelacioPeticio($ultimId, $gremi, $cicle){
		$dades = new dades();
		
		$bd = $dades->connecta();				
		$retorn = false;
		if($bd != false){
			
			$sql= $bd->prepare("INSERT INTO `peticionscicles`(`idPeticio`, `idGremi`, `idCicle`) VALUES (?,?,?);");
			$sql->bindParam(1, $ultimId, PDO::PARAM_INT);
			$sql->bindParam(2, $gremi, PDO::PARAM_INT);
			$sql->bindParam(3, $cicle, PDO::PARAM_INT);
			$sql->execute();		
			$filesAfectades = $sql->rowCount();	//Per determinar el nombre de files afectades.					
			
			if($filesAfectades > 0){									
				echo "<br>RELACIÓ INSERIDA CORRECTAMENT";						
				$retorn = true;
			}else{							//No les ha inserit
				echo "<br>NO S'HA AFEGIT LA RELACIÓ<br>";
				$retorn = false;
			}
			$bd = null;					
		}
		return $retorn;
	}		

	//Funcions modificar mestre
	//Funció que ens permet obtenir les especialitats que es cursen al centre.
	//modificaCursTutor.php, modificaDadesMestre.php
	function getMestres(){											/// Actualitzat \\\
		$dades = new dades();		
		$bd = $dades->connecta();
		$retorn = false;
		if($bd != false){
			$sql = $bd->prepare("SELECT idProf, nomProf, cognomProf FROM professors WHERE idProf > 1;");			
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
	
	// Obtenim les dades del mestre que tenen opció a ser modificades.
	// modificaDadesMestre.php
	function getDadesMestreModificar($idProf){						/// Actualitzat \\\
		$dades = new dades();
		$bd = $dades->connecta();
		$retorn = false;
		if($bd != false){
			$sql = $bd->prepare("SELECT nomProf, cognomProf, emailProf, telefonProf, nomDePas, clauDePas FROM professors WHERE idProf = ?;");			
			$sql->bindParam(1, $idProf, PDO::PARAM_INT);
			$sql->execute();		
			$resultat = $sql->fetchAll(PDO::FETCH_ASSOC);			
			if($resultat){
				$retorn = $resultat;
			}else{
				$retorn = false;
			}
			$bd = null;
		}
		return $retorn;
	}

	//Funció que usarem per modificar les Dades personals de l'alumne
	//La usem a: modificaDadesAlumne.php
	function modificaDadesMestre($idProf,$nomAlumne,$cognomAlumne,$correu,$telefon,$nomDePas,$clauDePas){	/// Actualitzat \\\
		$dades = new dades();
		$bd = $dades->connecta();
		$retorn = false;	
		if($bd != false){
			$sql= $bd->prepare("UPDATE `professors` SET `nomProf`= ?,`cognomProf`= ?,`emailProf`= ?,`telefonProf`= ?,`nomDePas`= ?,`clauDePas`= ? WHERE `idProf` = ?;");
			$sql->bindParam(1, $nomAlumne, PDO::PARAM_STR);
			$sql->bindParam(2, $cognomAlumne, PDO::PARAM_STR);
			$sql->bindParam(3, $correu, PDO::PARAM_STR);
			$sql->bindParam(4, $telefon, PDO::PARAM_STR);
			$sql->bindParam(5, $nomDePas, PDO::PARAM_STR);
			$sql->bindParam(6, $clauDePas, PDO::PARAM_STR);
			$sql->bindParam(7, $idProf, PDO::PARAM_INT);			
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
	
	//Funció que usarem per inserir una relació entre un alumne i una petició de FCT
	//insereixTutorsFCT.php
	function insereixMestre($nomMestre,$cognomMestre,$email,$telefon,$rol,$nomPas,$clauPas,$cicle){			/// Actualitzat \\\
		$dades = new dades();
		$bd = $dades->connecta();
		$retorn = false;		
		if($bd != false){
			$sql= $bd->prepare("INSERT INTO `professors`(`nomProf`, `cognomProf`, `emailProf`, `telefonProf`, `idTipusRol`, `nomDePas`, `clauDePas`) VALUES 
			(?,?,?,?,?,?,?)");
			$sql->bindParam(1, $nomMestre, PDO::PARAM_STR);
			$sql->bindParam(2, $cognomMestre, PDO::PARAM_STR);
			$sql->bindParam(3, $email, PDO::PARAM_STR);
			$sql->bindParam(4, $telefon, PDO::PARAM_STR);
			$sql->bindParam(5, $rol, PDO::PARAM_INT);
			$sql->bindParam(6, $nomPas, PDO::PARAM_STR);
			$sql->bindParam(7, $clauPas, PDO::PARAM_STR);
			$sql->execute();
			$filesAfectades = $sql->rowCount();	//Per determinar el nombre de files afectades.			
			if($filesAfectades > 0){
				$ultimId = $bd->lastInsertId();	//Obtenim el darrer ID.
			}else{
				$ultimId = false;
			}
		}
		$bd = null;
		return $ultimId;
	}
	
	//Funció que usarem per inserir una relació entre un mestre i un cicle formatiu
	//insereixTutorsFCT.php, modificaCursTutor.php
	function insereixRelacioMestreCicle($idMestre,$cicle){		/// Actualitzat \\\
		$dades = new dades();
		$bd = $dades->connecta();
		$retorn = false;		
		if($bd != false){
			$sql= $bd->prepare("INSERT INTO `professorscicles`(`idProf`, `idCicle`) VALUES (?,?)");
			$sql->bindParam(1, $idMestre, PDO::PARAM_INT);
			$sql->bindParam(2, $cicle, PDO::PARAM_INT);
			$sql->execute();
			$filesAfectades = $sql->rowCount();	//Per determinar el nombre de files afectades.
			if($filesAfectades > 0){
				$retorn = true;	//Obtenim el darrer ID.
			}else{
				$retorn = false;
			}			
		}
		$bd = null;
		return $retorn;
	}

	// Obtenim les dads bàsiques del mestre en funció del seu ID.
	// modificaCursTutor.php
	function getDadesMestreCurs($idProf){					/// Actualitzat \\\
		$dades = new dades();
		$bd = $dades->connecta();
		$retorn = false;
		if($bd != false){
			$sql = $bd->prepare
			("SELECT pr.nomProf, pr.cognomProf, cf.nomCicle 
			FROM ciclesformatius AS cf
			INNER JOIN professorscicles AS pc ON cf.idCicle = pc.idCicle
			INNER JOIN professors AS pr ON pr.idProf = pc.idProf
			WHERE pr.idProf = ?");
			$sql->bindParam(1, $idProf, PDO::PARAM_INT);
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
	
	// Obtenim el llistat de Cicles Formatius on pot fer docencia un mestre en funció del Gremi al que pertany.
	// modificaCursTutor.php
	function getLlistaCiclesPerMestre($idProf){				/// Actualitzat \\\
		$dades = new dades();
		$bd = $dades->connecta();
		$retorn = false;
		if($bd != false){
			$sql = $bd->prepare("SELECT cf.idCicle, cf.nomCicle
								FROM ciclesformatius As cf
								WHERE cf.idGremi = (SELECT cf.idGremi
													FROM ciclesformatius AS cf
													INNER JOIN professorscicles AS pc ON cf.idCicle = pc.idCicle
													INNER JOIN professors AS pr ON pr.idProf = pc.idProf
													WHERE pr.idProf = ?);");
			$sql->bindParam(1, $idProf, PDO::PARAM_INT);
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
	
	//Funció que usarem per modificar la relació entre un Mestre i un Cicle Formatiu.
	// modificaCursTutor.php
	function modificaRelacioCursMestre($idMestre, $idCicle){	/// Actualitzat \\\
		$dades = new dades();
		$bd = $dades->connecta();
		$retorn = false;	
		if($bd != false){
			$sql= $bd->prepare("UPDATE `professorscicles` SET `idCicle`= ? WHERE `idProf` = ?;");
			$sql->bindParam(1, $idCicle, PDO::PARAM_INT);
			$sql->bindParam(2, $idMestre, PDO::PARAM_INT);			
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
	
	//Funció que ens permetrà inserir una petició a la Base de Dades.
	// insereixPeticioBT.php
	function tramitaPeticio_BT($id, $tasques, $requisits, $direccio, $email, $telefon, $gremi, $cicle){		/// Actualitzat \\\
		$dades = new dades();		
		$bd = $dades->connecta();
		$retorn = false;
		$ultimId = false;
		
		if($bd != false){			
			$sql= $bd->prepare("INSERT INTO `ofertesbt`(`idEmpresa`,`tasques`,`requisits`,`direccio`,`email`,`telefon`) VALUES (?,?,?,?,?,?)");
			$sql->bindParam(1, $id, PDO::PARAM_INT);
			$sql->bindParam(2, $tasques, PDO::PARAM_STR);
			$sql->bindParam(3, $requisits, PDO::PARAM_STR);
			$sql->bindParam(4, $direccio, PDO::PARAM_STR);
			$sql->bindParam(5, $email, PDO::PARAM_STR);
			$sql->bindParam(6, $telefon, PDO::PARAM_STR);
			$sql->execute();
			$filesAfectades = $sql->rowCount();			
			if($filesAfectades > 0){
				$ultimId = $bd->lastInsertId();
			}		
			//Si el darrer id es superior a 0, fem la inserició de la petició relacionada.
			if($ultimId > 0){
				$retorn = insereixRelacioOferta($ultimId, $gremi, $cicle);
			}
		}
		$bd = null;
		return $retorn;
	}
	
	//Funció que ens comprovarà si l'empresa inserida existeix.
	// insereixPeticioBT.php
	function comprovaEmpresa_BT($nif, $nomEmpresa){				/// Actualitzat \\\
		$dades = new dades();		
		$bd = $dades->connecta();		
		$idEmpresa = false;		
		if($bd != false){			
			$sql= $bd->prepare("SELECT idEmpresa, NIF FROM empresa WHERE NIF = ?;");
			$sql->bindParam(1, $nif, PDO::PARAM_STR);
			$sql->execute();		
			$resultat = $sql->fetchAll(PDO::FETCH_ASSOC);			
			if($resultat){			//Si l'ha trobat, també obtenim l'ID de l'emrpesa.
				foreach ($resultat as $fila){
					$index = 0;
					foreach ($fila as $valor) {
						if($index === 0){
							$idEmpresa = $valor;
						}
						$index = $index + 1;
					}
				}				
				$bd = null;
			}else if(!$resultat){	//Si no l'ha trobat, haurem de crear un registre per l'empresa.
				$bd = null;	
				$idEmpresa = insereixEmpresa_BT($nif, $nomEmpresa);	//Crida a la funció Inserir empresa.				
			}
		}
		return $idEmpresa;
	}
	
	//Funció que ens comprovarà si l'empresa inserida existeix.
	// insereixPeticioBT.php
	function insereixEmpresa_BT($nif, $nomEmpresa){					/// Actualitzat \\\
		$dades = new dades();
		$bd = $dades->connecta();		
		if($bd != false){			
			$sql= $bd->prepare("INSERT INTO `empresa`(`nomEmpresa`, `NIF`) VALUES (?,?);");
			$sql->bindParam(1, $nomEmpresa, PDO::PARAM_STR);
			$sql->bindParam(2, $nif, PDO::PARAM_STR);
			$sql->execute();
			$filesAfectades = $sql->rowCount();			
			if($filesAfectades > 0){			
				$ultimId = $bd->lastInsertId();	//Obtenim el darrer ID.
		
			}else{				
				$ultimId = false;
			}
		}
		$bd = null;
		return $ultimId;
	}
	
	//Funció que inserirà a la BBDD la relació entre una petició i el gremi (i cicle si escau al que pertany).
	// insereixPeticioBT.php
	function insereixRelacioOferta($ultimId, $gremi, $cicle){		/// Actualitzat \\\
		$dades = new dades();
		$bd = $dades->connecta();
		$retorn = false;
		if($bd != false){
			$sql= $bd->prepare("INSERT INTO `ofertescicles`(`idOferta`,`idCicle`,`idGremi`) VALUES (?,?,?);");
			$sql->bindParam(1, $ultimId, PDO::PARAM_INT);
			$sql->bindParam(2, $cicle, PDO::PARAM_INT);
			$sql->bindParam(3, $gremi, PDO::PARAM_INT);
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
	
	//Obtenim les dades bàsiques de l'alumne que haurem de modificar.
	// modificaCursAlumnes.php
	function getDadesRelacioAlumneModificar($idAlumne){				/// Actualitzat \\\
		$dades = new dades();		
		$bd = $dades->connecta();		
		if($bd != false){
			$sql = $bd->prepare("SELECT al.nomAlumne, al.cognomsAlumne, cf.nomCicle, pr.nomProf, pr.cognomProf
								FROM alumnes AS al
								INNER JOIN ciclesformatius As cf ON al.idCicle = cf.idCicle
								INNER JOIN professors AS pr ON al.idProf = pr.idProf								
								WHERE al.idAlumne = ?;");			
			$sql->bindParam(1, $idAlumne, PDO::PARAM_INT);
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
	
	//Obtenim les dades bàsiques de l'alumne que haurem de modificar.
	// modificaCursAlumnes.php
	function getMestresCurs($idCicle){								/// Actualitzat \\\
		$dades = new dades();		
		$bd = $dades->connecta();
		$retorn = false;
		if($bd != false){
			$sql = $bd->prepare
			("SELECT pr.idProf, pr.nomProf, pr.cognomProf, cf.nomCicle
			FROM professors AS pr
			INNER JOIN professorscicles AS pc ON pr.idProf = pc.idProf
			INNER JOIN ciclesformatius AS cf ON pc.idCicle = cf.idCicle
			WHERE cf.idCicle = ?;");
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
	}
	
	//Funció que usarem per modificar la relació entre un Mestre i un Cicle Formatiu.
	//La usem a: modificaDadesAlumne.php
	function modificaRelacioCursAlumne($idMestre, $idCicle, $idAlumne){	/// Actualitzat \\\
		$dades = new dades();
		$bd = $dades->connecta();
		$retorn = false;	
		if($bd != false){
			$sql= $bd->prepare("UPDATE `alumnes` SET `idCicle`= ?, `idProf`= ? WHERE `idAlumne`= ?;");
			$sql->bindParam(1, $idCicle, PDO::PARAM_INT);
			$sql->bindParam(2, $idMestre, PDO::PARAM_INT);
			$sql->bindParam(3, $idAlumne, PDO::PARAM_INT);			
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
	
	//FUNCIONS DE DONAR DE BAIXA UN ALUMNE
	// baixaAlumne.php
	function obtenirAlumnesCentreBaixa($tipus,$filtre){				/// Actualitzada \\\
		$dades = new dades();
		$bd = $dades->connecta();		
		if($bd != false){
			if($tipus == 1){
				$sql = $bd->prepare(
				"SELECT al.idAlumne, al.nomAlumne, al.cognomsAlumne, al.emailAlumne, al.telefonAlumne, es.descripcio, cf.nomCicle, gr.nomGremi
				FROM alumnes AS al
				INNER JOIN estatfct AS es ON al.idEstatFCT = es.idEstatFCT
				INNER JOIN ciclesformatius AS cf ON al.idCicle = cf.idCicle
				INNER JOIN gremis AS gr ON cf.idGremi = gr.idGremi
				WHERE al.idCicle > 0
				ORDER BY (cf.idCicle);");
			}else if($tipus == 2){
				$sql = $bd->prepare(
				"SELECT al.idAlumne, al.nomAlumne, al.cognomsAlumne, al.emailAlumne, al.telefonAlumne, es.descripcio, cf.nomCicle, gr.nomGremi
				FROM alumnes AS al
				INNER JOIN estatfct AS es ON al.idEstatFCT = es.idEstatFCT
				INNER JOIN ciclesformatius AS cf ON al.idCicle = cf.idCicle
				INNER JOIN gremis AS gr ON cf.idGremi = gr.idGremi
				WHERE cf.idGremi = ?
				ORDER BY (cf.idCicle);");
				$sql->bindParam(1, $filtre, PDO::PARAM_INT);
			}else if($tipus == 3){
				$sql = $bd->prepare(
				"SELECT al.idAlumne, al.nomAlumne, al.cognomsAlumne, al.emailAlumne, al.telefonAlumne, es.descripcio, cf.nomCicle, gr.nomGremi
				FROM alumnes AS al
				INNER JOIN estatfct AS es ON al.idEstatFCT = es.idEstatFCT
				INNER JOIN ciclesformatius AS cf ON al.idCicle = cf.idCicle
				INNER JOIN gremis AS gr ON cf.idGremi = gr.idGremi
				WHERE al.idCicle = ?
				ORDER BY (cf.idCicle);");
				$sql->bindParam(1, $filtre, PDO::PARAM_INT);
			}else if($tipus == 4){
				$sql = $bd->prepare(
				"SELECT al.idAlumne, al.nomAlumne, al.cognomsAlumne, al.emailAlumne, al.telefonAlumne, es.descripcio, cf.nomCicle, gr.nomGremi
				FROM alumnes AS al
				INNER JOIN estatfct AS es ON al.idEstatFCT = es.idEstatFCT
				INNER JOIN ciclesformatius AS cf ON al.idCicle = cf.idCicle
				INNER JOIN gremis AS gr ON cf.idGremi = gr.idGremi
				WHERE (cf.idGremi = 0 OR al.idCicle = 0)
				ORDER BY (cf.idCicle)");
			}		
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
		unset($bd);
		unset($dades);
		return $retorn;
	}

	//Obtenir les Dades de l'Alumne al que li farem la transferència a una altre taula.
	// baixaAlumne.php
	function getDadesAlumneTransferencia($idAlumne){				/// Actualitzada \\\
		$dades = new dades();		
		$bd = $dades->connecta();		
		if($bd != false){
			$sql = $bd->prepare("SELECT al.nomAlumne, al.cognomsAlumne, al.emailAlumne, al.telefonAlumne, al.idCicle
								FROM alumnes AS al
								WHERE al.idAlumne = ?;");
			$sql->bindParam(1, $idAlumne, PDO::PARAM_INT);
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
	
	//Comprova si l'Alumne que mirem d'inserir a ExAlumnes, ja disposava d'un camp a aquesta taula o no.
	// baixaAlumne.php
	function comprovaExistenciaAlumne($idAlumne){					/// Actualitzada \\\
		$dades = new Dades(); 
		$bd = $dades->connecta();
		$retorn = false;
		if($bd != false){
			$sql = $bd->prepare("SELECT idExAlumnes FROM `exalumnes` WHERE anticIdAlumne = ?");
			$sql->bindParam(1, $idAlumne, PDO::PARAM_INT);
			$sql->execute();		
			$resultat = $sql->fetchAll(PDO::FETCH_ASSOC);			
			if($resultat){
				$retorn = $resultat;
			}			
		}
		$bd = null;
		return $retorn;
	}
	
	//Inserir un nou registre d'un alumne a la taula d'exalumnes
	// baixaAlumne.php
	function setNouExalumne($idAlumne,$nomAlumne,$cognomAlumne,$email,$telefon){	/// Actualitzada \\\
		$dades = new dades();		
		$bd = $dades->connecta();
		$ultimId = false;		
		if($bd != false){
			$sql= $bd->prepare("INSERT INTO `exalumnes`(`nomAlumne`, `cognomsAlumne`, `emailAlumne`, `telefonAlumne`, `anticIdAlumne`) VALUES (?,?,?,?,?);");
			$sql->bindParam(1, $nomAlumne, PDO::PARAM_STR);
			$sql->bindParam(2, $cognomAlumne, PDO::PARAM_STR);
			$sql->bindParam(3, $email, PDO::PARAM_STR);
			$sql->bindParam(4, $telefon, PDO::PARAM_STR);
			$sql->bindParam(5, $idAlumne, PDO::PARAM_INT);
			$sql->execute();
			$filesAfectades = $sql->rowCount();			
			if($filesAfectades > 0){
				$ultimId = $bd->lastInsertId();
			}
		}
		$bd = null;
		return $ultimId;
	};
	
	//Inserir la relació entre un ExAlumne i el Cicle Formatiu.
	// baixaAlumne.php
	function setRelacioExAlumneCicle($idExalumne, $cicleFormatiu){	/// Actualitza \\\
		$dades = new dades();
		$bd = $dades->connecta();
		$retorn = false;
		if($bd != false){			
			$sql= $bd->prepare("INSERT INTO `exalumnescicles`(`idExAlumne`, `idCicle`) VALUES (?,?);");
			$sql->bindParam(1, $idExalumne, PDO::PARAM_INT);
			$sql->bindParam(2, $cicleFormatiu, PDO::PARAM_INT);
			$sql->execute();
			$filesAfectades = $sql->rowCount();			
			if($filesAfectades > 0){
				$retorn = true;
			}
		}
		$bd = null;
		return $retorn;
	}
	
	//Elimina la relació entre una FCT i un Alumne, PASSANT COM A PARÀMETRE L'ID DE L'ALUMNE!
	// baixaAlumne.php
	function eliminaAlumnePeticio($idAlumne){						/// Actualitzada \\\
		$dades = new dades();
		$bd = $dades->connecta();
		$retorn = false;
		if($bd != false){
			$sql= $bd->prepare("DELETE FROM `alumnepeticio` WHERE `idAlumne`= ?;");
			$sql->bindParam(1, $idAlumne, PDO::PARAM_INT);
			$sql->execute();
			$filesAfectades = $sql->rowCount();			
			if($filesAfectades > 0){
				$retorn = true;
			}
		}
		$bd = null;
		return $retorn;
	}
	
	//Elimina un Alumne!
	// baixaAlumne.php
	function eliminaAlumne($idAlumne){						/// Actualitzada \\\
		$dades = new dades();
		$bd = $dades->connecta();
		$retorn = false;	
		if($bd != false){
			$sql= $bd->prepare("DELETE FROM `alumnes` WHERE `idAlumne`= ?;");
			$sql->bindParam(1, $idAlumne, PDO::PARAM_INT);
			$sql->execute();
			$filesAfectades = $sql->rowCount();			
			if($filesAfectades > 0){
				$retorn = true;
			}
		}
		$bd = null;
		return $retorn;
	}
	
	//Reposa el Curs del Cicle Formatiu de l'Alumne al curs "Sense Especificar" al ser mantingut i no eliminat de la Base de Dades.	
	// baixaAlumne.php
	function resetCicle($idAlumne){
		$dades = new dades();
		$bd = $dades->connecta();
		$retorn = false;
		if($bd != false){
			$sql= $bd->prepare("UPDATE `alumnes` SET `idEstatFCT`= 0,`idCicle`= 0,`idProf`= 1 WHERE `idAlumne` = ?");
			$sql->bindParam(1, $idAlumne, PDO::PARAM_INT);
			$sql->execute();
			$filesAfectades = $sql->rowCount();			
			if($filesAfectades > 0){
				$retorn = true;
			}
		}
		$bd = null;
		return $retorn;
	}
	
	//Comprova si hi ha relació entre un alumne i les FCT.
	// baixaAlumne.php
	function comprovaExistenciaRelacioAlumneFCT($idAlumne){
		$dades = new Dades();
		$bd = $dades->connecta();
		$retorn = false;
		if($bd != false){
			$sql = $bd->prepare("SELECT COUNT(idAlumnePeticio) AS res FROM alumnepeticio WHERE idAlumne = ?");
			$sql->bindParam(1, $idAlumne, PDO::PARAM_INT);
			$sql->execute();
			$resultat = $sql->fetchAll(PDO::FETCH_ASSOC);
			if($resultat){
				foreach($resultat as $fila){
					$retorn = $fila["res"];
				}
			}
		}
		$bd = null;
		return $retorn;
	}
	
	//Obtenim el llistat d'Ofertes de Treball.
	// llistaOfertesBT.php
	function obtenirOfertesCentre($tipus,$filtre,$sentencia){				/// Actualitzat \\\
		$dades = new dades();
		$bd = $dades->connecta();
		
		if($bd != false){			
			if($tipus == 1){
				$sql = $bd->prepare($sentencia);
			}else if($tipus == 2){
				$sql = $bd->prepare($sentencia);
				$sql->bindParam(1, $filtre, PDO::PARAM_INT);
			}else if($tipus == 3){
				$sql = $bd->prepare($sentencia);
				$sql->bindParam(1, $filtre, PDO::PARAM_INT);
			}else if($tipus == 4){
				$sql = $bd->prepare($sentencia);
			}
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
	
	//Inserir un Alumne nou a la Base de Dades.
	// inserirAlumnes.php
	function insereixNouAlumne($nomAlumne,$cognomsAlumne,$email,$telefon,$idCicle,$idMestre){
		$dades = new dades();
		$bd = $dades->connecta();
		$retorn = false;
		$idEstatFCT = 0;		
		if($bd != false){			
			$sql= $bd->prepare("INSERT INTO alumnes (nomAlumne, cognomsAlumne, emailAlumne, telefonAlumne, idEstatFCT, idCicle, idProf) VALUES 
			(?,?,?,?,?,?,?)");
			$sql->bindParam(1, $nomAlumne, PDO::PARAM_STR);
			$sql->bindParam(2, $cognomsAlumne, PDO::PARAM_STR);
			$sql->bindParam(3, $email, PDO::PARAM_STR);
			$sql->bindParam(4, $telefon, PDO::PARAM_STR);
			$sql->bindParam(5, $idEstatFCT, PDO::PARAM_INT);
			$sql->bindParam(6, $idCicle, PDO::PARAM_INT);
			$sql->bindParam(7, $idMestre, PDO::PARAM_INT);
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
	
	//Obtenim el llistat dels exalumnes.
	// llistaExAlumnes.php
	function obtenirExAlumnes($tipus,$filtre,$sentencia){				/// Actualitzat \\\
		$dades = new dades();
		$bd = $dades->connecta();
		
		if($bd != false){			
			if($tipus == 1){
				$sql = $bd->prepare($sentencia);
			}else if($tipus == 2){
				$sql = $bd->prepare($sentencia);
				$sql->bindParam(1, $filtre, PDO::PARAM_INT);
			}else if($tipus == 3){
				$sql = $bd->prepare($sentencia);
				$sql->bindParam(1, $filtre, PDO::PARAM_INT);
			}else if($tipus == 4){
				$sql = $bd->prepare($sentencia);
			}
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
	
?>