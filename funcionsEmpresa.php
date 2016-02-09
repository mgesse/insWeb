<?php
	//Funció que ens permetrà inserir una petició a la Base de Dades.
	function tramitaPeticio($id, $estatPeticio, $nomContacte, $email, $tasques, $telefon, $direccio, $gremi, $cicle){
		$dades = new dades();
		
		$bd = $dades->connecta();
		$retorn = false;
		$ultimId = false;
		
		/*echo "<br> - - ID: $id - -";
		echo "<br> - - Estat de la Petició: $estatPeticio - -";
		echo "<br> - - Nom del Contacte: $nomContacte - -";
		echo "<br> - - Correu: $email - -";
		echo "<br> - - tasques: $tasques - -";
		echo "<br> - - telefon: $telefon - -";
		echo "<br> - - Direcció: $direccio - -";*/
		
		
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
				//echo "<br>INSERIDES CORRECTAMENT";		
				$ultimId = $bd->lastInsertId();	//Obtenim el darrer ID.						
			}else{							//No les ha inserit
				//echo "<br>NO S'HA AFEGIT LA PETICIÓ<br>";						
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
	function getGremis(){
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
			if($arrayDades){
				//print_r($arrayDades);
			}else{
				///echo "NO DATA ARRAY";
			}					
			$bd = null;					
		}
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
				//echo "NO DATA ARRAY";
			}					
			$bd = null;					
		}
		return $arrayDades;
	}		
	
	//Funció que ens comprovarà si l'empresa inserida existeix.
	function comprovaEmpresa($nif, $nomEmpresa){
		$dades = new dades();
		
		$bd = $dades->connecta();				
		
		$idEmpresa = false;
		
		if($bd != false){
			
			$sql= $bd->prepare("SELECT idEmpresa, NIF FROM empresa WHERE NIF = ?;");
			$sql->bindParam(1, $nif, PDO::PARAM_STR, 8);
			$sql->execute();			
		
			$resultat = $sql->fetchAll(PDO::FETCH_ASSOC);				
			
			if($resultat){			//Si l'ha trobat, també obtenim l'ID de l'emrpesa.
				//echo "<br>Dades Trobades<br>";
				print_r($resultat);
				
				foreach ($resultat as $fila){
					$index = 0;							
					foreach ($fila as $valor) {
						if($index === 0){
							//echo "<br> $valor\n";
							$idEmpresa = $valor;
						}								
						$index = $index + 1;								
					}
				}						
				
				$bd = null;	
			}else if(!$resultat){	//Si no l'ha trobat, haurem de crear un registre per l'empresa.
				//echo "<br>Dades Buides<br>";
				//print_r($resultat);
				
				$bd = null;	
				//Crida a la funció Inserir Empresa. Haurem de fer un LastId.
				$idEmpresa = insereixEmpresa($nif, $nomEmpresa);
				
			}else{							//Si no es cap de les dues, alguna cosa ha anat malament.
				//echo "<br>???<br>";
				$bd = null;	
			}
			//$bd = null;	//No ens cal aquí.				
		}
		return $idEmpresa;
	}
	
	//Funció que ens comprovarà si l'empresa inserida existeix.
	function insereixEmpresa($nif, $nomEmpresa){
		$dades = new dades();
		
		$bd = $dades->connecta();				
		
		if($bd != false){
			
			$sql= $bd->prepare("INSERT INTO `empresa`(`nomEmpresa`, `NIF`) VALUES (?,?);");
			$sql->bindParam(1, $nomEmpresa, PDO::PARAM_STR, 45);
			$sql->bindParam(2, $nif, PDO::PARAM_STR, 9);
			$sql->execute();		
			$filesAfectades = $sql->rowCount();	//Per determinar el nombre de files afectades.					
			
			if($filesAfectades > 0){			//Si l'ha trobat, també obtenim l'ID de l'emrpesa.
				$ultimId = $bd->lastInsertId();	//Obtenim el darrer ID.
				//echo "ID del darrer valor: $ultimId";						
				
			}else{							//No les ha inserit
				//echo "<br>NO S'HA AFEGIT L'EMPRESA<br>";
				$ultimId = false;
			}
			$bd = null;					
		}
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
				//echo "<brRELACIÓ INSERIDA CORRECTAMENT";						
				$retorn = true;
			}else{							//No les ha inserit
				//echo "<br>NO S'HA AFEGIT LA RELACIÓ<br>";
				$retorn = false;
			}
			$bd = null;					
		}
		return $retorn;
	}

//===================================================================================================================================
//======================================= Funcions per a les Ofertes de Treball =====================================================
//===================================================================================================================================

//Funció que ens permetrà inserir una petició a la Base de Dades.
	function tramitaPeticioEmp($id, $tasques, $requisits, $direccio, $email, $telefon, $gremi, $cicle){
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
			$filesAfectades = $sql->rowCount();	//Per determinar el nombre de files afectades.					
			
			if($filesAfectades > 0){			//Si l'ha inserit, hem de inserir la relació.
				//echo "<br>INSERIDES CORRECTAMENT";		
				$ultimId = $bd->lastInsertId();	//Obtenim el darrer ID.						
			}else{							//No les ha inserit
				//echo "<br>NO S'HA AFEGIT LA PETICIÓ<br>";						
			}
			$bd = null;	
			
			//Si el darrer id es superior a 0, fem la inserició de la petició relacionada.
			if($ultimId > 0){
				$retorn = insereixRelacioOferta($ultimId, $gremi, $cicle);
			}
		}
		return $retorn;
	}
	
	//Funció que inserirà a la BBDD la relació entre una petició i el gremi (i cicle si escau al que pertany).
	function insereixRelacioOferta($ultimId, $gremi, $cicle){
		$dades = new dades();
		
		$bd = $dades->connecta();				
		$retorn = false;
		if($bd != false){
			
			$sql= $bd->prepare("INSERT INTO `ofertescicles`(`idOferta`,`idCicle`,`idGremi`) VALUES (?,?,?);");
			$sql->bindParam(1, $ultimId, PDO::PARAM_INT);
			$sql->bindParam(2, $cicle, PDO::PARAM_INT);
			$sql->bindParam(3, $gremi, PDO::PARAM_INT);
			$sql->execute();		
			$filesAfectades = $sql->rowCount();	//Per determinar el nombre de files afectades.					
			
			if($filesAfectades > 0){									
				//echo "<brRELACIÓ INSERIDA CORRECTAMENT";						
				$retorn = true;
			}else{							//No les ha inserit
				//echo "<br>NO S'HA AFEGIT LA RELACIÓ<br>";
				$retorn = false;
			}
			$bd = null;					
		}
		return $retorn;
	}
	
?>