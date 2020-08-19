<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . '/libraries/REST_Valid.php';

class Contacts extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function index_get()
    {
        $this->load->model('UserModel', 'user');
        $check = $this->user->isLoggedIn();
        $data['title'] = "Earbender - Contact";

        if ($check) {
            $this->load->view('templates/header', $data);
            $this->load->view('pages/contact');
            $this->load->view('templates/footer');
        } else {
            $data['title'] = "Earbender - Landing";

            $this->load->view('templates/header', $data);
            $this->load->view('pages/landing');
            $this->load->view('templates/footer');
        }
    }

    public function contact_get()
    {
        $uname = $this->session->uname;
        $this->load->model('ContactModel');
        // $tags = $this->ContactModel->getTagsByContactID($contactValue->contact_id);
        $id = $this->get('id');
        $sortType = $this->get('sortType');
        $contactValue = $this->ContactModel->show_contacts($sortType, $uname);
        if ($id === null) {
            if ($contactValue) {
                $this->response($contactValue, 200);
            } else {

                // Set the response and exit
                $this->response([
                    'status' => false,
                    'message' => 'No users were found'
                ], 404);
            }
        } else {
            if (array_key_exists($id, $contactValue)) {
                $this->response($contactValue->contact_id, 200);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'No such user found'
                ], 404);
            }
        }
    }

    public function contact_post()
    {

        $data = json_decode(file_get_contents('php://input'), true);

        $fname = $data['fname'];
        $tags = $data['tags'];
        $lname = $data['lname'];
        $number = $data['number'];
        $email = $data['email'];
        $userId = 1;
        $uname = $this->session->uname;

        $bagOfValues = array(
            'firstName' => $fname,
            'lastName' =>  $lname,
            'number' => $number,
            'email' => $email,
            'userId' => $userId,
            'userName' => $uname
        );


        $this->load->model('ContactModel', 'manager');
        $this->manager->insert_contact($bagOfValues, $tags);
        $this->response(['Item created successfully.'], REST_Controller::HTTP_OK);
    }

    public function contact_put($ContactID)
    {
        $fname = $this->put('fname');
        $lname = $this->put('lname');
        $number = $this->put('number');
        $email = $this->put('email');
        $userId = $this->put('userId');

        $this->load->model('ContactModel', 'manager');
        $this->manager->update_contact($ContactID, $fname, $lname, $number, $email, $userId);

        $this->response(['Item updated successfully.'], REST_Controller::HTTP_OK);
    }

    public function contact_delete($ContactID)
    {
        $this->load->model('ContactModel', 'manager');
        $this->manager->delete_contact($ContactID);

        $this->response(['Item deleted successfully.'], REST_Controller::HTTP_OK);
    }

    public function search_get()
    {
        $searchTerm = $this->get('search_contact');

        $this->load->model('ContactModel', 'manager');
        $userId = 1;
        $contactValue = $this->manager->get_Search_results($searchTerm, $userId);
        if ($contactValue) {
            $this->response($contactValue, 200);
        } else {
            // Set the response and exit
            $this->response('[{}]', 200);
        }
    }

    public function exportExcel_get()
    {
        $this->load->model('ContactModel', 'manager');
        $userId = 1;
        $contactXml = $this->manager->get_exportXml($userId);
        if ($contactXml) {
            $this->response($contactXml, 200);
        } else {
            // Set the response and exit
            $this->response([
                'status' => false,
                'message' => 'Cannot Create Xml'
            ], 404);
        }
    }
}
