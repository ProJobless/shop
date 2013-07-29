<?php

class Tienda_model extends CI_Model {

    function config_inicial(){
        $this->load->model('categoria_model','categoria');
        
        $data['barra_lateral'] = $this->categoria->get_barra_lateral();
        
        return $data;
    }
    
    function get_producto($id){
        $this->load->model('producto_model','producto');
        
        $productos = $this->producto->get_producto('*',$id);
        
        $tmp = (isset($productos[0])) ? $productos[0] : NULL;
        return $tmp;
    }
    
    function get_producto_by_subcat($id){
        $this->load->model('producto_model','producto');
        
        $productos = $this->producto->get_producto_by_subcat($id);
        
        return $productos;
    }
    
    function get_presentacion_by_producto($id){
        $this->load->model('producto_model','producto');
        
        $productos = $this->producto->get_presentacion_by_producto($id);
        
        return $productos;
    }
    
    function get_categorias($tienda, $lang) {
        $this->db->order_by('nombre', 'asc');
        $cat = $this->db->get_where('categoria', array('Tienda_idTienda' => $tienda['idTienda'], 'activo' => 'SI'));
        //print_r($cat->result_array());
        $optgroup;
        $nombre = extracto_correcto($lang['lang'], 'nombre');
        foreach ($cat->result() as $arreglo) {
            $optgroup[$arreglo->idCategoria][$nombre] = $arreglo->$nombre;
            $this->db->order_by('nombre','ASC');
            $subcat = $this->db->get_where('subcategoria', array('Categoria_idCategoria' => $arreglo->idCategoria, 'activo' => 'SI'));
            foreach ($subcat->result() as $arreglo1) {
                $optgroup[$arreglo->idCategoria][$arreglo1->idSubcategoria]['value'] = $arreglo1->idSubcategoria;
                $optgroup[$arreglo->idCategoria][$arreglo1->idSubcategoria][$nombre] = $arreglo1->$nombre;
            }
        }
        return $optgroup;
    }
    
    function top_ten(){
        $this->db->select('*,count(*) AS num, Presentacion_idPresentacion');
        $this->db->from('contenidopedido');
        $this->db->group_by('Presentacion_idPresentacion');
        $this->db->order_by('num','desc');
        $this->db->limit(10);
        $this->db->join('presentacion','presentacion.idPresentacion = contenidopedido.Presentacion_idPresentacion');
        $this->db->join('producto','producto.idProducto = presentacion.Producto_idProducto');
        $q = $this->db->get();
        
        return $q;
    }
    
    function get_productos($tienda,$campos='*',$orden='normal'){
        
        $this->db->select($campos);
        
        if($orden=='alfabeto'){
            $this->db->order_by('producto.nombre');
            $this->db->where(array('categoria.Tienda_idTienda' => $tienda['idTienda'], 'presentacion.activo' => 'SI'));
            //$this->db->select('*,producto.nombre as produ_nombre');
            $this->db->join('producto', 'producto.idProducto = presentacion.Producto_idProducto');
            $this->db->join('subcategoria', 'subcategoria.idSubCategoria = producto.Subcategoria_idSubcategoria');
            $this->db->join('categoria', 'categoria.idCategoria = subcategoria.Categoria_idCategoria');
        }else{
            $this->db->order_by('presentacion.clave');
            $this->db->where(array('categoria.Tienda_idTienda'=>$tienda['idTienda'],'presentacion.activo'=>'SI'));
            $this->db->join('producto','producto.idProducto = presentacion.Producto_idProducto');
            $this->db->join('subcategoria','subcategoria.idSubCategoria = producto.Subcategoria_idSubcategoria');
            $this->db->join('categoria','categoria.idCategoria = subcategoria.Categoria_idCategoria');
        }
        
        $q = $this->db->get('presentacion');
        
        return $q;
    }
    
    function get_precio_default(){
        $this->db->select('precio_cliente');
        $q = $this->db->get_where('tipocliente',array('idTipoCliente'=>3));
        $tmp = $q->result_array();
        return ($tmp[0]['precio_cliente']/100);
    }
    
    function get_precio_promocion($clave){
        $this->db->select('idPresentacion');
        $this->db->where('clave',$clave);
        $q = $this->db->get('presentacion');
        $tmp = $q->result_array();
        $id = (!empty($tmp)) ? $tmp[0]['idPresentacion'] : 0;
        
        $query = "SELECT precio FROM promociones WHERE Presentacion_idPresentacion =".$id." AND date_start <= '".date('Y-m-d')."' AND date_end >='".date('Y-m-d')."';";
        $q = $this->db->query($query);
        $tmp = $q->result_array();
        $precio_promocion = (!empty($tmp)) ? $tmp[0]['precio'] : 0.00;
        
        return $precio_promocion;
    }
    
    function enviar_catalogo($post){
        $this->load->library('email', configuraMail());
        $this->email->set_newline("\r\n");

        $this->email->from('noresponder@circulosaludable.com.mx', $tienda['nombre']);
        $this->email->to('ventas@circulosaludable.com.mx');
        $this->email->subject('Solicitud de Cliente Catálogo');
        $this->email->message($this->load->view('mail/ventasxcatalogo', $post, true));
        $this->email->send();
    }

}
