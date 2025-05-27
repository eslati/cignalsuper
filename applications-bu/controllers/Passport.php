<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Passport extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->model('Player', 'play', TRUE);
	}

	public function test()
	{
		include('../phpqrcode/qrlib.php');
		QRcode::png('PHP QR Code :)', 'qr/qr.png', QR_ECLEVEL_L, 10);
		echo '<img src="../qr/qr.png">';
	}

	public function destro()
	{
		$this->session->unset_userdata('loggedin');
		redirect('/');
	}

	public function index()
	{
		if ($this->session->loggedin) {
			$this->play->homePage();
		} else {
			$this->load->view('alpha/start');
		}
	}

	public function regist()
	{
		if ($this->session->loggedin) {
			redirect('/');
		} else {
			$this->play->registerSubmit();
		}
	}

	public function logmein()
	{
		if ($this->session->loggedin) {
			redirect('/');
		} else {
			$this->play->playerLogin();
		}
	}

}