<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cliente extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/cliente
     * 	- or -  
     * 		http://example.com/index.php/cliente/index
     * 	- or -
     * Since this controller is set as the default controller in 
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/cliente/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct() {
        parent::__construct();
        $this->load->library('phpsession');
        $this->load->model('admin/generic_model', 'g');
        $this->load->model('admin/cliente_model', 'c');
        $this->load->helper('funciones_custom_helper');
    }

    public function index() {
        $data = $this->g->config_inicial();
        $data['seccion'] = $this->uri->segment(3);
        $this->load->view('admin/nuevos/cliente_view', $data);
    }

    public function alta() {

        if ($this->form_validation->run('alta_cliente') === FALSE) {
            $data = $this->g->config_inicial();
            $data['seccion'] = $this->uri->segment(3);
            $data['tipos'] = $this->c->get_tipo_cliente();
            $this->load->view('admin/nuevos/cliente_view', $data);
        } else {
            $post = $this->input->post(NULL, TRUE);
            $this->c->guardar($post);
            $this->phpsession->flashsave('acierto', 'El cliente ha sido dado de alta con éxito.');
            redirect(current_url());
        }
    }

    public function editar($idcliente=0) {
        
        if($idcliente == 0){
            redirect('admin/cliente/lista');
        }
        
        if ($this->form_validation->run('alta_cliente') === FALSE) {
            $data = $this->g->config_inicial();
            $data['seccion'] = $this->uri->segment(3);
            $data['tipos'] = $this->c->get_tipo_cliente();
            $data['cliente'] = $this->c->get_one_cliente($idcliente);
            $this->load->view('admin/nuevos/cliente_view', $data);
        } else {
            $post = $this->input->post(NULL, TRUE);
            $post['idcliente'] = $idcliente;
            $this->c->guardar($post,TRUE);
            $this->phpsession->flashsave('acierto', 'El cliente ha sido editado con éxito.');
            redirect(current_url());
        }
        
    }

    public function estado() {

        $post = $this->input->post(NULL, TRUE);
        $this->c->estado($post);
    }

    public function lista() {

        $data = $this->g->config_inicial();
        $data['seccion'] = $this->uri->segment(3);
        $data['clientes'] = $this->c->get_clientes($_SESSION['userdata']['tienda'], 'cliente.nombre as nombre_cliente,apellido,idCliente,cliente.activo,tipocliente.nombre,contrasena,abreviatura,fecha');
        $this->load->view('admin/nuevos/cliente_view', $data);
    }

    public function exportar() {

        $data = $this->g->config_inicial();
        $data['seccion'] = $this->uri->segment(3);
        $this->load->view('admin/nuevos/cliente_view', $data);
    }

    public function buscar() {
        $post = $this->input->post(NULL, TRUE);
        $post['tienda'] = $_SESSION['userdata']['tienda'];
        $data['clientes'] = $this->c->buscar($post);
        $this->load->view('admin/loads/buscar_cliente', $data);
    }

}

/* End of file cliente.php */
/* Location: ./application/controllers/cliente.php */