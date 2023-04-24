<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Captcha extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->model('captcha_model');
	}

	function index()
	{
		$this->load->view('captcha');
	}

	function validate()
	{
		$captcha_response = trim($this->input->post('g-recaptcha-response'));

		if($captcha_response != '')
		{
			$keySecret = '6LfMUa8lAAAAACVv_vGyGKB-5gflKjTMBT1pMj7b';

			$check = array(
				'secret'		=>	$keySecret,
				'response'		=>	$this->input->post('g-recaptcha-response')
			);

			$startProcess = curl_init();

			curl_setopt($startProcess, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");

			curl_setopt($startProcess, CURLOPT_POST, true);

			curl_setopt($startProcess, CURLOPT_POSTFIELDS, http_build_query($check));

			curl_setopt($startProcess, CURLOPT_SSL_VERIFYPEER, false);

			curl_setopt($startProcess, CURLOPT_RETURNTRANSFER, true);

			$receiveData = curl_exec($startProcess);

			$finalResponse = json_decode($receiveData, true);

			if($finalResponse['success'])
			{
				

				redirect('captcha');
			}
			else
			{
				$this->session->set_flashdata('message', 'Validation Fail Try Again');
				redirect('captcha');
			}
		}
		else
		{
			$this->session->set_flashdata('message', 'Validation Fail Try Again');

			redirect('captcha');
		}
	}

}

?>