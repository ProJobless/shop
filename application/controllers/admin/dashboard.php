<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/dashboard
     * 	- or -  
     * 		http://example.com/index.php/dashboard/index
     * 	- or -
     * Since this controller is set as the default controller in 
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/dashboard/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct() {
        parent::__construct();

        $this->load->helper('funciones_custom_helper');
    }

    public function index() {

        $consulta_tienda = $this->db->get_where('tienda', array('nombre' => "E-Shop"));
        $tienda = datosTienda($consulta_tienda);
        $data['nombre_tienda'] = $tienda['nombre'];
        $data['seccion'] = 'inicio_login';
        //$secure_number = $_SESSION['userdata']['secure_number'];
        //$consulta_user = $this->db->get_where('usuario',array('secure_number' => $secure_number));
        /* if($consulta_user->num_rows > 0){
          echo "ERROR DE SESION";//redirect('admin/dashboard/salir');
          } */
        $logged = false;
        if (!empty($_SESSION['userdata'])) {
            $logged = $_SESSION['userdata']['logged'];
        }
        $data['logged'] = $logged;

        if ($logged) {
            $cliente_logged = $this->db->get_where('usuario', array('secure_number' => $_SESSION['userdata']['secure_number']));
            $data['last_user'] = datosUser($consulta_user);
        }
        $rules =
                array(
                    array(
                        'field' => 'username',
                        'label' => 'Correo',
                        'rules' => 'required|valid_email|xss_clean|callback_checkUser'
                    ),
                    array(
                        'field' => 'password',
                        'label' => 'Contraseña',
                        'rules' => 'required|xss_clean|callback_checkPass'
                    ),
        );

        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('admin/dashboard_index', $data);
        } else {
            //echo "bien";
            $correo = set_value('username');
            $pass = (set_value('password'));
            //echo $correo;
            $sql = $this->db->get_where('usuario', array('correo' => $correo, 'pass' => $pass, 'activo' => 'SI'));
            if ($sql->num_rows() > 0) {
                //echo "doble bien";
                $secure_number = securityNumber($correo);

                foreach ($sql->result() as $user) {

                    $cliente_idx = $user->idUsuario;
                    $Tienda_idTienda = $user->Tienda_idTienda;
                    $real_number = 'SE' . $user->idUsuario;
                    $this->db->where('idUsuario', $user->idUsuario);
                    $this->db->update('usuario', array('secure_number' => $real_number));
                }
                $newdata = array(
                    'secure_number' => $real_number,
                    'tienda' => $Tienda_idTienda,
                    'logged' => TRUE,
                    'user' => $cliente_idx
                );
                //$this->session->set_userdata($newdata);

                $_SESSION['userdata'] = $newdata;
                //print_r($_SESSION);
                redirect('admin/dashboard/inicio');
            } else {
                $this->phpsession->flashsave('error_login', 'Error al intentar entrar al sistema.');
                redirect('admin/dashboard');
            }
        }
    }

    public function prueba() {
        $logged = $_SESSION['userdata']['logged'];
        if ($logged == TRUE) {
            echo '<pre>';
            print_r($_SESSION);
            echo '</pre>';
        }
    }

    public function inicio() {
        //$this->load->helper('funciones_custom');
        $tienda_cookie = $_SESSION['userdata']['tienda'];
        $consulta_tienda = $this->db->get_where('tienda', array('idTienda' => $tienda_cookie));
        $tienda = datosTienda($consulta_tienda);
        $data['nombre_tienda'] = $tienda['nombre'];
        $data['seccion'] = 'inicio';
        $secure_number = $_SESSION['userdata']['secure_number'];
        $consulta_user = $this->db->get_where('usuario', array('secure_number' => $secure_number));
        /* if($consulta_user->num_rows > 0){
          redirect('admin/dashboard/salir');
          } */
        $logged = $_SESSION['userdata']['logged'];

        if ($logged == TRUE) {
            /* echo '<pre>';
              print_r($_SESSION);
              echo '</pre>'; */
        }
        $consulta_user = $this->db->get_where('usuario', array('secure_number' => $secure_number));
        $user = datosUser($consulta_user);
        $consulta_rol = $this->db->get_where('permiso', array('idPermiso' => $user['permiso']));
        $rol = permisoUser($consulta_rol);
        //$rol = "sin_rol";
        switch ($rol) {
            default:
                //echo "mal";
                show_404();
                break;

            case 'ADMINISTRADOR':
                $data['rol'] = $rol;
                $this->load->view('admin/dashboard_inicio', $data);
                break;

            case 'PRODUCTO_INFORMACION_INGREDIENTES':
                $data['rol'] = $rol;
                $this->load->view('admin/dashboard_inicio', $data);
                break;
            case 'PRODUCTO_INFORMACION_GENERAL':
                $data['rol'] = $rol;
                $this->load->view('admin/dashboard_inicio', $data);
                break;

            case 'PRODUCTO_PRECIO':
                $data['rol'] = $rol;
                $this->load->view('admin/dashboard_inicio', $data);
                break;

            case 'PRODUCTO_VIDEO':
                $data['rol'] = $rol;
                $this->load->view('admin/dashboard_inicio', $data);
                break;

            case 'PEDIDOS_CATALOGO':
                $data['rol'] = $rol;
                $this->load->view('admin/dashboard_inicio', $data);
                break;

            case 'PEDIDOS_REPRESENTANTE_VENTAS':
                $data['rol'] = $rol;
                $this->load->view('admin/dashboard_inicio', $data);
                break;

            case 'PEDIDOS_REPRESENTANTE_EMBARQUES':
                $data['rol'] = $rol;
                $this->load->view('admin/dashboard_inicio', $data);
                break;
        }
    }

    public function tipo_cliente($seccion = "tipo_cliente", $cliente_url = 'none') {
        $tienda_cookie = $_SESSION['userdata']['tienda'];
        $consulta_tienda = $this->db->get_where('tienda', array('idTienda' => $tienda_cookie));
        $tienda = datosTienda($consulta_tienda);
        $data['nombre_tienda'] = $tienda['nombre'];
        $data['idTienda'] = $tienda['idTienda'];
        $secure_number = $_SESSION['userdata']['secure_number'];
        $consulta_user = $this->db->get_where('usuario', array('secure_number' => $secure_number));
        /* if($consulta_user->num_rows > 0){
          redirect('admin/dashboard/salir');
          } */
        $logged = $_SESSION['userdata']['logged'];
        if ($logged != TRUE) {
            redirect('admin/dashboard');
        }
        $consulta_user = $this->db->get_where('usuario', array('secure_number' => $secure_number));
        $user = datosUser($consulta_user);
        $consulta_rol = $this->db->get_where('permiso', array('idPermiso' => $user['permiso']));
        $rol = permisoUser($consulta_rol);
        switch ($seccion) {
            case "tipo_cliente":
                switch ($rol) {
                    default:
                        show_404();
                        break;

                    case 'ADMINISTRADOR':
                        $data['seccion'] = $seccion;
                        $data['rol'] = $rol;
                        $this->load->view('admin/altas_consultas', $data);
                        break;
                }
                break;
            case "alta":
                switch ($rol) {
                    default:
                        show_404();
                        break;

                    case 'ADMINISTRADOR':
                        $rules = reglasInsertar('tipo_cliente');
                        $data['seccion'] = "alta_tipo_cliente";
                        $data['rol'] = $rol;
                        $data['consulta'] = "none";

                        $this->form_validation->set_rules($rules);
                        if ($this->form_validation->run() == FALSE) {
                            $this->load->view('admin/altas_consultas', $data);
                        } else {
                            $idTienda = $tienda['idTienda'];
                            $cliente = datosInsertar('tipo_cliente', $idTienda);
                            $insertar = $this->db->insert('tipocliente', $cliente);
                            if ($insertar) {
                                $this->phpsession->flashsave('insert_message', 'El tipo de cliente se ha creado con éxito.');
                                redirect('admin/dashboard/tipo_cliente/alta');
                            } else {
                                $this->phpsession->flashsave('insert_message', 'Error #2420: No se pudo crear el tipo de cliente; por favor contacte a su administrador.');
                                redirect('admin/dashboard/tipo_cliente/alta');
                            }
                        }
                        break;
                }
                break;
            case "consulta":
                switch ($rol) {
                    default:
                        show_404();
                        break;
                    case 'ADMINISTRADOR':
                        $data['seccion'] = "consulta_tipo_cliente";
                        $data['rol'] = $rol;
                        $this->db->order_by('idTipoCliente', 'asc');
                        $data['consulta'] = $this->db->get_where('tipocliente', array('Tienda_idTienda' => $tienda['idTienda']));
                        $this->load->view('admin/altas_consultas', $data);

                        break;
                }
                break;
            case "desactivar":
                switch ($rol) {
                    default:
                        show_404();
                        break;
                    case 'ADMINISTRADOR':
                        if ($cliente_url == 'none') {
                            redirect('admin/dashboard/tipo_cliente/consulta');
                        }
                        $this->db->where('idTipoCliente', $cliente_url);
                        $update = $this->db->update('tipocliente', array('activo' => 'NO'));
                        redirect('admin/dashboard/tipo_cliente/consulta');
                        break;
                }
                break;
            case "activar":
                switch ($rol) {
                    default:
                        show_404();
                        break;
                    case 'ADMINISTRADOR':
                        if ($cliente_url == 'none') {
                            redirect('admin/dashboard/tipo_cliente/consulta');
                        }
                        $this->db->where('idTipoCliente', $cliente_url);
                        $update = $this->db->update('tipocliente', array('activo' => 'SI'));
                        redirect('admin/dashboard/tipo_cliente/consulta');
                        break;
                }
                break;
            case "ver":
                switch ($rol) {
                    default:
                        show_404();
                        break;
                    case 'ADMINISTRADOR':
                        if ($cliente_url == 'none') {
                            redirect('admin/dashboard/tipo_cliente/consulta');
                        }
                        //$buscar = str_replace('_',' ',$cliente_url);
                        $sql = $this->db->get_where('tipocliente', array('idTipoCliente' => $cliente_url, 'Tienda_idTienda' => $tienda['idTienda']));
                        if ($sql->num_rows() < 1) {
                            redirect('dashboard/tipo_cliente/consulta');
                        }
                        $data['consulta'] = $sql;
                        $data['seccion'] = "ver_tipo_cliente";
                        $data['rol'] = $rol;

                        $this->load->view('admin/altas_consultas', $data);

                        break;
                }
                break;
            case "editar":
                switch ($rol) {
                    default:
                        show_404();
                        break;
                    case 'ADMINISTRADOR':
                        if ($cliente_url == 'none') {
                            redirect('admin/dashboard/tipo_cliente/consulta');
                        }
                        //$buscar = str_replace('_',' ',$cliente_url);

                        $sql = $this->db->get_where('tipocliente', array('idTipoCliente' => $cliente_url, 'Tienda_idTienda' => $tienda['idTienda']));
                        if ($sql->num_rows() < 1) {
                            redirect('dashboard/tipo_cliente/consulta');
                        }
                        $data['consulta'] = $sql;
                        $data['seccion'] = "editar_tipo_cliente";
                        $data['rol'] = $rol;
                        $rules = reglasInsertar('editar_tipo_cliente');
                        $this->form_validation->set_rules($rules);
                        if ($this->form_validation->run() == FALSE) {
                            $this->load->view('admin/altas_consultas', $data);
                        } else {
                            $idTienda = $tienda['idTienda'];
                            $cliente = datosInsertar('editar_tipo_cliente', $idTienda);
                            $this->db->where('idTipoCliente', $cliente_url);
                            $update = $this->db->update('tipocliente', $cliente);
                            if ($update) {
                                $this->phpsession->flashsave('update_message', "El tipo de cliente se ha actualizado con éxito.");
                                redirect("admin/dashboard/tipo_cliente/consulta");
                            } else {
                                $this->phpsession->flashsave('update_message', 'Error #2420: No se pudo crear el tipo de cliente; por favor contacte a su administrador.');
                                redirect("admin/dashboard/tipo_cliente/editar/$cliente_url");
                            }
                        }
                        break;
                }
                break;
            default:
                show_404();
                break;
        }
    }

    public function tipo_cambio($seccion = "tipo_cambio", $cliente_url = 'none') {
        $tienda_cookie = $_SESSION['userdata']['tienda'];
        $consulta_tienda = $this->db->get_where('tienda', array('idTienda' => $tienda_cookie));
        $tienda = datosTienda($consulta_tienda);
        $data['nombre_tienda'] = $tienda['nombre'];
        $data['idTienda'] = $tienda['idTienda'];
        $secure_number = $_SESSION['userdata']['secure_number'];
        $consulta_user = $this->db->get_where('usuario', array('secure_number' => $secure_number));
        /* if($consulta_user->num_rows > 0){
          redirect('admin/dashboard/salir');
          } */
        $logged = $_SESSION['userdata']['logged'];
        if ($logged != TRUE) {
            redirect('admin/dashboard');
        }
        $consulta_user = $this->db->get_where('usuario', array('secure_number' => $secure_number));
        $user = datosUser($consulta_user);
        $consulta_rol = $this->db->get_where('permiso', array('idPermiso' => $user['permiso']));
        $rol = permisoUser($consulta_rol);
        switch ($seccion) {
            case "tipo_cambio":
                $sql = $this->db->get_where('configuracion', array('accion' => 'tipo_cambio', 'Tienda_idTienda' => $tienda['idTienda']));
                foreach ($sql->result() as $cambio) {
                    $idConfiguracion = $cambio->idConfiguracion;
                    redirect('admin/dashboard/tipo_cambio/editar/' . $idConfiguracion);
                }
                break;

            case "editar":
                switch ($rol) {
                    default:
                        show_404();
                        break;
                    case 'ADMINISTRADOR':
                        if ($cliente_url == 'none') {
                            redirect('admin/dashboard/inicio');
                        }
                        //$buscar = str_replace('_',' ',$cliente_url);
                        //$sql = $this->db->get_where('tipocliente', array('idTipoCliente'=>$cliente_url));
                        //$data['consulta'] = $sql;
                        $data['seccion'] = "editar_tipo_cambio";
                        $data['rol'] = $rol;
                        $sql = $this->db->get_where('configuracion', array('idConfiguracion' => $cliente_url, 'accion' => 'tipo_cambio', 'Tienda_idTienda' => $tienda['idTienda']));
                        if ($sql->num_rows() < 1) {
                            redirect('dashboard/inicio');
                        }
                        $data['consulta'] = $sql;
                        $rules = reglasInsertar('editar_tipo_cambio');
                        $this->form_validation->set_rules($rules);
                        if ($this->form_validation->run() == FALSE) {
                            $this->load->view('admin/altas_consultas', $data);
                        } else {
                            $idTienda = $tienda['idTienda'];
                            $usuario = datosInsertar('editar_tipo_cambio', $idTienda);
                            $this->db->where('idConfiguracion', $cliente_url);
                            $update = $this->db->update('configuracion', $usuario);
                            if ($update) {
                                $this->phpsession->flashsave('update_message', "El tipo de cambio se ha actualizado con éxito.");
                                redirect("admin/dashboard/tipo_cambio/editar/" . $cliente_url);
                            } else {
                                $this->phpsession->flashsave('update_message', 'Error #2420: No se pudo actualizar el tipo de cambio; por favor contacte a su administrador.');
                                redirect("admin/dashboard/tipo_cambio/editar/" . $cliente_url);
                            }
                        }
                        break;
                }
                break;
            default:
                show_404();
                break;
        }
    }

    public function usuario($seccion = "usuario", $cliente_url = 'none') {
        $tienda_cookie = $_SESSION['userdata']['tienda'];
        $consulta_tienda = $this->db->get_where('tienda', array('idTienda' => $tienda_cookie));
        $tienda = datosTienda($consulta_tienda);
        $data['nombre_tienda'] = $tienda['nombre'];
        $data['idTienda'] = $tienda['idTienda'];
        $secure_number = $_SESSION['userdata']['secure_number'];
        $consulta_user = $this->db->get_where('usuario', array('secure_number' => $secure_number));
        /* if($consulta_user->num_rows > 0){
          redirect('admin/dashboard/salir');
          } */
        $logged = $_SESSION['userdata']['logged'];
        if ($logged != TRUE) {
            redirect('admin/dashboard');
        }
        $consulta_user = $this->db->get_where('usuario', array('secure_number' => $secure_number));
        $user = datosUser($consulta_user);
        $consulta_rol = $this->db->get_where('permiso', array('idPermiso' => $user['permiso']));
        $rol = permisoUser($consulta_rol);
        switch ($seccion) {
            case "usuario":
                switch ($rol) {
                    default:
                        show_404();
                        break;

                    case 'ADMINISTRADOR':
                        $data['seccion'] = $seccion;
                        $data['rol'] = $rol;
                        $this->load->view('admin/altas_consultas', $data);
                        break;
                }
                break;
            case "alta":
                switch ($rol) {
                    default:
                        show_404();
                        break;

                    case 'ADMINISTRADOR':
                        $rules = reglasInsertar('usuario');
                        $data['seccion'] = "alta_usuario";
                        $data['rol'] = $rol;
                        $data['consulta'] = $this->db->get('permiso');

                        $this->form_validation->set_rules($rules);
                        if ($this->form_validation->run() == FALSE) {
                            $this->load->view('admin/altas_consultas', $data);
                        } else {
                            $idTienda = $tienda['idTienda'];
                            $user = datosInsertar('usuario', $idTienda);
                            $insertar = $this->db->insert('usuario', $user);
                            if ($insertar) {
                                /* $this->load->library('email');
                                  $this->email->from('no-reply@eshop.com', 'No Reply');
                                  $this->email->to(set_value('correro'));
                                  $this->email->cc('jmarquez@estrategiasdigitales.com.mx');
                                  //$this->email->bcc('them@their-example.com');
                                  $this->email->subject('Email Test');
                                  $this->email->message('Testing the email class.');
                                  $config['protocol'] = 'smtp';
                                  $config['mailpath'] = '/usr/sbin/sendmail';
                                  $config['charset'] = 'iso-8859-1';
                                  $config['wordwrap'] = TRUE;
                                  $this->email->initialize($config);
                                  $this->email->send(); */
                                $this->phpsession->flashsave('insert_message', 'El Usuario se ha creado con éxito.');
                                //echo $this->email->print_debugger();
                                redirect('admin/dashboard/usuario/alta');
                            } else {
                                $this->phpsession->flashsave('insert_message', 'Error #2420: No se pudo crear al usuario; por favor contacte a su administrador.');
                                redirect('admin/dashboard/usuario/alta');
                            }
                        }
                        break;
                }
                break;
            case "consulta":
                switch ($rol) {
                    default:
                        show_404();
                        break;
                    case 'ADMINISTRADOR':
                        $data['seccion'] = "consulta_usuario";
                        $data['rol'] = $rol;
                        $this->db->where('usuario.Tienda_idTienda', $tienda['idTienda']);
                        $this->db->order_by('idUsuario', 'asc');
                        $this->db->select('*');
                        $this->db->from('usuario');
                        $this->db->join('permiso', 'usuario.Permiso_idPermiso = permiso.idPermiso');
                        $data['consulta'] = $this->db->get();
                        $this->load->view('admin/altas_consultas', $data);

                        break;
                }
                break;
            case "desactivar":
                switch ($rol) {
                    default:
                        show_404();
                        break;
                    case 'ADMINISTRADOR':
                        if ($cliente_url == 'none') {
                            redirect('admin/dashboard/usuario/consulta');
                        }
                        $this->db->where('idUsuario', $cliente_url);
                        $update = $this->db->update('usuario', array('activo' => 'NO'));
                        redirect('admin/dashboard/usuario/consulta');
                        break;
                }
                break;
            case "activar":
                switch ($rol) {
                    default:
                        show_404();
                        break;
                    case 'ADMINISTRADOR':
                        if ($cliente_url == 'none') {
                            redirect('admin/dashboard/usuario/consulta');
                        }
                        $this->db->where('idUsuario', $cliente_url);
                        $update = $this->db->update('usuario', array('activo' => 'SI'));
                        redirect('admin/dashboard/usuario/consulta');
                        break;
                }
                break;
            case "ver":
                switch ($rol) {
                    default:
                        show_404();
                        break;
                    case 'ADMINISTRADOR':
                        if ($cliente_url == 'none') {
                            redirect('admin/dashboard/usuario/consulta');
                        }
                        //$buscar = str_replace('_',' ',$cliente_url);
                        //$sql = $this->db->get_where('usuario', array('idTipoCliente'=>$cliente_url));
                        //$data['consulta'] = $sql;
                        $data['seccion'] = "ver_usuario";
                        $data['rol'] = $rol;
                        $this->db->order_by('idUsuario', 'asc');
                        $this->db->select('*');
                        $this->db->from('usuario');
                        $this->db->where('idUsuario', $cliente_url);
                        $this->db->join('permiso', 'usuario.Permiso_idPermiso = permiso.idPermiso');
                        $data['consulta'] = $this->db->get();
                        $this->load->view('admin/altas_consultas', $data);

                        break;
                }
                break;
            case "editar":
                switch ($rol) {
                    default:
                        show_404();
                        break;
                    case 'ADMINISTRADOR':
                        if ($cliente_url == 'none') {
                            redirect('admin/dashboard/usuario/consulta');
                        }
                        //$buscar = str_replace('_',' ',$cliente_url);
                        //$sql = $this->db->get_where('tipocliente', array('idTipoCliente'=>$cliente_url));
                        //$data['consulta'] = $sql;
                        $data['seccion'] = "editar_usuario";
                        $data['rol'] = $rol;
                        $sql = $this->db->get_where('usuario', array('idUsuario' => $cliente_url, 'Tienda_idTienda' => $tienda['idTienda']));
                        if ($sql->num_rows() < 1) {
                            redirect('dashboard/tipo_cliente/consulta');
                        }
                        $data['consulta'] = $sql;
                        $rules = reglasInsertar('editar_usuario');
                        $this->form_validation->set_rules($rules);
                        if ($this->form_validation->run() == FALSE) {
                            $this->load->view('admin/altas_consultas', $data);
                        } else {
                            $idTienda = $tienda['idTienda'];
                            $usuario = datosInsertar('editar_usuario', $idTienda);
                            $this->db->where('idUsuario', $cliente_url);
                            $update = $this->db->update('usuario', $usuario);
                            if ($update) {
                                $this->phpsession->flashsave('update_message', "El Usuario se ha actualizado con éxito.");
                                redirect("admin/dashboard/usuario/consulta");
                            } else {
                                $this->phpsession->flashsave('update_message', 'Error #2420: No se pudo crear el usuario; por favor contacte a su administrador.');
                                redirect("admin/dashboard/usuario/editar/$cliente_url");
                            }
                        }
                        break;
                }
                break;
            default:
                show_404();
                break;
        }
    }

    public function checkUser($user) {

        $sql = $this->db->get_where('usuario', array('correo' => $user));

        if ($sql->num_rows() == 1) {
            return true;
        } else {
            $this->form_validation->set_message('checkUser', 'El campo %s no contiene un usuario válido.');
            return false;
        }
    }

    public function checkPass($pass) {
        $sql = $this->db->get_where('usuario', array('pass' => ($pass)));

        if ($sql->num_rows() > 0) {
            return true;
        } else {
            $this->form_validation->set_message('checkPass', 'Error al intentar entrar al sistema.');
            return false;
        }
    }

    public function checkMail($user) {
        $sql = $this->db->get_where('usuario', array('correo' => $user));

        if ($sql->num_rows() == 1) {
            $this->form_validation->set_message('checkMail', 'El campo %s ya esta en uso.');
            return false;
        } else {
            return true;
        }
    }

    public function salir() {

        $consulta_user = $this->db->get_where('usuario', array('secure_number' => $secure_number));
        foreach ($consulta_user->result() as $user) {

            $this->db->where('idUsuario', $user->idUsuario);
            $this->db->update('usuario', array('secure_number' => NULL));
        }
        $newdata = array(
            'secure_number' => NULL,
            'tienda' => NULL,
            'logged' => FALSE
        );
        //$this->session->unset_userdata($newdata);

        unset($_SESSION['userdata']);
        //echo site_url('admin/dashboard');
        redirect('admin/dashboard');
    }

    public function terminar_sesion($secure_number1) {
        $secure_number = $_SESSION['userdata']['secure_number'];
        $logged = $_SESSION['userdata']['logged'];
        if ($logged != TRUE) {
            redirect('admin/dashboard');
        }
        $consulta_user = $this->db->get_where('usuario', array('secure_number' => $secure_number));
        $user = datosUser($consulta_user);
        $consulta_rol = $this->db->get_where('permiso', array('idPermiso' => $user['permiso']));
        $rol = permisoUser($consulta_rol);
        if ($rol == 'ADMINISTRADOR') {
            $consulta_user1 = $this->db->get_where('usuario', array('secure_number' => $secure_number1));
            foreach ($consulta_user1->result() as $user) {

                $this->db->where('idUsuario', $user->idUsuario);
                $this->db->update('usuario', array('secure_number' => NULL));
            }
            redirect('admin/dashboard/usuario/consulta');
        }
    }

}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */