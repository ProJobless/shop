<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Generic_model extends CI_Model {

    /**
     * Regresa todos los correos en la base de datos.
     * 
     * @return array Correos en la base de datos
     */
    public function get_correos() {
        $q = $this->db->get_where('correo', array('activo' => 'SI'));
        return $q->result_array();
    }

    public function guardar_correo($post) {
        $this->db->insert('correo', $post);
    }
    
    public function get_correo($seccion){
        $q = $this->db->get_where('correo', array('activo' => 'SI','seccion'=>$seccion));
        return $q->result_array();
    }
    
    public function config_inicial() {
        $tienda_cookie = $_SESSION['userdata']['tienda'];
        $consulta_tienda = $this->db->get_where('tienda', array('idTienda' => $tienda_cookie));
        $tienda = datosTienda($consulta_tienda);
        $data['nombre_tienda'] = $tienda['nombre'];
        $data['seccion'] = 'inicio';
        $secure_number = $_SESSION['userdata']['secure_number'];
        $consulta_user = $this->db->get_where('usuario', array('secure_number' => $secure_number));

        $logged = $_SESSION['userdata']['logged'];

        $consulta_user = $this->db->get_where('usuario', array('secure_number' => $secure_number));
        $user = datosUser($consulta_user);
        $consulta_rol = $this->db->get_where('permiso', array('idPermiso' => $user['permiso']));
        $rol = permisoUser($consulta_rol);
        $data['rol'] = $rol;

        return $data;
    }

}

?>