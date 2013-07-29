<?php

class Cuenta_model extends CI_Model {
    
    public function iniciar($post,$session_space='usuario'){
        $str = $post['email'];
        $pass = $post['pass'];
        $id = substr($str, 2);
        
        $sql = $this->db->query("SELECT idCliente,cliente.nombre,apellido,correo as c,
                                        contrasena as p, precio_cliente as descuento,
                                        promocion
                                FROM cliente
                                JOIN tipocliente ON TipoCliente_idTipoCliente = idTipoCliente
                                WHERE (correo = '".$str."' AND contrasena='".$pass."' AND cliente.activo='SI')
                                OR (idCliente = '".$id."' AND contrasena='".$pass."' AND cliente.activo='SI')");
        
        if($sql->num_rows() > 0){
            $tmp = $sql->result_array();
            $this->phpsession->save('datos',$tmp[0],$session_space);
            $msg['tipo'] = 'acierto';
            $msg['contenido'] = 'Bienvenido a tu cuenta!!!';
        }else{
            $msg['tipo'] = 'error';
            $msg['contenido'] = 'Error al ingresar al sistema.';
        }
        
        return $msg;
    }
    
    public function direccion($seccion='usuario'){
        $usuario = $this->phpsession->get('datos',$seccion);
        
        $this->db->where('idCliente',$usuario['idCliente']);
        $this->db->join('direccion', 'idDireccion = Direccion_idDireccion');
        $q = $this->db->get('cliente');
        if($q->num_rows() > 0){
            $tmp = $q->result_array();
            
            return $tmp[0];
        }else{
            return array();
        }
    }
    
    
    

}

