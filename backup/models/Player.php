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
									->where('active', 'Y')
									->get('player')
									->row_array();
					if (isset($res['id']) == 1) {
						$this->session->set_userdata(array(
							'loggedin'	=>	$res['id'],
							'name'		=>	$res['data'],
							'qr'		=>	$res['qr']
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
			$this->form_validation->set_rules('mobile', 'Mobile', array('trim','required','max_length[11]',array(
				'validmobile', function($mobile) {
					$res = $this->db->where('mobile', substr($mobile, 1) )
									->get('player')
									->row_array();
					if (isset($res['id']) == 0) {
						return TRUE;
					} else {
						$this->form_validation->set_message('validmobile', 'mobile already registered');
						return FALSE;
					}
				} )
			));
			if ($this->form_validation->run() === FALSE) {
				$this->load->view('alpha/register');
			} else {
				$this->db->insert('player', array(
					'mobile'=>	substr($this->input->post('mobile'), 1),
					'data'	=>	$this->input->post('name')
				) );
				$id = $this->db->insert_id();
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
		} else {
			$this->load->view('alpha/notime');
		}
	}

}