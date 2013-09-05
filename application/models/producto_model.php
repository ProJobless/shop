<?php

class Producto_model extends CI_Model {
    
    function get_producto($campos='*',$idproducto=0){
        if($idproducto != 0){
            $this->db->where('idProducto',$idproducto);
        }
        $this->db->select($campos);
        $this->db->order_by('nombre','ASC');
        $q = $this->db->get('producto');
        
        return $q->result_array();
    }
    
    function get_producto_by_subcat($id,$campos='*'){
        
        
        
        $pages = 6; //Numero de registros mostrados por páginas
        $this->load->library('pagination'); //Cargamos la librería de paginación
        $config = config_paginacion();

        $config['base_url'] = site_url('tienda/categoria/'.$id.'/'); // parametro base de la aplicación, si tenemos un .htaccess nos evitamos el index.php
        $config['total_rows'] = $this->totalproductos($id);
        $config['per_page'] = $pages;
        $config['num_links'] = 1; //Numero de links mostrados en la paginación
        $config["uri_segment"] = 4; //Para que los links en la paginación sean los correctos.



        $this->pagination->initialize($config);
        $q = $this->paginaproductos($id, $campos, $config['per_page'], $this->uri->segment(4));
        return $q->result_array();
        
    }

    public function paginaproductos($id, $campos, $per_page, $segment) {
        
        $this->db->select($campos);
        $this->db->order_by('nombre','ASC');
        $this->db->where(array('Subcategoria_idSubcategoria'=>$id));
        $q = $this->db->get('producto',$per_page,$segment);
        
        return $q;
    }

    public function totalproductos($id) {
        $this->db->select('idProducto');
        $q = $this->db->get_where('producto',array('Subcategoria_idSubcategoria'=>$id));


        return $q->num_rows();
    }
    
    function get_presentacion_by_producto($id,$campos='*'){
        $this->db->select($campos);
        $this->db->order_by('clave','ASC');
        $q = $this->db->get_where('presentacion',array('Producto_idProducto'=>$id));
        
        return $q->result_array();
    }
    
    function listado($orden='clave'){
        
        $campos = 'idPresentacion,
                    clave,
                    estado_fisico,
                    estado_fisico_en,
                    producto.nombre as descripcion,
                    contenido_neto as presentacion,
                    contenido_neto_en as presentacion_en,
                    grupo,
                    iva,
                    precio_publico as precio';
        $this->db->order_by($orden,'ASC');
        $this->db->join('producto','idProducto = Producto_idProducto');
        $this->db->where(array('presentacion.activo' => 'SI'));
        $this->db->select($campos);
        $q = $this->db->get('presentacion');
        
        return $q->result_array();
    }
    
    public function check_presentacion($codigo){
        $q = $this->db->get_where('presentacion',array('clave'=>$codigo));
        if($q->num_rows() > 0){
            $tmp = $q->result_array();
            return $tmp[0]['idPresentacion'];
        }else{
            return 0;
        }
        
        
    }

}
