<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/libraries/REST_Valid.php';

class ContactControl extends REST_Controller
{

	function __construct()
	{
		parent::__construct();
	}

	public function contact_get()
	{
		$this->load->model('ContactModel', 'manager');
		$contacts = $this->manager->show_contacts();

		echo json_encode($contacts);
	}

	public function contact_post()
	{
		$data = json_decode(file_get_contents('php://input'), true);

		$fname = $data['fname'];
		$lname = $data['lname'];
		$number = $data['number'];
		$email = $data['email'];
		$address = $data['address'];
		$userId = 1;

		$bagOfValues = array(
            'firstName' => $fname,
            'lastName' =>  $lname,
            'number' => $number,
            'email' => $email,
            'address' => $address,
            'userId' => $userId
        );
		// var_dump($fname); die();

		$this->load->model('ContactModel', 'manager');
		$this->manager->insert_contact($bagOfValues);

		// $status_message = $this->checkForStatus($results);
		// $this->json_encode_function($status_message);
	}

	public function contact_put()
	{
		$unique_id = $this->put('unique_id');
		$new_action = $this->put('action_name');
		$this->load->model('ContactModel', 'manager');
		$results = $this->manager->update_action($unique_id, $new_action);
		$status_message = $this->checkForStatus($results);
		$this->json_encode_function($status_message);
	}

	public function contact_delete()
	{
		$unique_id = $this->delete('unique_id');
		$this->load->model('ContactModel', 'manager');
		$results = $this->manager->delete_action($unique_id);
		$status_message = $this->checkForStatus($results);
		$this->json_encode_function($status_message);
	}

	public function json_encode_function($results)
	{
		header('content-Type:text/json; charset=UTF-8');
		echo json_encode($results);
	}

	public function checkForStatus($results)
	{
		if ($results == 1) {
			$message_result = array(
				'status' => 'true'
			);
		} else {
			$message_result = array(
				'status' => 'false'
			);
		}
		return $message_result;
	}
}
