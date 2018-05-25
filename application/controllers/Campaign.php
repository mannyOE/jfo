<?php /**
 * 
 */
class Campaign extends CI_Controller
{
	

	function index(){
		$this->load->view('Home/header');
		$this->load->view('Home/navigation');
		$this->load->view('Home/indexpage');
		$this->load->view('Home/footer');
		$this->load->view('Home/tail');
	}
} ?>