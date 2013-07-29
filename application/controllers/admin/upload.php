<?php

class Upload extends CI_Controller {

        public function __construct() {
            parent::__construct();
            
            $this->load->helper('funciones_custom_helper');


        }
        
	function index()
	{
		$this->load->view('admin/upload_form', array('error' => ' ' ));
	}

	function do_upload()
	{
		$config['upload_path'] = '../eshop/productos_img/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '100';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';
		$config['overwrite'] = TRUE;

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors());

			$this->load->view('admin/upload_form', $error);
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());

			$this->load->view('admin/upload_success', $data);
		}
	}
}
?>
