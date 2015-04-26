<?php
Class Model_base{

	public $mysqli;

	public function __construct() {
		$this->mysqli = new mysqli("localhost", "u656145912_root", "154815", "u656145912_larav");
		if ($this->mysqli->connect_errno)
			throw new Exception("Connect failed: %s\n", $this->mysqli->connect_error);
	}	

	public function test2() {
		echo ("ok");
	}
}