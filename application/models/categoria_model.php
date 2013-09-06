<?php

class Categoria_model extends CI_Model {

    function get_barra_lateral(){
        $data = NULL;
        $cats = $this->get_categorias();
        foreach($cats as $c){
            $data[$c['idCategoria']]['info'] = $c;
            $data[$c['idCategoria']]['subcats'] = $this->get_subcategorias($c['idCategoria']);
        }
        
        return $data;
    }
    
    function get_categorias($campos='*'){
        $this->db->select($campos);
        $this->db->where('activo','SI');
        $this->db->order_by('nombre','ASC');
        $q = $this->db->get('categoria');
        
        return $q->result_array();
    }
    
    function get_subcategorias($idcategoria=0,$campos='*'){
        
        if($idcategoria != 0){
            $this->db->where('Categoria_idCategoria',$idcategoria);
        }
        $this->db->select($campos);
        $this->db->where('activo','SI');
        $this->db->order_by('nombre','ASC');
        $q = $this->db->get('subcategoria');
        
        return $q->result_array();
    }

}
