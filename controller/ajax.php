<?php
// require("../model/model.php");

// $a = new Ajax();
// switch($_GET['method']){
// 	case 'already': $a->alreadyExist(); break;
// }

Class AjaxController extends BaseController {
	private $model;

	function __construct() {
		parent::__construct();
		date_default_timezone_set('UTC');
		require 'model/model.php';
		$this->model = new Model();
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

	public function test1() {
		$this->view->render('login');
	}

	public function test2($x = null) {
		echo ('inside test2 with'. $x);
	}
}
