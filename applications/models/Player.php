<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Player extends CI_Model {

	private function _checkEvent()
	{
		$cur = date('Y-m-d H:i:s');
		$res = $this->db->where('start <', $cur)
						->where('end >', $cur)
						->get('eventtime')
						->row_array();
		if (isset($res['id']) ) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function playerLogin()
	{
		if ($this->_checkEvent() ) {
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', '');
			$this->form_validation->set_rules('mobile', 'Mobile', array('trim','required','max_length[11]', array(
				'validmobile', function($mobile) {
					$res = $this->db->where('mobile', substr($mobile, 1) )
									->get('player')
									->row_array();
									
					if (isset($res['id']) == 1) {
							
						if ($res['active'] == "Y") {
							$this->session->set_userdata(array(
								'loggedin'	=>	$res['id'],
								'name'		=>	$res['data'],
								'qr'		=>	$res['qr']
							) );
							return TRUE;

						} else {
							$this->session->set_userdata([
								'otp_user_id' => $res['id'],
								'otp_email'   => $res['email']
							]);
							redirect('otp');
						}

					} else {
						$this->form_validation->set_message('validmobile', 'Mobile number is not yet registered!');
						return FALSE;
					}
				}
			) ) );
			if ($this->form_validation->run() === FALSE) {
				$this->load->view('alpha/login');
			} else {
				redirect('/');
			}
		} else {
			$this->load->view('alpha/notime');
		}
	}

	public function homePage()
	{
		$play = $this->db->select('badge_id')
						->where('player_id', $this->session->loggedin)
						->get('playbadge')
						->result_array();
		$count = count($play);
		if ($count < 8) {
			$badge = $this->db->where('active', 'Y')
						->get('badge')
						->result_array();
			$this->load->view('alpha/main', array(
				'badge'	=>	$badge,
				'play'	=>	array_column($play, 'badge_id'),
				'count'	=>	$count
			) );
		} else {
			$res = $this->db->select('winner.id, win_id, name, image')
							->join('claim', 'winner.id = win_id', 'LEFT')
							->join('prizealloc', 'alloc_id = prizealloc.id')
							->join('prize', 'prize_id = prize.id')
							->where('player_id', $this->session->loggedin)
							->get('winner')
							->row_array();
			if (isset($res['id']) == 1) {
				if (is_null($res['win_id']) ) {
					$this->load->view('alpha/done', array('prize'=>$res['name']) );
				} else {
					$this->load->view('alpha/claim');
				}
			} else {
				$this->load->view('alpha/sorry');
			}
		}
	}

	public function registerSubmit()
	{
		if ($this->_checkEvent() ) {
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', '');
			$this->form_validation->set_rules('name', 'Name', 'trim|required|max_length[80]');
			
			$this->form_validation->set_rules('email', 'Email', array('trim', 'required', 'valid_email', 'max_length[100]', array(
				'validemail', function($email) {
					$res = $this->db->where('email', $email)
									->get('player')
									->row_array();
					if (empty($res['id'])) {
						return TRUE;
					} else {
						$this->form_validation->set_message('validemail', '* Your email address is already registered!');
						return FALSE;
					}
				} )
			));

			$this->form_validation->set_rules('mobile', 'Mobile', array('trim', 'required', 'max_length[11]', array(
				'validmobile', function($mobile) {
					$res = $this->db->where('mobile', substr($mobile, 1) )
									->get('player')
									->row_array();
					if (isset($res['id']) == 0) {
						return TRUE;
					} else {
						$this->form_validation->set_message('validmobile', '* Your mobile number is already registered!');
						return FALSE;
					}
				} )
			));

			if ($this->form_validation->run() === FALSE) {
			    $error = $this->session->flashdata('error');
				$this->load->view('alpha/register');

			} else {
				$this->db->insert('player', array(
					'mobile'=>	substr($this->input->post('mobile'), 1),
					'data'	=>	$this->input->post('name'),
					'email' => 	$this->input->post('email')
				) );

				$id = $this->db->insert_id();
				
				$this->session->set_userdata([
					'otp_user_id' 	=> 	$this->db->insert_id(),
					'otp_email'   	=> 	$this->input->post('email')
				]);
				
				include('../phpqrcode/qrlib.php');
				$fname = md5($id);
				QRcode::png(str_pad($id, 8, 0, STR_PAD_LEFT), "qr/$fname.png", QR_ECLEVEL_L, 10);
				
				$this->db->where('id', $id)
					->set('qr', "$fname.png")
					->update('player');

				$email = $this->input->post('email');
				
				$this->sendOtp($email);
				redirect('otp');
			}
		} else {
			$this->load->view('alpha/notime');
		}
	}

	public function otpSubmit()
	{
		if ($this->_checkEvent() ) {

			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', '');
			$this->form_validation->set_rules('otp', 'OTP', 'trim|required|max_length[4]');

			$otp_error_count = $this->session->userdata('otp_error_count') ?? null;

			if ($this->form_validation->run() === FALSE) {
				
			    $error = $this->session->flashdata('error');
				$this->load->view('alpha/otp', ['error' => $error]);

			} else {
				$otp 		= 	$this->input->post('otp');
				$user_id 	= 	$this->session->userdata('otp_user_id') ?? null;
				$email   	= 	$this->session->userdata('otp_email') ?? null;

				$sql = $this->db->select('*')
					->from('otp')
					->where('user_id', $user_id)
					->order_by('id', 'DESC')
					->limit(1)
					->get();

				$res = $sql->row_array();
				
				if($res['otp'] == $otp){
					$this->db->set('active', 'Y')
						->where('id', $user_id)
						->update('player');
					
					$array = array(
						'id' 	=> $user_id,
					);

					$sql = $this->db->select('*')
						->from('player')
						->where($array)
						->limit(1)
						->get();
					$res = $sql->row_array();

					$this->session->set_userdata(array(
						'loggedin'	=>	$res['id'],
						'name'		=>	$res['data'],
						'qr'		=>	$res['qr']
					) );

					redirect('/');

				} else {
					
					$this->session->set_userdata([
						'otp_error_count' => $otp_error_count + 1
					]);
					
					if ($otp_error_count >= 1) {
						$this->resendOtp();

					} else {
						$this->session->set_flashdata('error', 'Incorrect OTP entered!');
					}

					redirect('/otp');
				}

			}
			
		} else {
			$this->load->view('alpha/notime');
		}
	}

	public function resendOtp() {
		$user_id 			= $this->session->userdata('otp_user_id');
		$email   			= $this->session->userdata('otp_email');
		$otp_error_count	= $this->session->userdata('otp_error_count') ?? null;

		$this->sendOtp($email);

		if ($otp_error_count >= 1) {
			$this->session->set_flashdata('error', "You failed twice! We’ve sent a new OTP to your email");
			$this->session->set_userdata([
				'otp_error_count' => 0
			]);
		} else {
			$this->session->set_flashdata('error', 'New OTP has been sent!');
		}
		
		redirect('/otp');
	}

	public function sendOtp($email){
		$otp = rand(1000, 9999);
		$res = $this->db->where('email', $email)
			->get('player')
			->row_array();

		$data = array(
			'email'		=> $email,
			'otp'		=> $otp,
			'user_id'	=> $res['id']
		);

		$this->db->insert('otp', $data);
		$this->sendEmail($email, $otp);

		$res = ($this->db->affected_rows() != 1) ? false : true;
		return $res;
	}

	public function sendEmail($email, $otp){
		$msg = "Your One-Time-Password is " . $otp . ".";
		$subject = "Cignal ePassport OTP";
		$curl = curl_init();
        $hash = md5(substr(hash('sha512', "12e6bcd7f258880a-$email-$subject-$msg"), 4, 32));
        curl_setopt_array($curl, array(
            CURLOPT_URL => '172.31.10.142/email/',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'name'      => 'cignalepass',
                'hash'      => $hash,
                'to'        => $email,
                'subject'   => $subject,
                'message'   => $msg
            ),
        ) );
        $response = curl_exec($curl);
        curl_close($curl);        
	}

}