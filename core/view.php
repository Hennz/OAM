<?php
Class View{
	public function __construct() {
	}	

	public function render($name) {
		require 'view/'.$name.'.php';
	}
}