<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Player extends CI_Model {

	public function playerLogin()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules('mobile', 'Mobile', array('trim','required','max_length[11]', array(
			'validmobile', function($mobile) {
				$res = $this->db->where('mobile', substr($mobile, 1) )
								->where('active', 'Y')
								->get('player')
								->row_array();
				if (isset($res['id']) == 1) {
					$this->session->set_userdata(array(
						'loggedin'	=>	$res['id'],
						'name'		=>	$res['data']
					) );
					return TRUE;
				} else {
					$this->form_validation->set_message('validmobile', 'mobile not registered');
					return FALSE;
				}
			}
		) ) );
		if ($this->form_validation->run() === FALSE) {
			$this->load->view('alpha/login');
		} else {
			redirect('/');
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
			$this->load->view('alpha/done');
		}
	}

	public function registerSubmit()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules('name', 'Name', 'trim|required|max_length[80]');
		$this->form_validation->set_rules('mobile', 'Mobile', 'trim|required|max_length[11]|is_unique[player.mobile]');
		if ($this->form_validation->run() === FALSE) {
			$this->load->view('alpha/register');
		} else {
			$this->db->insert('player', array(
				'mobile'=>	substr($this->input->post('mobile'), 1),
				'data'	=>	$this->input->post('name')
			) );
			$id = $this->db->insert_id();
			//include('../phpqrcode/qrlib.php');
			include('/var/www/dev/applications/phpqrcode/qrlib.php');
			$fname = md5($id);
			QRcode::png(str_pad($id, 8, 0, STR_PAD_LEFT), "qr/$fname.png", QR_ECLEVEL_L, 10);
			$this->db->where('id', $id)
					->set('qr', "$fname.png")
					->update('player');
			$this->session->set_userdata(array(
				'loggedin'	=>	$id,
				'name'		=>	$this->input->post('name'),
				'qr'		=>	"$fname.png"
			) );
			redirect('/');
		}
	}

}