<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reporte extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/reporte
	 *	- or -  
	 * 		http://example.com/index.php/reporte/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/reporte/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
    
        public function __construct() {
            parent::__construct();
            
            $this->load->helper('funciones_custom_helper');


        }
        
	public function index()
	{
		show_404();
	}

	public function surtir()
	{
		$tienda_cookie = $_SESSION['userdata']['tienda'];
		$consulta_tienda = $this->db->get_where('tienda',array('idTienda' => $tienda_cookie));
		$tienda = datosTienda($consulta_tienda);
		$data['nombre_tienda'] = $tienda['nombre'];
		$secure_number = $_SESSION['userdata']['secure_number'];
		$consulta_user = $this->db->get_where('usuario',array('secure_number' => $secure_number));
		if($consulta_user->num_rows != 1){
			//redirect('admin/dashboard/salir');
		}

		$logged = $_SESSION['userdata']['logged'];
		/*if($logged){
			echo '<pre>';
			print_r($_SESSION);
			echo '</pre>';
			echo $_SESSION['userdata']['secure_number'];
		}*/
		if(!$logged){
			redirect('admin/dashboard');
		}
		$consulta_user = $this->db->get_where('usuario',array('secure_number' => $secure_number));
		$user = datosUser($consulta_user);
		$consulta_rol = $this->db->get_where('permiso',array('idPermiso'=>$user['permiso']));
		$rol = permisoUser($consulta_rol);
		//echo 'surtir';

		/*$this->db->distinct('persona_dos');
		$this->db->where(array('Estado_idEstado' => 2));
		$surtidores = $this->db->get('reporte');*/

		$this->load->model('admin/surtidor_model','surtidor');
		//$data['surtidores'] = $this->db->query('SELECT DISTINCT(persona_dos) FROM `reporte` WHERE Estado_idEstado = 2 LIMIT 0, 30');
		$data['surtidores'] = $this->surtidor->getallsurtidores();
		//$data['rol'] = 'ADMINISTRADOR';
		/*echo '<pre>';
		print_r($data['surtidores']);*/
		$data['rol'] = $rol;
		$data['seccion'] = 'reporte';
		//$this->form_validation->set_rules('email', 'Email', 'required');
		$this->form_validation->set_rules('select_persona','Seleccionar Persona','required');
		$this->form_validation->set_rules('fecha_inicio','Fecha de Inicio','required');
		$this->form_validation->set_rules('fecha_final','Fecha de Final','required');

		if($this->form_validation->run() == FALSE){
			$data['mostrar'] = FALSE;
			
		}else{
			/******* Muchos de estos procesos deberían estar en un modelo pero, debido a la urgencia del 'requerimiento' se hizo todo dentro del controlador.
					Favor de colocarlos en un modelo.
			*********/
                        $this->load->model('admin/pedido_model','pedido');
			$data['mostrar'] = TRUE;
			$select = $_POST['select_persona'];
			$inicio = $_POST['fecha_inicio'];
			$final = $_POST['fecha_final'];
			$data['consulta'] = $this->db->query("SELECT * FROM `reporte` JOIN pedido ON Pedido_idPedido = idPedido WHERE persona_dos REGEXP('$select') AND fecha_aut BETWEEN '$inicio' AND '$final 23:59:59' AND reporte.Estado_idEstado = 2");
			$temp = $data['consulta'];
			foreach($temp->result() as $temp1){
				$reporte = $temp1->idReporte;
				$pedido = $temp1->Pedido_idPedido;

				/* Sacar la fecha del siguiente estado*/
				$data['pedido'][$pedido]['fecha_siguiente'] = $this->db->query("SELECT fecha_aut FROM `reporte` WHERE Pedido_idPedido = $pedido and Estado_idEstado = 4");

				/* Sacar el importe total del pedido surtido */
				$data['pedido'][$pedido]['importe_pedido'] = $this->db->query(" SELECT SUM( precio * cantidad ) AS total FROM `contenidopedido` WHERE Pedido_idPedido =$pedido ");

				/* Sacar la fecha de recepcion de pedido */
				$data['pedido'][$pedido]['fecha_recepcion'] = $this->db->query("SELECT fecha_aut FROM `reporte` WHERE Pedido_idPedido = $pedido and Estado_idEstado = 1");
			}
		}
		$this->load->view('admin/reporte/surtir',$data);
	}

	public function nosurtido(){

		$tienda_cookie = $_SESSION['userdata']['tienda'];
		$consulta_tienda = $this->db->get_where('tienda',array('idTienda' => $tienda_cookie));
		$tienda = datosTienda($consulta_tienda);
		$data['nombre_tienda'] = $tienda['nombre'];
		$secure_number = $_SESSION['userdata']['secure_number'];
		$consulta_user = $this->db->get_where('usuario',array('secure_number' => $secure_number));
		if($consulta_user->num_rows != 1){
			//redirect('admin/dashboard/salir');
		}

		$logged = $_SESSION['userdata']['logged'];
		
		if(!$logged){
			redirect('admin/dashboard');
		}
		$consulta_user = $this->db->get_where('usuario',array('secure_number' => $secure_number));
		$user = datosUser($consulta_user);
		$consulta_rol = $this->db->get_where('permiso',array('idPermiso'=>$user['permiso']));
		$rol = permisoUser($consulta_rol);

		$this->form_validation->set_rules('fecha_inicio','Fecha de Inicio','required');
		$this->form_validation->set_rules('fecha_final','Fecha de Final','required');

		$data['rol'] = $rol;
		$data['seccion'] = 'reporte';

		if($this->form_validation->run() == FALSE){

			$data['mostrar'] = FALSE;
			

		}else{

			$data['mostrar'] = TRUE;
			$inicio = $_POST['fecha_inicio'];
			$final = $_POST['fecha_final'];
			$this->db->where("pedido.fecha_pedido BETWEEN '$inicio' AND '$final 23:59:59' AND reporte.Estado_idEstado = 3");
			$this->db->join("pedido","pedido.idPedido = reporte.Pedido_idPedido");
			$this->db->order_by('Pedido_idPedido','ASC');
			$q = $this->db->get('reporte');

			//$q= $this->db->get('pedido');
			/*echo '<pre>';
			print_r($q->result_array());
			echo '</pre>';*/
			$data['consulta'] = $q;
			foreach($q->result() as $temp1){
				$pedido = $temp1->Pedido_idPedido;
				$data['pedido'][$pedido]['importe_pedido'] = $this->db->query(" SELECT SUM( precio * cantidad ) AS total FROM `contenidopedido` WHERE Pedido_idPedido =$pedido ");
			}
			

		}

		$this->load->view("admin/reporte/nosurtido",$data);


	}
}

/* End of file reporte.php */
/* Location: ./application/controllers/reporte.php */