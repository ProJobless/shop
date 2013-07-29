<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tools extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/tools
	 *	- or -  
	 * 		http://example.com/index.php/tools/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/tools/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
         public function __construct() {
            parent::__construct();
            
            $this->load->helper('funciones_custom_helper');


        }
        
	public function index()
	{
		//$this->load->model('admin/clientes');
		$filas = file('../admin/archives/clientes_tab.txt');

		echo (empty($filas)) ? 'vacío' : 'lleno';

		$i=0;
		$numero_fila=0;

		

		while($filas[$i]!=NULL){ 
			
			// genero array con por medio del separador "," que es el que tiene el archivo txt
			$row = explode("	",$filas[$i]);

			$direccion= array(
						 	'calle' => $row[7],
						 	'numero_exterior' => 'S/I' ,
						 	'numero_interior' => 'S/I',
						 	'colonia' => $row[8],
						 	'delegacion' => $row[9],
						 	'codigo_postal' => $row[10],
						 	'ciudad' => $row[11],
						 	'estado' => $row[12],
						 	'pais' => $row[13]
						);
			$razon_social = (!empty($row[6])) ? $row[6] : ''.$row[2].' '.$row[3].'';
			

			//INSERTAMOS
			$this->db->insert('direccion',$direccion);
			$id_query = $this->db->query('select last_insert_id() as ultimo');
			foreach($id_query->result() as $id_query1){
				$id_direccion = $id_query1->ultimo;
				$empresa= array(
					'razon_social' => $razon_social,
					'correo' => $row[5],
					'Direccion_idDireccion' => $id_direccion
				);
				$this->db->insert('empresa',$empresa);
				$id_query2 = $this->db->query('select last_insert_id() as ultimo');
				foreach($id_query2->result() as $id_query3){
					if( ($row[22] == 'PC') || ($row[22] == 'C') || (empty($row[22])) ){
						$tipo_cliente = 3;
					}elseif($row[22] == 'MA'){
						$tipo_cliente = 6;
					}elseif($row[22] == 'MB'){
						$tipo_cliente = 7;
					}elseif($row[22] == 'RA'){
						$tipo_cliente = 8;
					}elseif($row[22] == 'RB'){
						$tipo_cliente = 9;
					}elseif($row[22] == 'RC'){
						$tipo_cliente = 10;
					}else{
						$tipo_cliente = 3;
					}
					$fechax = explode('/', $row[19]);
					$fecha = $fechax[2].'-'.$fechax[1].'-'.$fechax[0];
					$pass = (empty($row[18])) ? 'generico' : $row[18];
					$cliente=array(
									'idCliente' => $row[0],
									'nombre' => $row[2],
									'apellido' => $row[3],
									'contrasena' => $row[18],
									'fecha' => $fecha,
									'Tienda_idTienda' => 2,
									'Empresa_idEmpresa' => $id_query3->ultimo,
									'Direccion_idDireccion' => 1,
									'TipoCliente_idTipoCliente' => $tipo_cliente
								);
					$this->db->insert('cliente',$cliente);
					echo 'Insertado el cliente '.$row[2].' '.$row[3];

				}
			
			
			}
			// incrementamos contador
			$i++;
			$numero_fila++;
			// imprimimos datos en pantalla

			
			echo 'Id: '.$row[0].'<br/>';

			/*echo 'Nombre: '.$row[1].'<br/>';
			echo 'Apellidos: '.$row[2].'<br/>';
			echo 'Profesión: '.$row[3].'<br/>';
			echo 'Edad: '.$row[4].'<br/>';
			echo 'Ciudad: '.$row[5].'<br/><br/>'; */

			echo '<pre>';
			print_r($row);
			print_r($direccion);
			print_r($empresa);
			print_r($cliente);

		}
	}

	public function cliente(){
		$filas = file('../admin/archives/clientes_tab.txt');

		echo (empty($filas)) ? 'vacío' : 'lleno';

		$i=0;
		$numero_fila=0;

		

		while($filas[$i]!=NULL){ 
			$row = explode("	",$filas[$i]);
		if( ($row[22] == 'PC') || ($row[22] == 'C') || (empty($row[22])) ){
						$tipo_cliente = 3;
					}elseif($row[22] == 'MA'){
						$tipo_cliente = 6;
					}elseif($row[22] == 'MB'){
						$tipo_cliente = 7;
					}elseif($row[22] == 'RA'){
						$tipo_cliente = 8;
					}elseif($row[22] == 'RB'){
						$tipo_cliente = 9;
					}elseif($row[22] == 'RC'){
						$tipo_cliente = 10;
					}else{
						$tipo_cliente = 3;
					}
					$fechax = explode('/', $row[19]);
					$fecha = $fechax[2].'-'.$fechax[1].'-'.$fechax[0];
					$cliente=array(
									'idCliente' => $row[0],
									'nombre' => $row[2],
									'apellido' => $row[3],
									'contrasena' => $row[18],
									'Tienda_idTienda' => 2,
									'Empresa_idEmpresa' => 'OTRO',
									'Direccion_idDireccion' => 1,
									'fecha' => $fecha,
									'TipoCliente_idTipoCliente' => $tipo_cliente
								);
				
		$i++;
			$numero_fila++;
			echo '<pre>';
			print_r($row);
		print_r($cliente);
		}
	}

	public function pedidos(){

		$filas = file('../admin/archives/pedido.csv');

		echo (empty($filas)) ? 'vacío' : 'lleno';

		$i=0;
		$numero_fila=0;

		

		while($filas[$i]!=NULL){ 
			
			// genero array con por medio del separador "," que es el que tiene el archivo txt
			$row = explode(",",$filas[$i]);
			$rowi = str_replace('"', '', $row);
			$this->db->where(array('idCliente' => $rowi[1]));
			$this->db->select('*,cliente.nombre as nom_client,empresa.correo as emp_correo');
			$this->db->join('empresa','Empresa_idEmpresa = idEmpresa');
			$this->db->join('direccion','empresa.Direccion_idDireccion = idDireccion');
			$this->db->from('cliente');
			$cliente = $this->db->get();
			foreach($cliente->result() as $client){

				$tienda = $client->Tienda_idTienda;
				
				$factura = array(
							'razon_social' => $client->nom_client.' '.$client->apellido ,
							'rfc' => 'sinrfc',
							'Direccion_idDireccion' => $client->Direccion_idDireccion
							);
				$general = array(
							'nombre' => $client->nom_client.' '.$client->apellido ,
							'correo' => $client->emp_correo,
							'Direccion_idDireccion' => $client->Direccion_idDireccion
							);
				$envio = array(
							'persona_recibe' => $client->nom_client.' '.$client->apellido,
							'Direccion_idDireccion' => $client->Direccion_idDireccion
							);
				$this->db->insert('general',$general);
				$id_query = $this->db->query('select last_insert_id() as ultimo');
				foreach($id_query->result() as $id_query1){
					$id_general = $id_query1->ultimo;
				}
				$this->db->insert('factura',$factura);
				$id_query = $this->db->query('select last_insert_id() as ultimo');
				foreach($id_query->result() as $id_query1){
					$id_factura = $id_query1->ultimo;
				}
				$this->db->insert('envio',$envio);
				$id_query = $this->db->query('select last_insert_id() as ultimo');
				foreach($id_query->result() as $id_query1){
					$id_envio = $id_query1->ultimo;
				}

				$estado = (trim($rowi[22]) === 'terminado') ? 9 : 2;
				$pedido = array(
					'idPedido' => $rowi[0],
					'forma_pago' => 'N.A.',
					'Envio_idEnvio' => $id_envio ,
					'Tienda_idTienda' => $tienda,
					'Cliente_idCliente' => $rowi[1],
					'Factura_idFactura' => $id_factura,
					'General_idGeneral' => $id_general,
					'Estado_idEstado' => $estado,
					'fecha_pedido' => $rowi[2]
				);
				$this->db->insert('pedido',$pedido);

				if($estado == 2){
					echo 'insertado una vez para '.$rowi[0].'<br/>';
					$insert = array(
						'Pedido_idPedido' => $rowi[0],
						'Estado_idEstado' => 1,
						'persona_uno' => 'SISTEMA',
						'fecha' => date('d/m/Y',time()),
						'hora' => date('H:i:s',time()),
						'observaciones' => 'Dada de alta por el Sistema'
						);
					$this->db->insert('reporte',$insert);
				}
			}

			
			//echo $direccion_idDireccion;
			// incrementamos contador
			$i++;
			$numero_fila++;
			// imprimimos datos en pantalla

			
			echo 'Id: '.$row[0].'<br/>';

			/*echo 'Nombre: '.$row[1].'<br/>';
			echo 'Apellidos: '.$row[2].'<br/>';
			echo 'Profesión: '.$row[3].'<br/>';
			echo 'Edad: '.$row[4].'<br/>';
			echo 'Ciudad: '.$row[5].'<br/><br/>'; */

			echo '<pre>';
			print_r($rowi);
			print_r($factura);
			print_r($general);
			print_r($envio);
			print_r($pedido);
			

		}
	}

	public function contenidos()
	{
		$filas = file('../admin/archives/contenidopedido.csv');

		echo (empty($filas)) ? 'vacío' : 'lleno';

		$i=0;
		$numero_fila=0;

		

		while($filas[$i]!=NULL){ 
			$row = explode(",",$filas[$i]);
			$rowi = str_replace('"', '', $row);

			$contenidopedido = array(
					'Presentacion_idPresentacion' => $rowi[2],
					'Pedido_idPedido' => $rowi[1],
					'precio' => $rowi[4] ,
					'cantidad' => $rowi[5]
				);
			$this->db->insert('contenidopedido',$contenidopedido);


			$i++;
			$numero_fila++;
			// imprimimos datos en pantalla

			
			echo 'Id: '.$row[0].'<br/>';

			/*echo 'Nombre: '.$row[1].'<br/>';
			echo 'Apellidos: '.$row[2].'<br/>';
			echo 'Profesión: '.$row[3].'<br/>';
			echo 'Edad: '.$row[4].'<br/>';
			echo 'Ciudad: '.$row[5].'<br/><br/>'; */

			echo '<pre>';
			print_r($rowi);
			print_r($contenidopedido);
			

		}
	}
}

/* End of file tools.php */
/* Location: ./application/controllers/tools.php */