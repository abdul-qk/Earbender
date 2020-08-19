<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/libraries/REST_Valid.php';

class TestController extends REST_Controller {

	public $todo_data = array();

	function __construct() {
		parent::__construct();
	}

	public function index_get() {
        var_dump('Hello World');
    }
}