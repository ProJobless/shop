<?php

class Carro_model extends CI_Model {
    
    public function agregar($idpresentacion,$qty=1,$mayorista=FALSE){
        
        $carro = $this->phpsession->get('contenidos','carro');
        
        $this->db->where(array('presentacion.idpresentacion' => $idpresentacion));
        $this->db->select('*,producto.nombre as produ_nombre');
        $this->db->from('presentacion');
        $this->db->join('producto', 'presentacion.Producto_idProducto = producto.idProducto');
        $this->db->join('subcategoria', 'producto.Subcategoria_idSubcategoria = subcategoria.idSubcategoria');
        $this->db->join('categoria', 'subcategoria.Categoria_idCategoria = categoria.idCategoria');
        $sql = $this->db->get();
        
        if($sql->num_rows() == 1){
            $tmp1 = $sql->result_array();
            $tmp = $tmp1[0];
            //if(is_array($carro)){
                if(isset($carro[$idpresentacion]) && $qty != 0){
                    
                    $data = array(
                        'id' => $tmp['clave'],
                        'name' => $tmp['produ_nombre'],
                        'qty' => ($mayorista == TRUE) ? $qty : $carro[$idpresentacion]['qty'] + $qty,
                        'price' => $tmp['precio_publico'],
                        'options' => array('estado_fisico' => $tmp['estado_fisico'], 'contenido_neto' => $tmp['contenido_neto'], 'iva' => $tmp['iva'])
                    );
                    
                    $carro[$idpresentacion] = $data;
                    
                }elseif(isset($carro[$idpresentacion]) && $qty == 0){
                    unset($carro[$idpresentacion]);
                    
                }elseif($qty != 0){
                    $data = array(
                        'id' => $tmp['clave'],
                        'name' => $tmp['produ_nombre'],
                        'qty' => $qty,
                        'price' => $tmp['precio_publico'],
                        'options' => array('estado_fisico' => $tmp['estado_fisico'], 'contenido_neto' => $tmp['contenido_neto'], 'iva' => $tmp['iva'])
                    );
                    $carro[$idpresentacion] = $data;
                    
                    
                }
                
                $this->phpsession->save('contenidos',$carro,'carro');
            //}
            
        }
    }
    
    public function quitar($idpresentacion) {

        $carro = $this->phpsession->get('contenidos', 'carro');
        
        if (isset($carro[$idpresentacion])) {

            unset($carro[$idpresentacion]);
        }

        $this->phpsession->save('contenidos', $carro, 'carro');
    }
    
    public function cambiar($idpresentacion,$qty){
        $carro = $this->phpsession->get('contenidos', 'carro');
        
        if (isset($carro[$idpresentacion])) {
            if($qty == ' '){
                
            }elseif($qty == 0){
                unset($carro[$idpresentacion]);
            }else{
                $carro[$idpresentacion]['qty'] = $qty;
            }
            
        }

        $this->phpsession->save('contenidos', $carro, 'carro');
    }
    
    public function total_articulos(){
        $carro = $this->phpsession->get('contenidos','carro');
        $total = 0;
        if(!empty($carro)){
           foreach ($carro as $c) {
                $total += $c['qty'];
            } 
        }
        
        return $total;
        
    }
    
    public function get_subtotal(){
        $carro = $this->phpsession->get('contenidos','carro');
        $subtotal = 0;
        if(!empty($carro)){
           foreach ($carro as $c) {
                $subtotal += $c['qty'] * ($c['price'] * (125/100));
            } 
        }
        
        return $subtotal;
    }
    
    public function mayorista($productos){
        foreach($productos as $x){
            
            foreach($x as $xx){
                $this->agregar($xx->id,$xx->qty,TRUE);
            }
            
        }
    }
    
    

}

