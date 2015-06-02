<?php
// require("../model/model.php");

// $a = new Ajax();
// switch($_GET['method']){
// 	case 'already': $a->alreadyExist(); break;
// }

Class AjaxController extends BaseController {

	public $mysqli;

	public function __construct() {
		$this->mysqli = new mysqli("localhost", "u656145912_root", "154815", "u656145912_larav");
		if ($this->mysqli->connect_errno) {
		    throw new Exception("Connect failed: %s\n", $this->mysqli->connect_error);
		}
	}

	public function deletePproject() {
		// $sql = "DELETE FROM projects WHERE id = ".$id;
		$sql = "DELETE FROM projects WHERE id = ".$_POST['id'];
		if(!$result = $this->mysqli->query($sql))
		    die('There was an error running the query [' . $this->mysqli->error . ']');
		if($result)
			echo(true);
		else 
			echo (false);
	}

	public function chooseProject() {
		$user_id = $_SESSION['user']['user_id'];
		$project_id = $_POST['id'];
		$sql = "SELECT * FROM notes WHERE user_id = ".$user_id;
		if(!$result = $this->mysqli->query($sql))
		    die('There was an error running the query [' . $this->mysqli->error . ']');
		if($result->num_rows > 0) {
			$sql2 = "UPDATE notes SET project_id = ".$project_id." WHERE user_id =".$user_id;
			$this->mysqli->query($sql2);
			echo('update');
		} else {	
			$sql2 = "SELECT owner_id FROM projects WHERE id=".$project_id;
			$result = $this->mysqli->query($sql2);
			if($result->num_rows > 0)
				while ($row = $result->fetch_assoc()) {
				$ret[] = $row;
			}
			$owner_id = $ret[0]['owner_id'];
			$sql3 = "INSERT INTO notes (user_id, project_id, owner_project) VALUES (".$user_id.", ". $project_id.",".$owner_id.")";
			$this->mysqli->query($sql3);
			echo('insert');
		}
	}

	public function setNote() {
		$id = $_POST['id'];
		$value = $_POST['value'];
		$sql = "UPDATE notes SET note = ".$value." WHERE id =".$id;
		if ($this->mysqli->query($sql) == TRUE)
			echo true;
		else
			echo false;
	}

	public function alreadyExist(){
		$email = $_POST['email'];
		$condition = "email = '". $email."'";
		$results = $this->model->selectWithCondition('users', $condition);
		if (count($results)>0) {
			echo 'true';
		} else {
			echo 'false';
		}
	}

}
