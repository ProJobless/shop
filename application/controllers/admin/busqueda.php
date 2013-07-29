<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class busqueda extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/busqueda
	 *	- or -  
	 * 		http://example.com/index.php/busqueda/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/busqueda/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
    
        public function __construct() {
            parent::__construct();
            
            $this->load->helper('funciones_custom_helper');


        }
    
	public function index()
	{
		$this->load->view('admin/busqueda_message');
	}

	public function pedido(){
		$tienda_cookie = $_SESSION['userdata']['tienda'];
		$consulta_tienda = $this->db->get_where('tienda',array('idTienda' => $tienda_cookie));
		$tienda = datosTienda($consulta_tienda);
		$data['nombre_tienda'] = $tienda['nombre'];
		$secure_number = $_SESSION['userdata']['secure_number'];
		$consulta_user = $this->db->get_where('usuario',array('secure_number' => $secure_number));
		/*if($consulta_user->num_rows != 1){
			redirect('admin/dashboard/salir');
		}*/
		$logged = $_SESSION['userdata']['logged'];
		
		if(!$logged){
			redirect('admin/dashboard');
		}
		$consulta_user = $this->db->get_where('usuario',array('secure_number' => $secure_number));
		$user = datosUser($consulta_user);
		$consulta_rol = $this->db->get_where('permiso',array('idPermiso'=>$user['permiso']));
		$rol = permisoUser($consulta_rol);

		$this->load->model('admin/paginator_model');
		$pages=10; //Numero de registros mostrados por páginas
		$this->load->library('pagination'); //Cargamos la librería de paginación
		$config['base_url'] = base_url().'busqueda/pedido'; // parametro base de la aplicación, si tenemos un .htaccess nos evitamos el index.php
		    
		$config['per_page'] = $pages; 
		$config['num_links'] = 5; //Numero de links mostrados en la paginación
		$config["uri_segment"] = 3; //Para que los links en la paginación sean los correctos.
		$config['first_link'] = 'Inicio';
		$config['last_link'] = 'Final';

		
		
		
		//echo (!empty($_POST['token'])) ? 'lleno' : 'vacio';

		$_SESSION['busqueda'] = (!empty($_POST['token'])) ? $_POST['token'] : $_SESSION['busqueda'];
		$buscar = (!empty($_SESSION['busqueda'])) ? $_SESSION['busqueda'] : $_POST['token'];
		

		if( is_numeric($buscar) ){
			
			$sql = $this->db->get_where('pedido',array('idPedido'=>$buscar));
			if($sql->num_rows() > 0){
				$config['total_rows'] = $sql->num_rows();
				$this->pagination->initialize($config); 
 				$data["consulta"] = $this->paginator_model->getPedidoPaginated("consulta_id",$tienda['idTienda'],$config['per_page'],$this->uri->segment(3),$buscar);
				$data['seccion'] = 'consulta_todos';
				$data['rol'] = $rol;
				$this->load->view('admin/altas_consultas',$data);
			}else{
				$this->session->set_flashdata('update_message', 'No se ha encontrado ningún resultado.');
				redirect($_SERVER["HTTP_REFERER"]);
			}

		}else{
			$num_rows = $this->paginator_model->totalPedidos("consulta_pcliente",$tienda['idTienda'],$buscar) ; 
			if($num_rows > 0){
				$config['total_rows'] =$num_rows;
				$this->pagination->initialize($config); 
 				$data["consulta"] = $this->paginator_model->getPedidoPaginated("consulta_pcliente",$tienda['idTienda'],$config['per_page'],$this->uri->segment(3),$buscar);
				$data['seccion'] = 'consulta_todos';
				$data['rol'] = $rol;
				$this->load->view('admin/altas_consultas',$data);
			}else{
				$this->session->set_flashdata('update_message', 'No se ha encontrado ningún resultado.');
				redirect($_SERVER["HTTP_REFERER"]);
			}

			

		}
	}

	public function consulta_cliente(){

		$tienda_cookie = $_SESSION['userdata']['tienda'];
		$consulta_tienda = $this->db->get_where('tienda',array('idTienda' => $tienda_cookie));
		$tienda = datosTienda($consulta_tienda);
		$data['nombre_tienda'] = $tienda['nombre'];
		$secure_number = $_SESSION['userdata']['secure_number'];
		$consulta_user = $this->db->get_where('usuario',array('secure_number' => $secure_number));
		/*if($consulta_user->num_rows != 1){
			redirect('admin/dashboard/salir');
		}*/
		$logged = $_SESSION['userdata']['logged'];
		
		if(!$logged){
			redirect('admin/dashboard');
		}
		$consulta_user = $this->db->get_where('usuario',array('secure_number' => $secure_number));
		$user = datosUser($consulta_user);
		$consulta_rol = $this->db->get_where('permiso',array('idPermiso'=>$user['permiso']));
		$rol = permisoUser($consulta_rol);

		$this->load->model('admin/paginator_model');
		$pages=10000; //Numero de registros mostrados por páginas
		$this->load->library('pagination'); //Cargamos la librería de paginación
		$config['base_url'] = base_url().'busqueda/consulta_cliente'; // parametro base de la aplicación, si tenemos un .htaccess nos evitamos el index.php
		    
		$config['per_page'] = $pages; 
		$config['num_links'] = 5; //Numero de links mostrados en la paginación
		$config["uri_segment"] = 3; //Para que los links en la paginación sean los correctos.
		$config['first_link'] = 'Inicio';
		$config['last_link'] = 'Final';


		$_SESSION['busqueda'] = (!empty($_POST['token'])) ? $_POST['token'] : $_SESSION['busqueda'];
		$buscar1 = (!empty($_SESSION['busqueda'])) ? $_SESSION['busqueda'] : $_POST['token'];

		$buscar2 = '('.str_replace(' ','|',$buscar1).')+';
		//echo $buscar2;
		
		$buscar = substr($buscar1, 2); 
		if( is_numeric($buscar) ){
			
			$sql = $this->db->get_where('cliente',array('idCliente'=>$buscar));
			if($sql->num_rows() > 0){
				$config['total_rows'] = $sql->num_rows();
				$this->pagination->initialize($config); 
 				$data["consulta"] = $this->paginator_model->getClientPaginated($tienda['idTienda'],$config['per_page'],$this->uri->segment(3),$buscar,"cliente_id");
				$data['seccion'] = 'consulta_cliente';
				$data['rol'] = $rol;
				$this->load->view('admin/altas_consultas',$data);
			}else{
				$this->session->set_flashdata('update_message', 'No se ha encontrado ningún resultado.');
				redirect($_SERVER["HTTP_REFERER"]);
			}

		}else{
			$buscar = $buscar2;
			$num_rows = $this->paginator_model->totalClientes($tienda['idTienda'],"cliente_like",$buscar) ; 
			if($num_rows > 0){
				$config['total_rows'] =$num_rows;
				$this->pagination->initialize($config); 
 				$data["consulta"] = $this->paginator_model->getClientPaginated($tienda['idTienda'],$config['per_page'],$this->uri->segment(3),$buscar,"cliente_like");
				$data['seccion'] = 'consulta_cliente';
				$data['rol'] = $rol;
				$this->load->view('admin/altas_consultas',$data);
			}else{
				$this->session->set_flashdata('update_message', 'No se ha encontrado ningún resultado.');
				redirect($_SERVER["HTTP_REFERER"]);
			}
		}

	}

	public function consulta_producto(){

		$tienda_cookie = $_SESSION['userdata']['tienda'];
		$consulta_tienda = $this->db->get_where('tienda',array('idTienda' => $tienda_cookie));
		$tienda = datosTienda($consulta_tienda);
		$data['nombre_tienda'] = $tienda['nombre'];
		$secure_number = $_SESSION['userdata']['secure_number'];
		$consulta_user = $this->db->get_where('usuario',array('secure_number' => $secure_number));
		/*if($consulta_user->num_rows != 1){
			redirect('admin/dashboard/salir');
		}*/
		$logged = $_SESSION['userdata']['logged'];
		
		if(!$logged){
			redirect('admin/dashboard');
		}
		$consulta_user = $this->db->get_where('usuario',array('secure_number' => $secure_number));
		$user = datosUser($consulta_user);
		$consulta_rol = $this->db->get_where('permiso',array('idPermiso'=>$user['permiso']));
		$rol = permisoUser($consulta_rol);

		
		
		
		//echo (!empty($_POST['token'])) ? 'lleno' : 'vacio';

		$_SESSION['busqueda'] = (!empty($_POST['token'])) ? $_POST['token'] : $_SESSION['busqueda'];
		$buscar = (!empty($_SESSION['busqueda'])) ? $_SESSION['busqueda'] : $_POST['token'];
		$buscar2 = '('.str_replace(' ','|',$buscar).')+';
		
		$buscar = $buscar2;
		$query = "SELECT `idCategoria`, `categoria`.`nombre` as catnombre, `categoria`.`activo` as catactivo, `idSubcategoria`, `subcategoria`.`nombre` as subcatnombre, 
		`subcategoria`.`activo` as subcatactivo, `idProducto`, `producto`.`nombre`, `producto`.`uso`, `producto`.`imagen`, `producto`.`activo` as produactivo, 
		`SubCategoria_idSubCategoria` 
		FROM (`producto`) 
		JOIN `subcategoria` ON `subcategoria`.`idSubCategoria` = `producto`.`Subcategoria_idSubCategoria` 
		JOIN `categoria` ON `categoria`.`idCategoria` = `subcategoria`.`Categoria_idCategoria` 
		WHERE `categoria`.`Tienda_idTienda` = '2' 
		AND `producto`.`nombre` REGEXP '$buscar' 
		ORDER BY `categoria`.`nombre` asc, `subcategoria`.`nombre`, `producto`.`nombre` asc";
		$q=$this->db->query($query);
		
		$data['consulta'] = $q;
		$tmp = $data['consulta'];

		//echo $buscar;
		if($tmp->num_rows() > 0){
			//echo $buscar;
			$data['seccion'] = 'consulta_producto';
			$data['rol'] = $rol;
			$this->load->view('admin/altas_consultas',$data);
		}else{
			$this->session->set_flashdata('update_message', 'No se ha encontrado ningún resultado.');
			//echo 'error';
			redirect($_SERVER["HTTP_REFERER"]);
		}
		
	}

	public function consulta_presentacion(){

		$tienda_cookie = $_SESSION['userdata']['tienda'];
		$consulta_tienda = $this->db->get_where('tienda',array('idTienda' => $tienda_cookie));
		$tienda = datosTienda($consulta_tienda);
		$data['nombre_tienda'] = $tienda['nombre'];
		$secure_number = $_SESSION['userdata']['secure_number'];
		$consulta_user = $this->db->get_where('usuario',array('secure_number' => $secure_number));
		/*if($consulta_user->num_rows != 1){
			redirect('admin/dashboard/salir');
		}*/
		$logged = $_SESSION['userdata']['logged'];
		
		if(!$logged){
			redirect('admin/dashboard');
		}
		$consulta_user = $this->db->get_where('usuario',array('secure_number' => $secure_number));
		$user = datosUser($consulta_user);
		$consulta_rol = $this->db->get_where('permiso',array('idPermiso'=>$user['permiso']));
		$rol = permisoUser($consulta_rol);

		
		
		
		//echo (!empty($_POST['token'])) ? 'lleno' : 'vacio';

		$_SESSION['busqueda'] = (!empty($_POST['token'])) ? $_POST['token'] : $_SESSION['busqueda'];
		$buscar = (!empty($_SESSION['busqueda'])) ? $_SESSION['busqueda'] : $_POST['token'];
		$buscar2 = '('.str_replace(' ','|',$buscar).')+';
		
		$buscar = $buscar2;
		
		$query = "SELECT `idPresentacion`, `presentacion`.`clave`, `producto`.`nombre` as nombre_producto, `presentacion`.`estado_fisico`, `presentacion`.`contenido_neto`, 
		`presentacion`.`iva`, `presentacion`.`precio_publico`, `presentacion`.`activo`, `presentacion`.`ingredientes`, `presentacion`.`imagen`, `presentacion`.`video`,
		 `presentacion`.`grupo` 
		 FROM (`presentacion`) 
		 JOIN `producto` ON `producto`.`idProducto` = `presentacion`.`Producto_idProducto` 
		 JOIN `subcategoria` ON `subcategoria`.`idSubCategoria` = `producto`.`Subcategoria_idSubCategoria` 
		 JOIN `categoria` ON `categoria`.`idCategoria` = `subcategoria`.`Categoria_idCategoria` 
		 WHERE `categoria`.`Tienda_idTienda` = '2'
		 AND `producto`.`nombre` REGEXP '$buscar'  
		 ORDER BY `producto`.`nombre` asc";
		$q=$this->db->query($query);
		
		$data['consulta'] = $q;
		$tmp = $data['consulta'];

		//echo $buscar;
		if($tmp->num_rows() > 0){
			//echo $buscar;
			$data['seccion'] = 'consulta_presentacion';
			$data['rol'] = $rol;
			$this->load->view('admin/altas_consultas',$data);
		}else{
			$this->session->set_flashdata('update_message', 'No se ha encontrado ningún resultado.');
			//echo 'error';
			redirect($_SERVER["HTTP_REFERER"]);
		}
		
	}
}

/* End of file busqueda.php */
/* Location: ./application/controllers/busqueda.php */