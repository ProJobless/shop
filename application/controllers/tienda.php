<?php

/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.2.4 or newer
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Academic Free License version 3.0
 *
 * This source file is subject to the Academic Free License (AFL 3.0) that is
 * bundled with this package in the files license_afl.txt / license_afl.rst.
 * It is also available through the world wide web at this URL:
 * http://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to obtain it
 * through the world wide web, please send an email to
 * licensing@ellislab.com so we can send you a copy immediately.
 *
 * @package		CodeIgniter
 * @author		EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2013, EllisLab, Inc. (http://ellislab.com/)
 * @license		http://opensource.org/licenses/AFL-3.0 Academic Free License (AFL 3.0)
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Tienda extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/tienda
     * 	- or -
     * 		http://example.com/index.php/tienda/index
     * 	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/tienda/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('tienda_model', 'tienda');
        $this->load->model('carro_model', 'carro');
        
        
    }

    public function index() {
        $data['global_config'] = $this->tienda->config_inicial();
        
        $this->load->view('tienda_view', $data);
    }

    public function categoria($idcategoria = 0) {
        $data['global_config'] = $this->tienda->config_inicial();
        $data['productos'] = $this->tienda->get_producto_by_subcat($idcategoria);
        $this->load->view('categoria_view', $data);
    }
    
    public function producto($idproducto=0){
        
        
        $data['global_config'] = $this->tienda->config_inicial();
        $data['producto'] = $this->tienda->get_producto($idproducto);
        $data['presentaciones'] = $this->tienda->get_presentacion_by_producto($idproducto);
        $this->load->view('producto_view', $data);
        
    }
    
    public function test_agregar_producto($idproducto,$qty){
        $this->carro->agregar($idproducto,$qty);
        
        print_r($_SESSION);
    }
    
    public function agregar_producto(){
        $post = $this->input->post(NULL,TRUE);
        $this->carro->agregar($post['id'],$post['qty']);
        $this->load->view('carro/'.$post['size']);
    }
    
    public function quitar_producto(){
        $post = $this->input->post(NULL,TRUE);
        $this->carro->quitar($post['id']);
        $this->load->view('carro/'.$post['size']);
    }
    
    public function cambiar_producto(){
        $post = $this->input->post(NULL,TRUE);
        $this->carro->cambiar($post['id'],$post['qty']);
        
        //echo 'Subtotal: '.$this->carro->get_subtotal().' MPX';
        
        //echo json_encode($post);
        
        
    }
    
    public function subtotal(){
        echo number_format($this->carro->get_subtotal(),2);
    }
    
    public function total_articulos(){
        echo $this->carro->total_articulos();
    }
    
    public function row_suma($id){
        $carro = $this->phpsession->get('contenidos','carro');
        
        echo number_format($carro[$id]['qty'] * ($carro[$id]['price'] * (125/100)),2);
    }
    
    public function vaciar_carro(){
        $this->phpsession->clear('contenidos','carro');
        redirect('tienda');
    }

}

/* End of file tienda.php */
/* Location: ./application/controllers/tienda.php */