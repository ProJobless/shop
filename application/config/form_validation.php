<?php

$config = array(
    'entrar_cuenta' => array(
        array(
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'required|callback__check_combination'
        ),
        array(
            'field' => 'pass',
            'label' => 'Contraseña',
            'rules' => 'required'
        )
    ),
    'alta_cliente' => array(
        array(
            'field' => "tipo",
            'label' => 'Tipo de Cliente',
            'rules' => 'required'
        ),
        array(
            'field' => "nombres",
            'label' => 'Nombre(s)',
            'rules' => 'required'
        ),
        array(
            'field' => "apellidos",
            'label' => 'Apellido(s)',
            'rules' => 'required'
        ),
        array(
            'field' => "email",
            'label' => 'Correo Electrónico',
            'rules' => 'required|valid_email'
        ),
        array(
            'field' => "email1",
            'label' => 'Confirmar Correo Electrónico',
            'rules' => 'required|matches[email]'
        ),
        array(
            'field' => "telefono",
            'label' => 'Teléfono',
            'rules' => 'required|numeric'
        ),
        array(
            'field' => "tipo_telefono",
            'label' => 'Tipo Teléfono',
            'rules' => 'required'
        ),
        array(
            'field' => "razon",
            'label' => 'Razón Social o Comercial',
            'rules' => ''
        ),
        array(
            'field' => "calle",
            'label' => 'Calle y Número',
            'rules' => 'required'
        ),
        array(
            'field' => "colonia",
            'label' => 'Colonia',
            'rules' => 'required'
        ),
        array(
            'field' => "delegacion",
            'label' => 'Delegación o Municipio',
            'rules' => 'required'
        ),
        array(
            'field' => "cp",
            'label' => 'Código Postal',
            'rules' => 'required|numeric'
        ),
        array(
            'field' => "ciudad",
            'label' => 'Ciudad',
            'rules' => 'required'
        ),
        array(
            'field' => "estado",
            'label' => 'Estado',
            'rules' => 'required'
        ),
        array(
            'field' => "pass",
            'label' => 'Contraseña',
            'rules' => 'required'
        ),
        array(
            'field' => "pass1",
            'label' => 'Confirmar Contraseña',
            'rules' => 'required|matches[pass]'
        )
    ),
    'alta_surtidor' => array(
        array(
            'field' => 'nombre',
            'label' => 'Nombre Completo',
            'rules' => 'required'
        )
    ),
    'correos' => array(
        array(
            'field' => "nombre",
            'label' => 'Nombre',
            'rules' => 'required'
        ),
        array(
            'field' => "direccion",
            'label' => 'Dirección',
            'rules' => 'required'
        ),
        array(
            'field' => "seccion",
            'label' => 'Sección',
            'rules' => 'required'
        )
    ),
    'guardar_pedido' => array(
        array(
            'field' => "f_razon",
            'label' => 'Nombre o Razón Social(Factura)',
            'rules' => 'callback__factura_completa'
        ),
        array(
            'field' => "f_rfc",
            'label' => 'RFC(Factura)',
            'rules' => 'alpha_numeric|callback__factura_completa'
        ),
        array(
            'field' => "f_calle",
            'label' => 'Calle(Factura)',
            'rules' => 'callback__factura_completa'
        ),
        array(
            'field' => "f_colonia",
            'label' => 'Colonia(Factura)',
            'rules' => 'callback__factura_completa'
        ),
        array(
            'field' => "f_cp",
            'label' => 'Código Postal(Factura)',
            'rules' => 'numeric|callback__factura_completa'
        ),
        array(
            'field' => "f_delegacion",
            'label' => 'Delegación(Factura)',
            'rules' => 'callback__factura_completa'
        ),
        array(
            'field' => "f_estado",
            'label' => 'Estado(Factura)',
            'rules' => 'callback__factura_completa'
        ),
        array(
            'field' => "f_pais",
            'label' => 'País(Factura)',
            'rules' => 'callback__factura_completa'
        ),
        array(
            'field' => "e_persona",
            'label' => 'Persona que recibe(Envío)',
            'rules' => 'callback__envio_completa'
        ),
        array(
            'field' => "e_calle",
            'label' => 'Calle(Envío)',
            'rules' => 'callback__envio_completa'
        ),
        array(
            'field' => "e_colonia",
            'label' => 'Colonia(Envío)',
            'rules' => 'callback__envio_completa'
        ),
        array(
            'field' => "e_cp",
            'label' => 'Código Postal(Envío)',
            'rules' => 'numeric|callback__envio_completa'
        ),
        array(
            'field' => "e_delegacion",
            'label' => 'Delegación(Envío)',
            'rules' => 'callback__envio_completa'
        ),
        array(
            'field' => "e_estado",
            'label' => 'Estado(Envío)',
            'rules' => 'callback__envio_completa'
        ),
        array(
            'field' => "e_pais",
            'label' => 'País(Envío)',
            'rules' => 'callback__envio_completa'
        ),
        array(
            'field' => "forma_pago",
            'label' => 'Forma de Pago',
            'rules' => 'required'
        )
    )
    
);