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
		$sql = " SELECT * FROM " .$table;
		if(!$result = $this->mysqli->query($sql))
		    die('There was an error running the query [' . $this->mysqli->error . ']');
		if($result->num_rows > 0)
			while ($row = $result->fetch_assoc()) {
			$ret[] = $row;
		}
		return $ret;
	}

	public function selectWithCondition($table, $condition) {
		$ret = array();
		$sql = " SELECT * FROM " . $table . " WHERE " . $condition;
		// die($sql);
		if(!$result = $this->mysqli->query($sql))
		    die('There was an error running the query [' . $this->mysqli->error . ']');
		if($result->num_rows > 0)
			while ($row = $result->fetch_assoc()) {
			$ret[] = $row;
		}
		return $ret;
	}

	public function insert($table, $v){
		$kv = array();
		$vv = array();
		foreach ($v as $key => $value) {
			mysqli_real_escape_string($this->mysqli, $key);
			mysqli_real_escape_string($this->mysqli, $value);
			array_push($kv, $key);
			array_push($vv, (string)$value);
		}
		$columns = implode(',', $kv);
		$values = implode('","', $vv);

		$sql = 'INSERT INTO '. $table .'('. $columns .') VALUES ("' .$values. '")';

		if(!$result = $this->mysqli->query($sql))
		    die('There was an error running the query [' . $this->mysqli->error . ']');
		if ((int)$this->mysqli->insert_id >0)
			return (int)$this->mysqli->insert_id;
		else
			return 0;
	}

	public function update($table, $v, $condition) {
		$upd = array();
		foreach ($v as $key => $value) {
			array_push($upd, (string)$key.' = "'.$value.'"');
		}
		$action = implode(',', $upd);
		$sql = 'UPDATE '. $table . ' SET '. $action .' WHERE ' .$condition;
		
		if ($this->mysqli->query($sql) === TRUE)
			return true;
		else
			return false;
	}

	public function counter($table, $condition=null) {
		$ret = 0;
		if ($condition == null) {
			$sql = " SELECT * FROM " . $table;
			$res = $this->mysqli->query($sql);
		    if($res->num_rows > 0)
				$ret = $res->num_rows;
		} else {
			$sql = " SELECT * FROM " . $table . " WHERE " . $condition;
			$res = $this->mysqli->query($sql);
		    if($res->num_rows > 0)
				$ret = $res->num_rows;	
		}
		return (int)$ret;
	}

	// OTHERS
	public function selectAllProjects() {
		$ret = array();
		$sql = " SELECT projects.id AS project_id,
						projects.title,
						projects.subject,
						projects.max_note,
						projects.max_studs,
						users.username
					FROM projects
					LEFT JOIN users
					ON projects.owner_id = users.id";

		if(!$result = $this->mysqli->query($sql))
		    die('There was an error running the query [' . $this->mysqli->error . ']');
		if($result->num_rows > 0)
			while ($row = $result->fetch_assoc()) {
			$ret[] = $row;
		}
		return $ret;
	}

	public function selectProject($project_id, $user_id) {
		$ret = array();
		$sql = " SELECT notes.id AS idd,
						notes.file_name,
						notes.note,
						notes.project_id,
						users.id AS user_id,
						users.username,
						projects.title,
						projects.subject,
						projects.max_note,
						projects.max_studs
					FROM notes
					LEFT JOIN users
					ON notes.user_id = users.id
					LEFT JOIN projects
					ON notes.project_id = projects.id
					WHERE notes.project_id =".$project_id." 
					AND notes.owner_project =".$user_id;
		// die($sql);
		if(!$result = $this->mysqli->query($sql))
		    die('There was an error running the query [' . $this->mysqli->error . ']');
		if($result->num_rows > 0)
			while ($row = $result->fetch_assoc()) {
			$ret[] = $row;
		}
		return $ret;
	}

}

?>