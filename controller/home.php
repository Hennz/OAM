<?php
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

	//LOGIN
	public function index() {
		if(isset($_COOKIE['username']) && isset($_COOKIE['email'])) {
			$condition = 'username = "'. $_COOKIE['username'].'" AND email = "'.$_COOKIE['email'].'"';
			$results = $this->model->selectWithCondition('users', $condition);
			if (count($results>0)) {
				$_SESSION["user"] = array(
							'user_id' => $results[0]['id'],
							'user_type' => $results[0]['type'],
							'username' => $results[0]['username'],
							'email' => $results[0]['email']
							);
				$this->view->render('home');
			}
		} elseif (isset($_SESSION["user"]) && !empty($_SESSION["user"])) {
			$this->view->render('home');
		} else {
			$this->view->render('login');
		}	
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
								'user_id' => $results[0]['id'],
								'user_type' => $results[0]['type'],
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
			if ((isset($_SESSION["user"])) && (!empty($_SESSION["user"]))) {
				$this->view->render('home');
			} else {
				$this->view->render('login');
			}
		}
	}

	public function register(){
		if (isset($_POST) && !empty($_POST)) {
			// var_dump($_POST); die();
			$data = array(
				$_POST['fname'] => array(
					'required'=>true,
					'max'=>20
					),
				$_POST['lname'] => array(
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
					'username' => $_POST['fname'].' '.$_POST['lname'],
					'fname' => $_POST['fname'],
					'lname' => $_POST['lname'],
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
								'user_id' => $value['id'],
								'user_type' => $value['type'],
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
		unset($_COOKIE['username']);
    	unset($_COOKIE['email']);
		$this->view->render('login');
	}

	//PROFILE
	public function profile() {
		if (isset($_POST) && !empty($_POST)) {
			// var_dump($_POST);die();
			$condition = 'id = '.$_SESSION['user']['user_id'];
			$v = array(
				'username' => $_POST['username'],
				'fname' => $_POST['fname'],
				'lname' => $_POST['lname'],
				'stud_year' => $_POST['stud_year'],
				);
			if ($_SESSION['user']['user_type'] == 1) {
				$v['stud_group'] = $_POST['group'];
			} 
			if ($_SESSION['user']['user_type'] == 2) {
				$v['groups'] = "all";
				if (!empty($_POST['groups'])) {
					$v['groups'] = "";
					foreach ($_POST['groups'] as $value) {
						$v['groups'] .= $value;
					}
				}
			} 
			$res = $this->model->update('users', $v, $condition);
			if ($res) {
				$v['type'] = $_SESSION["user"]["user_type"];
				$v['email'] = $_SESSION["user"]["email"];
				$v['group'] = $v['stud_group'];
				$this->view->data =$v;
				$this->view->page_message = array(
						'nottice' => 'Profile updated!'
					);
				$this->view->render('profile');
			} else {
				$v['type'] = $_SESSION["user"]["user_type"];
				$v['email'] = $_SESSION["user"]["email"];
				$v['group'] = $v['stud_group'];
				$this->view->data =$v;
				$this->view->page_message = array(
						'error' => 'Update problem!'
					);
				$this->view->render('profile');
			}
		} else {
			$user_id = $_SESSION["user"]['user_id'];
			$condition = 'id = "'. $user_id .'"';
			$results = $this->model->selectWithCondition('users', $condition);
			$this->view->data = $results[0];
			$this->view->render('profile');
		}
	}

	public function changePassword() {
		if (isset($_POST) && !empty($_POST)) {
			$valid =true;
			if ($valid == true){
				$condition = 'password = "'.md5($_POST['oldpassword']).'"';
				$res = $this->model->counter('users', $condition);
				if ((int)$res>0) {
					$condition = 'id = '.$_SESSION['user']['user_id'];
					$v= array('password' => md5($_POST['newpassword']));
					$res = $this->model->update('users', $v, $condition);
					if ($res) {
						$this->view->page_message = array(
								'nottice' => 'Password was changed with succes!'
							);
						$this->view->render('profile');
					} else {
						$this->view->page_message = array(
								'error' => 'Change password problem!'
							);
						$this->view->render('profile');
					}
				}
			}
		} else {
			$user_id = $_SESSION["user"]['user_id'];
			$condition = 'id = "'. $user_id .'"';
			$results = $this->model->selectWithCondition('users', $condition);
			$this->view->data = $results[0];
			$this->view->render('profile');
		}
	}

	public function usersList($type=1) {
		$condition = 'type = '.$type;
		$results = $this->model->selectWithCondition('users', $condition);
		$this->view->type = $type;
		$this->view->data = $results;
		$this->view->render('usersList');
	}

	//TEST
	public function test() {
		$this->view->render('test');
	}

}
?>