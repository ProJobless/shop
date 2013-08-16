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

class Pedido extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/pedido
     * 	- or -
     * 		http://example.com/index.php/pedido/index
     * 	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/pedido/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('tienda_model', 'tienda');
        $this->load->model('pedido_model', 'pedido');
        $this->load->model('cliente_model', 'cliente');
        $this->load->model('carro_model', 'carro');
        
        
    }

    public function index() {
        $data['global_config'] = $this->tienda->config_inicial();
        
        $this->load->view('pedido/previo',$data);
        
    }
    
    public function previo(){
        $data['global_config'] = $this->tienda->config_inicial();
        
        $this->load->view('pedido/previo',$data);
    }
    
    public function confirmar(){
        $this->load->model('cuenta_model', 'cuenta');
        $data['general'] = $this->cuenta->direccion();
        $this->load->view('pedido/confirmar',$data);
    }
    
    public function colocar(){
        if($this->form_validation->run('guardar_pedido') === FALSE){
           echo '<div class="alert alert-error">'.validation_errors().'</div>'; 
        }else{
           $this->load->model('pedido_model','pedido');
           $post = $this->input->post(NULL,TRUE);
           //print_r($post);
           $info = $this->pedido->guardar($post);
           
           echo '<div class="alert alert-'.$info['tipo'].'">'.$info['msg'].'</div>';
           
           if($info['tipo'] == 'success'){
               echo '<script type="text/javascript">
                    window.location.replace("'.site_url('tienda/exito').'");
                   </script>';
           }
           
        }
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

/* End of file pedido.php */
/* Location: ./application/controllers/pedido.php */