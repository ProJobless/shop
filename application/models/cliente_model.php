<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cliente_model extends CI_Model {

    function get_clientes($idtienda, $campos = '*') {
        $this->db->where(array('cliente.Tienda_idTienda' => $idtienda));
        $this->db->order_by('idCliente', 'DESC');
        $this->db->select($campos);
        $this->db->from('cliente');
        $this->db->join('tipocliente', 'cliente.TipoCliente_idTipoCliente = tipocliente.idTipoCliente');
        $q = $this->db->get();

        return $q->result_array();
    }

    function estado($post) {
        $this->db->where('idCliente', $post['idcliente']);
        $this->db->update('cliente', array('activo' => $post['estado']));
    }

    function buscar($post) {
        $query = "SELECT cliente.nombre as nombre_cliente,apellido,idCliente,cliente.activo,tipocliente.nombre,contrasena,abreviatura,fecha
                        FROM `cliente`
                        JOIN tipocliente ON cliente.TipoCliente_idTipoCliente = tipocliente.idTipoCliente
                        WHERE cliente.Tienda_idTienda = '" . $post['tienda'] . "' 
                        AND (cliente.nombre LIKE '%" . $post['buscar'] . "%' ESCAPE '!'
                            OR cliente.apellido LIKE '%" . $post['buscar'] . "%' ESCAPE '!'
                                )
                        ORDER BY idCliente DESC";
        $q = $this->db->query($query);
        //echo $this->db->last_query();
        $tmp = $q->result_array();

        return $tmp;
    }

    function get_tipo_cliente($campos='*') {
        $this->db->order_by('nombre','ASC');
        $this->db->select($campos);
        $q = $this->db->get('tipocliente');
        
        return $q->result_array();
    }
    
    function guardar($post,$editar=FALSE){
        //print_r($post);
        
        if($editar == FALSE){
           //Guardar una direccion para el cliente
            $data1 = array(
                'calle' => $post['calle'],
                'colonia' => $post['colonia'],
                'delegacion' => $post['delegacion'],
                'codigo_postal' => $post['cp'],
                'ciudad' => $post['ciudad'],
                'estado' => $post['estado']
            );

            $this->db->insert('direccion',$data1);

            //Obtener el id de la direccion
            $direccion = $this->db->insert_id();

            //Guardar una empresa
            $data2 = array(
                'razon_social' => $post['razon'],
                'correo' => $post['email'],
                'Direccion_idDireccion' => $direccion
            );

            $this->db->insert('empresa',$data2);

            //Obtener el id de la empresa
            $empresa = $this->db->insert_id();

            //Guardar al cliente
            $data3 = array(
                'nombre' => $post['nombres'],
                'apellido' => $post['apellidos'],
                'correo' => $post['email'],
                'telefono' => $post['telefono'],
                'tipo_telefono' => $post['tipo_telefono'],
                'contrasena' => $post['pass'],
                'TipoCliente_idTipoCliente' => $post['tipo'],
                'Empresa_idEmpresa' => $empresa,
                'Direccion_idDireccion' => $direccion,
                'Tienda_idTienda' => 2
            );

            $this->db->insert('cliente',$data3); 
        }else{
            //Actualizar direccion para el cliente
            $data1 = array(
                'calle' => $post['calle'],
                'colonia' => $post['colonia'],
                'delegacion' => $post['delegacion'],
                'codigo_postal' => $post['cp'],
                'ciudad' => $post['ciudad'],
                'estado' => $post['estado']
            );
            $this->db->where('idDireccion',$post['iddireccion']);
            $this->db->update('direccion',$data1);

            //Actualizar empresa
            $data2 = array(
                'razon_social' => $post['razon'],
                'correo' => $post['email']
            );
            
            $this->db->where('idEmpresa',$post['idempresa']);
            $this->db->update('empresa',$data2);

            //Actualizar al cliente
            $data3 = array(
                'nombre' => $post['nombres'],
                'apellido' => $post['apellidos'],
                'correo' => $post['email'],
                'telefono' => $post['telefono'],
                'tipo_telefono' => $post['tipo_telefono'],
                'contrasena' => $post['pass'],
                'TipoCliente_idTipoCliente' => $post['tipo']
            );
            
            $this->db->where('idCliente',$post['idcliente']);
            $this->db->update('cliente',$data3);
        }
        
    }
    
    function get_one_cliente($idcliente){
        
        $this->db->select('idCliente,nombre,apellido,cliente.correo,cliente.telefono,tipo_telefono,contrasena,TipoCliente_idTipoCliente,razon_social,calle,colonia,delegacion,codigo_postal,ciudad,estado,idDireccion,idEmpresa');
        $this->db->join('direccion','cliente.Direccion_idDireccion = idDireccion');
        $this->db->join('empresa','cliente.Empresa_idEmpresa = idEmpresa');
        $q = $this->db->get_where('cliente',array('idCliente'=>$idcliente,'Tienda_idTienda'=>2));
        
        if($q->num_rows() > 0){
            $tmp = $q->result_array();
        }else{
            $tmp[0] = NULL;
        }
        
        return $tmp[0];
    }
    
    function get_one_cliente2($idcliente,$campos='*'){
        $this->db->select($campos);
        $q = $this->db->get_where('cliente',array('idCliente'=>$idcliente,'Tienda_idTienda'=>2));
        
        if($q->num_rows() > 0){
            $tmp = $q->result_array();
            
            return $tmp[0];
        }else{
            return array();
        }
    }

}

?>