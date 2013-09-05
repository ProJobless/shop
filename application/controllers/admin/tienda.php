<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tienda extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/tienda
	 *	- or -  
	 * 		http://example.com/index.php/tienda/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/tienda/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
         public function __construct() {
            parent::__construct();
            
            $this->load->helper('funciones_custom_helper');
            $this->load->helper('excel_helper');


        }
        
	public function index()
	{
		redirect('admin/tienda/inicio');
	}
	
	public function inicio($seccion = 'tienda_all')
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
		switch($rol){
		default:
			show_404();
		break;
		
		case 'ADMINISTRADOR':
			$data['rol'] = $rol;
			$data['seccion'] = $seccion;
			$this->load->view('admin/altas_consultas',$data);
		break;
		
		case 'PRODUCTO_INFORMACION_GENERAL':
			$data['rol'] = $rol;
			$data['seccion'] = $seccion;
			$this->load->view('admin/altas_consultas',$data);
		break;
		case 'PRODUCTO_INFORMACION_INGREDIENTES':
			$data['rol'] = $rol;
			$data['seccion'] = $seccion;
			$this->load->view('admin/altas_consultas',$data);
		break;
		
		case 'PRODUCTO_PRECIO':
			$data['rol'] = $rol;
			$data['seccion'] = $seccion;
			$this->load->view('admin/altas_consultas',$data);
		break;
		
		case 'PRODUCTO_VIDEO':
			$data['rol'] = $rol;
			$data['seccion'] = $seccion;
			$this->load->view('admin/altas_consultas',$data);
		break;
		case 'PEDIDOS_CATALOGO':
			$data['rol'] = $rol;
			$data['seccion'] = $seccion;
			$this->load->view('admin/altas_consultas',$data);
		break;
		case 'PEDIDOS_REPRESENTANTE_VENTAS':
			$data['rol'] = $rol;
			$data['seccion'] = $seccion;
			$this->load->view('admin/altas_consultas',$data);
		break;
		case 'PEDIDOS_REPRESENTANTE_EMBARQUES':
			$data['rol'] = $rol;
			$data['seccion'] = $seccion;
			$this->load->view('admin/altas_consultas',$data);
		break;
		}
	}
	public function cliente($seccion = "cliente",$cliente_url='none')
	{
		$tienda_cookie = $_SESSION['userdata']['tienda'];
		$consulta_tienda = $this->db->get_where('tienda',array('idTienda' => $tienda_cookie));
		$tienda = datosTienda($consulta_tienda);
		$data['nombre_tienda'] = $tienda['nombre'];
		$data['idTienda'] = $tienda['idTienda'];
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
		switch($seccion){
			case "cliente":
				switch($rol){
				default:
					show_404();
				break;
				case 'ADMINISTRADOR':
					$data['seccion'] = $seccion;
					$data['rol'] = $rol;
					$this->load->view('admin/altas_consultas',$data);
				break;
			}
			break;
			case "alta":
				switch($rol){
				default:
					show_404();
				break;
		
				case 'ADMINISTRADOR':
					$rules = reglasInsertar('alta_cliente_general');
					$data['seccion'] = "alta_cliente_general";
					$data['rol'] = $rol;
					$data['consulta'] = $this->db->get_where('tipocliente',array('activo'=>'SI','Tienda_idTienda'=>$tienda['idTienda']));
					
					$this->form_validation->set_rules($rules); 
					if($this->form_validation->run() == FALSE){
					$this->load->view('admin/altas_consultas',$data);
					}else{
					$idTienda = $tienda['idTienda'];
					$cliente = datosInsertar('alta_cliente_general',$idTienda);
					$insertar = $this->db->insert('cliente', $cliente);
					$id_query = $this->db->query('select last_insert_id() as ultimo');
						foreach($id_query->result() as $id_query1){
							$id_cliente = $id_query1->ultimo;
							}
					//$insertar = TRUE;
					if($insertar){
						if(!empty($_POST['calle']) || !empty($_POST['numext']) || !empty($_POST['numint']) || !empty($_POST['colonia']) || !empty($_POST['delegacion']) || !empty($_POST['codigo']) || !empty($_POST['ciudad']) || ($_POST['estados'] != 'none') ||($_POST['paises'] != 'none')){
						
						$direccion = datosInsertar('alta_cliente_general_direccion',$idTienda);
						$insertarD = $this->db->insert('direccion', $direccion);
						if($insertarD){
								$id_query = $this->db->query('select last_insert_id() as ultimo');
								foreach($id_query->result() as $id_query1){
								$id_direccion = $id_query1->ultimo;
								}
								$this->db->where('idCliente', $id_cliente);
								$this->db->update('cliente', array('Direccion_idDireccion' => $id_direccion)); 
							}
						//echo "hay una direccion";
						}
					//$this->phpsession->flashsave('insert_message', 'El cliente se ha creado con éxito.');
					 redirect("admin/tienda/cliente/editar_empresa/$id_cliente");
					}else{
					$this->phpsession->flashsave('insert_message', 'Error #2420: No se pudo crear el cliente; por favor contacte a su administrador.');
					redirect('admin/tienda/cliente/alta');
					}
					}
				break;
			}
			break;
			case "consulta":
				switch($rol){
				default:
					show_404();
				break;
				case 'ADMINISTRADOR':
					$data['seccion'] = "consulta_cliente";
					$data['rol'] = $rol;
					/*$this->db->where(array('cliente.Tienda_idTienda'=>$tienda['idTienda']));
					$this->db->order_by('idCliente','asc');
					$this->db->select('cliente.nombre as nombre_cliente,apellido,secure_number,idCliente,cliente.activo,tipocliente.nombre');
					$this->db->from('cliente');
					$this->db->join('tipocliente', 'cliente.TipoCliente_idTipoCliente = tipocliente.idTipoCliente');
					$data['consulta'] = $this->db->get();*/

					$this->load->model('admin/paginator_model');
					$pages=15; //Numero de registros mostrados por páginas
					$this->load->library('pagination'); //Cargamos la librería de paginación
					$config['base_url'] = base_url().'tienda/cliente/consulta'; // parametro base de la aplicación, si tenemos un .htaccess nos evitamos el index.php
					$config['total_rows'] = $this->paginator_model->totalClientes($tienda['idTienda']) ;    
					$config['per_page'] = $pages; 
					$config['num_links'] = 5; //Numero de links mostrados en la paginación
					$config["uri_segment"] = 4; //Para que los links en la paginación sean los correctos.
					$config['first_link'] = 'Inicio';
					$config['last_link'] = 'Final';

					$this->pagination->initialize($config); 
			 	
					$data["consulta"] = $this->paginator_model->getClientPaginated($tienda['idTienda'],$config['per_page'],$this->uri->segment(4));
					/*foreach($data['consulta']->result() as $client){
						echo good;
					}*/
					$this->load->view('admin/altas_consultas',$data);
					
				break;
			}
			break;
			case "desactivar":
				switch($rol){
				default:
					show_404();
				break;
				case 'ADMINISTRADOR':
					if($cliente_url == 'none' ){
						redirect('admin/tienda/tipo_cliente/consulta');
					}
					$this->db->where('idCliente', $cliente_url);
					$update = $this->db->update('cliente', array('activo'=>'NO'));
					redirect($_SERVER['HTTP_REFERER']);
				break;
				}
			break;
			case "activar":
				switch($rol){
				default:
					show_404();
				break;
				case 'ADMINISTRADOR':
					if($cliente_url == 'none' ){
						redirect('admin/tienda/tipo_cliente/consulta');
					}
					$this->db->where('idCliente', $cliente_url);
					$update = $this->db->update('cliente', array('activo'=>'SI'));
					redirect($_SERVER['HTTP_REFERER']);
				break;
				}
			break;
			case "ver":
				switch($rol){
				default:
					show_404();
				break;
				case 'ADMINISTRADOR':
					if($cliente_url == 'none' ){
						redirect('admin/tienda/cliente/consulta');
					}
					//$buscar = str_replace('_',' ',$cliente_url);
					$sql = $this->db->get_where('cliente', array('idCliente'=>$cliente_url,'Tienda_idTienda' => $tienda['idTienda']));
					if($sql->num_rows() < 1){
						redirect ('tienda/cliente/consulta');
					}
					$data['consulta'] = $sql;
					$data['seccion'] = "cliente_ver";
					$data['rol'] = $rol;
					$this->db->where(array('cliente.Tienda_idTienda'=>$tienda['idTienda'],'idCliente'=>$cliente_url));
					$this->db->select('titulo,cliente.nombre,apellido,fecha_nacimiento,correo,correo_otro,telefono,telefono_celular,sitio_web,nota,clave,contrasena,secure_number,tipocliente.nombre as tipo_cliente,descripcion,calle,numero_exterior,numero_interior,colonia,delegacion,codigo_postal,ciudad,estado,pais');
					$this->db->from('cliente');
					$this->db->join('tipocliente', 'cliente.TipoCliente_idTipoCliente = tipocliente.idTipoCliente');
					$this->db->join('direccion','cliente.Direccion_idDireccion = direccion.idDireccion');
					$data['consultaUno'] = $this->db->get();
					$this->db->where(array('cliente.Tienda_idTienda'=>$tienda['idTienda'],'idCliente'=>$cliente_url));
					$this->db->select('razon_social,cargo,empresa.correo,empresa.correo_otro,empresa.telefono,fax,empresa.telefono_celular,empresa.sitio_web,calle,numero_exterior,numero_interior,colonia,delegacion,codigo_postal,ciudad,estado,pais');
					$this->db->from('cliente');
					$this->db->join('empresa', 'cliente.Empresa_idEmpresa = empresa.idEmpresa');
					$this->db->join('direccion','empresa.Direccion_idDireccion = direccion.idDireccion');
					$data['consultaDos'] = $this->db->get();
					$data['consultaTres'] = $cliente_url;
					$this->load->view('admin/altas_consultas',$data);
					
				break;
				}
			break;
			case "editar_general":
				switch($rol){
				default:
					show_404();
				break;
				case 'ADMINISTRADOR':
					if($cliente_url == 'none' ){
						redirect('admin/tienda/cliente/consulta');
					}
					//$buscar = str_replace('_',' ',$cliente_url);
					
					$sql = $this->db->get_where('cliente', array('idCliente'=>$cliente_url,'Tienda_idTienda' => $tienda['idTienda']));
					if($sql->num_rows() < 1){
						redirect ('tienda/cliente/consulta');
					}
					$data['consulta'] = $sql;
					$data['seccion'] = "cliente_edicion_general";
					$data['rol'] = $rol;
					$rules = reglasInsertar('editar_cliente_general');
					$data['consultaUno'] = $sql;
					$data['consultaDos'] = $this->db->get_where('tipocliente',array('activo'=>'SI','Tienda_idTienda'=>$tienda['idTienda']));
					foreach($sql->result() as $cliente_temp){$idDireccion = $cliente_temp->Direccion_idDireccion;}
					$data['consultaTres'] = $this->db->get_where('direccion',array('idDireccion'=>$idDireccion));
					$this->form_validation->set_rules($rules); 
					
					if($this->form_validation->run() == FALSE){
					$this->load->view('admin/altas_consultas',$data);
					
					}else{
					
					$idTienda = $tienda['idTienda'];
					$cliente = datosInsertar('edicion_cliente_general',$idTienda);
					$this->db->where('idCliente', $cliente_url);
					$update = $this->db->update('cliente',$cliente);
					if($update){
						if(!empty($_POST['calle']) || !empty($_POST['numext']) || !empty($_POST['numint']) || !empty($_POST['colonia']) || !empty($_POST['delegacion']) || !empty($_POST['codigo']) || !empty($_POST['ciudad']) || ($_POST['estados'] != 'none') ||($_POST['paises'] != 'none')){
						/*$id_query = $this->db->query('select last_insert_id() as ultimo');
						foreach($id_query->result() as $id_query1){
							$id_cliente = $id_query1->ultimo;
							}*/
						$direccion_query = $this->db->get_where('direccion',array('idDireccion'=>$idDireccion));
						
						$direccion = datosInsertar('edicion_cliente_general_direccion',$idTienda);
						
						if(($direccion_query->num_rows() == 1) && ($idDireccion != 1)){
						$this->db->where('idDireccion', $idDireccion);
						$insertarD = $this->db->update('direccion', $direccion);
						$this->db->where('idCliente', $cliente_url);
						$this->db->update('cliente', array('Direccion_idDireccion' => $idDireccion));
						}else{
						$insertarD = $this->db->insert('direccion', $direccion);
						
						if($insertarD){
								$id_query = $this->db->query('select last_insert_id() as ultimo');
								foreach($id_query->result() as $id_query1){
								$id_direccion = $id_query1->ultimo;
								}
								$this->db->where('idCliente', $cliente_url);
								$this->db->update('cliente', array('Direccion_idDireccion' => $id_direccion)); 
							}
						}
						//echo "hay una direccion";
						}
					
					//$this->phpsession->flashsave('update_message', "El cliente se ha actualizado con éxito.");
					redirect("admin/tienda/cliente/editar_empresa/$cliente_url");
					}else{
					$this->phpsession->flashsave('update_message', 'Error #2420: No se pudo actualizar cliente; por favor contacte a su administrador.');
					redirect("admin/tienda/cliente/editar_general/$cliente_url");
					}
					
					}
				break;
				}
			break;
			case "editar_empresa":
				switch($rol){
				default:
					show_404();
				break;
				case 'ADMINISTRADOR':
					if($cliente_url == 'none' ){
						redirect('admin/tienda/cliente/consulta');
					}
					//$buscar = str_replace('_',' ',$cliente_url);
					
					$sql = $this->db->get_where('cliente', array('idCliente'=>$cliente_url,'Tienda_idTienda' => $tienda['idTienda']));
					if($sql->num_rows() < 1){
						redirect ('tienda/cliente/consulta');
					}
					$data['consulta'] = $sql;
					$data['seccion'] = "cliente_edicion_empresa";
					$data['rol'] = $rol;
					$rules = reglasInsertar('editar_cliente_empresa');
					$cliente_temp = datosCliente($sql);
					$data['consultaUno'] = $sql;
					$data['consultaDos'] = $this->db->get_where('empresa',array('idEmpresa'=>$cliente_temp['Empresa_idEmpresa']));
					foreach($data['consultaDos']->result() as $empresa_temp){$idDireccion = $empresa_temp->Direccion_idDireccion;}
					$data['consultaTres'] = $this->db->get_where('direccion',array('idDireccion'=>$idDireccion));
					$this->form_validation->set_rules($rules); 
					if($this->form_validation->run() == FALSE){
					$this->load->view('admin/altas_consultas',$data);
					}else{
					$idTienda = $tienda['idTienda'];
					$empresa = datosInsertar('edicion_cliente_empresa',$idTienda);
					$this->db->where('idCliente', $cliente_url);
					$getC = $this->db->get('cliente');
					$cliente_temp = datosCliente($getC);
					if($cliente_temp['Empresa_idEmpresa'] != 2){
					$this->db->where('idEmpresa',$cliente_temp['Empresa_idEmpresa']);
					$update = $this->db->update('empresa',$empresa);
					}else{
					$update = $this->db->insert('empresa',$empresa);
					$id_query = $this->db->query('select last_insert_id() as ultimo');
								foreach($id_query->result() as $id_query1){
								$id_empresa = $id_query1->ultimo;
								}
					$this->db->where('idCliente', $cliente_url);
					$this->db->update('cliente',array('Empresa_idEmpresa' => $id_empresa));
					}
					if($update){
						if(!empty($_POST['calle']) || !empty($_POST['numext']) || !empty($_POST['numint']) || !empty($_POST['colonia']) || !empty($_POST['delegacion']) || !empty($_POST['codigo']) || !empty($_POST['ciudad']) || ($_POST['estados'] != 'none') ||($_POST['paises'] != 'none')){
						/*$id_query = $this->db->query('select last_insert_id() as ultimo');
						foreach($id_query->result() as $id_query1){
							$id_cliente = $id_query1->ultimo;
							}*/
						$direccion_query = $this->db->get_where('direccion',array('idDireccion'=>$idDireccion));
						
						$direccion = datosInsertar('edicion_cliente_empresa_direccion',$idTienda);
						
						if(($direccion_query->num_rows() == 1) && ($idDireccion != 1)){
						$this->db->where('idDireccion', $idDireccion);
						$insertarD = $this->db->update('direccion', $direccion);
						$this->db->where('idCliente', $cliente_url);
						$getC = $this->db->get('cliente');
						$cliente_temp = datosCliente($getC);
						$this->db->where('idEmpresa', $cliente_temp['Empresa_idEmpresa']);
						$this->db->update('empresa', array('Direccion_idDireccion' => $idDireccion));
						}else{
						$insertarD = $this->db->insert('direccion', $direccion);
						
						if($insertarD){
								$id_query = $this->db->query('select last_insert_id() as ultimo');
								foreach($id_query->result() as $id_query1){
								$id_direccion = $id_query1->ultimo;
								}
								$this->db->where('idCliente', $cliente_url);
								$getC = $this->db->get('cliente');
								$cliente_temp = datosCliente($getC);
								$this->db->where('idEmpresa', $cliente_temp['Empresa_idEmpresa']);
								$this->db->update('empresa', array('Direccion_idDireccion' => $id_direccion)); 
							}
						}
						//echo "hay una direccion";
						}
					
					//$this->phpsession->flashsave('update_message', "El cliente se ha actualizado con éxito.");
					redirect("admin/tienda/cliente/editar_nota/$cliente_url");
					}else{
					$this->phpsession->flashsave('update_message', 'Error #2420: No se pudo actualizar cliente; por favor contacte a su administrador.');
					redirect("admin/tienda/cliente/editar_empresa/$cliente_url");
					}
					}
				break;
				}
			break;
			case "editar_nota":
				switch($rol){
				default:
					show_404();
				break;
				case 'ADMINISTRADOR':
					if($cliente_url == 'none' ){
						redirect('admin/tienda/cliente/consulta');
					}
					//$buscar = str_replace('_',' ',$cliente_url);
					
					$sql = $this->db->get_where('cliente', array('idCliente'=>$cliente_url,'Tienda_idTienda' => $tienda['idTienda']));
					if($sql->num_rows() < 1){
						redirect ('tienda/cliente/consulta');
					}
					$data['consulta'] = $sql;
					$data['seccion'] = "cliente_edicion_notas";
					$data['rol'] = $rol;
					$rules = reglasInsertar('editar_cliente_nota');
					$cliente_temp = datosCliente($sql);
					$data['consultaUno'] = $sql;
					$data['consultaDos'] = "none";
					//foreach($data['consultaDos']->result() as $empresa_temp){$idDireccion = $empresa_temp->Direccion_idDireccion;}
					$data['consultaTres'] = "none";
					$this->form_validation->set_rules($rules); 
					if($this->form_validation->run() == FALSE){
					$this->load->view('admin/altas_consultas',$data);
					}else{
					$idTienda = $tienda['idTienda'];
					$notas = datosInsertar('edicion_cliente_nota',$idTienda);
					$this->db->where('idCliente', $cliente_url);
					$update = $this->db->update('cliente',$notas);
					if($update){
					
					//$this->phpsession->flashsave('update_message', "El cliente se ha actualizado con éxito.");
					redirect("admin/tienda/cliente/editar_password/$cliente_url");
					}else{
					$this->phpsession->flashsave('update_message', 'Error #2420: No se pudo actualizar cliente; por favor contacte a su administrador.');
					redirect("admin/tienda/cliente/editar_notas/$cliente_url");
					}
					}
				break;
				}
			break;
			case "editar_password":
				switch($rol){
				default:
					show_404();
				break;
				case 'ADMINISTRADOR':
					if($cliente_url == 'none' ){
						redirect('admin/tienda/cliente/consulta');
					}
					//$buscar = str_replace('_',' ',$cliente_url);
					
					$sql = $this->db->get_where('cliente', array('idCliente'=>$cliente_url,'Tienda_idTienda' => $tienda['idTienda']));
					if($sql->num_rows() < 1){
						redirect ('tienda/cliente/consulta');
					}
					$data['consulta'] = $sql;
					$data['seccion'] = "cliente_edicion_password";
					$data['rol'] = $rol;
					$rules = reglasInsertar('editar_cliente_password');
					$cliente_temp = datosCliente($sql);
					$data['consultaUno'] = $sql;
					$data['consultaDos'] = "none";
					//foreach($data['consultaDos']->result() as $empresa_temp){$idDireccion = $empresa_temp->Direccion_idDireccion;}
					$data['consultaTres'] = "none";
					$this->form_validation->set_rules($rules); 
					if($this->form_validation->run() == FALSE){
					$this->load->view('admin/altas_consultas',$data);
					}else{
					$idTienda = $tienda['idTienda'];
					$pass = datosInsertar('edicion_cliente_password',$idTienda);
					
					if(empty($_POST['contrasena'])){

						$this->phpsession->flashsave('update_message', "El cliente se ha actualizado con éxito sin contar la contraseña.");
						redirect("admin/tienda/cliente/consulta");
					}
					$this->db->where('idCliente', $cliente_url);
					$update = $this->db->update('cliente',$pass);
					if($update){
					
					$this->phpsession->flashsave('update_message', "El cliente se ha actualizado con éxito.");
					redirect("admin/tienda/cliente/consulta");
					}else{
					$this->phpsession->flashsave('update_message', 'Error #2420: No se pudo actualizar cliente; por favor contacte a su administrador.');
					redirect("admin/tienda/cliente/editar_notas/$cliente_url");
					}
					}
				break;
				}
			break;
			case 'excel':

				$campos = "*,
							cliente.nombre as nom_client,
							cliente.activo as client_act";
				$this->db->select($campos);
				$this->db->where(array('cliente.Tienda_idTienda' => $tienda['idTienda']));
				$this->db->from('cliente');
				$this->db->join('tipocliente','cliente.TipoCliente_idTipoCliente = tipocliente.idTipoCliente');
				$this->db->join('empresa','cliente.Empresa_idEmpresa = empresa.idEmpresa');
				$this->db->join('direccion','empresa.Direccion_idDireccion = direccion.idDireccion');
				$query=$this->db->get();

				$this->load->helper('excel');
				cliente_excel_html($query, 'listadoclientes');
				/*foreach ($query->result() as $key) {
					echo $key->nombre.'<br/>';
				}*/
			break;
			default:
				show_404();
			break;
		
		}
		
	}
	
	public function categoria($seccion = "categoria",$cliente_url='none')
	{
		$tienda_cookie = $_SESSION['userdata']['tienda'];
		$consulta_tienda = $this->db->get_where('tienda',array('idTienda' => $tienda_cookie));
		$tienda = datosTienda($consulta_tienda);
		$data['nombre_tienda'] = $tienda['nombre'];
		$data['idTienda'] = $tienda['idTienda'];
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
		switch($seccion){
			case "categoria":
				switch($rol){
				default:
					show_404();
				break;
				case 'ADMINISTRADOR':
					$data['seccion'] = $seccion;
					$data['rol'] = $rol;
					$this->load->view('admin/altas_consultas',$data);
				break;
			}
			break;
			case "alta":
				switch($rol){
				default:
					show_404();
				break;
		
				case 'ADMINISTRADOR':
					$rules = reglasInsertar('alta_categoria');
					$data['seccion'] = "alta_categoria";
					$data['rol'] = $rol;
					$data['consulta'] = "none";
					$rules = reglasInsertar('alta_categoria');
					$this->form_validation->set_rules($rules); 
					if($this->form_validation->run() == FALSE){
					$this->load->view('admin/altas_consultas',$data);
					}else{
					$idTienda = $tienda['idTienda'];
					$categoria = datosInsertar('alta_categoria',$idTienda);
					$insertar = $this->db->insert('categoria', $categoria);
					if($insertar){
					$this->phpsession->flashsave('insert_message', 'La categoria se ha creado con éxito.');
					 redirect("admin/tienda/categoria/alta");
					}else{
					$this->phpsession->flashsave('insert_message', 'Error #2420: No se pudo crear la categoria; por favor contacte a su administrador.');
					redirect('admin/tienda/categoria/alta');
					}
					}
				break;
			}
			break;
			case "consulta":
				switch($rol){
				default:
					show_404();
				break;
				case 'ADMINISTRADOR':
					$data['seccion'] = "consulta_categoria";
					$data['rol'] = $rol;
					//$data['consulta'] = $this->db->get_where('categoria',array('Tienda_idTienda'=>$tienda['idTienda']));

					$this->load->model('admin/paginator_model');
					$pages=10; //Numero de registros mostrados por páginas
					$this->load->library('pagination'); //Cargamos la librería de paginación
					$config['base_url'] = site_url('tienda/categoria/consulta'); // parametro base de la aplicación, si tenemos un .htaccess nos evitamos el index.php
					$config['total_rows'] = $this->paginator_model->totalCategorias($tienda['idTienda']) ;    
					$config['per_page'] = $pages; 
					$config['num_links'] = 5; //Numero de links mostrados en la paginación
					$config["uri_segment"] = 4; //Para que los links en la paginación sean los correctos.
					$config['first_link'] = 'Inicio';
					$config['last_link'] = 'Final';

					$this->pagination->initialize($config); 
			 	
					$data["consulta"] = $this->paginator_model->getCategoryPaginated($tienda['idTienda'],$config['per_page'],$this->uri->segment(4));
					$this->load->view('admin/altas_consultas',$data);
					
				break;
			}
			break;
			case "desactivar":
				switch($rol){
				default:
					show_404();
				break;
				case 'ADMINISTRADOR':
					if($cliente_url == 'none' ){
						redirect('admin/tienda/categoria/consulta');
					}
					$this->db->where('idCategoria', $cliente_url);
					$update = $this->db->update('categoria', array('activo'=>'NO'));
					$this->db->where('Categoria_idCategoria', $cliente_url);
					$update2 = $this->db->update('subcategoria', array('activo'=>'NO'));
					redirect('admin/tienda/categoria/consulta');
				break;
				}
			break;
			case "activar":
				switch($rol){
				default:
					show_404();
				break;
				case 'ADMINISTRADOR':
					if($cliente_url == 'none' ){
						redirect('admin/tienda/categoria/consulta');
					}
					$this->db->where('idCategoria', $cliente_url);
					$update = $this->db->update('categoria', array('activo'=>'SI'));
					$this->db->where('Categoria_idCategoria', $cliente_url);
					$update2 = $this->db->update('subcategoria', array('activo'=>'SI'));
					redirect('admin/tienda/categoria/consulta');
				break;
				}
			break;
			case "editar":
				switch($rol){
				default:
					show_404();
				break;
				case 'ADMINISTRADOR':
					if($cliente_url == 'none' ){
						redirect('admin/tienda/categoria/consulta');
					}
					//$buscar = str_replace('_',' ',$cliente_url);
					
					$sql = $this->db->get_where('categoria', array('idCategoria'=>$cliente_url,'Tienda_idTienda' => $tienda['idTienda']));
					if($sql->num_rows() < 1){
						redirect ('tienda/categoria/consulta');
					}
					$data['consulta'] = $sql;
					$data['seccion'] = "editar_categoria";
					$data['rol'] = $rol;
					$rules = reglasInsertar('editar_categoria');
					//$cliente_temp = datosCliente($sql);
					$this->form_validation->set_rules($rules); 
					if($this->form_validation->run() == FALSE){
					$this->load->view('admin/altas_consultas',$data);
					}else{
					$idTienda = $tienda['idTienda'];
					$categoria = datosInsertar('editar_categoria',$idTienda);
					$this->db->where('idCategoria', $cliente_url);
					$update = $this->db->update('categoria',$categoria);
					if($update){
					
					$this->phpsession->flashsave('update_message', "La categoria se ha actualizado con éxito.");
					redirect("admin/tienda/categoria/consulta");
					}else{
					$this->phpsession->flashsave('update_message', 'Error #2420: No se pudo actualizar la categoria; por favor contacte a su administrador.');
					redirect("admin/tienda/categoria/editar/$cliente_url");
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
	
	public function subcategoria($seccion = "categoria",$cliente_url='none')
	{
		$tienda_cookie = $_SESSION['userdata']['tienda'];
		$consulta_tienda = $this->db->get_where('tienda',array('idTienda' => $tienda_cookie));
		$tienda = datosTienda($consulta_tienda);
		$data['nombre_tienda'] = $tienda['nombre'];
		$data['idTienda'] = $tienda['idTienda'];
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
		switch($seccion){
			case "categoria":
				switch($rol){
				default:
					show_404();
				break;
				case 'ADMINISTRADOR':
					$data['seccion'] = $seccion;
					$data['rol'] = $rol;
					$this->load->view('admin/altas_consultas',$data);
				break;
			}
			break;
			case "alta":
				switch($rol){
				default:
					show_404();
				break;
		
				case 'ADMINISTRADOR':
					
					$data['seccion'] = "alta_subcategoria";
					$data['rol'] = $rol;
					$data['consulta'] = $this->db->get_where('categoria',array('Tienda_idTienda'=>$tienda['idTienda'],'activo'=>'SI'));
					$rules = reglasInsertar('alta_subcategoria');
					$this->form_validation->set_rules($rules); 
					if($this->form_validation->run() == FALSE){
					$this->load->view('admin/altas_consultas',$data);
					}else{
					$idTienda = $tienda['idTienda'];
					$subcategoria = datosInsertar('alta_subcategoria',$idTienda);
					$insertar = $this->db->insert('subcategoria', $subcategoria);
					if($insertar){
					$this->phpsession->flashsave('insert_message', 'La subcategoria se ha creado con éxito.');
					 redirect("admin/tienda/subcategoria/alta");
					}else{
					$this->phpsession->flashsave('insert_message', 'Error #2420: No se pudo crear la subcategoria; por favor contacte a su administrador.');
					redirect('admin/tienda/subcategoria/alta');
					}
					}
				break;
			}
			break;
			case "consulta":
				switch($rol){
				default:
					show_404();
				break;
				case 'ADMINISTRADOR':
					$data['seccion'] = "consulta_subcategoria";
					$data['rol'] = $rol;
					if($cliente_url == 'none'){
						$this->db->where(array('categoria.Tienda_idTienda'=>$tienda['idTienda']));
						$this->db->select('idCategoria,categoria.nombre as catnombre,categoria.nombre as catnombre,categoria.activo as catactivo,Tienda_idTienda,idSubcategoria,subcategoria.nombre,subcategoria.activo,Categoria_idCategoria,subcategoria.nombre_en');
						$this->db->from('categoria');
						$this->db->join('subcategoria','subcategoria.Categoria_idCategoria = categoria.idCategoria');
						$data['consulta'] = $this->db->get();
					}else{
						//$data['consulta'] = $this->db->get_where('subcategoria',array('Categoria_idCategoria'=>$cliente_url));
						$this->db->where(array('subcategoria.Categoria_idCategoria'=>$cliente_url));
						$this->db->select('idCategoria,categoria.nombre as catnombre,categoria.nombre as catnombre,categoria.activo as catactivo,Tienda_idTienda,idSubcategoria,subcategoria.nombre,subcategoria.activo,Categoria_idCategoria,subcategoria.nombre_en');
						$this->db->from('subcategoria');
						$this->db->join('categoria','subcategoria.Categoria_idCategoria = categoria.idCategoria');
						$data['consulta'] = $this->db->get();
					}
					$this->load->view('admin/altas_consultas',$data);
					
				break;
			}
			break;
			case "desactivar":
				switch($rol){
				default:
					show_404();
				break;
				case 'ADMINISTRADOR':
					if($cliente_url == 'none' ){
						redirect('admin/tienda/subcategoria/consulta');
					}
					$this->db->where('idSubcategoria', $cliente_url);
					$update = $this->db->update('subcategoria', array('activo'=>'NO'));
					redirect($_SERVER['HTTP_REFERER']);
				break;
				}
			break;
			case "activar":
				switch($rol){
				default:
					show_404();
				break;
				case 'ADMINISTRADOR':
					if($cliente_url == 'none' ){
						redirect('admin/tienda/subcategoria/consulta');
					}
					$this->db->where('idSubcategoria', $cliente_url);
					$update = $this->db->update('subcategoria', array('activo'=>'SI'));
					redirect($_SERVER['HTTP_REFERER']);
				break;
				}
			break;
			case "editar":
				switch($rol){
				default:
					show_404();
				break;
				case 'ADMINISTRADOR':
					if($cliente_url == 'none' ){
						redirect('admin/tienda/categoria/consulta');
					}
					//$buscar = str_replace('_',' ',$cliente_url);
					
					$sql = $this->db->get_where('subcategoria', array('idSubcategoria'=>$cliente_url));
					if($sql->num_rows() < 1){
						redirect ('tienda/subcategoria/consulta');
					}
					$data['consultaUno'] = $sql;
					$data['consultaDos'] = $this->db->get_where('categoria', array('Tienda_idTienda'=>$tienda['idTienda']));
					$data['consultaTres'] = $sql;
					$data['seccion'] = "dos_editar_subcategoria";
					$data['rol'] = $rol;
					$rules = reglasInsertar('editar_subcategoria');
					//$cliente_temp = datosCliente($sql);
					$this->form_validation->set_rules($rules); 
					if($this->form_validation->run() == FALSE){
					$this->load->view('admin/altas_consultas',$data);
					}else{
					$idTienda = $tienda['idTienda'];
					$subcategoria = datosInsertar('editar_subcategoria',$idTienda);
					$this->db->where('idSubcategoria', $cliente_url);
					$update = $this->db->update('subcategoria',$subcategoria);
					if($update){
					
					$this->phpsession->flashsave('update_message', "La subcategoria se ha actualizado con éxito.");
					redirect("admin/tienda/categoria/consulta");
					}else{
					$this->phpsession->flashsave('update_message', 'Error #2420: No se pudo actualizar la subcategoria; por favor contacte a su administrador.');
					redirect("admin/tienda/categoria/editar/$cliente_url");
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
	
	public function producto($seccion = "producto",$cliente_url='none')
	{
		$tienda_cookie = $_SESSION['userdata']['tienda'];
		$consulta_tienda = $this->db->get_where('tienda',array('idTienda' => $tienda_cookie));
		$tienda = datosTienda($consulta_tienda);
		$data['nombre_tienda'] = $tienda['nombre'];
		$data['idTienda'] = $tienda['idTienda'];
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
		switch($seccion){
			case "producto":
				switch($rol){
				default:
					show_404();
				break;
				case 'PRODUCTO_VIDEO':
				case 'PRODUCTO_PRECIO':
				case 'PRODUCTO_INFORMACION_GENERAL':
				case 'PRODUCTO_INFORMACION_INGREDIENTES':
				case 'ADMINISTRADOR':
					$data['seccion'] = $seccion;
					$data['rol'] = $rol;
					$this->load->view('admin/altas_consultas',$data);
				break;
			}
			break;
			case "alta":

				/*Información para todos los casos */

				$data['seccion'] = "alta_producto";
				$data['rol'] = $rol;
				$this->db->order_by('idCategoria','asc');
				$cat = $this->db->get_where('categoria',array('Tienda_idTienda'=>$tienda['idTienda'],'activo'=>'SI'));
				$optgroup;
				foreach($cat->result() as $arreglo){
					$optgroup[$arreglo->idCategoria]['nombre'] = $arreglo->nombre;
					$subcat = $this->db->get_where('subcategoria',array('Categoria_idCategoria'=>$arreglo->idCategoria,'activo'=>'SI'));
				foreach($subcat->result() as $arreglo1){
						$optgroup[$arreglo->idCategoria][$arreglo1->idSubcategoria]['value'] = $arreglo1->idSubcategoria;
						$optgroup[$arreglo->idCategoria][$arreglo1->idSubcategoria]['nombre'] = $arreglo1->nombre;
					}
				}
				$data['consulta'] = $optgroup;

				switch($rol){

				default:
					show_404();
				break;
				case "PRODUCTO_INFORMACION_GENERAL":
					$rules = reglasInsertar('alta_producto');
					$this->form_validation->set_rules($rules); 
					
					if($this->form_validation->run() == FALSE){
					$this->load->view('admin/altas_consultas',$data);
					
					}else{
					
					$idTienda = $tienda['idTienda'];
					
					$config['upload_path'] = './productos_img/';
					$config['allowed_types'] = 'gif|jpg|png';
					$config['max_size'] = '2048';
					$config['max_width'] = '800';
					$config['max_height'] = '800';
					$config['overwrite'] = FALSE;
					$config['remove_spaces'] = TRUE;
					$this->load->library('upload', $config);

					if ( ! $this->upload->do_upload())
					{
						$error = array('error' => $this->upload->display_errors());
						$_POST['newimagen'] = 'sinImagen.png';
						$this->phpsession->flashsave('error_upload', $error);
						$this->phpsession->flashsave('insert_message', 'Error #2422: No se pudo crear el producto; por favor contacte a su administrador.');
						redirect('admin/tienda/producto/alta');
					}
					else
					{
						$imagen = $this->upload->data();
						$_POST['newimagen'] = $imagen['file_name'];
						$configu['image_library'] = 'gd2';
						$configu['source_image'] = $imagen['full_path'];
						$configu['maintain_ratio'] = FALSE;
						$configu['width'] = 175;
						$configu['height'] = 175;
						$this->load->library('image_lib',$configu);
						$this->image_lib->resize();
					}
					
					$producto = datosInsertar('alta_producto',$idTienda);
					//$producto = datosInsertar('alta_producto_imagen',$idTienda);
					$insertar = $this->db->insert('producto', $producto);
					
					if($insertar){
					$this->phpsession->flashsave('insert_message', 'El producto se ha creado con éxito.');
					redirect("admin/tienda/producto/alta");
					}else{
					$this->phpsession->flashsave('insert_message', 'Error #2420: No se pudo crear el producto; por favor contacte a su administrador.');
					redirect('admin/tienda/producto/alta');
					}
					}
				break;

				case 'ADMINISTRADOR':
					
					
					$rules = reglasInsertar('alta_producto');
					$this->form_validation->set_rules($rules); 
					
					if($this->form_validation->run() == FALSE){
					$this->load->view('admin/altas_consultas',$data);
					
					}else{
					
					$idTienda = $tienda['idTienda'];
					
					
					$config['upload_path'] = './productos_img/';
					$config['allowed_types'] = 'gif|jpg|png';
					$config['max_size'] = '2048';
					$config['max_width'] = '800';
					$config['max_height'] = '800';
					$config['overwrite'] = FALSE;
					$config['remove_spaces'] = TRUE;
					$this->load->library('upload', $config);

					if ( ! $this->upload->do_upload())
					{
						$error = array('error' => $this->upload->display_errors());
						$_POST['newimagen'] = 'sinImagen.png';
						$this->phpsession->flashsave('error_upload', $error);
						$this->phpsession->flashsave('insert_message', 'Error #2422: No se pudo crear el producto; por favor contacte a su administrador.');
						redirect('admin/tienda/producto/alta');
					}
					else
					{
						$imagen = $this->upload->data();
						$_POST['newimagen'] = $imagen['file_name'];
						$configu['image_library'] = 'gd2';
						$configu['source_image'] = $imagen['full_path'];
						$configu['maintain_ratio'] = FALSE;
						$configu['width'] = 175;
						$configu['height'] = 175;
						$this->load->library('image_lib',$configu);
						$this->image_lib->resize();
					}
					
					$producto = datosInsertar('alta_producto',$idTienda);
					//$producto = datosInsertar('alta_producto_imagen',$idTienda);
					$insertar = $this->db->insert('producto', $producto);
					
					if($insertar){
					$this->phpsession->flashsave('insert_message', 'El producto se ha creado con éxito.');
					redirect("admin/tienda/producto/alta");
					}else{
					$this->phpsession->flashsave('insert_message', 'Error #2420: No se pudo crear el producto; por favor contacte a su administrador.');
					redirect('admin/tienda/producto/alta');
					}
					}
				break;
				}
			break;
			case "consulta":


				switch($rol){
				default:
					show_404();
				break;
				case 'PRODUCTO_VIDEO':
				case 'PRODUCTO_PRECIO':
				case 'PRODUCTO_INFORMACION_GENERAL':
				case 'PRODUCTO_INFORMACION_INGREDIENTES':
				case 'ADMINISTRADOR':
					$data['seccion'] = "consulta_producto";
					$data['rol'] = $rol;
					if($cliente_url == 'none'){
						$this->db->order_by('categoria.nombre asc,subcategoria.nombre,producto.nombre asc');
						$this->db->where(array('categoria.Tienda_idTienda'=>$tienda['idTienda']));
						$this->db->select('idCategoria,categoria.nombre as catnombre,categoria.activo as catactivo,idSubcategoria,subcategoria.nombre as subcatnombre,subcategoria.activo as subcatactivo,idProducto,producto.nombre,producto.uso,producto.imagen,producto.activo as produactivo,SubCategoria_idSubCategoria');
						$this->db->from('producto');
						$this->db->join('subcategoria','subcategoria.idSubCategoria = producto.Subcategoria_idSubCategoria');
						$this->db->join('categoria','categoria.idCategoria = subcategoria.Categoria_idCategoria');
						$data['consulta'] = $this->db->get();
					}
					$this->load->view('admin/altas_consultas',$data);
					
				break;
			}
			break;
			case "desactivar":
				switch($rol){
				default:
					show_404();
				break;
				case 'PRODUCTO_INFORMACION_GENERAL':
				case 'ADMINISTRADOR':
					if($cliente_url == 'none' ){
						redirect('admin/tienda/producto/consulta');
					}
					$this->db->where('idProducto', $cliente_url);
					$update = $this->db->update('producto', array('activo'=>'NO'));
					redirect('admin/tienda/producto/consulta');
				break;
				}
			break;
			case "activar":
				switch($rol){
				default:
					show_404();
				break;
				case 'PRODUCTO_INFORMACION_GENERAL':
				case 'ADMINISTRADOR':
					if($cliente_url == 'none' ){
						redirect('admin/tienda/producto/consulta');
					}
					$this->db->where('idProducto', $cliente_url);
					$update = $this->db->update('producto', array('activo'=>'SI'));
					redirect('admin/tienda/producto/consulta');
				break;
				}
			break;
			case "ver":
				switch($rol){
				default:
					show_404();
				break;
				case 'PRODUCTO_PRECIO':
				case 'PRODUCTO_VIDEO':
				case 'PRODUCTO_INFORMACION_GENERAL':
				case 'PRODUCTO_INFORMACION_INGREDIENTES':
				case 'ADMINISTRADOR':
					$data['seccion'] = "ver_producto";
					$data['rol'] = $rol;
					$this->db->where(array('producto.idProducto'=>$cliente_url));
					$this->db->select('*,idCategoria,categoria.nombre as catnombre,categoria.activo as catactivo,idSubcategoria,subcategoria.nombre as subcatnombre,subcategoria.activo as subcatactivo,idProducto,producto.nombre,producto.uso,producto.imagen,producto.activo as produactivo,SubCategoria_idSubCategoria,,producto.uso_en as uso_ingles');
					$this->db->from('producto');
					$this->db->join('subcategoria','subcategoria.idSubCategoria = producto.Subcategoria_idSubCategoria');
					$this->db->join('categoria','categoria.idCategoria = subcategoria.Categoria_idCategoria');
					$data['consulta'] = $this->db->get();
					
					$this->load->view('admin/altas_consultas',$data);
					
				break;
			}
			break;
			case "editar":
				switch($rol){
				default:
					show_404();
				break;
				case 'PRODUCTO_INFORMACION_GENERAL':
				case 'ADMINISTRADOR':
					if($cliente_url == 'none' ){
						redirect('admin/tienda/producto/consulta');
					}
					//$buscar = str_replace('_',' ',$cliente_url);
					
					$sql = $this->db->get_where('producto', array('idProducto'=>$cliente_url));
					if($sql->num_rows() < 1){
						redirect ('tienda/producto/consulta');
					}
					$data['consultaUno'] = $sql;

					$data['seccion'] = "alta_producto";
					$data['rol'] = $rol;
					$this->db->order_by('idCategoria','asc');
					$cat = $this->db->get_where('categoria',array('Tienda_idTienda'=>$tienda['idTienda'],'activo'=>'SI'));
					$optgroup;
					foreach($cat->result() as $arreglo){
						$optgroup[$arreglo->idCategoria]['nombre'] = $arreglo->nombre;
						$subcat = $this->db->get_where('subcategoria',array('Categoria_idCategoria'=>$arreglo->idCategoria,'activo'=>'SI'));
						foreach($subcat->result() as $arreglo1){
							$optgroup[$arreglo->idCategoria][$arreglo1->idSubcategoria]['value'] = $arreglo1->idSubcategoria;
							$optgroup[$arreglo->idCategoria][$arreglo1->idSubcategoria]['nombre'] = $arreglo1->nombre;
						}
					}
					$data['consultaDos'] = $optgroup;
					$data['consultaTres'] = $sql;
					$data['seccion'] = "dos_editar_producto";
					$data['rol'] = $rol;
					$rules = reglasInsertar('editar_producto');
					//$cliente_temp = datosCliente($sql);
					$this->form_validation->set_rules($rules); 
					if($this->form_validation->run() == FALSE){
					$this->load->view('admin/altas_consultas',$data);
					
					}else{
					
					$idTienda = $tienda['idTienda'];
					
					$config['upload_path'] = './productos_img/';
					$config['allowed_types'] = 'gif|jpg|png';
					$config['max_size'] = '2048';
					$config['max_width'] = '800';
					$config['max_height'] = '800';
					$config['overwrite'] = FALSE;
					$config['remove_spaces'] = TRUE;
					$this->load->library('upload', $config);

					foreach($sql->result() as $producto_temp){
						$img_temp = $producto_temp->imagen;
					}

					if ( ! $this->upload->do_upload())
					{
						$error = array('error' => $this->upload->display_errors());
						$_POST['newimagen'] = $img_temp;
						$this->phpsession->flashsave('error_upload', $error);
						//redirect('admin/tienda/producto/alta');
					}
					else
					{
						$imagen = $this->upload->data();
						$_POST['newimagen'] = $imagen['file_name'];
						$configu['image_library'] = 'gd2';
						$configu['source_image'] = $imagen['full_path'];
						$configu['maintain_ratio'] = FALSE;
						$configu['width'] = 175;
						$configu['height'] = 175;
						$this->load->library('image_lib',$configu);
						$this->image_lib->resize();
					}
					
					$producto = datosInsertar('alta_producto',$idTienda);
					$this->db->where('idProducto', $cliente_url);
					$update = $this->db->update('producto',$producto);
					if($update){
					
					$this->phpsession->flashsave('update_message', "El producto se ha actualizado con éxito.");
					redirect("admin/tienda/producto/consulta");
					}else{
					$this->phpsession->flashsave('update_message', 'Error #2420: No se pudo actualizar el producto; por favor contacte a su administrador.');
					redirect("admin/tienda/producto/editar/$cliente_url");
					}
					}
				break;
				}
			break;
			case 'excel':

				$campos = "*,
							categoria.nombre as catnombre,
							subcategoria.nombre as subcatnombre,
							producto.nombre as produnombre,
							presentacion.activo as active";
				$this->db->select($campos);
				$this->db->order_by('categoria.nombre asc,subcategoria.nombre asc,producto.nombre asc');
				$this->db->where(array('categoria.Tienda_idTienda'=>$tienda['idTienda']));
				$this->db->from('presentacion');
				$this->db->join('producto','presentacion.Producto_idProducto = producto.idProducto');
				$this->db->join('subcategoria','subcategoria.idSubCategoria = producto.Subcategoria_idSubCategoria');
				$this->db->join('categoria','categoria.idCategoria = subcategoria.Categoria_idCategoria');
				$query=$this->db->get();

				$this->load->helper('excel');
				producto_excel_html($query, 'listadoproductos');
				/*foreach ($query->result() as $key) {
					echo $key->nombre.'<br/>';
				}*/
			break;
			default:
				show_404();
			break;
		
		}
	}
	
	public function presentacion($seccion = "producto",$cliente_url='none')
	{
		$tienda_cookie = $_SESSION['userdata']['tienda'];
		$consulta_tienda = $this->db->get_where('tienda',array('idTienda' => $tienda_cookie));
		$tienda = datosTienda($consulta_tienda);
		$data['nombre_tienda'] = $tienda['nombre'];
		$data['idTienda'] = $tienda['idTienda'];
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
		switch($seccion){
			case "producto":
				switch($rol){
				default:
					show_404();
				break;
				case 'PRODUCTO_VIDEO':
				case 'PRODUCTO_PRECIO':
				case 'PRODUCTO_INFORMACION_GENERAL':
				case 'PRODUCTO_INFORMACION_INGREDIENTES':
				case 'ADMINISTRADOR':
					$data['seccion'] = $seccion;
					$data['rol'] = $rol;
					$this->load->view('admin/altas_consultas',$data);
				break;
			}
			break;
			case "alta":
				$data['seccion'] = "alta_presentacion";
				$data['rol'] = $rol;
				$this->db->where(array('categoria.Tienda_idTienda'=>$tienda['idTienda'],'producto.activo'=>'SI','categoria.activo'=>'SI','subcategoria.activo'=>'SI'));
				$this->db->select('idCategoria,categoria.nombre as catnombre,categoria.activo as catactivo,idSubcategoria,subcategoria.nombre as subcatnombre,subcategoria.activo as subcatactivo,idProducto,producto.nombre,producto.uso,producto.imagen,producto.activo as produactivo,SubCategoria_idSubCategoria');
				$this->db->from('producto');
				$this->db->join('subcategoria','subcategoria.idSubCategoria = producto.Subcategoria_idSubCategoria');
				$this->db->join('categoria','categoria.idCategoria = subcategoria.Categoria_idCategoria');
				$cat = $this->db->get();
				foreach($cat->result() as $arreglo){
					$optgroup[$arreglo->idSubcategoria]['nombre'] = $arreglo->subcatnombre;
					$subcat = $this->db->get_where('producto',array('Subcategoria_idSubCategoria'=>$arreglo->idSubcategoria,'activo'=>'SI'));
				foreach($subcat->result() as $arreglo1){
						$optgroup[$arreglo->idSubcategoria][$arreglo1->idProducto]['value'] = $arreglo1->idProducto;
						$optgroup[$arreglo->idSubcategoria][$arreglo1->idProducto]['nombre'] = $arreglo1->nombre;
					}
				}
				$data['consulta'] = $optgroup;

				switch($rol){
				default:
					show_404();
				break;
				

				case 'PRODUCTO_INFORMACION_GENERAL':
					$rules = reglasInsertar('alta_presentacion_info');
					$this->form_validation->set_rules($rules); 
					if($this->form_validation->run() == FALSE){
					$this->load->view('admin/altas_consultas',$data);
					}else{
					
					$idTienda = $tienda['idTienda'];

					$config['upload_path'] = './productos_img/';
					$config['allowed_types'] = 'gif|jpg|png';
					$config['max_size'] = '2048';
					$config['max_width'] = '800';
					$config['max_height'] = '800';
					$config['overwrite'] = FALSE;
					$config['remove_spaces'] = TRUE;
					$this->load->library('upload', $config);

					if ( ! $this->upload->do_upload())
					{
						$error = array('error' => $this->upload->display_errors());
						$_POST['newimagen'] = 'sinImagen.png';
						$this->phpsession->flashsave('error_upload', $error);
						$this->phpsession->flashsave('insert_message', 'Error #2422: No se pudo crear la presentación; por favor contacte a su administrador.');
						redirect('admin/tienda/presentacion/alta');
					}
					else
					{
						$imagen = $this->upload->data();
						$_POST['newimagen'] = $imagen['file_name'];
						$configu['image_library'] = 'gd2';
						$configu['source_image'] = $imagen['full_path'];
						$configu['maintain_ratio'] = FALSE;
						$configu['width'] = 175;
						$configu['height'] = 175;
						$this->load->library('image_lib',$configu);
						$this->image_lib->resize();
					}

					$presentacion = datosInsertar('alta_presentacion_info',$idTienda);
					$insertar = $this->db->insert('presentacion', $presentacion);
					
					if($insertar){
					$this->phpsession->flashsave('insert_message', 'La presentación se ha creado con éxito.');
					 redirect("admin/tienda/presentacion/alta");
					}else{

					$this->phpsession->flashsave('insert_message', 'Error #2420: No se pudo crear la presentación; por favor contacte a su administrador.');
					redirect('admin/tienda/presentacion/alta');
					
					}
					
					}
				break;
				case 'ADMINISTRADOR':
					
					$rules = reglasInsertar('alta_presentacion_admin');
					$this->form_validation->set_rules($rules); 
					if($this->form_validation->run() == FALSE){
					$this->load->view('admin/altas_consultas',$data);
					}else{
					
					$idTienda = $tienda['idTienda'];

					$config['upload_path'] = './productos_img/';
					$config['allowed_types'] = 'gif|jpg|png';
					$config['max_size'] = '2048';
					$config['max_width'] = '800';
					$config['max_height'] = '800';
					$config['overwrite'] = FALSE;
					$config['remove_spaces'] = TRUE;
					$this->load->library('upload', $config);

					if ( ! $this->upload->do_upload())
					{
						$error = array('error' => $this->upload->display_errors());
						$_POST['newimagen'] = 'sinImagen.png';
						$this->phpsession->flashsave('error_upload', $error);
						$this->phpsession->flashsave('insert_message', 'Error #2422: No se pudo crear la presentación; por favor contacte a su administrador.');
						redirect('admin/tienda/presentacion/alta');
					}
					else
					{
						$imagen = $this->upload->data();
						$_POST['newimagen'] = $imagen['file_name'];
						$configu['image_library'] = 'gd2';
						$configu['source_image'] = $imagen['full_path'];
						$configu['maintain_ratio'] = FALSE;
						$configu['width'] = 175;
						$configu['height'] = 175;
						$this->load->library('image_lib',$configu);
						$this->image_lib->resize();
					}

					$presentacion = datosInsertar('alta_presentacion_admin',$idTienda);
					$insertar = $this->db->insert('presentacion', $presentacion);
					
					if($insertar){
					$this->phpsession->flashsave('insert_message', 'La presentación se ha creado con éxito.');
					 redirect("admin/tienda/presentacion/alta");
					}else{

					$this->phpsession->flashsave('insert_message', 'Error #2420: No se pudo crear la presentación; por favor contacte a su administrador.');
					redirect('admin/tienda/presentacion/alta');
					
					}
					
					}
				break;
			}
			break;
			case "consulta":
				switch($rol){
				default:
					show_404();
				break;
				case 'PRODUCTO_INFORMACION_GENERAL':
				case 'PRODUCTO_INFORMACION_INGREDIENTES':
				case 'PRODUCTO_PRECIO':
				case 'PRODUCTO_VIDEO':
				case 'ADMINISTRADOR':
					$data['seccion'] = "consulta_presentacion";
					$data['rol'] = $rol;
					if($cliente_url == 'none'){
						$this->db->order_by('producto.nombre asc');
						$this->db->where(array('categoria.Tienda_idTienda'=>$tienda['idTienda']));
						$this->db->select('idPresentacion,presentacion.clave,producto.nombre as nombre_producto,presentacion.estado_fisico,presentacion.contenido_neto,presentacion.iva,presentacion.precio_publico,presentacion.activo,presentacion.ingredientes,presentacion.imagen,presentacion.video,presentacion.grupo');
						$this->db->from('presentacion');
						$this->db->join('producto','producto.idProducto = presentacion.Producto_idProducto');
						$this->db->join('subcategoria','subcategoria.idSubCategoria = producto.Subcategoria_idSubCategoria');
						$this->db->join('categoria','categoria.idCategoria = subcategoria.Categoria_idCategoria');
						$data['consulta'] = $this->db->get();
					}else{

						//$data['consulta'] = $this->db->get_where('subcategoria',array('Categoria_idCategoria'=>$cliente_url));
						$this->db->order_by('producto.nombre asc');
						$this->db->where(array('presentacion.Producto_idProducto'=>$cliente_url));
						$this->db->select('idPresentacion,presentacion.clave,producto.nombre as nombre_producto,presentacion.estado_fisico,presentacion.contenido_neto,presentacion.iva,presentacion.precio_publico,presentacion.activo,presentacion.ingredientes,presentacion.imagen,presentacion.video,presentacion.grupo');
						$this->db->from('presentacion');
						$this->db->join('producto','producto.idProducto = presentacion.Producto_idProducto');
						$this->db->join('subcategoria','subcategoria.idSubCategoria = producto.Subcategoria_idSubCategoria');
						$this->db->join('categoria','categoria.idCategoria = subcategoria.Categoria_idCategoria');
						$data['consulta'] = $this->db->get();
					}
					$this->load->view('admin/altas_consultas',$data);
					
				break;
			}
			break;
			case "desactivar":
				switch($rol){
				default:
					show_404();
				break;
				case 'PRODUCTO_INFORMACION_GENERAL':
				case 'ADMINISTRADOR':
					if($cliente_url == 'none' ){
						redirect('admin/tienda/presentacion/consulta');
					}
					$this->db->where('idPresentacion', $cliente_url);
					$update = $this->db->update('presentacion', array('activo'=>'NO'));
					redirect($_SERVER['HTTP_REFERER']);
				break;
				}
			break;
			case "activar":
				switch($rol){
				default:
					show_404();
				break;
				case 'PRODUCTO_INFORMACION_GENERAL':
				case 'ADMINISTRADOR':
					if($cliente_url == 'none' ){
						redirect('admin/tienda/presentacion/consulta');
					}
					$this->db->where('idPresentacion', $cliente_url);
					$update = $this->db->update('presentacion', array('activo'=>'SI'));
					redirect($_SERVER['HTTP_REFERER']);
				break;
				}
			break;
			case "ver":
				switch ($rol) {
				default:
					# code...
				break;
				case 'PRODUCTO_INFORMACION_GENERAL':	
				case 'PRODUCTO_INFORMACION_INGREDIENTES':	
				case 'PRODUCTO_PRECIO':	
				case 'PRODUCTO_VIDEO':	
				case 'ADMINISTRADOR':
					$data['seccion'] = "dos_ver_presentacion";
					$data['rol'] = $rol;
					$this->db->where(array('presentacion.idPresentacion'=>$cliente_url));
					$this->db->select('idPresentacion,presentacion.clave,producto.nombre as nombre_producto,presentacion.estado_fisico,presentacion.contenido_neto,presentacion.iva,presentacion.precio_publico,presentacion.activo,presentacion.ingredientes,presentacion.imagen,presentacion.video,presentacion.grupo,presentacion.video_en,presentacion.contenido_neto_en,presentacion.estado_fisico_en');
					$this->db->from('presentacion');
					$this->db->join('producto','producto.idProducto = presentacion.Producto_idProducto');
					$this->db->join('subcategoria','subcategoria.idSubCategoria = producto.Subcategoria_idSubCategoria');
					$this->db->join('categoria','categoria.idCategoria = subcategoria.Categoria_idCategoria');
					$data['consultaUno'] = $this->db->get();
					$data['consultaDos'] = $this->db->get_where('tipocliente',array('Tienda_idTienda'=>$tienda['idTienda'],'activo'=>'SI'));
					$data['consultaTres'] = "none";
					$data['consulta'] = "none";
				
					$this->load->view('admin/altas_consultas',$data);
				break;	
				}
			break;
			case "editar":
				if($cliente_url == 'none' ){
						redirect('admin/tienda/categoria/consulta');
					}
					//$buscar = str_replace('_',' ',$cliente_url);
					$this->db->where(array('presentacion.idPresentacion'=>$cliente_url));
					$this->db->select('idPresentacion,presentacion.clave,producto.nombre as nombre_producto,presentacion.estado_fisico,presentacion.contenido_neto,presentacion.iva,presentacion.precio_publico,presentacion.activo,presentacion.ingredientes,presentacion.imagen,presentacion.video,presentacion.grupo,presentacion.Producto_idProducto,presentacion.video_en,presentacion.contenido_neto_en,presentacion.estado_fisico_en');
					$this->db->from('presentacion');
					$this->db->join('producto','producto.idProducto = presentacion.Producto_idProducto');
					$this->db->join('subcategoria','subcategoria.idSubCategoria = producto.Subcategoria_idSubCategoria');
					$this->db->join('categoria','categoria.idCategoria = subcategoria.Categoria_idCategoria');
					$sql = $this->db->get();

					if($sql->num_rows() < 1){
						redirect ('tienda/presentacion/consulta');
					}
					
					$data['consultaUno'] = $sql;
					$data['consultaDos'] = $this->db->get_where('tipocliente',array('Tienda_idTienda'=>$tienda['idTienda'],'activo'=>'SI'));
					
					$this->db->where(array('categoria.Tienda_idTienda'=>$tienda['idTienda'],'producto.activo'=>'SI','categoria.activo'=>'SI','subcategoria.activo'=>'SI'));
					$this->db->select('idCategoria,categoria.nombre as catnombre,categoria.activo as catactivo,idSubcategoria,subcategoria.nombre as subcatnombre,subcategoria.activo as subcatactivo,idProducto,producto.nombre,producto.uso,producto.imagen,producto.activo as produactivo,SubCategoria_idSubCategoria');
					$this->db->from('producto');
					$this->db->join('subcategoria','subcategoria.idSubCategoria = producto.Subcategoria_idSubCategoria');
					$this->db->join('categoria','categoria.idCategoria = subcategoria.Categoria_idCategoria');
					$data['consultaTres'] = $this->db->get();
					
					$data['seccion'] = "dos_editar_presentacion";
					$data['rol'] = $rol;
				switch($rol){
				default:
					show_404();
				break;
				case 'PRODUCTO_INFORMACION_GENERAL':
					$rules = reglasInsertar('editar_presentacion_info');
					//$cliente_temp = datosCliente($sql);
					$this->form_validation->set_rules($rules); 
					if($this->form_validation->run() == FALSE){
					$this->load->view('admin/altas_consultas',$data);
					}else{
					$idTienda = $tienda['idTienda'];
					$config['upload_path'] = './productos_img/';
					$config['allowed_types'] = 'gif|jpg|png';
					$config['max_size'] = '2048';
					$config['max_width'] = '800';
					$config['max_height'] = '800';
					$config['overwrite'] = FALSE;
					$config['remove_spaces'] = TRUE;
					$this->load->library('upload', $config);

					foreach($sql->result() as $producto_temp){
						$img_temp = $producto_temp->imagen;
					}

					if ( ! $this->upload->do_upload())
					{
						$error = array('error' => $this->upload->display_errors());
						$_POST['newimagen'] = $img_temp;
						$this->phpsession->flashsave('error_upload', $error);
						//redirect('admin/tienda/producto/alta');
					}
					else
					{
						$imagen = $this->upload->data();
						$_POST['newimagen'] = $imagen['file_name'];
						$configu['image_library'] = 'gd2';
						$configu['source_image'] = $imagen['full_path'];
						$configu['maintain_ratio'] = FALSE;
						$configu['width'] = 175;
						$configu['height'] = 175;
						$this->load->library('image_lib',$configu);
						$this->image_lib->resize();
					}
					$presentacion = datosInsertar('editar_presentacion_info',$idTienda);
					$this->db->where('idPresentacion', $cliente_url);
					$update = $this->db->update('presentacion',$presentacion);
					if($update){
					
					$this->phpsession->flashsave('update_message', "La presentación se ha actualizado con éxito.");
					redirect("admin/tienda/presentacion/consulta");
					}else{
					$this->phpsession->flashsave('update_message', 'Error #2420: No se pudo actualizar la presentación; por favor contacte a su administrador.');
					redirect("admin/tienda/presentacion/editar/$cliente_url");
					}
					}
				break;
				case 'PRODUCTO_INFORMACION_INGREDIENTES':
					$rules = reglasInsertar('editar_presentacion_info_ingredientes');
					//$cliente_temp = datosCliente($sql);
					$this->form_validation->set_rules($rules); 
					if($this->form_validation->run() == FALSE){
					$this->load->view('admin/altas_consultas',$data);
					}else{
					$idTienda = $tienda['idTienda'];
					$config['upload_path'] = './productos_img/';
					$config['allowed_types'] = 'gif|jpg|png';
					$config['max_size'] = '2048';
					$config['max_width'] = '800';
					$config['max_height'] = '800';
					$config['overwrite'] = FALSE;
					$config['remove_spaces'] = TRUE;
					$this->load->library('upload', $config);

					foreach($sql->result() as $producto_temp){
						$img_temp = $producto_temp->imagen;
					}

					if ( ! $this->upload->do_upload())
					{
						$error = array('error' => $this->upload->display_errors());
						$_POST['newimagen'] = $img_temp;
						$this->phpsession->flashsave('error_upload', $error);
						//redirect('admin/tienda/producto/alta');
					}
					else
					{
						$imagen = $this->upload->data();
						$_POST['newimagen'] = $imagen['file_name'];
						$configu['image_library'] = 'gd2';
						$configu['source_image'] = $imagen['full_path'];
						$configu['maintain_ratio'] = FALSE;
						$configu['width'] = 175;
						$configu['height'] = 175;
						$this->load->library('image_lib',$configu);
						$this->image_lib->resize();
					}
					$presentacion = datosInsertar('editar_presentacion_info_ingredientes',$idTienda);
					$this->db->where('idPresentacion', $cliente_url);
					$update = $this->db->update('presentacion',$presentacion);
					if($update){
					
					$this->phpsession->flashsave('update_message', "La presentación se ha actualizado con éxito.");
					redirect("admin/tienda/presentacion/consulta");
					}else{
					$this->phpsession->flashsave('update_message', 'Error #2420: No se pudo actualizar la presentación; por favor contacte a su administrador.');
					redirect("admin/tienda/presentacion/editar/$cliente_url");
					}
					}
				break;
				case 'PRODUCTO_PRECIO':
					$rules = reglasInsertar('editar_presentacion_precio');
					//$cliente_temp = datosCliente($sql);
					$this->form_validation->set_rules($rules); 
					if($this->form_validation->run() == FALSE){
					$this->load->view('admin/altas_consultas',$data);
					}else{
					$idTienda = $tienda['idTienda'];
					$config['upload_path'] = './productos_img/';
					$config['allowed_types'] = 'gif|jpg|png';
					$config['max_size'] = '2048';
					$config['max_width'] = '800';
					$config['max_height'] = '800';
					$config['overwrite'] = FALSE;
					$config['remove_spaces'] = TRUE;
					$this->load->library('upload', $config);

					foreach($sql->result() as $producto_temp){
						$img_temp = $producto_temp->imagen;
					}

					if ( ! $this->upload->do_upload())
					{
						$error = array('error' => $this->upload->display_errors());
						$_POST['newimagen'] = $img_temp;
						$this->phpsession->flashsave('error_upload', $error);
						//redirect('admin/tienda/producto/alta');
					}
					else
					{
						$imagen = $this->upload->data();
						$_POST['newimagen'] = $imagen['file_name'];
						$configu['image_library'] = 'gd2';
						$configu['source_image'] = $imagen['full_path'];
						$configu['maintain_ratio'] = FALSE;
						$configu['width'] = 175;
						$configu['height'] = 175;
						$this->load->library('image_lib',$configu);
						$this->image_lib->resize();
					}
					$presentacion = datosInsertar('editar_presentacion_precio',$idTienda);
					$this->db->where('idPresentacion', $cliente_url);
					$update = $this->db->update('presentacion',$presentacion);
					if($update){
					
					$this->phpsession->flashsave('update_message', "La presentación se ha actualizado con éxito.");
					redirect("admin/tienda/presentacion/consulta");
					}else{
					$this->phpsession->flashsave('update_message', 'Error #2420: No se pudo actualizar la presentación; por favor contacte a su administrador.');
					redirect("admin/tienda/presentacion/editar/$cliente_url");
					}
					}
				break;
				case 'PRODUCTO_VIDEO':
					$rules = reglasInsertar('editar_presentacion_video');
					//$cliente_temp = datosCliente($sql);
					$this->form_validation->set_rules($rules); 
					if($this->form_validation->run() == FALSE){
					$this->load->view('admin/altas_consultas',$data);
					}else{
					$idTienda = $tienda['idTienda'];
					$config['upload_path'] = './productos_img/';
					$config['allowed_types'] = 'gif|jpg|png';
					$config['max_size'] = '2048';
					$config['max_width'] = '800';
					$config['max_height'] = '800';
					$config['overwrite'] = FALSE;
					$config['remove_spaces'] = TRUE;
					$this->load->library('upload', $config);

					foreach($sql->result() as $producto_temp){
						$img_temp = $producto_temp->imagen;
					}

					if ( ! $this->upload->do_upload())
					{
						$error = array('error' => $this->upload->display_errors());
						$_POST['newimagen'] = $img_temp;
						$this->phpsession->flashsave('error_upload', $error);
						//redirect('admin/tienda/producto/alta');
					}
					else
					{
						$imagen = $this->upload->data();
						$_POST['newimagen'] = $imagen['file_name'];
						$configu['image_library'] = 'gd2';
						$configu['source_image'] = $imagen['full_path'];
						$configu['maintain_ratio'] = FALSE;
						$configu['width'] = 175;
						$configu['height'] = 175;
						$this->load->library('image_lib',$configu);
						$this->image_lib->resize();
					}
					$presentacion = datosInsertar('editar_presentacion_video',$idTienda);
					$this->db->where('idPresentacion', $cliente_url);
					$update = $this->db->update('presentacion',$presentacion);
					if($update){
					
					$this->phpsession->flashsave('update_message', "La presentación se ha actualizado con éxito.");
					redirect("admin/tienda/presentacion/consulta");
					}else{
					$this->phpsession->flashsave('update_message', 'Error #2420: No se pudo actualizar la presentación; por favor contacte a su administrador.');
					redirect("admin/tienda/presentacion/editar/$cliente_url");
					}
					}
				break;
				case 'ADMINISTRADOR':
					
					$rules = reglasInsertar('editar_presentacion_admin');
					//$cliente_temp = datosCliente($sql);
					$this->form_validation->set_rules($rules); 
					if($this->form_validation->run() == FALSE){
					$this->load->view('admin/altas_consultas',$data);
					}else{
					$idTienda = $tienda['idTienda'];
					$config['upload_path'] = './productos_img/';
					$config['allowed_types'] = 'gif|jpg|png';
					$config['max_size'] = '2048';
					$config['max_width'] = '800';
					$config['max_height'] = '800';
					$config['overwrite'] = FALSE;
					$config['remove_spaces'] = TRUE;
					$this->load->library('upload', $config);

					foreach($sql->result() as $producto_temp){
						$img_temp = $producto_temp->imagen;
					}

					if ( ! $this->upload->do_upload())
					{
						$error = array('error' => $this->upload->display_errors());
						$_POST['newimagen'] = $img_temp;
						$this->phpsession->flashsave('error_upload', $error);
						//redirect('admin/tienda/producto/alta');
					}
					else
					{
						$imagen = $this->upload->data();
						$_POST['newimagen'] = $imagen['file_name'];
						$configu['image_library'] = 'gd2';
						$configu['source_image'] = $imagen['full_path'];
						$configu['maintain_ratio'] = FALSE;
						$configu['width'] = 175;
						$configu['height'] = 175;
						$this->load->library('image_lib',$configu);
						$this->image_lib->resize();
					}
					$presentacion = datosInsertar('editar_presentacion_admin',$idTienda);
					$this->db->where('idPresentacion', $cliente_url);
					$update = $this->db->update('presentacion',$presentacion);
					if($update){
					
					$this->phpsession->flashsave('update_message', "La presentación se ha actualizado con éxito.");
					redirect("admin/tienda/presentacion/consulta");
					}else{
					$this->phpsession->flashsave('update_message', 'Error #2420: No se pudo actualizar la presentación; por favor contacte a su administrador.');
					redirect("admin/tienda/presentacion/editar/$cliente_url");
					}
					}
				break;
				}
			break;
			case promocion:
				$data['seccion'] = "consulta_promocion";
					$data['rol'] = $rol;
					//$data['consulta'] = $this->db->get_where('subcategoria',array('Categoria_idCategoria'=>$cliente_url));
					
					$this->db->where(array('presentacion.idPresentacion'=>$cliente_url));
					$this->db->select('*,idPresentacion,presentacion.clave,producto.nombre as nombre_producto,presentacion.estado_fisico,presentacion.contenido_neto,presentacion.iva,presentacion.precio_publico,presentacion.activo,presentacion.ingredientes,presentacion.imagen,presentacion.video,presentacion.grupo');
					$this->db->from('presentacion');
					$this->db->join('producto','producto.idProducto = presentacion.Producto_idProducto');
					$this->db->join('subcategoria','subcategoria.idSubCategoria = producto.Subcategoria_idSubCategoria');
					$this->db->join('categoria','categoria.idCategoria = subcategoria.Categoria_idCategoria');
					$this->db->join('promociones','promociones.Presentacion_idPresentacion = presentacion.idPresentacion');
					$data['consulta'] = $this->db->get();
					
					$this->form_validation->set_rules(reglasInsertar('promocion'));
					if($this->form_validation->run() == FALSE){

						$this->load->view('admin/altas_consultas',$data);
					}else{
						//$datos = datosInsertar('promocion');
						if($_POST['fecha_inicio'] <= $_POST['fecha_final']){

							$promocion = datosInsertar('promocion');
							$this->db->insert('promociones',$promocion);
							$this->phpsession->flashsave('insert_message', 'La promoción se ha creado con éxito.');
							redirect($_SERVER['HTTP_REFERER']);
							/*echo '<pre>';
							print_r($promocion);*/
						}else{
							$this->phpsession->flashsave('insert_message', 'Error #2420: No se pudo crear la promoción; por favor contacte a su administrador.');
							redirect($_SERVER['HTTP_REFERER']);
						}
					}
			break;
			default:
				show_404();
			break;
		
		}
		
	}



	public function terminar_sesion($secure_number1){
		$secure_number = $_SESSION['userdata']['secure_number'];
		$logged = $_SESSION['userdata']['logged'];
		if(!$logged){
			redirect('admin/dashboard');
		}
		$consulta_user = $this->db->get_where('usuario',array('secure_number' => $secure_number));
		$user = datosUser($consulta_user);
		$consulta_rol = $this->db->get_where('permiso',array('idPermiso'=>$user['permiso']));
		$rol = permisoUser($consulta_rol);
		if($rol == 'ADMINISTRADOR'){
		$consulta_user1= $this->db->get_where('cliente',array('secure_number' => $secure_number1));
		foreach($consulta_user1->result() as $user){
				
				$this->db->where('idCliente', $user->idCliente);
				$this->db->update('cliente', array('secure_number'=>NULL));  
			}
		redirect('admin/tienda/cliente/consulta');
		}
	}

	public function checkClient($user)
	{
		$id = $_POST['id'];
		$this->db->join('cliente','empresa.idEmpresa = cliente.Empresa_idEmpresa');
		$sql = $this->db->get_where('empresa',array('empresa.correo'=>$user,'idEmpresa !='=>$id,'cliente.activo'=>'SI'));
		
		if($sql->num_rows() < 1){
			return true;
		}else{
			$this->form_validation->set_message('checkClient', 'El campo %s contiene un mail que ya ha sido utilizado.');
			return false;
		}
	}

	public function checkFecha($fecha)
	{
		$id = $_POST['id'];
		$sql = $this->db->get_where('promociones',array('date_start'=>$fecha,'Presentacion_idPresentacion'=>$id));
		
		if($sql->num_rows() < 1){
			$sql1 = $this->db->get_where('promociones',array('date_end>'=>$fecha,'Presentacion_idPresentacion'=>$id));
			if($sql1->num_rows() < 1){
				return true;
			}else{
				$this->form_validation->set_message('checkFecha', 'El campo %s contiene una fecha que ya ha sido utilizada.');
				return false;
			}
			
		}else{
			$this->form_validation->set_message('checkFecha', 'El campo %s contiene una fecha que ya ha sido utilizada.');
			return false;
		}
	}
}

/* End of file tienda.php */
/* Location: ./application/controllers/tienda.php */