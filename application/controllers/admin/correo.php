<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Correo extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/alta
	 *	- or -  
	 * 		http://example.com/index.php/alta/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/alta/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
    
         public function __construct() {
            parent::__construct();
            
            $this->load->helper('funciones_custom_helper');


        }
        
	public function index()
	{
		
		//print_r($url);
		//$this->login_model->checkLogin();
		show_404();

	}
        
        public function alta(){
            $this->load->library('phpsession');
            $tienda_cookie = $_SESSION['userdata']['tienda'];
            $consulta_tienda = $this->db->get_where('tienda',array('idTienda' => $tienda_cookie));
            $tienda = datosTienda($consulta_tienda);
            $data['nombre_tienda'] = $tienda['nombre'];
            $data['seccion'] = 'alta';
            $secure_number = $_SESSION['userdata']['secure_number'];
            $consulta_user = $this->db->get_where('usuario',array('secure_number' => $secure_number));
            /*if($consulta_user->num_rows > 0){
                    redirect('admin/dashboard/salir');
            }*/
            $logged = $_SESSION['userdata']['logged'];

            if($logged == TRUE){
                    /*echo '<pre>';
                    print_r($_SESSION);
                    echo '</pre>';*/
            }
            $consulta_user = $this->db->get_where('usuario',array('secure_number' => $secure_number));
            $user = datosUser($consulta_user);
            $consulta_rol = $this->db->get_where('permiso',array('idPermiso'=>$user['permiso']));
            $rol = permisoUser($consulta_rol);
            $data['rol'] = $rol;
                
            $this->load->model('admin/generic_model','gen');
            if($this->form_validation->run('correos') === FALSE){
                
                $data['accion'] = $this->uri->segment(2);
                $data['correos'] = $this->gen->get_correos();
                $this->load->view('admin/nuevos/correo_view',$data);
                
            }else{
                $post = $this->input->post(NULL,TRUE);
                $this->gen->guardar_correo($post);
                $this->phpsession->flashsave('acierto','El correo ha sido guardado con éxito.');
                redirect(current_url());
            }
            
        }
        
        public function eliminar($idcorreo){
            $this->load->library('phpsession');
            $this->db->where('idcorreo',$idcorreo);
            $this->db->update('correo',array('activo'=>'NO'));
            $this->phpsession->flashsave('acierto','La dirección de correo ha sido eliminada.');
            redirect($_SERVER['HTTP_REFERER']);
        }

}

/* End of file alta.php */
/* Location: ./application/controllers/alta.php */