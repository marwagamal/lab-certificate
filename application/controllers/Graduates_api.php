<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
header("Access-Control-Allow-Origin: http://egyptscholars.org");
class Graduates_api extends REST_Controller {
	
	public function search_students_post()
	{
		if(empty($_POST['name']))
		{
			$this->response([
				'status' => FALSE,
				'message' => 'Empty Parameters'
			    ], 404); // NOT_FOUND (404) being the HTTP response code
		}
		$this->load->model('model_graduates');
	 	$data = $this->model_graduates->list_graduates_by_name($_POST['name']);
	 	if($data)
	 	{
	 		 // Set the response and exi
	 		$this->response($data, 200); // OK (200) being the HTTP response code
	 	}
	 	else
	 	{
	 		 // Set the response and exi
	 		$this->response([
				'status' => FALSE,
				'message' => 'Student could not be found'
			    ], 404); // NOT_FOUND (404) being the HTTP response code
	 	}	 	
	}
	
	
	public function get_student_post()
	{
		if(empty($_POST['id']))
		{
			$this->response([
				'status' => FALSE,
				'message' => 'Empty Parameters'
			    ], 404); // NOT_FOUND (404) being the HTTP response code
		}
		$this->load->model('model_graduates');
	 	$data = $this->model_graduates->get_graduate_data($_POST['id']);
	 	if($data)
	 	{
	 		 // Set the response and exi
	 		$this->response($data, 200); // OK (200) being the HTTP response code
	 	}
	 	else
	 	{
	 		 // Set the response and exi
	 		$this->response([
				'status' => FALSE,
				'message' => 'Student could not be found'
			    ], 404); // NOT_FOUND (404) being the HTTP response code
	 	}	 	
	}
	
	
	public function get_student_image_get()
	{
		$id = $_GET['id'];
		if ($id === NULL)
		{
			$this->response([
				'status' => FALSE,
				'message' => 'Empty Parameters'
			    ], 404); // NOT_FOUND (404) being the HTTP response code
		}
		$id = (int) $id;
		// Validate the id.
		if ($id <= 0)
		{
		    // Invalid id, set the response and exit.
		    $this->response([
				'status' => FALSE,
				'message' => 'Empty Parameters'
			    ], 400); // BAD_REQUEST (400) being the HTTP response code
		}
		
		$this->load->model('model_graduates');
	 	$data = $this->model_graduates->get_graduate_image($id);
	 	if($data)
	 	{
	 		 // Set the response and exi
	 		$this->response($data, 200); // OK (200) being the HTTP response code
	 	}
	 	else
	 	{
	 		 // Set the response and exi
	 		$this->response([
				'status' => FALSE,
				'message' => 'Student could not be found'
			    ], 404); // NOT_FOUND (404) being the HTTP response code
	 	}
	}
}
