<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Model {

	private $user = NULL;

	public function scanPage()
	{
		if ($this->session->prizer) {
			$this->load->view('sigma/prizer');
		} else {
			$this->load->view('sigma/qr');
		}
	}

	public function prizeMon()
	{
		$res = $this->db->join('prize', 'prize_id = prize.id')
						->where('loc_id', $this->session->locid)
						->where('prizealloc.active', 'Y')
						->get('prizealloc')
						->result_array();
		$data = '';
		foreach ($res as $i) {
			$data .= "\n{$i['name']} :\t\t{$i['claim']}/{$i['stock']}";
		}
		echo $data;
	}

	public function claimPrize()
	{
		$pid = intval($this->input->post('prc') );
		$usr = $this->db->where('id', $pid)
						->where('active', 'Y')
						->get('player')
						->num_rows();
		if ($usr == 1) {
			$res = $this->db->select('winner.id, win_id, name, image')
							->join('claim', 'winner.id = win_id', 'LEFT')
							->join('prizealloc', 'alloc_id = prizealloc.id')
							->join('prize', 'prize_id = prize.id')
							->where('player_id', $pid)
							->get('winner')
							->row_array();
			if (isset($res['id']) == 1) {
				if (is_null($res['win_id']) ) {
					$this->db->insert('claim', array('win_id' => $res['id']) );
					echo "Give Prize {$res['name']} 🎉";
				} else {
					echo '🚫Prize Already Claimed🚫';
				}
			} else {
				echo "Sorry. Player didn't win a prize😥";
			}
		} else {
			echo 'QR Invalid';
		}
	}

	public function qrData()
	{
		$pid = intval($this->input->post('qrc') );
		$usr = $this->db->where('id', $pid)
						->where('active', 'Y')
						->get('player')
						->num_rows();
		if ($usr == 1) {
			$res = $this->db->where('player_id', $pid)
							->where('badge_id', $this->session->bid)
							->get('playbadge')
							->num_rows();
			if ($res == 1) {
				echo '🚫This badge is ALREADY UNLOCKED🚫';
			} else {
				$this->db->insert('playbadge', array(
					'player_id'	=>	$pid,
					'badge_id'	=>	$this->session->bid,
					'user_id'	=>	$this->session->clog
				) );
				$this->_checkCompletion($pid);
				echo 'Badge Successfully Unlocked✅️';
			}
		} else {
			echo 'invalid QR';
		}
	}

	private function _checkCompletion($pid)
	{
		$play = $this->db->select('badge_id')
						->where('player_id', $pid)
						->get('playbadge')
						->num_rows();
		if ($play == 8) {
			$this->_getAvailprize($pid);
		}
	}

	private function _getAvailprize($pid)
	{
		$res = $this->db->select('percent, prizealloc.id as alloc_id')
						->join('prize', 'prize_id = prize.id')
						->where('loc_id', $this->session->locid)
						->where('claim < stock')
						->where('prizealloc.active', 'Y')
						->where('prize.active', 'Y')
						->get('prizealloc')
						->result_array();
		$rand = rand(0, 99);
		$count = count($res);
		if ($count > 0) {
			$prize = $res[rand(0, $count-1)];
			if ($rand <= $prize['percent']) {
				$this->db->where('id', $prize['alloc_id'])
						->set('`claim`', '`claim` + 1', FALSE)
						->update('prizealloc');
				$this->db->insert('winner', array(
					'player_id'	=>	$pid,
					'alloc_id'	=>	$prize['alloc_id']
				) );
				return TRUE;
			}
		}
		return FALSE;
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
			$res = $this->db->select('prizer, badge.id as bid, location.id as locid, location.name as lname, image')
							->join('location', 'loc_id = location.id')
							->join('badge', 'badge_id = badge.id')
							->where('`user`.id', $this->user['id'])
							->get('user')
							->row_array();
			if ($res['prizer'] == 'Y') {
				$this->session->set_userdata(array(
					'clog'	=>	$this->user['id'],
					'locid'	=>	$res['locid'],
					'name'	=>	$res['lname'],
					'prizer'=>	TRUE
				) );
			} else {
				$this->session->set_userdata(array(
					'clog'	=>	$this->user['id'],
					'locid'	=>	$res['locid'],
					'name'	=>	$res['lname'],
					'image'	=>	$res['image'],
					'bid'	=>	$res['bid']
				) );
			}
			redirect('/Cadminl23');
		}
	}

}