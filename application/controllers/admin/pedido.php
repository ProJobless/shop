<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pedido extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/pedido
	 *	- or -  
	 * 		http://example.com/index.php/pedido/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/pedido/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
    
         public function __construct() {
            parent::__construct();
            
            $this->load->helper('funciones_custom_helper');


        }
        
	public function index()
	{
		redirect('admin/pedido/inicio');
	}
	
	

	public function inicio($seccion = 'pedido_all')
	{
		// Debería llamarse sólo cuando lo necesita pero no tengo tiempo para checar ese detalle
		$this->load->model('admin/surtidor_model','surtidor');
		$data['surtidores'] = $this->surtidor->getallsurtidores();

		// fin instrucción puerca

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
		switch($rol){
		default:
			show_404();
		break;
		
		case 'ADMINISTRADOR':
			$data['rol'] = $rol;
			$data['seccion'] = $seccion;
			$this->load->view('admin/altas_consultas',$data);
		break;
		
		}
	}
	
	public function recibido($seccion = 'pedido_recibido',$cliente_url='none'){

		// Debería llamarse sólo cuando lo necesita pero no tengo tiempo para checar ese detalle
		$this->load->model('admin/surtidor_model','surtidor');
		$data['surtidores'] = $this->surtidor->getallsurtidores();

		// fin instrucción puerca

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
		
		switch($seccion){
			case 'pedido_recibido':
				switch($rol){
				default:
					show_404();
				break;
				case 'ADMINISTRADOR':
				case 'PEDIDOS_CATALOGO':
				case 'PEDIDOS_REPRESENTANTE_VENTAS':
				case 'PEDIDOS_REPRESENTANTE_EMBARQUES':
					$data['seccion'] = $seccion;
					$data['rol'] = $rol;
					$this->load->view('admin/altas_consultas',$data);
				break;
				}
			break;
			case 'catalogo':
				switch($rol){
				default:
					show_404();
				break;
				case 'ADMINISTRADOR':
				case 'PEDIDOS_CATALOGO':
					$data['seccion'] = 'consulta_catalogo_recibido';
					$data['rol'] = $rol;
					/* NOTA EL TIPO CLIENTE 3 ES DEFAULT PARA CATÁLOGO */
					//$this->db->where(array('pedido.Tienda_idTienda'=>$tienda['idTienda'],'tipocliente.idTipoCliente'=>3,'pedido.Estado_idEstado <'=>3));
					/*$this->db->where(array('pedido.Tienda_idTienda'=>$tienda['idTienda'],'tipocliente.idTipoCliente'=>3,'pedido.Estado_idEstado <'=>3));
					$this->db->order_by('idPedido','desc');
					$this->db->select('idPedido,cliente.nombre,cliente.apellido,pedido.fecha_pedido,estado.nombre as estado');
					$this->db->from('pedido');
					$this->db->join('cliente', 'cliente.idCliente = pedido.Cliente_idCliente');
					$this->db->join('tipocliente', 'cliente.TipoCliente_idTipoCliente = tipocliente.idTipoCliente');
					$this->db->join('estado', 'estado.idEstado = pedido.Estado_idEstado');
					$data['consulta'] = $this->db->get();*/

					$this->load->model('admin/paginator_model');
					$pages=10; //Numero de registros mostrados por páginas
					$this->load->library('pagination'); //Cargamos la librería de paginación
					$config['base_url'] = base_url().'pedido/recibido/'.$seccion; // parametro base de la aplicación, si tenemos un .htaccess nos evitamos el index.php
					$config['total_rows'] = $this->paginator_model->totalPedidos($data['seccion'],$tienda['idTienda']) ;    
					$config['per_page'] = $pages; 
					$config['num_links'] = 5; //Numero de links mostrados en la paginación
					$config["uri_segment"] = 5; //Para que los links en la paginación sean los correctos.
					$config['first_link'] = 'Inicio';
					$config['last_link'] = 'Final';

					$this->pagination->initialize($config); 
			 	
					$data["consulta"] = $this->paginator_model->getPedidoPaginated($data['seccion'],$tienda['idTienda'],$config['per_page'],$this->uri->segment(5));
					
                                        //print_r($data['consulta']);
					$this->load->view('admin/altas_consultas',$data);
				break;
				}
			break;
			case 'representante':
				switch($rol){
				default:
					show_404();
				break;
				case 'ADMINISTRADOR':
				case 'PEDIDOS_REPRESENTANTE_VENTAS':
				case 'PEDIDOS_REPRESENTANTE_EMBARQUES':
					$data['seccion'] = 'consulta_representante_recibido';
					$data['rol'] = $rol;
					/* NOTA EL TIPO CLIENTE 3 ES DEFAULT PARA CATÁLOGO */
					/*$this->db->where(array('pedido.Tienda_idTienda'=>$tienda['idTienda'],'tipocliente.idTipoCliente !='=>3,'pedido.Estado_idEstado <'=>3));
					//$this->db->or_where(array('pedido.Estado_idEstado'=>1,'pedido.Estado_idEstado'=>2));
					$this->db->order_by('idPedido','desc');
					$this->db->select('idPedido,cliente.nombre,cliente.apellido,pedido.fecha_pedido,estado.nombre as estado');
					$this->db->from('pedido');
					$this->db->join('cliente', 'cliente.idCliente = pedido.Cliente_idCliente');
					$this->db->join('tipocliente', 'cliente.TipoCliente_idTipoCliente = tipocliente.idTipoCliente');
					$this->db->join('estado', 'estado.idEstado = pedido.Estado_idEstado');
					$data['consulta'] = $this->db->get();*/

					$this->load->model('admin/paginator_model');
					$pages=10; //Numero de registros mostrados por páginas
					$this->load->library('pagination'); //Cargamos la librería de paginación
					$config['base_url'] = base_url().'pedido/recibido/'.$seccion; // parametro base de la aplicación, si tenemos un .htaccess nos evitamos el index.php
					$config['total_rows'] = $this->paginator_model->totalPedidos($data['seccion'],$tienda['idTienda']) ;    
					$config['per_page'] = $pages; 
					$config['num_links'] = 5; //Numero de links mostrados en la paginación
					$config["uri_segment"] = 4; //Para que los links en la paginación sean los correctos.
					$config['first_link'] = 'Inicio';
					$config['last_link'] = 'Final';

					$this->pagination->initialize($config); 
			 	
					$data["consulta"] = $this->paginator_model->getPedidoPaginated($data['seccion'],$tienda['idTienda'],$config['per_page'],$this->uri->segment(4));
					$this->load->view('admin/altas_consultas',$data);
				break;
				}
			break;
			case 'ver':
				switch($rol){
				default:
					show_404();
				break;
				case 'ADMINISTRADOR':
				case 'PEDIDOS_CATALOGO':
				case 'PEDIDOS_REPRESENTANTE_VENTAS':
				case 'PEDIDOS_REPRESENTANTE_EMBARQUES':
					$data['seccion'] = 'dos_ver_pedido';
					$data['rol'] = $rol;

					$campos = "idPedido,
								cliente.nombre,
								cliente.apellido,
								cliente.idCliente,
								empresa.telefono as cliente_telefono,
								pedido.fecha_pedido,
								estado.nombre as estado,
								tipocliente.nombre as tipo_cliente,
								tipocliente.promocion,
								tipocliente.abreviatura,
								factura.razon_social,
								factura.rfc,
								dir_fact.calle as calle_fact,
								dir_fact.numero_exterior as exterior_fact,
								dir_fact.numero_interior as interior_fact,
								dir_fact.colonia as colonia_fact,
								dir_fact.delegacion as del_fact,
								dir_fact.codigo_postal as postal_fact,
								dir_fact.ciudad as ciudad_fact,
								dir_fact.estado as estado_fact,
								dir_fact.pais as pais_fact,
								general.nombre as nombre_gen,
								general.correo as correo_gen,
								dir_gen.calle as calle_gen,
								dir_gen.numero_exterior as exterior_gen,
								dir_gen.numero_interior as interior_gen,
								dir_gen.colonia as colonia_gen,
								dir_gen.delegacion as del_gen,
								dir_gen.codigo_postal as postal_gen,
								dir_gen.ciudad as ciudad_gen,
								dir_gen.estado as estado_gen,
								dir_gen.pais as pais_gen,
								envio.persona_recibe,
								dir_env.calle as calle_env,
								dir_env.numero_exterior as exterior_env,
								dir_env.numero_interior as interior_env,
								dir_env.colonia as colonia_env,
								dir_env.delegacion as del_env,
								dir_env.codigo_postal as postal_env,
								dir_env.ciudad as ciudad_env,
								dir_env.estado as estado_env,
								dir_env.pais as pais_env";
					
					$this->db->where(array('pedido.Tienda_idTienda'=>$tienda['idTienda'],'pedido.idPedido'=>$cliente_url));
					$this->db->order_by('idPedido','desc');
					$this->db->select($campos);
					$this->db->from('pedido');
					$this->db->join('cliente', 'cliente.idCliente = pedido.Cliente_idCliente');
					$this->db->join('empresa', 'empresa.idEmpresa = cliente.Empresa_idEmpresa');
					$this->db->join('tipocliente', 'cliente.TipoCliente_idTipoCliente = tipocliente.idTipoCliente');
					$this->db->join('estado', 'estado.idEstado = pedido.Estado_idEstado');
					$this->db->join('factura', 'factura.idFactura = pedido.Factura_idFactura');
					$this->db->join('direccion as dir_fact', 'dir_fact.idDireccion = factura.Direccion_idDireccion');
					$this->db->join('general', 'general.idGeneral = pedido.General_idGeneral');
					$this->db->join('direccion as dir_gen', 'dir_gen.idDireccion = general.Direccion_idDireccion');
					$this->db->join('envio', 'envio.idEnvio = pedido.Envio_idEnvio');
					$this->db->join('direccion as dir_env', 'dir_env.idDireccion = envio.Direccion_idDireccion');
					$data['consultaUno'] = $this->db->get();


					$this->db->where(array('contenidopedido.Pedido_idPedido' => $cliente_url));
					$this->db->order_by('idContenidoPedido','asc');
					$this->db->select('*');
					$this->db->from('contenidopedido');
					$this->db->join('presentacion', 'presentacion.idPresentacion = contenidopedido.Presentacion_idPresentacion');
					$this->db->join('producto', 'presentacion.Producto_idProducto = producto.idProducto');
					$data['consultaDos'] = $this->db->get();
					
					$this->load->model('admin/pedido_model','pedido');
					$data['consultaTres'] = $this->pedido->getnosurtidos($cliente_url);

					//print_r($data['consultaTres']);
					$this->load->view('admin/altas_consultas',$data);
				break;
				}
			break;
			case 'estado':
				switch($rol){
				default:
					show_404();
				break;
				case 'ADMINISTRADOR':
				case 'PEDIDOS_CATALOGO':
				case 'PEDIDOS_REPRESENTANTE_VENTAS':
				case 'PEDIDOS_REPRESENTANTE_EMBARQUES':
					$data['seccion'] = 'editar_estado';
					$data['rol'] = $rol;
					/* NOTA EL TIPO CLIENTE 3 ES DEFAULT PARA CATÁLOGO */
					$this->db->where(array('pedido.Tienda_idTienda'=>$tienda['idTienda'],'reporte.Pedido_idPedido' => $cliente_url));
					$this->db->order_by('idReporte','asc');
					$this->db->select('*');
					$this->db->from('reporte');
					$this->db->join('pedido', 'pedido.idPedido = reporte.Pedido_idPedido');
					$this->db->join('estado', 'reporte.Estado_idEstado = estado.idEstado');
					$data['consulta'] = $this->db->get();

					$this->db->where(array('idPedido' => $cliente_url));
					$this->db->select('*');
					$this->db->from('pedido');
					$this->db->join('estado', 'pedido.Estado_idEstado = estado.idEstado');
					$data['consultaDos'] = $this->db->get();

					$data['consultaTres'] = $this->db->query("SELECT SUM( precio * cantidad ) AS total FROM `contenidopedido` WHERE Pedido_idPedido =$cliente_url");

					$rules = reglasInsertar('editar_reporte');
					$this->form_validation->set_rules($rules); 
					
					if($this->form_validation->run() == FALSE){
						
						$this->load->view('admin/seguimiento_pedido',$data);
					
					}else{

						$idTienda = $tienda['idTienda'];
						$reporte = datosInsertar('editar_reporte',$idTienda);
						$insert = $this->db->insert('reporte',$reporte);
						

						$id = array('Estado_idEstado' => $_POST['idestado'] + 1);

						$this->db->where('idPedido', $cliente_url);
						$update = $this->db->update('pedido',$id);

						if($update){
					
							$this->phpsession->flashsave('update_message', "El reporte se ha actualizado con éxito.");
							$id_temp =  $_POST['idestado'] + 1;
							if($id_temp < 3){
								redirect("admin/pedido/recibido/estado/$cliente_url");
							}elseif(($id_temp > 2) && ($id_temp < 9) ){
								redirect("admin/pedido/proceso/estado/$cliente_url");
							}else{
								redirect("admin/pedido/surtido/estado/$cliente_url");
							}
							
						}else{
							$this->phpsession->flashsave('update_message', 'Error #2420: No se pudo actualizar el reporte; por favor contacte a su administrador.');
							redirect("admin/pedido/recibido/estado/$cliente_url");
						}

					}
				break;
				}
			break;
			default:
				show_404();
			break;
		}
	}

	public function todos($seccion = 'todos',$cliente_url='none'){

		// Debería llamarse sólo cuando lo necesita pero no tengo tiempo para checar ese detalle
		$this->load->model('admin/surtidor_model','surtidor');
		$data['surtidores'] = $this->surtidor->getallsurtidores();

		// fin instrucción puerca

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
		
		switch($seccion){
			
			case 'observacion':
				if($cliente_url == 'none'){
					show_404();
				}else{
					if(!empty($_POST['observacion'])){
						$nueva = $_POST['original'].'<br /><b style="font-size:9px;">'.date('d/m/Y H:i:s').'</b><br/>'.$_POST['observacion'];

						$this->db->where(array('idReporte'=>$cliente_url));
						$this->db->set('observaciones', $nueva);
						$this->db->update('reporte');
						redirect($_SERVER["HTTP_REFERER"]); 
					}else{
						redirect($_SERVER["HTTP_REFERER"]); 
					}
				}
			break;
			
			case 'hola':
				echo 'hola mundo!';
			break;
			case 'todos':
				switch($rol){
				default:
					show_404();
				break;
				case 'ADMINISTRADOR':
				case 'PEDIDOS_CATALOGO':
					$data['seccion'] = 'consulta_todos';
					$data['rol'] = $rol;
					/* NOTA EL TIPO CLIENTE 3 ES DEFAULT PARA CATÁLOGO */
					//$this->db->where(array('pedido.Tienda_idTienda'=>$tienda['idTienda'],'tipocliente.idTipoCliente'=>3,'pedido.Estado_idEstado <'=>3));
					/*$this->db->where(array('pedido.Tienda_idTienda'=>$tienda['idTienda'],'tipocliente.idTipoCliente'=>3,'pedido.Estado_idEstado <'=>3));
					$this->db->order_by('idPedido','desc');
					$this->db->select('idPedido,cliente.nombre,cliente.apellido,pedido.fecha_pedido,estado.nombre as estado');
					$this->db->from('pedido');
					$this->db->join('cliente', 'cliente.idCliente = pedido.Cliente_idCliente');
					$this->db->join('tipocliente', 'cliente.TipoCliente_idTipoCliente = tipocliente.idTipoCliente');
					$this->db->join('estado', 'estado.idEstado = pedido.Estado_idEstado');
					$data['consulta'] = $this->db->get();*/

					$this->load->model('admin/paginator_model');
					$pages=10; //Numero de registros mostrados por páginas
					$this->load->library('pagination'); //Cargamos la librería de paginación
					$config['base_url'] = base_url().'pedido/todos/todos/'; // parametro base de la aplicación, si tenemos un .htaccess nos evitamos el index.php
					$config['total_rows'] = $this->paginator_model->totalPedidos($data['seccion'],$tienda['idTienda']) ;    
					$config['per_page'] = $pages; 
					$config['num_links'] = 5; //Numero de links mostrados en la paginación
					$config["uri_segment"] = 4; //Para que los links en la paginación sean los correctos.
					$config['first_link'] = 'Inicio';
					$config['last_link'] = 'Final';

					$this->pagination->initialize($config); 
			 	
					$data["consulta"] = $this->paginator_model->getPedidoPaginated($data['seccion'],$tienda['idTienda'],$config['per_page'],$this->uri->segment(4));
					
					$this->load->view('admin/altas_consultas',$data);
				break;
				}
			break;
			case 'ver':
				redirect('admin/pedido/recibido/ver/'.$cliente_url);
			break;
			case 'estado':
				switch($rol){
				default:
					show_404();
				break;
				case 'ADMINISTRADOR':
				case 'PEDIDOS_CATALOGO':
				case 'PEDIDOS_REPRESENTANTE_VENTAS':
				case 'PEDIDOS_REPRESENTANTE_EMBARQUES':
					$data['seccion'] = 'editar_estado';
					$data['rol'] = $rol;
					/* NOTA EL TIPO CLIENTE 3 ES DEFAULT PARA CATÁLOGO */
					$this->db->where(array('pedido.Tienda_idTienda'=>$tienda['idTienda'],'reporte.Pedido_idPedido' => $cliente_url));
					$this->db->order_by('idReporte','asc');
					$this->db->select('*');
					$this->db->from('reporte');
					$this->db->join('pedido', 'pedido.idPedido = reporte.Pedido_idPedido');
					$this->db->join('estado', 'reporte.Estado_idEstado = estado.idEstado');
					$data['consulta'] = $this->db->get();

					$this->db->where(array('idPedido' => $cliente_url));
					$this->db->select('*');
					$this->db->from('pedido');
					$this->db->join('estado', 'pedido.Estado_idEstado = estado.idEstado');
					$data['consultaDos'] = $this->db->get();

					$data['consultaTres'] = $this->db->query("SELECT SUM( precio * cantidad ) AS total FROM `contenidopedido` WHERE Pedido_idPedido =$cliente_url");

					$rules = reglasInsertar('editar_reporte');
					$this->form_validation->set_rules($rules); 
					
					if($this->form_validation->run() == FALSE){
						
						$this->load->view('admin/seguimiento_pedido',$data);
					
					}else{

						$idTienda = $tienda['idTienda'];
						$reporte = datosInsertar('editar_reporte',$idTienda);
						$insert = $this->db->insert('reporte',$reporte);
						

						$id = array('Estado_idEstado' => $_POST['idestado'] + 1);

						$this->db->where('idPedido', $cliente_url);
						$update = $this->db->update('pedido',$id);

						if($update){
					
							$this->phpsession->flashsave('update_message', "El reporte se ha actualizado con éxito.");
							$id_temp =  $_POST['idestado'] + 1;
							if($id_temp < 3){
								redirect("admin/pedido/recibido/estado/$cliente_url");
							}elseif(($id_temp > 2) && ($id_temp < 9) ){
								redirect("admin/pedido/proceso/estado/$cliente_url");
							}else{
								redirect("admin/pedido/surtido/estado/$cliente_url");
							}
							
						}else{
							$this->phpsession->flashsave('update_message', 'Error #2420: No se pudo actualizar el reporte; por favor contacte a su administrador.');
							redirect("admin/pedido/recibido/estado/$cliente_url");
						}

					}
				break;
				}
			break;
			default:
				show_404();
			break;
		}
	}

	public function proceso($seccion = 'pedido_proceso',$cliente_url='none'){

		// Debería llamarse sólo cuando lo necesita pero no tengo tiempo para checar ese detalle
		$this->load->model('admin/surtidor_model','surtidor');
		$data['surtidores'] = $this->surtidor->getallsurtidores();

		// fin instrucción puerca

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
		
		switch($seccion){
			case 'pedido_proceso':
				switch($rol){
				default:
					show_404();
				break;
				case 'ADMINISTRADOR':
				case 'PEDIDOS_CATALOGO':
				case 'PEDIDOS_REPRESENTANTE_VENTAS':
				case 'PEDIDOS_REPRESENTANTE_EMBARQUES':
					$data['seccion'] = $seccion;
					$data['rol'] = $rol;
					$this->load->view('admin/altas_consultas',$data);
				break;
				}
			break;
			case 'catalogo':
				switch($rol){
				default:
					show_404();
				break;
				case 'ADMINISTRADOR':
				case 'PEDIDOS_CATALOGO':
					$data['seccion'] = 'consulta_catalogo_proceso';
					$data['rol'] = $rol;
					/* NOTA EL TIPO CLIENTE 3 ES DEFAULT PARA CATÁLOGO */
					$this->db->where(array('pedido.Tienda_idTienda'=>$tienda['idTienda'],'tipocliente.idTipoCliente'=>3,'pedido.Estado_idEstado >'=>2,'pedido.Estado_idEstado <'=>9));
					$this->db->order_by('idPedido','desc');
					$this->db->select('idPedido,cliente.nombre,cliente.apellido,pedido.fecha_pedido,estado.nombre as estado');
					$this->db->from('pedido');
					$this->db->join('cliente', 'cliente.idCliente = pedido.Cliente_idCliente');
					$this->db->join('tipocliente', 'cliente.TipoCliente_idTipoCliente = tipocliente.idTipoCliente');
					$this->db->join('estado', 'estado.idEstado = pedido.Estado_idEstado');
					$data['consulta'] = $this->db->get();
					$this->load->view('admin/altas_consultas',$data);
				break;
				}
			break;
			case 'representante':
				switch($rol){
				default:
					show_404();
				break;
				case 'ADMINISTRADOR':
				case 'PEDIDOS_REPRESENTANTE_VENTAS':
				case 'PEDIDOS_REPRESENTANTE_EMBARQUES':
					$data['seccion'] = 'consulta_representante_proceso';
					$data['rol'] = $rol;
					/* NOTA EL TIPO CLIENTE 3 ES DEFAULT PARA CATÁLOGO */
					$this->db->where(array('pedido.Tienda_idTienda'=>$tienda['idTienda'],'tipocliente.idTipoCliente !='=>3,'pedido.Estado_idEstado >'=>2));
					$this->db->where('pedido.Estado_idEstado <',9);
					$this->db->order_by('idPedido','desc');
					$this->db->select('idPedido,cliente.nombre,cliente.apellido,pedido.fecha_pedido,estado.nombre as estado');
					$this->db->from('pedido');
					$this->db->join('cliente', 'cliente.idCliente = pedido.Cliente_idCliente');
					$this->db->join('tipocliente', 'cliente.TipoCliente_idTipoCliente = tipocliente.idTipoCliente');
					$this->db->join('estado', 'estado.idEstado = pedido.Estado_idEstado');
					$data['consulta'] = $this->db->get();
					$this->load->view('admin/altas_consultas',$data);
				break;
				}
			break;
			case 'ver':
				redirect('admin/pedido/recibido/ver/'.$cliente_url);
			break;
			case 'estado':
				switch($rol){
				default:
					show_404();
				break;
				case 'ADMINISTRADOR':
				case 'PEDIDOS_CATALOGO':
				case 'PEDIDOS_REPRESENTANTE_VENTAS':
				case 'PEDIDOS_REPRESENTANTE_EMBARQUES':
					$data['seccion'] = 'editar_estado';
					$data['rol'] = $rol;
					/* NOTA EL TIPO CLIENTE 3 ES DEFAULT PARA CATÁLOGO */
					$this->db->where(array('pedido.Tienda_idTienda'=>$tienda['idTienda'],'reporte.Pedido_idPedido' => $cliente_url));
					$this->db->order_by('idReporte','asc');
					$this->db->select('*');
					$this->db->from('reporte');
					$this->db->join('pedido', 'pedido.idPedido = reporte.Pedido_idPedido');
					$this->db->join('estado', 'reporte.Estado_idEstado = estado.idEstado');
					$data['consulta'] = $this->db->get();

					$this->db->where(array('idPedido' => $cliente_url));
					$this->db->select('*');
					$this->db->from('pedido');
					$this->db->join('estado', 'pedido.Estado_idEstado = estado.idEstado');
					$data['consultaDos'] = $this->db->get();

					$data['consultaTres'] = $this->db->query("SELECT SUM( precio * cantidad ) AS total FROM `contenidopedido` WHERE Pedido_idPedido =$cliente_url");

					$rules = reglasInsertar('editar_reporte');
					$this->form_validation->set_rules($rules); 
					
					if($this->form_validation->run() == FALSE){
						
						$this->load->view('admin/seguimiento_pedido',$data);
					
					}else{

						$idTienda = $tienda['idTienda'];
						$reporte = datosInsertar('editar_reporte',$idTienda);
						$insert = $this->db->insert('reporte',$reporte);
						

						$id = array('Estado_idEstado' => $_POST['idestado'] + 1);

						$this->db->where('idPedido', $cliente_url);
						$update = $this->db->update('pedido',$id);

						if($update){
					
							$this->phpsession->flashsave('update_message', "El reporte se ha actualizado con éxito.");
							$id_temp =  $_POST['idestado'] + 1;
							if($id_temp < 3){
								redirect("admin/pedido/recibido/estado/$cliente_url");
							}elseif(($id_temp > 2) && ($id_temp < 9) ){
								redirect("admin/pedido/proceso/estado/$cliente_url");
							}else{
								redirect("admin/pedido/surtido/estado/$cliente_url");
							}
							
						}else{
							$this->phpsession->flashsave('update_message', 'Error #2420: No se pudo actualizar el reporte; por favor contacte a su administrador.');
							redirect("admin/pedido/recibido/estado/$cliente_url");
						}

					}
				break;
				}
			break;
			default:
				show_404();
			break;
		}
	}

	public function surtido($seccion = 'pedido_surtido',$cliente_url='none'){

		// Debería llamarse sólo cuando lo necesita pero no tengo tiempo para checar ese detalle
		$this->load->model('admin/surtidor_model','surtidor');
		$data['surtidores'] = $this->surtidor->getallsurtidores();

		// fin instrucción puerca

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
		
		switch($seccion){
			case 'pedido_surtido':
				switch($rol){
				default:
					show_404();
				break;
				case 'ADMINISTRADOR':
				case 'PEDIDOS_CATALOGO':
				case 'PEDIDOS_REPRESENTANTE_VENTAS':
				case 'PEDIDOS_REPRESENTANTE_EMBARQUES':
					$data['seccion'] = $seccion;
					$data['rol'] = $rol;
					$this->load->view('admin/altas_consultas',$data);
				break;
				}
			break;
			case 'catalogo':
				switch($rol){
				default:
					show_404();
				break;
				case 'ADMINISTRADOR':
				case 'PEDIDOS_CATALOGO':
					$data['seccion'] = 'consulta_catalogo_surtido';
					$data['rol'] = $rol;
					/* NOTA EL TIPO CLIENTE 3 ES DEFAULT PARA CATÁLOGO */
					$this->db->where(array('pedido.Tienda_idTienda'=>$tienda['idTienda'],'tipocliente.idTipoCliente'=>3,'pedido.Estado_idEstado'=>9));
					$this->db->order_by('idPedido','desc');
					$this->db->select('idPedido,cliente.nombre,cliente.apellido,pedido.fecha_pedido,estado.nombre as estado');
					$this->db->from('pedido');
					$this->db->join('cliente', 'cliente.idCliente = pedido.Cliente_idCliente');
					$this->db->join('tipocliente', 'cliente.TipoCliente_idTipoCliente = tipocliente.idTipoCliente');
					$this->db->join('estado', 'estado.idEstado = pedido.Estado_idEstado');
					$data['consulta'] = $this->db->get();
					$this->load->view('admin/altas_consultas',$data);
				break;
				}
			break;
			case 'representante':
				switch($rol){
				default:
					show_404();
				break;
				case 'ADMINISTRADOR':
				case 'PEDIDOS_REPRESENTANTE_VENTAS':
				case 'PEDIDOS_REPRESENTANTE_EMBARQUES':
					$data['seccion'] = 'consulta_representante_surtido';
					$data['rol'] = $rol;
					/* NOTA EL TIPO CLIENTE 3 ES DEFAULT PARA CATÁLOGO */
					$this->db->where(array('pedido.Tienda_idTienda'=>$tienda['idTienda'],'tipocliente.idTipoCliente !='=>3,'pedido.Estado_idEstado'=>9));
					//$this->db->or_where(array('pedido.Estado_idEstado'=>1,'pedido.Estado_idEstado'=>2));
					$this->db->order_by('idPedido','desc');
					$this->db->select('idPedido,cliente.nombre,cliente.apellido,pedido.fecha_pedido,estado.nombre as estado');
					$this->db->from('pedido');
					$this->db->join('cliente', 'cliente.idCliente = pedido.Cliente_idCliente');
					$this->db->join('tipocliente', 'cliente.TipoCliente_idTipoCliente = tipocliente.idTipoCliente');
					$this->db->join('estado', 'estado.idEstado = pedido.Estado_idEstado');
					$data['consulta'] = $this->db->get();
					$this->load->view('admin/altas_consultas',$data);
				break;
				}
			break;
			case 'ver':
				redirect('admin/pedido/recibido/ver/'.$cliente_url);
			break;
			case 'estado':
				switch($rol){
				default:
					show_404();
				break;
				case 'ADMINISTRADOR':
				case 'PEDIDOS_CATALOGO':
				case 'PEDIDOS_REPRESENTANTE_VENTAS':
				case 'PEDIDOS_REPRESENTANTE_EMBARQUES':
					$data['seccion'] = 'editar_estado';
					$data['rol'] = $rol;
					/* NOTA EL TIPO CLIENTE 3 ES DEFAULT PARA CATÁLOGO */
					$this->db->where(array('pedido.Tienda_idTienda'=>$tienda['idTienda'],'reporte.Pedido_idPedido' => $cliente_url));
					$this->db->order_by('idReporte','asc');
					$this->db->select('*');
					$this->db->from('reporte');
					$this->db->join('pedido', 'pedido.idPedido = reporte.Pedido_idPedido');
					$this->db->join('estado', 'reporte.Estado_idEstado = estado.idEstado');
					$data['consulta'] = $this->db->get();

					$this->db->where(array('idPedido' => $cliente_url));
					$this->db->select('*');
					$this->db->from('pedido');
					$this->db->join('estado', 'pedido.Estado_idEstado = estado.idEstado');
					$data['consultaDos'] = $this->db->get();

					$data['consultaTres'] = $this->db->query("SELECT SUM( precio * cantidad ) AS total FROM `contenidopedido` WHERE Pedido_idPedido =$cliente_url");

					$rules = reglasInsertar('editar_reporte');
					$this->form_validation->set_rules($rules); 
					
					if($this->form_validation->run() == FALSE){
						
						$this->load->view('admin/seguimiento_pedido',$data);
					
					}else{

						$idTienda = $tienda['idTienda'];
						$reporte = datosInsertar('editar_reporte',$idTienda);
						$insert = $this->db->insert('reporte',$reporte);
						

						$id = array('Estado_idEstado' => $_POST['idestado'] + 1);

						$this->db->where('idPedido', $cliente_url);
						$update = $this->db->update('pedido',$id);

						if($update){
					
							$this->phpsession->flashsave('update_message', "El reporte se ha actualizado con éxito.");
							$id_temp =  $_POST['idestado'] + 1;
							if($id_temp < 3){
								redirect("admin/pedido/recibido/estado/$cliente_url");
							}elseif(($id_temp > 2) && ($id_temp < 9) ){
								redirect("admin/pedido/proceso/estado/$cliente_url");
							}else{
								redirect("admin/pedido/surtido/estado/$cliente_url");
							}
							
						}else{
							$this->phpsession->flashsave('update_message', 'Error #2420: No se pudo actualizar el reporte; por favor contacte a su administrador.');
							redirect("admin/pedido/recibido/estado/$cliente_url");
						}

					}
				break;
				}
			break;
			default:
				show_404();
			break;
		}
	}

	public function antiguo($seccion = 'pedido_antiguo',$cliente_url='none'){

		// Debería llamarse sólo cuando lo necesita pero no tengo tiempo para checar ese detalle
		$this->load->model('admin/surtidor_model','surtidor');
		$data['surtidores'] = $this->surtidor->getallsurtidores();

		// fin instrucción puerca

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
		
		switch($seccion){
			
			case 'pedido_antiguo':
				switch($rol){
				default:
					show_404();
				break;
				case 'ADMINISTRADOR':
					$data['seccion'] = 'consulta_antiguo';
					$data['rol'] = $rol;
					/* NOTA EL TIPO CLIENTE 3 ES DEFAULT PARA CATÁLOGO */
					$this->db->order_by('idPedido','desc');
					$this->db->select('pedido_historia.id as idPedido,cliente.nombre,cliente.apellido,pedido_historia.fecha as fecha_pedido');
					$this->db->from('pedido_historia');
					$this->db->join('cliente', 'cliente.idCliente = pedido_historia.id_usuario');
					$this->db->join('tipocliente', 'cliente.TipoCliente_idTipoCliente = tipocliente.idTipoCliente');
					$data['consulta'] = $this->db->get();
					$this->load->view('admin/altas_consultas',$data);
				break;
				}
			break;
			
			case 'ver':
				switch($rol){
				default:
					show_404();
				break;
				case 'ADMINISTRADOR':
					$data['seccion'] = 'dos_ver_pedido';
					$data['rol'] = $rol;

					$campos = "pedido_historia.id as idPedido,
								cliente.nombre,
								cliente.apellido,
								pedido_historia.fecha as fecha_pedido,
								tipocliente.nombre as tipo_cliente,
								tipocliente.promocion,
								pedido_historia.razon_social,
								pedido_historia.rfc,
								cliente.nombre as nombre_gen,
								empresa.correo as correo_gen,
								dir_gen.calle as calle_gen,
								dir_gen.numero_exterior as exterior_gen,
								dir_gen.numero_interior as interior_gen,
								dir_gen.colonia as colonia_gen,
								dir_gen.delegacion as del_gen,
								dir_gen.codigo_postal as postal_gen,
								dir_gen.ciudad as ciudad_gen,
								dir_gen.estado as estado_gen,
								dir_gen.pais as pais_gen,
								";
					
					$this->db->where(array('pedido_historia.id'=>$cliente_url));
					$this->db->order_by('idPedido','desc');
					$this->db->select($campos);
					$this->db->from('pedido_historia');
					$this->db->join('cliente', 'cliente.idCliente = pedido_historia.id_usuario');
					$this->db->join('tipocliente', 'cliente.TipoCliente_idTipoCliente = tipocliente.idTipoCliente');
					$this->db->join('empresa', 'cliente.Empresa_idEmpresa = empresa.idEmpresa');
					$this->db->join('direccion as dir_gen', 'empresa.Direccion_idDireccion = dir_gen.idDireccion');
					$data['consultaUno'] = $this->db->get();


					$this->db->where(array('contenidopedido.Pedido_idPedido' => $cliente_url));
					$this->db->order_by('idContenidoPedido','asc');
					$this->db->select('*');
					$this->db->from('contenidopedido');
					$this->db->join('presentacion', 'presentacion.idPresentacion = contenidopedido.Presentacion_idPresentacion');
					$this->db->join('producto', 'presentacion.Producto_idProducto = producto.idProducto');
					$data['consultaDos'] = $this->db->get();
					
					$data['consultaTres'] = "none";
					$this->load->view('admin/altas_consultas',$data);
				break;
				}
			break;
			case 'estado':
				switch($rol){
				default:
					show_404();
				break;
				case 'ADMINISTRADOR':
				case 'PEDIDOS_CATALOGO':
				case 'PEDIDOS_REPRESENTANTE_VENTAS':
				case 'PEDIDOS_REPRESENTANTE_EMBARQUES':
					$data['seccion'] = 'editar_estado';
					$data['rol'] = $rol;
					/* NOTA EL TIPO CLIENTE 3 ES DEFAULT PARA CATÁLOGO */
					$this->db->where(array('pedido.Tienda_idTienda'=>$tienda['idTienda'],'reporte.Pedido_idPedido' => $cliente_url));
					$this->db->order_by('idReporte','asc');
					$this->db->select('*');
					$this->db->from('reporte');
					$this->db->join('pedido', 'pedido.idPedido = reporte.Pedido_idPedido');
					$this->db->join('estado', 'reporte.Estado_idEstado = estado.idEstado');
					$data['consulta'] = $this->db->get();

					$this->db->where(array('idPedido' => $cliente_url));
					$this->db->select('*');
					$this->db->from('pedido');
					$this->db->join('estado', 'pedido.Estado_idEstado = estado.idEstado');
					$data['consultaDos'] = $this->db->get();

					$data['consultaTres'] = $this->db->query("SELECT SUM( precio * cantidad ) AS total FROM `contenidopedido` WHERE Pedido_idPedido =$cliente_url");

					$rules = reglasInsertar('editar_reporte');
					$this->form_validation->set_rules($rules); 
					
					if($this->form_validation->run() == FALSE){
						
						$this->load->view('admin/seguimiento_pedido',$data);
					
					}else{

						$idTienda = $tienda['idTienda'];
						$reporte = datosInsertar('editar_reporte',$idTienda);
						$insert = $this->db->insert('reporte',$reporte);
						

						$id = array('Estado_idEstado' => $_POST['idestado'] + 1);

						$this->db->where('idPedido', $cliente_url);
						$update = $this->db->update('pedido',$id);

						if($update){
					
							$this->phpsession->flashsave('update_message', "El reporte se ha actualizado con éxito.");
							$id_temp =  $_POST['idestado'] + 1;
							if($id_temp < 3){
								redirect("admin/pedido/recibido/estado/$cliente_url");
							}elseif(($id_temp > 2) && ($id_temp < 9) ){
								redirect("admin/pedido/proceso/estado/$cliente_url");
							}else{
								redirect("admin/pedido/surtido/estado/$cliente_url");
							}
							
						}else{
							$this->phpsession->flashsave('update_message', 'Error #2420: No se pudo actualizar el reporte; por favor contacte a su administrador.');
							redirect("admin/pedido/recibido/estado/$cliente_url");
						}

					}
				break;
				}
			break;
			default:
				show_404();
			break;
		}
	}

	public function excel($cliente_url = 0){
		
		$seccion = 'dos_ver_pedido';
		$rol = 'ADMINISTRADOR';
		$tienda_cookie = $_SESSION['userdata']['tienda'];
		$consulta_tienda = $this->db->get_where('tienda',array('idTienda' => $tienda_cookie));
		$tienda = datosTienda($consulta_tienda);

					$campos = "idPedido,
								cliente.nombre,
								cliente.apellido,
								cliente.idCliente,
								empresa.telefono as cliente_telefono,
								pedido.fecha_pedido,
								estado.nombre as estado,
								tipocliente.nombre as tipo_cliente,
								tipocliente.promocion,
								tipocliente.abreviatura,
								factura.razon_social,
								factura.rfc,
								dir_fact.calle as calle_fact,
								dir_fact.numero_exterior as exterior_fact,
								dir_fact.numero_interior as interior_fact,
								dir_fact.colonia as colonia_fact,
								dir_fact.delegacion as del_fact,
								dir_fact.codigo_postal as postal_fact,
								dir_fact.ciudad as ciudad_fact,
								dir_fact.estado as estado_fact,
								dir_fact.pais as pais_fact,
								general.nombre as nombre_gen,
								general.correo as correo_gen,
								dir_gen.calle as calle_gen,
								dir_gen.numero_exterior as exterior_gen,
								dir_gen.numero_interior as interior_gen,
								dir_gen.colonia as colonia_gen,
								dir_gen.delegacion as del_gen,
								dir_gen.codigo_postal as postal_gen,
								dir_gen.ciudad as ciudad_gen,
								dir_gen.estado as estado_gen,
								dir_gen.pais as pais_gen,
								envio.persona_recibe,
								dir_env.calle as calle_env,
								dir_env.numero_exterior as exterior_env,
								dir_env.numero_interior as interior_env,
								dir_env.colonia as colonia_env,
								dir_env.delegacion as del_env,
								dir_env.codigo_postal as postal_env,
								dir_env.ciudad as ciudad_env,
								dir_env.estado as estado_env,
								dir_env.pais as pais_env";
					
					$this->db->where(array('pedido.Tienda_idTienda'=>$tienda['idTienda'],'pedido.idPedido'=>$cliente_url));
					$this->db->order_by('idPedido','desc');
					$this->db->select($campos);
					$this->db->from('pedido');
					$this->db->join('cliente', 'cliente.idCliente = pedido.Cliente_idCliente');
					$this->db->join('empresa', 'empresa.idEmpresa = cliente.Empresa_idEmpresa');
					$this->db->join('tipocliente', 'cliente.TipoCliente_idTipoCliente = tipocliente.idTipoCliente');
					$this->db->join('estado', 'estado.idEstado = pedido.Estado_idEstado');
					$this->db->join('factura', 'factura.idFactura = pedido.Factura_idFactura');
					$this->db->join('direccion as dir_fact', 'dir_fact.idDireccion = factura.Direccion_idDireccion');
					$this->db->join('general', 'general.idGeneral = pedido.General_idGeneral');
					$this->db->join('direccion as dir_gen', 'dir_gen.idDireccion = general.Direccion_idDireccion');
					$this->db->join('envio', 'envio.idEnvio = pedido.Envio_idEnvio');
					$this->db->join('direccion as dir_env', 'dir_env.idDireccion = envio.Direccion_idDireccion');
					$consultaUno = $this->db->get();


					$this->db->where(array('contenidopedido.Pedido_idPedido' => $cliente_url));
					$this->db->order_by('idContenidoPedido','asc');
					$this->db->select('*');
					$this->db->from('contenidopedido');
					$this->db->join('presentacion', 'presentacion.idPresentacion = contenidopedido.Presentacion_idPresentacion');
					$this->db->join('producto', 'presentacion.Producto_idProducto = producto.idProducto');
					$consultaDos = $this->db->get();
					
					$consultaTres = "none";

					//$html = construyeFormularioEdicion2($seccion,$rol,$consultaUno,$consultaDos,$consultaTres);

					//echo $html;

		$this->load->helper('excel');
		reporte_excel_html($seccion,$rol,$consultaUno,$consultaDos,$consultaTres,$idioma = false); 

		echo "<body onload='window.close();'>";

	}

	public function excel_todos($seccion1 = 'none'){
		
		$seccion = 'dos_ver_pedido';
		$rol = 'ADMINISTRADOR';
		$tienda_cookie = $_SESSION['userdata']['tienda'];
		$consulta_tienda = $this->db->get_where('tienda',array('idTienda' => $tienda_cookie));
		$tienda = datosTienda($consulta_tienda);

			switch($seccion1){
				case "consulta_catalogo_recibido":
	        		$this->db->where(array('pedido.Tienda_idTienda'=>$tienda['idTienda'],'tipocliente.idTipoCliente'=>3,'pedido.Estado_idEstado <'=>3));
					$this->db->order_by('idPedido','desc');
					$this->db->select('idPedido');
					$this->db->from('pedido');
					$this->db->join('cliente', 'cliente.idCliente = pedido.Cliente_idCliente');
					$this->db->join('tipocliente', 'cliente.TipoCliente_idTipoCliente = tipocliente.idTipoCliente');
					$this->db->join('estado', 'estado.idEstado = pedido.Estado_idEstado');
					$consulta = $this->db->get();
	        	break;
	        	case "consulta_representante_recibido":
					$this->db->where(array('pedido.Tienda_idTienda'=>$tienda['idTienda'],'tipocliente.idTipoCliente !='=>3,'pedido.Estado_idEstado <'=>3));
					$this->db->order_by('idPedido','desc');
					$this->db->select('idPedido');
					$this->db->from('pedido');
					$this->db->join('cliente', 'cliente.idCliente = pedido.Cliente_idCliente');
					$this->db->join('tipocliente', 'cliente.TipoCliente_idTipoCliente = tipocliente.idTipoCliente');
					$this->db->join('estado', 'estado.idEstado = pedido.Estado_idEstado');
					$consulta = $this->db->get();
				break;
	        	case "consulta_representante_proceso":
	        		$this->db->where(array('pedido.Tienda_idTienda'=>$tienda['idTienda'],'tipocliente.idTipoCliente !='=>3,'pedido.Estado_idEstado >'=>2));
					$this->db->where('pedido.Estado_idEstado <',9);
					$this->db->order_by('idPedido','desc');
					$this->db->select('idPedido');
					$this->db->from('pedido');
					$this->db->join('cliente', 'cliente.idCliente = pedido.Cliente_idCliente');
					$this->db->join('tipocliente', 'cliente.TipoCliente_idTipoCliente = tipocliente.idTipoCliente');
					$this->db->join('estado', 'estado.idEstado = pedido.Estado_idEstado');
					$consulta = $this->db->get();
					
	        	break;
				case "consulta_catalogo_proceso":
					$this->db->where(array('pedido.Tienda_idTienda'=>$tienda['idTienda'],'tipocliente.idTipoCliente'=>3,'pedido.Estado_idEstado >'=>2));
					$this->db->where('pedido.Estado_idEstado <',9);
					$this->db->order_by('idPedido','desc');
					$this->db->select('idPedido');
					$this->db->from('pedido');
					$this->db->join('cliente', 'cliente.idCliente = pedido.Cliente_idCliente');
					$this->db->join('tipocliente', 'cliente.TipoCliente_idTipoCliente = tipocliente.idTipoCliente');
					$this->db->join('estado', 'estado.idEstado = pedido.Estado_idEstado');
					$consulta = $this->db->get();
					
				break;
				case "consulta_representante_surtido":
					$this->db->where(array('pedido.Tienda_idTienda'=>$tienda['idTienda'],'tipocliente.idTipoCliente !='=>3,'pedido.Estado_idEstado'=>9));
					$this->db->order_by('idPedido','desc');
					$this->db->select('idPedido');
					$this->db->from('pedido');
					$this->db->join('cliente', 'cliente.idCliente = pedido.Cliente_idCliente');
					$this->db->join('tipocliente', 'cliente.TipoCliente_idTipoCliente = tipocliente.idTipoCliente');
					$this->db->join('estado', 'estado.idEstado = pedido.Estado_idEstado');
					$consulta = $this->db->get();
				break;
				case "consulta_catalogo_surtido":
					$this->db->where(array('pedido.Tienda_idTienda'=>$tienda['idTienda'],'tipocliente.idTipoCliente'=>3,'pedido.Estado_idEstado'=>9));
					$this->db->order_by('idPedido','desc');
					$this->db->select('idPedido');
					$this->db->from('pedido');
					$this->db->join('cliente', 'cliente.idCliente = pedido.Cliente_idCliente');
					$this->db->join('tipocliente', 'cliente.TipoCliente_idTipoCliente = tipocliente.idTipoCliente');
					$this->db->join('estado', 'estado.idEstado = pedido.Estado_idEstado');
					$consulta = $this->db->get();
				break;
	          
	     	}


			foreach($consulta->result() as $consult){
				$cliente_url = $consult->idPedido;
				$campos = "idPedido,
								cliente.nombre,
								cliente.apellido,
								cliente.idCliente,
								empresa.telefono as cliente_telefono,
								pedido.fecha_pedido,
								estado.nombre as estado,
								tipocliente.nombre as tipo_cliente,
								tipocliente.promocion,
								tipocliente.abreviatura,
								factura.razon_social,
								factura.rfc,
								dir_fact.calle as calle_fact,
								dir_fact.numero_exterior as exterior_fact,
								dir_fact.numero_interior as interior_fact,
								dir_fact.colonia as colonia_fact,
								dir_fact.delegacion as del_fact,
								dir_fact.codigo_postal as postal_fact,
								dir_fact.ciudad as ciudad_fact,
								dir_fact.estado as estado_fact,
								dir_fact.pais as pais_fact,
								general.nombre as nombre_gen,
								general.correo as correo_gen,
								dir_gen.calle as calle_gen,
								dir_gen.numero_exterior as exterior_gen,
								dir_gen.numero_interior as interior_gen,
								dir_gen.colonia as colonia_gen,
								dir_gen.delegacion as del_gen,
								dir_gen.codigo_postal as postal_gen,
								dir_gen.ciudad as ciudad_gen,
								dir_gen.estado as estado_gen,
								dir_gen.pais as pais_gen,
								envio.persona_recibe,
								dir_env.calle as calle_env,
								dir_env.numero_exterior as exterior_env,
								dir_env.numero_interior as interior_env,
								dir_env.colonia as colonia_env,
								dir_env.delegacion as del_env,
								dir_env.codigo_postal as postal_env,
								dir_env.ciudad as ciudad_env,
								dir_env.estado as estado_env,
								dir_env.pais as pais_env";
					
					$this->db->where(array('pedido.Tienda_idTienda'=>$tienda['idTienda'],'pedido.idPedido'=>$cliente_url));
					$this->db->order_by('idPedido','desc');
					$this->db->select($campos);
					$this->db->from('pedido');
					$this->db->join('cliente', 'cliente.idCliente = pedido.Cliente_idCliente');
					$this->db->join('empresa', 'empresa.idEmpresa = cliente.Empresa_idEmpresa');
					$this->db->join('tipocliente', 'cliente.TipoCliente_idTipoCliente = tipocliente.idTipoCliente');
					$this->db->join('estado', 'estado.idEstado = pedido.Estado_idEstado');
					$this->db->join('factura', 'factura.idFactura = pedido.Factura_idFactura');
					$this->db->join('direccion as dir_fact', 'dir_fact.idDireccion = factura.Direccion_idDireccion');
					$this->db->join('general', 'general.idGeneral = pedido.General_idGeneral');
					$this->db->join('direccion as dir_gen', 'dir_gen.idDireccion = general.Direccion_idDireccion');
					$this->db->join('envio', 'envio.idEnvio = pedido.Envio_idEnvio');
					$this->db->join('direccion as dir_env', 'dir_env.idDireccion = envio.Direccion_idDireccion');
					$consultaUno = $this->db->get();


					$this->db->where(array('contenidopedido.Pedido_idPedido' => $cliente_url));
					$this->db->order_by('idContenidoPedido','asc');
					$this->db->select('*');
					$this->db->from('contenidopedido');
					$this->db->join('presentacion', 'presentacion.idPresentacion = contenidopedido.Presentacion_idPresentacion');
					$this->db->join('producto', 'presentacion.Producto_idProducto = producto.idProducto');
					$consultaDos = $this->db->get();

					$consultaTres = 'none';

					$arreglo[] = array(
								'seccion' => $seccion,
								'rol' => $rol,
								'consultaUno' =>$consultaUno,
								'consultaDos' => $consultaDos,
								'consultaTres' => $consultaTres
								);
			}

					
			
		$this->load->helper('excel');
		reporte_excel_todos($arreglo); 

		//echo "<body onload='window.close();'>";

	}

	public function contenido_nosurtido($nopedido){
		$post = $this->input->post(NULL,TRUE);
		$post['nopedido'] = $nopedido;
		
		$this->load->model('admin/pedido_model','pedido');
		$this->pedido->guardarnosurtido($post);
		redirect('admin/pedido/recibido/ver/'.$nopedido);
	}

	
}

/* End of file pedido.php */
/* Location: ./application/controllers/pedido.php */