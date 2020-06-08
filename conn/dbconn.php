<?php
class dbConn{
	private $dbHost;
    private $dbName;
    private $dbUname;
	private $dbPassw;

	public function __construct(){
		$op = 3; //[ 1=live :: 2=V2 :: 3=localhost]
		if( $op == 1 ){
			$this->dbHost = 'localhost:3306';
            $this->dbName = 'hf_new';
            $this->dbUname = 'hf_new';
			$this->dbPassw = 'jGyf05#0';
		}
		elseif($op == 2){
			$this->dbHost = 'localhost';
            $this->dbName = 'hfv2_db';
            $this->dbUname = 'hfv2_db';
			$this->dbPassw = 'Jg&tq350';
        }
        elseif($op == 3){
			$this->dbHost = 'localhost';
            $this->dbName = 'datumdb';
            $this->dbUname = 'mysqlfab';
			$this->dbPassw = '10fbrc@adm01';
		}
	}

	// conectar a la base de datos
	public function connect(){
		$conexion_mysql = "mysql:host=$this->dbHost;dbname=$this->dbName";
		$link = new PDO($conexion_mysql, $this->dbUname, $this->dbPassw);
		$link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		//esta linea arregla la codificacion de caracteres UTF-8
		$link->exec('set names utf8');
		return $link;
	}
}
?>