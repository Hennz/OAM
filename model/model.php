<?php
Class Model extends Model_base {
	public $mysqli;

	public function __construct() {
		$this->mysqli = new mysqli("localhost", "u656145912_root", "154815", "u656145912_larav");
		if ($this->mysqli->connect_errno) {
		    throw new Exception("Connect failed: %s\n", $this->mysqli->connect_error);
		}
	}

	public function selectAll($table){
		$mysqli = new mysqli("localhost", "u656145912_root", "154815", "u656145912_larav");
		$sql = " SELECT * FROM " .$table;

		if(!$result = $mysqli->query($sql))
		    die('There was an error running the query [' . $mysqli->error . ']');
		if($result->num_rows > 0)
			$ret = $result->fetch_all();
		return $ret;
	}

	public function selectWithCondition($table, $condition) {
		$ret = array();
		$mysqli = new mysqli("localhost", "u656145912_root", "154815", "u656145912_larav");
		$sql = " SELECT * FROM " . $table . " WHERE " . $condition;
		if(!$result = $mysqli->query($sql))
		    die('There was an error running the query [' . $mysqli->error . ']');
		if($result->num_rows > 0)
			while ($row = $result->fetch_assoc()) {
			$ret[] = $row;
		}
		return $ret;
	}

	public function insert($table, $v){
		$mysqli = new mysqli("localhost", "u656145912_root", "154815", "u656145912_larav");
		$kv = array();
		$vv = array();
		foreach ($v as $key => $value) {
			array_push($kv, $key);
			array_push($vv, (string)$value);
		}
		$columns = implode(',', $kv);
		$values = implode('","', $vv);

		$sql = 'INSERT INTO '. $table .'('. $columns .') VALUES ("' .$values. '")';
		if(!$result = $mysqli->query($sql))
		    die('There was an error running the query [' . $this->mysqli->error . ']');
		if ((int)$mysqli->insert_id >0)
			return (int)$mysqli->insert_id;
		else
			return 0;
	}

	public function update($table, $v, $condition) {
		$mysqli = new mysqli("localhost", "u656145912_root", "154815", "u656145912_larav");
		$upd = array();
		//$vv = array();
		foreach ($v as $key => $value) {
			array_push($upd, (string)$key.' = '.(string)$value);
		}
		$action = implode(',', $upd);
		$sql = 'UPDATE '. $table . ' SET '. $action .' WHERE ' .$condition;
		if ($mysqli->query($sql) === TRUE)
			return true;
		else
			return false;
	}

}

?>