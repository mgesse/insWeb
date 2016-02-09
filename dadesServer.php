<?php
//Variables de Connexió a la BBDD
class dades{
	/*public $host='localhost';
	public $bbdd='gestiofct';
	public $usuari='root';
	public $clau='';*/
	
	public $host='mysql.hostinger.es';
	public $bbdd='u107292855_ins';
	public $usuari='u107292855_ins';
	public $clau='abcdef';
	
	function connecta(){
		try{
			//Establim connexió amb la BBDD
			$bd = new PDO('mysql:host='.$this->host.';dbname='.$this->bbdd.'',$this->usuari,$this->clau);
			
		}catch(PDOException $e){
			print "Error! ".$e->getMassage()."<br>";
			die();
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