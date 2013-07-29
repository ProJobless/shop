<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Paginator_model extends CI_Model {


		function getClientPaginated($id,$per_page,$segment,$buscar=0,$seccion='todos') {
			
			switch($seccion){
				case 'todos':
					$this->db->where(array('cliente.Tienda_idTienda'=>$id,'contrasena !=' => ' '));
					$this->db->order_by('idCliente','desc');
					$this->db->select('cliente.nombre as nombre_cliente,apellido,secure_number,idCliente,cliente.activo,tipocliente.nombre,tipocliente.abreviatura,cliente.fecha,cliente.contrasena');
					$this->db->join('tipocliente', 'cliente.TipoCliente_idTipoCliente = tipocliente.idTipoCliente');
					$q = $this->db->get('cliente',$per_page,$segment);
					return $q;
				break;
				case 'cliente_id':
					$this->db->where(array('cliente.Tienda_idTienda'=>$id,'cliente.idCliente'=>$buscar));
					$this->db->order_by('idCliente','desc');
					$this->db->select('cliente.nombre as nombre_cliente,apellido,secure_number,idCliente,cliente.activo,tipocliente.nombre,tipocliente.abreviatura,cliente.fecha,cliente.contrasena');
					$this->db->join('tipocliente', 'cliente.TipoCliente_idTipoCliente = tipocliente.idTipoCliente');
					$q = $this->db->get('cliente',$per_page,$segment);
					return $q;
				break;
				case 'cliente_like':
					$query = "SELECT `cliente`.`nombre` as nombre_cliente, `apellido`, `secure_number`, `idCliente`, `cliente`.`activo`, `tipocliente`.`nombre`, `tipocliente`.`abreviatura`, `cliente`.`fecha`, `cliente`.`contrasena` 
								FROM (`cliente`) 
								JOIN `tipocliente` ON `cliente`.`TipoCliente_idTipoCliente` = `tipocliente`.`idTipoCliente` 
								JOIN `empresa` ON `cliente`.`Empresa_idEmpresa` = `empresa`.`idEmpresa` 
								WHERE `cliente`.`Tienda_idTienda` = '2' 
								AND (`tipocliente`.nombre REGEXP '$buscar' 
									OR `empresa`.`correo` REGEXP '$buscar' 
									OR `cliente`.`nombre` REGEXP '$buscar' 
									OR `cliente`.`apellido` REGEXP '$buscar'
									OR `cliente`.`idCliente` REGEXP '$buscar')
								ORDER BY `idCliente` desc LIMIT $per_page ";
					$q=$this->db->query($query);
					/*$this->db->like('tipocliente.nombre',$buscar);
					$this->db->or_like('empresa.correo',$buscar);
					$this->db->or_like('cliente.nombre', $buscar); 
					$this->db->or_like('cliente.apellido', $buscar);
					$this->db->where(array('cliente.Tienda_idTienda'=>$id));
					$this->db->order_by('idCliente','desc');
					$this->db->select('cliente.nombre as nombre_cliente,apellido,secure_number,idCliente,cliente.activo,tipocliente.nombre,tipocliente.abreviatura,cliente.fecha,cliente.contrasena');
					$this->db->join('tipocliente', 'cliente.TipoCliente_idTipoCliente = tipocliente.idTipoCliente');
					$this->db->join('empresa', 'cliente.Empresa_idEmpresa = empresa.idEmpresa');
					$q = $this->db->get('cliente',$per_page,$segment);*/
					return $q;
				break;
			}

			
			
			/*$this->db->order_by('idCliente ASC');
			$this->db->where(array('cliente.Tienda_idTienda'=>$id));
			$this->db->select('cliente.nombre as nombre_cliente,apellido,secure_number,idCliente,cliente.activo,tipocliente.nombre');
			$this->db->from('cliente');
			$this->db->join('tipocliente', 'cliente.TipoCliente_idTipoCliente = tipocliente.idTipoCliente');
			$q = $this->db->get('cliente',$per_page,$segment);*/
			
			
			
		}

		function getCategoryPaginated($id,$per_page,$segment) {
			$this->db->where(array('Tienda_idTienda'=>$id));
			$q = $this->db->get('categoria',$per_page,$segment);
			
			
			return $q;
			
		}

		function getPedidoPaginated($seccion,$id,$per_page,$segment,$buscar=0) {
			switch($seccion){
				case "consulta_catalogo_recibido":
                                    
                                        $query = "SELECT 
                                                `idPedido`, `cliente`.`nombre`, `cliente`.`apellido`, `pedido`.`fecha_pedido`, `estado`.`nombre` as `estado`, `Estado_idEstado` 
                                                FROM `pedido` 
                                                JOIN `cliente` ON `cliente`.`idCliente` = `pedido`.`Cliente_idCliente` 
                                                JOIN `tipocliente` ON `cliente`.`TipoCliente_idTipoCliente` = `tipocliente`.`idTipoCliente` 
                                                JOIN `estado` ON `estado`.`idEstado` = (`pedido`.`Estado_idEstado` - 1) 
                                                WHERE `pedido`.`Tienda_idTienda` = $id 
                                                AND tipocliente.idTipoCliente = 3 AND pedido.Estado_idEstado < 3
                                                ORDER BY `idPedido` DESC 
                                                LIMIT $per_page ";
                                    
                                                if(!empty($segment)){
                                                    $query .= " OFFSET $segment";
                                                }
                                                
                                        $q = $this->db->query($query);
                                        
                                        //print_r($q->result());
                                        
                                        
					
                                        /*$this->db->where(array('pedido.Tienda_idTienda'=>$id,'tipocliente.idTipoCliente'=>3,'pedido.Estado_idEstado <'=>3));
					$this->db->order_by('idPedido','desc');
					$this->db->select('idPedido,cliente.nombre,cliente.apellido,pedido.fecha_pedido,estado.nombre as estado,Estado_idEstado');
					$this->db->join('cliente', 'cliente.idCliente = pedido.Cliente_idCliente');
					$this->db->join('tipocliente', 'cliente.TipoCliente_idTipoCliente = tipocliente.idTipoCliente');
					$this->db->join('estado', 'estado.idEstado = pedido.Estado_idEstado - 1');
					$q = $this->db->get('pedido',$per_page,$segment);*/
					return $q;
				break;

				case "consulta_representante_recibido":
					$this->db->where(array('pedido.Tienda_idTienda'=>$id,'tipocliente.idTipoCliente !='=>3,'pedido.Estado_idEstado <'=>3));
					$this->db->order_by('idPedido','desc');
					$this->db->select('idPedido,cliente.nombre,cliente.apellido,pedido.fecha_pedido,estado.nombre as estado,Estado_idEstado');
					$this->db->join('cliente', 'cliente.idCliente = pedido.Cliente_idCliente');
					$this->db->join('tipocliente', 'cliente.TipoCliente_idTipoCliente = tipocliente.idTipoCliente');
					$this->db->join('estado', 'estado.idEstado = (pedido.Estado_idEstado - 1)');
					$q = $this->db->get('pedido',$per_page,$segment);
					return $q;
				break;
				case "consulta_todos":
                                    
                                        $query = "SELECT 
                                                `idPedido`, `cliente`.`nombre`, `cliente`.`apellido`, `pedido`.`fecha_pedido`, `estado`.`nombre` as `estado`, `Estado_idEstado` 
                                                FROM `pedido` 
                                                JOIN `cliente` ON `cliente`.`idCliente` = `pedido`.`Cliente_idCliente` 
                                                JOIN `tipocliente` ON `cliente`.`TipoCliente_idTipoCliente` = `tipocliente`.`idTipoCliente` 
                                                JOIN `estado` ON `estado`.`idEstado` = (`pedido`.`Estado_idEstado` - 1) 
                                                WHERE `pedido`.`Tienda_idTienda` = $id
                                                ORDER BY `idPedido` DESC 
                                                LIMIT $per_page ";
                                    
                                                if(!empty($segment)){
                                                    $query .= " OFFSET $segment";
                                                }
                                                
                                        $q = $this->db->query($query);
					/*$this->db->where(array('pedido.Tienda_idTienda'=>$id));
					$this->db->order_by('idPedido','desc');
					$this->db->select('idPedido,cliente.nombre,cliente.apellido,pedido.fecha_pedido,estado.nombre as estado,Estado_idEstado');
					$this->db->join('cliente', 'cliente.idCliente = pedido.Cliente_idCliente');
					$this->db->join('tipocliente', 'cliente.TipoCliente_idTipoCliente = tipocliente.idTipoCliente');
					$this->db->join('estado', 'estado.idEstado = (pedido.Estado_idEstado - 1)');
					$q = $this->db->get('pedido',$per_page,$segment);*/
					return $q;
				break;
				case "consulta_id":
					$this->db->where(array('pedido.Tienda_idTienda'=>$id,'idPedido'=>$buscar));
					$this->db->order_by('idPedido','desc');
					$this->db->select('idPedido,cliente.nombre,cliente.apellido,pedido.fecha_pedido,estado.nombre as estado,Estado_idEstado');
					$this->db->join('cliente', 'cliente.idCliente = pedido.Cliente_idCliente');
					$this->db->join('tipocliente', 'cliente.TipoCliente_idTipoCliente = tipocliente.idTipoCliente');
					$this->db->join('estado', 'estado.idEstado = (pedido.Estado_idEstado - 1)');
					$q = $this->db->get('pedido',$per_page,$segment);
					return $q;
				break;
				case "consulta_pcliente":
					$this->db->like('cliente.nombre', $buscar); 
					$this->db->or_like('cliente.apellido', $buscar);
					$this->db->where(array('pedido.Tienda_idTienda'=>$id));
					$this->db->order_by('idPedido','desc');
					$this->db->select('idPedido,cliente.nombre,cliente.apellido,pedido.fecha_pedido,estado.nombre as estado,Estado_idEstado');
					$this->db->join('cliente', 'cliente.idCliente = pedido.Cliente_idCliente');
					$this->db->join('tipocliente', 'cliente.TipoCliente_idTipoCliente = tipocliente.idTipoCliente');
					$this->db->join('estado', 'estado.idEstado = (pedido.Estado_idEstado - 1)');
					$q = $this->db->get('pedido',$per_page,$segment);
					return $q;
				break;
			}
			
			
		}
 
		function totalClientes($id,$seccion="todos",$buscar=0)
		{
			switch ($seccion) {
				case 'todos':
					$this->db->where(array('cliente.Tienda_idTienda'=>$id));
					$q = $this->db->get('cliente');
					return  $q->num_rows() ;
				break;

				case 'cliente_like':
					/*$this->db->like('tipocliente.nombre',$buscar);
					$this->db->or_like('empresa.correo',$buscar);
					$this->db->or_like('cliente.nombre', $buscar); 
					$this->db->or_like('cliente.apellido', $buscar);
					$this->db->where(array('cliente.Tienda_idTienda'=>$id));
					$this->db->order_by('idCliente','desc');
					$this->db->select('cliente.nombre as nombre_cliente,apellido,secure_number,idCliente,cliente.activo,tipocliente.nombre,tipocliente.abreviatura,cliente.fecha,cliente.contrasena');
					$this->db->join('tipocliente', 'cliente.TipoCliente_idTipoCliente = tipocliente.idTipoCliente');
					$this->db->join('empresa', 'cliente.Empresa_idEmpresa = empresa.idEmpresa');
					$q = $this->db->get('cliente');*/
					$query = "SELECT `cliente`.`nombre` as nombre_cliente, `apellido`, `secure_number`, `idCliente`, `cliente`.`activo`, `tipocliente`.`nombre`, `tipocliente`.`abreviatura`, `cliente`.`fecha`, `cliente`.`contrasena` 
								FROM (`cliente`) 
								JOIN `tipocliente` ON `cliente`.`TipoCliente_idTipoCliente` = `tipocliente`.`idTipoCliente` 
								JOIN `empresa` ON `cliente`.`Empresa_idEmpresa` = `empresa`.`idEmpresa` 
								WHERE `cliente`.`Tienda_idTienda` = '2' 
								AND (`tipocliente`.nombre REGEXP '$buscar' 
									OR `empresa`.`correo` REGEXP '$buscar' 
									OR `cliente`.`nombre` REGEXP '$buscar' 
									OR `cliente`.`apellido` REGEXP '$buscar'
									OR `cliente`.`idCliente` REGEXP '$buscar')
								ORDER BY `idCliente` desc";
					$q=$this->db->query($query);
					return  $q->num_rows() ;
				break;
				
				default:
					# code...
				break;
			}
			
		}

		function totalCategorias($id)
		{
			$this->db->where(array('Tienda_idTienda'=>$id));
			 $q = $this->db->get('categoria');
			return  $q->num_rows() ;
		}

		function totalPedidos($seccion,$id,$buscar = 0)
		{
			switch($seccion){
				case "consulta_catalogo_recibido":
					$this->db->where(array('pedido.Tienda_idTienda'=>$id,'tipocliente.idTipoCliente'=>3,'pedido.Estado_idEstado <'=>3));
					$this->db->join('cliente', 'cliente.idCliente = pedido.Cliente_idCliente');
					$this->db->join('tipocliente', 'cliente.TipoCliente_idTipoCliente = tipocliente.idTipoCliente');
					$this->db->join('estado', 'estado.idEstado = pedido.Estado_idEstado');
					$q = $this->db->get('pedido');
					return  $q->num_rows() ;
				break;

				case "consulta_representante_recibido":
					$this->db->where(array('pedido.Tienda_idTienda'=>$id,'tipocliente.idTipoCliente !='=>3,'pedido.Estado_idEstado <'=>3));
					$this->db->join('cliente', 'cliente.idCliente = pedido.Cliente_idCliente');
					$this->db->join('tipocliente', 'cliente.TipoCliente_idTipoCliente = tipocliente.idTipoCliente');
					$this->db->join('estado', 'estado.idEstado = pedido.Estado_idEstado');
					$q = $this->db->get('pedido');
					return  $q->num_rows() ;
				break;

				case "consulta_todos":
					$this->db->where(array('pedido.Tienda_idTienda'=>$id));
					$this->db->order_by('idPedido','desc');
					$this->db->select('idPedido,cliente.nombre,cliente.apellido,pedido.fecha_pedido,estado.nombre as estado');
					$this->db->join('cliente', 'cliente.idCliente = pedido.Cliente_idCliente');
					$this->db->join('tipocliente', 'cliente.TipoCliente_idTipoCliente = tipocliente.idTipoCliente');
					$this->db->join('estado', 'estado.idEstado = pedido.Estado_idEstado');
					$q = $this->db->get('pedido');
					return  $q->num_rows() ;
				break;
				case "consulta_pcliente":
					$this->db->like('cliente.nombre', $buscar); 
					$this->db->or_like('cliente.apellido', $buscar);
					$this->db->where(array('pedido.Tienda_idTienda'=>$id));
					$this->db->order_by('idPedido','desc');
					$this->db->select('idPedido,cliente.nombre,cliente.apellido,pedido.fecha_pedido,estado.nombre as estado');
					$this->db->join('cliente', 'cliente.idCliente = pedido.Cliente_idCliente');
					$this->db->join('tipocliente', 'cliente.TipoCliente_idTipoCliente = tipocliente.idTipoCliente');
					$this->db->join('estado', 'estado.idEstado = pedido.Estado_idEstado');
					$q = $this->db->get('pedido');
					return  $q->num_rows() ;
				break;
				
			}
		}

		
	}
?>