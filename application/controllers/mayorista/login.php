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

class Login extends CI_Controller {

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
        
        
    }
    
    public function index(){
        if($this->form_validation->run('entrar_cuenta') == FALSE){
            $this->phpsession->clear(NULL,'mayorista');
            $this->load->view('mayorista/login');
        }else{
            $post = $this->input->post(NULL,TRUE);
            $msg = $this->cuenta->iniciar($post,'mayorista');
            $this->phpsession->flashsave($msg['tipo'],$msg['contenido']);
            redirect('mayorista/panel');
        }
        
    }
    
    public function salir(){
        $this->phpsession->clear(NULL,'mayorista');
        $this->phpsession->flashsave('acierto','Has finalizado tu sesión con éxito.');
        redirect('mayorista/login');
    }
    
    public function _check_combination($str){
        $pass = $_POST['pass'];
        $id = substr($str, 2);
        
        $sql = $this->db->query("SELECT idCliente FROM cliente
                                WHERE (correo = '".$str."' AND contrasena='".$pass."' AND activo='SI' AND TipoCliente_idTipoCliente != 3)
                                OR (idCliente = '".$id."' AND contrasena='".$pass."' AND activo='SI' AND TipoCliente_idTipoCliente != 3)");
        
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

/* End of file login.php */
/* Location: ./application/controllers/mayorista/login.php */