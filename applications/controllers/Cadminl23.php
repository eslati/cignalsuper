<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cadminl23 extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->model('User', 'usr', TRUE);
	}

	public function claim()
	{
		if ($this->session->prizer) {
			$this->usr->claimPrize();
		} else {
			echo 'error, pls relogin';
		}
	}

	public function pmon()
	{
		if ($this->session->prizer) {
			$this->usr->prizeMon();
		} else {
			echo 'error, pls relogin';
		}
	}

	public function postScan()
	{
		if ($this->session->clog) {
			$this->usr->qrData();
		} else {
			echo 'error, pls relogin';
		}
	}

	public function logout()
	{
		if ($this->session->clog) {
			$this->session->unset_userdata(array(
				'clog',
				'locid',
				'name',
				'image',
				'prizer',
				'bid'
			) );
			
		}
		redirect('cadminl23');
	}

	public function login()
	{
		if ($this->session->clog) {
			redirect('cadminl23');
		} else {
			$this->usr->userLogin();
		}
	}

	public function index()
	{
		if ($this->session->clog) {
			$this->usr->scanPage();
		} else {
			redirect('cadminl23/login');
		}
	}

}