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

class Cuenta extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/cuenta
     * 	- or -
     * 		http://example.com/index.php/cuenta/index
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
        
        
    }

    public function index() {
        $data['global_config'] = $this->tienda->config_inicial();
        
        $cuenta = $this->phpsession->get('datos','usuario');
        
        if(empty($cuenta)){
            $this->load->view('cuenta/entra_crea',$data);
        }else{
            $data['tipos'] = $this->cliente->get_tipo_cliente();
            $data['cliente'] = $this->cliente->get_one_cliente($cuenta['idCliente']);
            $this->load->view('cuenta/mi_perfil',$data);
        }
    }
    
    public function entrar(){
        $data['global_config'] = $this->tienda->config_inicial();
        
        if($this->form_validation->run('entrar_cuenta') === FALSE){
            $this->load->view('cuenta/entra_crea',$data);
        }else{
            $post = $this->input->post(NULL,TRUE);
            $msg = $this->cuenta->iniciar($post);
            $this->phpsession->flashsave($msg['tipo'],$msg['contenido']);
            redirect('cuenta');
        }
    }
    
    public function crear(){
        $data['global_config'] = $this->tienda->config_inicial();
        
        if($this->form_validation->run('alta_cliente') === FALSE){
            $this->load->view('cuenta/crear',$data);
        }else{
            $post = $this->input->post(NULL, TRUE);
            //$this->load->model('cliente_model','cliente');
            $this->cliente->guardar($post);
            $this->phpsession->flashsave('acierto','Felicidades ha dado de alta su cuenta con éxito. Por favor Ingrese a continuación.');
            redirect('cuenta');
        }
    }
    
    public function perfil(){
        //$this->lang->load("form_validation","english");
        
        $data['global_config'] = $this->tienda->config_inicial();
        $cuenta = $this->phpsession->get('datos','usuario');
        
        if($this->form_validation->run('alta_cliente') === FALSE){
            $data['tipos'] = $this->cliente->get_tipo_cliente();
            $data['cliente'] = $this->cliente->get_one_cliente($cuenta['idCliente']);
            $this->load->view('cuenta/mi_perfil',$data);
        }else{
            $post = $this->input->post(NULL, TRUE);
            //$this->load->model('cliente_model','cliente');
            $post['idcliente'] = $cuenta['idCliente'];
            $this->cliente->guardar($post,TRUE);
            $this->phpsession->flashsave('acierto','Has editado el cliente con éxito.');
            redirect('cuenta');
        }
    }
    
    public function salir(){
        $this->phpsession->clear(NULL,'usuario');
        $this->phpsession->flashsave('acierto','Has finalizado tu sesión con éxito.');
            redirect('cuenta');
    }
    
    public function _check_combination($str){
        $pass = $_POST['pass'];
        $id = substr($str, 2);
        
        $sql = $this->db->query("SELECT idCliente FROM cliente
                                WHERE (correo = '".$str."' AND contrasena='".$pass."' AND activo='SI')
                                OR (idCliente = '".$id."' AND contrasena='".$pass."' AND activo='SI')");
        
        //echo 'id'.$id;
        if ($sql->num_rows() == 0)
        {
                $this->form_validation->set_message('_check_combination', 'La combinación de correo y contraseña no es correcta.');
                return FALSE;
        }
        else
        {
                return TRUE;
        }
    }
    
    

}

/* End of file cuenta.php */
/* Location: ./application/controllers/cuenta.php */