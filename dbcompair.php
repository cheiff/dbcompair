<?php
class dbcompair{
	private $host = "";
	private $user = "";
	private $pass = "";
	private $dbname = array();
	protected $dbconnection = array();
	
	public function __construct(){
		$this->host = "LOCALHOST";
		$this->user = "root";
		$this->pass = "oshan1991";
		$this->dbname[1] = "one_myprod";
		$this->dbname[2] = "one_myprod_2";
	}
	
	protected function connect(){
	
		$this->dbconnection[1] = new mysqli($this->host, $this->user, $this->pass, $this->dbname[1]);
		$this->dbconnection[2] = new mysqli($this->host, $this->user, $this->pass, $this->dbname[2]);
		
		/* check connection */
		if ($this->dbconnection[1]->connect_errno) {
			printf("Connect failed: %s\n", $this->dbconnection[1]->connect_error);
			exit();
		}
		if ($this->dbconnection[2]->connect_errno) {
			printf("Connect failed: %s\n", $this->dbconnection[2]->connect_error);
			exit();
		}
	}
}