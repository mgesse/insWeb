<?php
//Variables de Connexió a la BBDD
class dades{
	public $host='localhost';
	public $bbdd='gestiofct';
	public $usuari='root';
	public $clau='';
	
	function connecta(){
		try{
			//Establim connexió amb la BBDD
			//$bd = new PDO('mysql:host='.$this->host.';dbname='.$this->bbdd.';charset=UTF8',$this->usuari,$this->clau);
			$bd = new PDO('mysql:host='.$this->host.';dbname='.$this->bbdd.'',$this->usuari,$this->clau);
			
		}catch(PDOException $e){
			print "Error! ".$e->getMessage()."<br>";
			
			die("Error! ".$e->getMessage()."<br>");
		}
		
		if($bd){
			//echo "Funciona";
			return $bd;
		}else{
			echo "NO Funciona";
			return false;
		}
	}	
}
?>