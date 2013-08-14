<?php

class Pedido_model extends CI_Model {
    
    public function guardar($post,$usuario = 'usuario'){
        $user = $this->phpsession->get('datos',$usuario);
        $carro = $this->phpsession->get('contenidos','carro');
        $data = array();
        $data['tipo'] = 'warning';
        $data['msg'] = 'Mensaje de Prueba.';
        if(!empty($user) && !empty($carro)){
            
            //Insertar una direccion para facturacion
            $factura = $this->direccion_factura($user,$post);
            
            //Insertar una direccion de envío
            $envio = $this->direccion_envio($user,$post);
            
            //Insertar una direccion de general
            $gral = $this->direccion_general($user);
            
            //Insertar el pedido
            $data3 = array(
                'forma_pago' => $post['forma_pago'],
                'Envio_idEnvio' => $envio,
                'Tienda_idTienda' => 2,
                'Cliente_idCliente' => $user['idCliente'],
                'Factura_idFactura' => $factura,
                'General_idGeneral' => $gral,
                'Estado_idEstado' => 2
            );
            
            $this->db->insert('pedido',$data3);
            
            $pedido = $this->db->insert_id();
            
            //Insertar los contenidos del pedido
            $this->guardar_contenidos($user,$carro,$pedido);
            
            //Insertar la primera fase del seguimiento del pedido
            $data2 = array(
                'Pedido_idPedido' => $pedido,
                'Estado_idEstado' => 1,
                'persona_uno' => 'SISTEMA',
                'fecha' => date('d/m/Y', time()),
                'hora' => date('H:i:s', time()),
                'observaciones' => 'Alta por Sistema'
            );
            $this->db->insert('reporte', $data2);
            
            $data['tipo'] = 'success';
            $data['msg'] = ($usuario == 'usuario') ? 'El pedido ha sido enviado con éxito.' : 'El pedido se ha colocado con éxito.';
            $this->envia_correo('mayorista');
            $this->phpsession->clear('contenidos','carro');
        }else{
            $data['tipo'] = 'error';
            if(empty($user)){
                $link = ($usuario == 'usuario') ? site_url('cuenta') : site_url('mayorista/login');
                $data['msg'] = 'Se ha perdido la sesión de usuario, por favor reingrese al <a href="'.$link.'">sistema aquí</a>.';
            }elseif(empty($carro)){
                $data['msg'] = 'Tu carrito de compras esta vacío, no se ha registrado actividad en más de 20 minutos. Por favor repite tu pedido.';
            }else{
                $data['msg'] = 'Un error desconocido ha sucedido, por favor contacte a su administrador.';
            }
            
        }
        
        return $data;
    }
    
    public function guardar_contenidos($user,$carro,$pedido){
        //print_r($carro);
        foreach($carro as $k => $v){
            $data = array(
                'Presentacion_idPresentacion' => $k,
                'Pedido_idPedido' => $pedido,
                'precio' => $v['price'] * ($user['descuento']/100),
                'cantidad' =>  $v['qty']
            );
            
            $this->db->insert('contenidopedido',$data);
        }
    }
    
    public function direccion_factura($user,$post){
        //print_r($user);
        if((empty($post['f_razon']) || empty($post['f_rfc']) || empty($post['f_calle']) || empty($post['f_colonia']) || empty($post['f_cp']) || empty($post['f_delegacion']) || empty($post['f_estado']) || empty($post['f_pais'])) ){
            $this->load->model('cliente_model','cliente');
            $tmp = $this->cliente->get_one_cliente2($user['idCliente'],'Direccion_idDireccion');
            if(is_array($tmp)){
                $direccion = $tmp['Direccion_idDireccion'];
            }else{
                $direccion = 1;
            }
        }else{
            $data = array(
                'calle' => $post['f_calle'],
                'colonia' => $post['f_colonia'],
                'delegacion' => $post['f_delegacion'],
                'codigo_postal' => $post['f_cp'],
                'ciudad' => $post['f_ciudad'],
                'estado' => $post['f_estado'],
                'pais' => $post['f_pais']
            );
            
            $this->db->insert('direccion',$data);
            
            $direccion = $this->db->insert_id();
        }
        
        $data2 = array(
            'razon_social' => $post['f_razon'],
            'rfc' => $post['f_rfc'],
            'Direccion_idDireccion' => $direccion
        );
        
        $this->db->insert('factura',$data2);
        
        $fact = $this->db->insert_id();
        
        return $fact;
    }
    
    public function direccion_envio($user,$post){
        if((empty($post['e_calle']) || empty($post['e_colonia']) || empty($post['e_cp']) || empty($post['e_delegacion']) || empty($post['e_estado']) || empty($post['e_pais'])) ){
            $this->load->model('cliente_model','cliente');
            $tmp = $this->cliente->get_one_cliente2($user['idCliente'],'Direccion_idDireccion');
            if(is_array($tmp)){
                $direccion = $tmp['Direccion_idDireccion'];
            }else{
                $direccion = 1;
            }
        }else{
            $data = array(
                'calle' => $post['e_calle'],
                'colonia' => $post['e_colonia'],
                'delegacion' => $post['e_delegacion'],
                'codigo_postal' => $post['e_cp'],
                'ciudad' => $post['e_ciudad'],
                'estado' => $post['e_estado'],
                'pais' => $post['e_pais']
            );
            
            $this->db->insert('direccion',$data);
            
            $direccion = $this->db->insert_id();
        }
        
        $data2 = array(
            'persona_recibe' => $post['e_persona'],
            'Direccion_idDireccion' => $direccion
        );
        
        $this->db->insert('envio',$data2);
        
        $envio = $this->db->insert_id();
        
        return $envio;
    }
    
    public function direccion_general($user){
        //print_r($user);
        $this->load->model('cliente_model','cliente');
        $tmp = $this->cliente->get_one_cliente2($user['idCliente'],'Direccion_idDireccion');
        if(is_array($tmp)){
            $direccion = $tmp['Direccion_idDireccion'];
        }else{
            $direccion = 1;
        }
        //print_r($user);
        $data2 = array(
            'nombre' => $user['nombre'].' '.$user['apellido'],
            'correo' => $user['c'],
            'Direccion_idDireccion' => $direccion
        );
        
        $this->db->insert('general',$data2);
        
        $gral = $this->db->insert_id();
        
        return $gral;
    }
    
    public function lista_by_cliente($idcliente){
        $pages = 50; //Numero de registros mostrados por páginas
        $this->load->library('pagination'); //Cargamos la librería de paginación
        $config['base_url'] = base_url() . 'mayorista/panel/colocados'; // parametro base de la aplicación, si tenemos un .htaccess nos evitamos el index.php
        $config['total_rows'] = $this->total_by_cliente($idcliente);
        $config['per_page'] = $pages;
        $config['num_links'] = 5; //Numero de links mostrados en la paginación
        $config["uri_segment"] = 4; //Para que los links en la paginación sean los correctos.

        $config['full_tag_open'] = '<div class="pagination"><ul>';
        $config['full_tag_close'] = '</ul></div>';
        $config['first_link'] = '<<';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = '>>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['prev_link'] = '<';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $this->pagination->initialize($config);
        
        $q = $this->paginar_by_cliente($idcliente,$config['per_page'],$this->uri->segment(4));
        
        return $q->result_array();
    }
    
    public function paginar_by_cliente($idcliente,$per_page,$segment){
        $query = "SELECT 
                `idPedido`, `cliente`.`nombre`, `cliente`.`apellido`, `pedido`.`fecha_pedido`, `estado`.`nombre` as `estado`, `Estado_idEstado` 
                FROM `pedido` 
                JOIN `cliente` ON `cliente`.`idCliente` = `pedido`.`Cliente_idCliente` 
                JOIN `tipocliente` ON `cliente`.`TipoCliente_idTipoCliente` = `tipocliente`.`idTipoCliente` 
                JOIN `estado` ON `estado`.`idEstado` = (`pedido`.`Estado_idEstado` - 1) 
                WHERE `pedido`.`Tienda_idTienda` = 2  
                AND cliente.idCliente = $idcliente
                ORDER BY `idPedido` DESC 
                LIMIT $per_page ";

        if (!empty($segment)) {
            $query .= " OFFSET $segment";
        }

        $q = $this->db->query($query);
        
        return $q;
    }
    
    public function total_by_cliente($idcliente){
        $query = "SELECT idPedido FROM `pedido` 
                JOIN `cliente` ON `cliente`.`idCliente` = `pedido`.`Cliente_idCliente` 
                JOIN `tipocliente` ON `cliente`.`TipoCliente_idTipoCliente` = `tipocliente`.`idTipoCliente` 
                JOIN `estado` ON `estado`.`idEstado` = (`pedido`.`Estado_idEstado` - 1) 
                WHERE `pedido`.`Tienda_idTienda` = 2  
                AND cliente.idCliente = $idcliente
                ORDER BY `idPedido` DESC ";

        $q = $this->db->query($query);
        
        return $q->num_rows();
    }
    
    public function envia_correo($tipo_user){
        $user = $this->phpsession->get('datos',$tipo_user);
        //print_r($user);
        //echo 'SOME---------';
        $data['usuario'] = $tipo_user;
        $this->load->library('email');
        $this->email->initialize(configuraMail2());
        //$this->email->set_newline("\r\n");

        $this->email->from('noresponder@smadesarrollo.com', 'Tecnobotánica de México');
        $this->email->to($user['c']);
        $this->email->subject('Confirmacion de Pedido');
        $this->email->message($this->load->view('carro/correo', $data, true));
        $this->email->send();
        
        //echo $this->email->print_debugger();
    }
    
    public function lista_excel(){
        $config['upload_path'] = './uploads/listas';
        $config['allowed_types'] = 'csv';
        $config['max_size'] = '800';                    
        $config['file_name'] = 'lista_'.date('ymdHis');
        $config['overwrite'] = TRUE;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('lista')) {
            //print_r($_FILES);
            //echo $this->upload->display_errors();
            $this->phpsession->flashsave('error', $this->upload->display_errors());                        
        } else {
            //$acierto = TRUE;
            $img = $this->upload->data();
            //echo '<br> --> '; print_r($img);
            $this->load->library('CSVReader');
            $csv = $this->csvreader->parse_file('uploads/listas/'.$img['file_name']);
            
            if(is_array($csv)){
                if(isset($csv[0]['codigo']) && isset($csv[0]['cantidad'])){
                    $this->load->model('producto_model','producto');
                    $this->load->model('carro_model','carro');
                    $string = '';
                    $cont = 0;
                    foreach($csv as $c){
                        $prueba = $this->producto->check_presentacion(trim($c['codigo']));
                        //echo $this->db->last_query();
                        if($prueba != 0){
                            $this->carro->agregar($prueba,trim($c['cantidad']),TRUE);
                            $cont++;
                        }else{
                            $string .=  '<p>No existe un producto con clave '.$c['codigo'].'</p>';
                        }
                    }
                    
                    if(!empty($string)){
                        $this->phpsession->flashsave('error',$string);
                    }
                    
                    if($cont != 0){
                        $this->phpsession->flashsave('acierto','Se han agregado '.$cont.' producto(s) al carro de compras.');                        
                        $this->phpsession->flashsave('mostrar_carro',TRUE);
                    }
                }else{
                    $this->phpsession->flashsave('error','El archivo no tiene los encabezados correctos.');
                    //echo 'Encabezados incorrectos';
                }
            }else{
                $this->phpsession->flashsave('error','El archivo esta vacío o corrupto.');
                //echo 'Archivo Vacío o Corrupto';
            }
            //print_r($csv);
            

        }
    }
    
    

}

