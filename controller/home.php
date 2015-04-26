<?php
// require("../model/model.php");
// require("../index.php");

// $h = new HomeControler();

// switch($_GET['method']){
// 	case 'index': $h->index(); break;
// 	case 'login': $h->login(); break;
// 	case 'register': $h->register(); break;
// 	case 'activate': $h->activate(); break;
// 	case 'logout': $h->logout(); break;
// 	case 'change_password': $h->changePassword(); break;
// }

Class HomeController extends BaseController {

	// const BASE_URL = "http://www.myprograming.esy.es/OAM/";
	// require("../model/model.php");
	private $model;
	

	function __construct() {
		parent::__construct();
		date_default_timezone_set('UTC');
		$this->view->page_message = array();
		require 'model/model.php';
		$this->model = new Model();
	}

	public function index() {
		unset($_SESSION['page_message']);

		if(isset($_COOKIE['username']) && isset($_COOKIE['email'])) {
			$condition = 'username = "'. $_COOKIE['username'].'" AND email = "'.$_COOKIE['email'].'"';
			$results = $this->model->selectWithCondition('users', $condition);
			if (count($results>0)) {
				$_SESSION["user"] = array(
							'username' => $results[0]['username'],
							'email' => $results[0]['email']
							);
				header('location: '.BASE_URL.'/home/profile');
			}
		} else {
			// die(BASE_URL.'/home/login');
			header('location: '.BASE_URL.'/home/login');
		}	
	}

	public function profile() {
		echo ("profile page");
	}

	public function login() {
		
		if (isset($_POST) && !empty($_POST)) {
			$data = array(
				$_POST['email'] => array(
					'required'=>true,
					'email'=>true
					),
				$_POST['password'] => array(
					'required'=>true
					)
				);
			$valid = $this->validator($data);
			if ($valid['succes']){
				$email = $_POST['email'];
				$password = md5($_POST['password']);
				$condition = 'email = "'. $email.'" AND password = "'.$password.'"';
				$results = $this->model->selectWithCondition('users', $condition);
				// $results = $this->model->test();
				if (count($results)>0) {
					if ($results[0]['status'] == 1) {
						$_SESSION["user"] = array(
								'username' => $results[0]['username'],
								'email' => $results[0]['email']
								);
						if (isset($_POST['remember'])) {
							setcookie('username', $results[0]['username'], time() + (86400 * 30 * 10), "/"); //10 day
							setcookie('email', $results[0]['email'], time() + (86400 * 30 * 10), "/"); //10 day
						}
						$this->view->render('home');
					} else {
						$this->view->page_message = array(
							'warning' => 'Invalid account. Try to validate it from your email.'
						);
						$this->view->render('login');
					}
				} else {
					$this->view->page_message = array(
						'error' => 'Invalid username or password.'
					);
					$this->view->render('login');
				}
			} else {
				$this->view->page_message = array(
						'error' => 'Invalid data.'
					);
				$this->view->render('login');
			}
		} else {
			$this->view->render('login');
		}
	}

	public function register(){
		if (isset($_POST) && !empty($_POST)) {
			// var_dump($_POST); die();
			$data = array(
				$_POST['username'] => array(
					'required'=>true,
					'max'=>20
					),
				$_POST['email'] => array(
					'required'=>true,
					'email'=>true
					),
				$_POST['password'] => array(
					'required'=>true,
					'min'=>4,
					'max'=>20
					),
				$_POST['rpassword'] => array(
					'required'=>true,
					'equal'=>$_POST['password']
					)
				);
			$valid = $this->validator($data);
			if ($valid['succes']){
				$code = rand(10000 , 99999);
				$v = array(
					'username' => $_POST['username'],
					'email' => $_POST['email'],
					'password' => md5($_POST['password']),
					'status' => $code,
					'type' => $_POST['user_type'],
					'stud_year' => $_POST['year'],
					'stud_group' => $_POST['group'].$_POST['semian']
					);
				if ((isset($_POST['groups'])) && (count($_POST['groups'])>0) ) {
					$temp = "";
					foreach ($_POST['groups'] as $val) {
						$temp .= $val;
					}
				}
					
				$inserted = $this->model->insert("users", $v);
				if ($inserted) {
					$header = 'MIME-Version: 1.0' . "\n";
					$header .= 'Content-type: text/html; charset=iso-8859-1';
					$msg = '<h3>Hello,</h3>'."\n";
					$msg .= '<p>Thanks for registering on our website. To activate your account you must acces next link:</p>';
					$msg .= '<a href="'.BASE_URL.'/home/activate/'.$code.'">activate hear</a>'."\n";
					$msg .= '<p>Regards,</p>'."\n";
					$msg .= '<p>OAM team</p>';
					mail($_POST['email'], 'Activate account on OAM', $msg, $header);
					// mail('alexeevyci@yahoo.com', 'Activate account', 'minnihhgvu', $header);
					$this->view->page_message = array(
							'nottice' => 'Registering succesfull. Please activate your account from email.'
						);
					$this->view->render('login');
				} else {
					$this->view->page_message = array(
							'error' => 'Error in process of registering. Please try again laterr!'
						);
					$this->view->render('login');
				}
			} else {
				$this->view->page_message = array(
							'error' => 'Invalid data.'
						);
				$this->view->render('login');
			}
		} else {
			$this->view->render('login');
		}
	}

	public function validator($data){
		$ret=array();
		$ret['succes']=true;
		$ret['message'] = array();

		foreach ($data as $key => $value) {
			foreach ($value as $key2 => $value2) {
				if ($key2 == 'required') {
					if (empty($key)) {
						$ret['succes']=false;
						array_push($ret['message'], $key.' is required.');
					}
				}
				if ($key2 == 'min') {
					if (strlen($key)<$value2) {
						$ret['succes']=false;
						array_push($ret['message'], $key.' must have more than'.$value2.' characters.');
					}
				}
				if ($key2 == 'max') {
					if (strlen($key)>$value2) {
						$ret['false']=false;
						array_push($ret['message'], $key.' must have less than'.$value2.' characters.');
					}
				}
				if ($key2 == 'email') {
					if (!filter_var($key, FILTER_VALIDATE_EMAIL)) {
						$ret['succes']=false;
						array_push($ret['message'], $key.' must have a mail format');
					}
				}
				if ($key2 == 'equal') {
					if ($key != $value2) {
						$ret['succes']=false;
						array_push($ret['message'], 'passwords do not match');
					}
				}
			}
		}
		// $ret['succes']=true;
		return $ret;
	}

	public function activate($code = null) {
		$newTime = date("Y-m-d H:i:s", strtotime('-24 hours'));
		if (!empty($code)) {
			$condition = 'status = ' . $code;
			$results = $this->model->selectWithCondition('users', $condition);
			if (count($results)>0) {
				$userId = 0;
				foreach ($results as $key => $value) {
					if ($value['created'] > $newTime)
						$userId = $value['id'];
					if ($userId>0) {
						$condition = 'id = '.$userId;
						$v = array('status' => 1);
						$res = $this->model->update('users', $v, $condition);
						if ($res) {
							$_SESSION["user"] = array(
								'username' => $value['username'],
								'email' => $value['email']
								);
							$this->view->render('home');
						} else {
							$this->view->page_message = array(
								'error' => 'Validation failed. Try to create a new account latter!'
							);
							$this->view->render('login');
						}
					} else {
						$this->view->page_message = array(
							'error' => 'Lifetime of activation link has expired. Create another account.'
						);
						$this->view->render('login');
					}
				}
			} else {
				$this->view->page_message = array(
							'error' => 'Bad url!.'
						);
				$this->view->render('login');
			}
		} else {
			$this->view->page_message = array(
				'error' => 'Bad url!.'
						);
			$this->view->render('login');
		}
	}

	public function logout() {
		unset($_SESSION['user']);
		header('location: '.BASE_URL.'/home/login');
	}

	public function changePassword() {
		die("change password");
	}

	public function test() {
		if (isset($_POST["coc"])) {
			var_dump($_POST);
		}
		else {
			$this->view->render('test');
		}
		
	}

}

?>