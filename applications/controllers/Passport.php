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

	public function destro()
	{
		$this->session->unset_userdata(array(
			'loggedin',
			'name',
			'qr'
		) );
		redirect('/');
	}

	public function priv()
	{
		$this->load->view('alpha/privacy');
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

	public function otp()
	{
		if ($this->session->loggedin) {
			redirect('/');
		} else {
			$this->play->otpSubmit();
		}
	}

	public function resend_otp()
	{
		if ($this->session->loggedin) {
			redirect('/');
		} else {
			$this->play->resendOtp();
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