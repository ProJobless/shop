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

class Panel extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/mayorista/cuenta
     * 	- or -
     * 		http://example.com/index.php/mayorista/cuenta/index
     * 	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/cuenta/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('tienda_model', 'tienda');
        $this->load->model('cuenta_model', 'cuenta');
        $this->load->model('cliente_model', 'cliente');
        $this->load->model('carro_model', 'carro');
        $this->load->model('producto_model', 'producto');
        
        
    }
    
    public function index(){
        $mayor = $this->phpsession->get('datos','mayorista');
        //print_r($mayor);
        //print_r($_SESSION);
        redirect('mayorista/panel/pedido');
        
        
    }
    
    public function pedido(){
        $data['listado'] = $this->producto->listado();
        $data['general'] = $this->cuenta->direccion('mayorista');
        $this->load->view('mayorista/panel/pedido',$data);
    }
    
    public function colocados(){
        $this->load->model('pedido_model','pedido');
        $mayor = $this->phpsession->get('datos','mayorista');
        $data['pedidos'] = $this->pedido->lista_by_cliente($mayor['idCliente']);
        $this->load->view('mayorista/panel/colocados',$data);
    }
    
    public function carro(){
        $mayor = $this->phpsession->get('datos','mayorista');
        //print_r($mayor);
        if(empty($mayor['promocion'])){
            $this->load->view('carro/mayorista');
        }else{
            $this->load->view('carro/mayorista_c');
        }
        //$this->load->view('carro/mayorista');
    }
    
    public function agregar_carro(){
        $post = $this->input->post(NULL,TRUE);
        //print_r($post);
        $productos = json_decode($post['pedido']);
        $this->carro->mayorista($productos);
        $mayor = $this->phpsession->get('datos','mayorista');
        //print_r($mayor);
        if(empty($mayor['promocion'])){
            $this->load->view('carro/mayorista');
        }else{
            $this->load->view('carro/mayorista_c');
        }
        
    }
    
    public function colocar(){
        if($this->form_validation->run('guardar_pedido') === FALSE){
           echo '<div class="alert alert-error">'.validation_errors().'</div>'; 
        }else{
           $this->load->model('pedido_model','pedido');
           $post = $this->input->post(NULL,TRUE);
           //print_r($post);
           $info = $this->pedido->guardar($post,'mayorista');
           
           echo '<div class="alert alert-'.$info['tipo'].'">'.$info['msg'].'</div>';
           
           if($info['tipo'] == 'success'){
               echo '<script type="text/javascript">
                    window.location.replace("'.site_url('mayorista/panel/colocados').'");
                   </script>';
           }
           
        }
        
    }
    
    public function lista_excel(){
        $this->load->model('pedido_model','pedido');
        $this->pedido->lista_excel();
        redirect('mayorista/panel/pedido');
    }
    
    public function _factura_completa($str){
        
        
        if((!empty($str)) && (empty($_POST['f_razon']) || empty($_POST['f_rfc']) || empty($_POST['f_calle']) || empty($_POST['f_colonia']) || empty($_POST['f_cp']) || empty($_POST['f_delegacion']) || empty($_POST['f_estado']) || empty($_POST['f_pais'])) ){
            $this->form_validation->set_message('_factura_completa','Para solicitar factura debes llenar todos los campos de la sección Factura.');
            return false;
        }else{
            return true;
        }
    }
    
    public function _envio_completa($str){
        if((!empty($str)) && (empty($_POST['e_persona']) || empty($_POST['e_calle']) || empty($_POST['e_colonia']) || empty($_POST['e_cp']) || empty($_POST['e_delegacion']) || empty($_POST['e_estado']) || empty($_POST['e_pais'])) ){
            $this->form_validation->set_message('_envio_completa','Para solicitar dirección diferente de envío debes llenar todos los campos de la seccion Envío.');
            return false;
        }else{
            return true;
        }
    }
    

}

/* End of file panel.php */
/* Location: ./application/controllers/mayorista/panel.php */