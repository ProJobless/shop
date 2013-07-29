<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Producto extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/producto
	 *	- or -  
	 * 		http://example.com/index.php/producto/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/producto/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
    
         public function __construct() {
            parent::__construct();
            
            $this->load->helper('funciones_custom_helper');


        }
        
	public function index()
	{
		
	}
        
        public function lista(){
            $this->load->library('phpsession');
            $data['seccion'] = $this->uri->segment(2);
            $data['rol'] = 'ADMINISTRADOR';
            $this->load->view('admin/nuevos/producto_view',$data);
        }
        
        public function subir_lista(){
            $this->load->model('admin/producto_model','producto');
            $this->load->library('phpsession');
            $lista = $this->producto->subir_lista();
            $this->phpsession->flashsave($lista['success'],$lista['resultado']);
            $this->phpsession->flashsave('detalles',$lista['detalles']);
            redirect('admin/producto/lista');
        }

	
}

/* End of file producto.php */
/* Location: ./application/controllers/producto.php */