<?php

class ContactModel extends CI_Model
{

	public function show_contacts($sortType, $uname)
	{
		$actions = array();
		$this->load->database();
		$this->db->select('*');
		$this->db->from('user_contact');
		$this->db->where('userName', $uname);
		$this->db->order_by('firstName', $sortType);
		$res = $this->db->get();

		foreach ($res->result() as $row) {
			$action = new Contact($row->ContactID, $row->firstName, $row->lastName, $row->number, $row->email, $row->userId);
			$tagsArray = $this->getTagsByContactID($row->ContactID);
			$action->__set('tags', $tagsArray);

			array_push($actions, $action);
		}
		return $actions;
	}

	public function insert_contact($array, $tags)
	{
		$this->load->database();

		$this->db->insert('user_contact', $array);
		$recordId = $this->db->insert_id();

		$resultTags = array();
		$tagArray = explode(",", $tags);
		for ($x = 0; $x < count($tagArray); $x++) {
			$genre = array(
				'tag_id' => $tagArray[$x],
				'contact_id' => $recordId,
			);
			array_push($resultTags, $genre);
		}
		$this->db->insert_batch('user_tag', $resultTags);
	}

	public function update_contact($unique_id, $contactFirstName, $contactLastName, $contactNumber, $contactEmail, $userId)
	{
		$temp = new Contact($unique_id, $contactFirstName, $contactLastName, $contactNumber, $contactEmail, $userId);
		$this->load->database();
		$this->db->where('contactID', $unique_id);
		$res = $this->db->update('user_contact', $temp->getContactArray());
		return $res;
	}

	public function getTagsByContactID($contactID)
	{
		$this->load->database();

		$tagarray = array();
		$this->db->select('*');
		$this->db->from('user_tag');
		$this->db->join('tags', 'user_tag.tag_id = tags.tagId');
		$this->db->where('contact_id', $contactID);

		$tags = $this->db->get();
		$results = $tags->result_array();

		if ($tags->num_rows() > 0) {
			foreach ($results as $result) {
				array_push($tagarray, $result['tagName']);
			}
			return $tagarray;
		} else {
			return null;
		}
	}

	public function delete_contact($unique_id)
	{
		$this->load->database();
		$this->db->where('contact_id', $unique_id);
		$res = $this->db->delete('user_tag');

		$this->db->where('ContactID', $unique_id);
		$res = $this->db->delete('user_contact');
		return $res;
	}

	public function get_Search_results($searchText, $userId)
	{
		$searchRsults = array();
		$this->load->database();
		$searchTerms = explode(",", $searchText);
		$this->db->select('*');
		$this->db->from('user_contact');
		$this->db->where('userId', $userId);
		$this->db->where_in('lastName', $searchTerms);
		$res = $this->db->get();
		$userContactResults = array();
		foreach ($res->result() as $row) {
			$contactArr = new Contact($row->ContactID, $row->firstName, $row->lastName, $row->number, $row->email, $row->userId);
			$tagsArray = $this->getTagsByContactID($row->ContactID);
			$contactArr->__set('tags', $tagsArray);
			array_push($userContactResults, $contactArr);
		}
		$this->db->select('*');
		$this->db->from('user_contact');
		$this->db->join('user_tag', 'user_contact.ContactID = user_tag.contact_id');
		$this->db->join('tags', 'user_tag.tag_id = tags.tagId');
		$this->db->where('userId', $userId);
		$this->db->where_in('tags.tagName', $searchTerms);
		$search = $this->db->get();
		$results = array();
		foreach ($search->result() as $row) {
			$tagArr = new Contact($row->ContactID, $row->firstName, $row->lastName, $row->number, $row->email, $row->userId);
			$tagsArray = $this->getTagsByContactID($row->ContactID);
			$tagArr->__set('tags', $tagsArray);
			array_push($results, $tagArr);
		}
		$searchRsults = array_merge($userContactResults, $results);
		return $searchRsults;
	}
	
	public function get_exportXml($userId)
	{
		$ContactDataArray = array();
		$this->load->database();
		$this->db->select('*');
		$this->db->from('user_contact');
		$this->db->where('userId', $userId);
		$res = $this->db->get();
		foreach ($res->result() as $row) {
			$action = new Contact($row->ContactID, $row->firstName, $row->lastName, $row->number, $row->email, $row->userId);
			$tagsArray = $this->getTagsByContactID($row->ContactID);
			$action->__set('tags', $tagsArray);
			array_push($ContactDataArray, $action);
		}
		$dom = new DOMDocument();
		$rootlist = $dom->createElement('ContactList');
		$dom->appendChild($rootlist);

		foreach ($ContactDataArray as $contact) {

			$ContactNode = $dom->createElement('Contact');

			$ContactID = $dom->createElement('ContactID');
			$ContactIDText = $dom->createTextNode($contact->contact_id);
			$ContactID->appendChild($ContactIDText);
			$ContactNode->appendChild($ContactID);

			$firstName = $dom->createElement('FirstName');
			$firstNameText = $dom->createTextNode($contact->fname);
			$firstName->appendChild($firstNameText);
			$ContactNode->appendChild($firstName);

			$lastName = $dom->createElement('LastName');
			$lastNameText = $dom->createTextNode($contact->lname);
			$lastName->appendChild($lastNameText);
			$ContactNode->appendChild($lastName);

			$phoneNumber = $dom->createElement('PhoneNumber');
			$phoneNumberText = $dom->createTextNode($contact->number);
			$phoneNumber->appendChild($phoneNumberText);
			$ContactNode->appendChild($phoneNumber);

			$email = $dom->createElement('Email');
			$emailText = $dom->createTextNode($contact->email);
			$email->appendChild($emailText);
			$ContactNode->appendChild($email);

			$taging = $dom->createElement('Tags');
			if (isset($contact->tagsArray)) {
				foreach ($contact->tagsArray['tags'] as $tags) {
					if (isset($tags)) {
						$tagName = $dom->createElement('TagName');
						$tagNameText = $dom->createTextNode($tags);
						$tagName->appendChild($tagNameText);
						$taging->appendChild($tagName);
					}
				}
				$ContactNode->appendChild($taging);
			}

			$rootlist->appendChild($ContactNode);
		}

		return $dom->saveXML();
	}
}

class Contact
{
	public $contact_id;
	public $fname;
	public $lname;
	public $number;
	public $email;
	public $userId;
	public $tagsArray;

	function __construct($contact_id, $firstName, $lastName, $number, $contactEmail, $userId)
	{
		$this->contact_id = $contact_id;
		$this->fname = $firstName;
		$this->lname = $lastName;
		$this->number = $number;
		$this->email = $contactEmail;
		$this->userId = $userId;
	}

	function getContactArray()
	{
		$tempArray = array(
			'ContactID' => $this->contact_id,
			'firstName' => $this->fname,
			'lastName' => $this->lname,
			'number' => $this->number,
			'email' => $this->email,
			'userId' => $this->userId
		);

		return $tempArray;
	}

	public function __set($prop, $value)
	{
		$this->tagsArray[$prop] = $value;
	}

	public function __get($prop)
	{
		return $this->tagsArray[$prop];
	}

	public function toArray()
	{
		return $this->tagsArray;
	}
}
