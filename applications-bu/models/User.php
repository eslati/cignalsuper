<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Model {

	private $user = NULL;

	public function scanPage()
	{
		$this->load->view('sigma/qr');
	}

	public function qrData()
	{
		$pid = intval($this->input->post('qrc') );
		$usr = $this->db->where('id', $pid)
						->where('active', 'Y')
						->get('user')
						->num_rows();
		if ($usr == 1) {
			$res = $this->db->where('player_id', $pid)
							->where('badge_id', $this->session->bid)
							->get('playbadge')
							->num_rows();
			if ($res == 1) {
				echo 'BADGE ALREADY UNLOCKED';
			} else {
				$this->db->insert('playbadge', array(
					'player_id'	=>	$pid,
					'badge_id'	=>	$this->session->bid,
					'user_id'	=>	$this->session->clog
				) );
				echo 'badge unlocked';
			}
		} else {
			echo 'invalid user';
		}
	}

	public function userLogin()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules('uname', 'Username', array('trim','required','max_length[40]', array(
			'validuser', function($uname) {
				$res = $this->db->where('uname', $uname)
								->get('user')
								->row_array();
				if (isset($res['id']) == 1) {
					$this->user = $res;
					return TRUE;
				} else {
					$this->form_validation->set_message('validuser', '');
					return FALSE;
				}
			}
		) ) );
		$this->form_validation->set_rules('paswd', 'Password', array('trim','required','max_length[40]', array(
			'validpass', function($paswd) {
				if (isset($this->user['paswd']) ) {
					if ($this->user['paswd'] == $paswd) {
						return TRUE;
					}
				}
				$this->form_validation->set_message('validpass', 'invalid username password');
				return FALSE;
			}
		) ) );
		if ($this->form_validation->run() === FALSE) {
			$this->load->view('sigma/login');
		} else {
			$res = $this->db->select('badge.id as bid, location.id as locid, location.name as lname')
							->join('location', 'loc_id = location.id')
							->join('badge', 'badge_id = badge.id')
							->where('`user`.id', $this->user['id'])
							->get('user')
							->row_array();
			$this->session->set_userdata(array(
				'clog'	=>	$this->user['id'],
				'locid'	=>	$res['locid'],
				'name'	=>	$res['lname'],
				'bid'	=>	$res['bid']
			) );
			redirect('/Cadminl23');
		}
	}

}