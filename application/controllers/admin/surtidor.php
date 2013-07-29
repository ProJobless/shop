<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Surtidor extends CI_Controller {

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
    
         
	public function __construct()
	{
		parent::__construct();
		//$this->load->model('admin/expediente_model','expediente');
		//$this->load->model('admin/login_model','login');
		//$this->login->checkLogin();
		$this->load->library('phpsession');
                $this->load->helper('funciones_custom_helper');
	}

	public function index()
	{
		
		//print_r($url);
		//$this->login_model->checkLogin();
		show_404();

	}

	public function alta()
	{
		/* A continuación pego las COCHINADAS que hice cuando cree el sistema 
			Básicamente son validaciones y generación de info, para le menu y la tienda a la que esta vinculado, etc.
		*/	
		$tienda_cookie = $_SESSION['userdata']['tienda'];
		$consulta_tienda = $this->db->get_where('tienda',array('idTienda' => $tienda_cookie));
		$tienda = datosTienda($consulta_tienda);
		$data['nombre_tienda'] = $tienda['nombre'];
		$data['seccion'] = 'inicio';
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

		/** FIN BLOQUE COCHINADAS **/


		//$this->login_model->checkLogin();
		$data['accion'] = 'alta';
		if($this->form_validation->run('alta_surtidor') == FALSE){
			$this->load->view('admin/surtidor_view',$data);
		}else{
			$post = $this->input->post(NULL, TRUE);
			

			$this->load->model('admin/surtidor_model','surtidor');
			$this->surtidor->guardarsurtidor($post);
			//print_r($post);
			$this->phpsession->flashsave('acierto','El surtidor ha sido dado de alta correctamente.');
			redirect(current_url());
			
		}
		
	}

	public function editar($idsurtidor = 0)
	{
		/* A continuación pego las COCHINADAS que hice cuando cree el sistema 
			Básicamente son validaciones y generación de info, para le menu y la tienda a la que esta vinculado, etc.
		*/	
		$tienda_cookie = $_SESSION['userdata']['tienda'];
		$consulta_tienda = $this->db->get_where('tienda',array('idTienda' => $tienda_cookie));
		$tienda = datosTienda($consulta_tienda);
		$data['nombre_tienda'] = $tienda['nombre'];
		$data['seccion'] = 'inicio';
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

		/** FIN BLOQUE COCHINADAS **/


		//$this->login_model->checkLogin();
		$this->load->model('admin/surtidor_model','surtidor');

		if($idsurtidor == 0){

			$data['surtidores'] = $this->surtidor->getsurtidor();
			$data['accion'] = 'lista';
		}else{
			$surtidores = $this->surtidor->getsurtidor($idsurtidor);
			$data['surtidor'] = $surtidores[0];
			$data['accion'] = 'editar';

			if($this->form_validation->run('alta_surtidor') == TRUE){
				$post = $this->input->post(NULL, TRUE);
				//$post['descripcion_tiny'] = $_POST['descripcion'];
				$this->surtidor->guardarsurtidor($post,true);
				$this->phpsession->flashsave('acierto','El surtidor ha sido editado correctamente.');
				redirect(current_url());
			}	
		}

		$this->load->view('admin/surtidor_view',$data);
		
	}

	public function borrar($idsurtidor=0)
	{
		/* A continuación pego las COCHINADAS que hice cuando cree el sistema 
			Básicamente son validaciones y generación de info, para le menu y la tienda a la que esta vinculado, etc.
		*/	
		$tienda_cookie = $_SESSION['userdata']['tienda'];
		$consulta_tienda = $this->db->get_where('tienda',array('idTienda' => $tienda_cookie));
		$tienda = datosTienda($consulta_tienda);
		$data['nombre_tienda'] = $tienda['nombre'];
		$data['seccion'] = 'inicio';
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

		/** FIN BLOQUE COCHINADAS **/

		//$this->login_model->checkLogin();

		if($idsurtidor == 0 || !is_numeric($idsurtidor)){
			show_404();
		}else{
			$this->load->model('admin/surtidor_model','surtidor');
			$this->surtidor->borrarsurtidor($idsurtidor);
			$this->phpsession->flashsave('acierto','El surtidor ha sido borrado con éxito.');
			redirect('admin/surtidor/editar');
		}
		
		
		
	}

}

/* End of file alta.php */
/* Location: ./application/controllers/alta.php */