<?php
/*compair the tables in the databases*/

class compair_tables extends dbcompair {

	private $dbdifference;
	private $table_create_string;
	
	public function __construct(){
		parent::__construct();
		$this->connect();
	}

	public function execute(){
		$query = "SHOW TABLES";
		$result1 = $this->dbconnection[1]->query($query);
		$result2 = $this->dbconnection[2]->query($query);
		if(!$result1){ echo ($this->dbconnection[1]->error);exit(); }
		if(!$result2){ echo ($this->dbconnection[2]->error);exit(); }
		// Cycle through results
		while ($row = $result1->fetch_array())$db1_tables[] = $row[0];
		while ($row = $result2->fetch_array())$db2_tables[] = $row[0];
		// Free result set
		$result1->close();
		$result2->close();
		//difference of the tables
		$this->dbdifference = $this->arrayDiff($db1_tables, $db2_tables);
		$this->createTables();
		var_dump($this->table_create_string);
	}
	
	private function createTables(){
		foreach($this->dbdifference as $key => $db){
			foreach($db as $table){
				if($result = $this->dbconnection[$key]->query('SHOW CREATE TABLE '.$table)){
					$response = $result->fetch_row();
					$this->table_create_string[$key] .= $response[1]."\n\n";
				} else {
					echo 'FAILED :: '.'SHOW CREATE TABLE '.$table; 
				}
			}
		}
	}

	private function arrayDiff($array1, $array2)
	{
		$array2 = array_flip($array2);
			foreach ($array1 as $key => $value) {
				if(isset($array2[$value])) {
					unset($array1[$key]);
					unset($array2[$value]);
				}
			}
		$arrays[1] = $array1;
		$arrays[2] = array_flip($array2);
		return $arrays;
	}
}
