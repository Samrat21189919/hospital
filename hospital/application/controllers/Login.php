<?php
/**
* 
*/
class Login extends CI_Controller
{
	private $headerData;
	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->headerData = array();
		$this->headerData['sidebar'] = false;
		$this->headerData['body_class'] = 'login';
	}

	public function index(){
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
		
		$this->load->library(array('form_validation'));
		$validations = array(
				array(
					'field' => 'u_name',
					'label'	=> 'User Name',
					'rules'	=> 'required'
				),
				array(
					'field' => 'u_pass',
					'label'	=> 'User Password',
					'rules'	=> 'required'
				)
			);
		$this->form_validation->set_rules($validations);
		if($this->form_validation->run()){
			$this->load->model('User_model');
			$findUser = $this->User_model->is_exist(array(
															'user_name'=> $this->input->post('u_name'),
															'password'=> md5($this->input->post('u_pass')),
														));
			if($findUser){

				$login_userObj = $this->User_model->get(array(
															'user_name'=> $this->input->post('u_name'),
															'password'=> md5($this->input->post('u_pass')),
														))[0];
				$login_user = array();
				foreach ($login_userObj as $key => $value) {
					if($key != 'password')
					$login_user[$key] = $value;
				}
				$this->session->set_userdata('login_user',$login_user);
				$this->session->set_userdata('is_login',true);
				redirect('department');
				if($login_user['role'] =="patient"){
					redirect('page/doctors');
				}else{
					redirect('department');
				}
			}else{
				$this->headerData['message'] = "User name Or Password Not Matches .";
			}
		}
		
	}
		else{
				$this->headerData['message'] = "Captcha Verification Failed .";
			}
	
		$this->load->view('header',$this->headerData);
		$this->load->view('login');
		$this->load->view('footer');
	}
}

?>