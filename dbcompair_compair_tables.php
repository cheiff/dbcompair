<?php
/*compair the tables in the databases*/

class compair_tables extends dbcompair {

	private $dbdifference;
	private $table_create_string;
	private $table_create_strings;
	private $insert_record_queries;
	private $insert_record_query;
	
	public function __construct(){
		parent::__construct();
		$this->connect();
	}

	public function findDifference(){
		$query = "SHOW TABLES";
		#list the tables in db1 and db2
		$result1 = $this->dbconnection[1]->query($query);
		$result2 = $this->dbconnection[2]->query($query);
		#exit in case of error
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
	}
	
	public function buildCreateTablesQuery(){
		foreach($this->dbdifference as $dbName => $db){
			foreach($db as $table){
				if($result = $this->dbconnection[$dbName]->query('SHOW CREATE TABLE '.$table)){
					$response = $result->fetch_row();
					$this->table_create_strings[$dbName] = $response[1];
				} else {
					echo 'FAILED :: '.'SHOW CREATE TABLE '.$table; 
				}
			}
			$this->table_create_string[$dbName] = implode(";\n\n",$this->table_create_strings);
			unset($this->table_create_strings);
		}
	}
	
	public function saveCreateTablesQuery($filename = 'createtables.sql'){
		foreach($this->table_create_string as $dbName => $value){
			file_put_contents($filename.'_'.$dbName.'.sql', $value);
		}
	}

	public function buildInsertIntoQuery(){
		foreach($this->dbdifference as $dbName => $db){
			#initialize the variables
                	foreach($db as $table){
				#list all the records in the table
				$InsertQuery = "SELECT * FROM `".$table."` ;";
				$result = $this->dbconnection[$dbName]->query($InsertQuery);
				#exit in case of error
				if(!$result){ echo ($this->dbconnection[$dbName]->error);exit(); }
				
				#loop through the records list and create insert query
				while ($row = $result->fetch_assoc()){
					#create insert query for the row
					$insertSQL = "INSERT INTO `" . $table . "` SET ";
					foreach ($row as $field => $value) {
						$insertSQL .= " `" . $field . "` = '" . $value . "', ";
					}
					#collect the queries to a array
					$table_insert_records[] = trim($insertSQL, ", ");
				}
				$this->insert_record_queries[$dbName][$table] = implode(";\n", $table_insert_records);
				unset($table_insert_records);
			}
			//merge the list of queryes to a single query
			$this->insert_record_query[$dbName] = implode(";\n\n",$this->insert_record_queries[$dbName]);
		}
	}
	 public function saveInsertIntoQuery($filename = 'insertinto'){
		#loop though the records database wise
		foreach($this->insert_record_query as $dbName => $value){
			#write the data to files
			file_put_contents($filename.'_'.$dbName.'.sql', $value);
		}
	}

	private function arrayDiff($array1, $array2)
	{
		$array2 = array_flip($array2);
			foreach ($array1 as $dbName => $value) {
				if(isset($array2[$value])) {
					unset($array1[$dbName]);
					unset($array2[$value]);
				}
			}
		$arrays[1] = $array1;
		$arrays[2] = array_flip($array2);
		return $arrays;
	}
}
