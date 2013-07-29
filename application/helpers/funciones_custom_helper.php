<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function datosTienda($consulta){
	foreach($consulta->result() as $tent){
		$tienda['idTienda'] = $tent->idTienda;
		$tienda['nombre'] = $tent->nombre;
		$tienda['descripcion'] = $tent->descripcion;
		$tienda['logo'] = $tent->logo;
	}
	return $tienda;
}

function datosUser($consulta){
	foreach($consulta->result() as $user){
		$usuario['idUsuario'] = $user->idUsuario;
		$usuario['correo'] = $user->correo;
		$usuario['pass'] = $user->pass;
		$usuario['tienda'] = $user->Tienda_idTienda;
		$usuario['permiso'] = $user->Permiso_idPermiso;
	}
	return $usuario;
}

function datosCliente($consulta){
	foreach($consulta->result() as $cliente){
		$usuario['idCliente'] = $cliente->idCliente;
		$usuario['secure_number'] = $cliente->secure_number;
		$usuario['contrasena'] = $cliente->contrasena;
		$usuario['TipoCliente_idTipoCliente'] = $cliente->TipoCliente_idTipoCliente;
		$usuario['Tienda_idTienda'] = $cliente->Tienda_idTienda;
		$usuario['Empresa_idEmpresa'] = $cliente->Empresa_idEmpresa;
		$usuario['Direccion_idDireccion'] = $cliente->Direccion_idDireccion;
	}
	return $usuario;
}

function permisoUser($consulta){
	foreach($consulta->result() as $permiso){
		$rol = $permiso->descripcion;
	}
	return $rol;
}

function reglasInsertar($formulario,$idioma = false){
	switch($formulario){
		case 'promocion':
			$rules =array(
							array(
								'field'   => 'precio_promocion',
								'label'   => 'Precio',
								'rules'   => 'required|numeric'
							),
							array(
								'field'   => 'fecha_inicio',
								'label'   => 'Fecha de Inicio',
								'rules'   => 'required|callback_checkFecha'
							),
							array(
								'field'   => 'fecha_final',
								'label'   => 'Fecha de Finalización',
								'rules'   => 'required|callback_checkFecha'
							)
						);
		break;
		case "editar_tipo_cliente":
		case "tipo_cliente":
			$rules =array(
							array(
								'field'   => 'nombre',
								'label'   => 'Nombre',
								'rules'   => 'required'
							),
							array(
								'field'   => 'descripcion',
								'label'   => 'Descripción',
								'rules'   => ''
							),
							array(
								'field'   => 'descuento',
								'label'   => 'Descuento',
								'rules'   => 'required|numeric|greater_than[-1]|less_than[200]'
							),
							array(
								'field'   => 'abreviatura',
								'label'   => 'Abreviatura TC',
								'rules'   => 'required'
							),
							array(
								'field'   => 'descripcion_en',
								'label'   => 'Descripción Inglés',
								'rules'   => ''
							),
							array(
								'field'   => 'nombre_en',
								'label'   => 'Nombre Inglés',
								'rules'   => ''
							),
							array(
								'field'   => 'promocion',
								'label'   => 'Descuento por Promoción',
								'rules'   => ''
							)
					);
		break;
		
			
		case "usuario":
			$rules =array(
							array(
								'field'   => 'correo',
								'label'   => 'Correo Electrónico',
								'rules'   => 'required|valid_email|callback_checkMail'
							),
							array(
								'field'   => 'password1',
								'label'   => 'Contraseña',
								'rules'   => 'required'
							),
							array(
								'field'   => 'password2',
								'label'   => 'Confirmacion de Contraseña',
								'rules'   => 'required|matches[password1]'
							),
							array(
								'field'   => 'permiso',
								'label'   => 'Permiso',
								'rules'   => 'required|greater_than[0]'
							)
					);
		break;
		case "editar_usuario":
			$rules =array(
							array(
								'field'   => 'actualiza_correo',
								'label'   => 'Correo Electrónico',
								'rules'   => 'required|valid_email'
							),
							array(
								'field'   => 'actualiza_password1',
								'label'   => 'Contraseña',
								'rules'   => 'matches[actualiza_password2]'
							),
							array(
								'field'   => 'actualiza_password2',
								'label'   => 'Confirmacion de Contraseña',
								'rules'   => 'matches[actualiza_password1]'
							)
					);
		break;
		case "editar_cliente_general":
		case "alta_cliente_general":
			$rules =array(
							array(
								'field'   => 'claveletra',
								'label'   => 'Tipo de Usuario',
								'rules'   => 'required|greater_than[0]'
							),
							array(
								'field'   => 'nombres',
								'label'   => 'Nombre',
								'rules'   => 'required'
							),
							array(
								'field'   => 'apellidos',
								'label'   => 'Apellido',
								'rules'   => 'required'
							),array(
								'field'   => 'titulo',
								'label'   => 'Titulo o Profesión',
								'rules'   => ''
							),array(
								'field'   => 'email',
								'label'   => 'Email Personal',
								'rules'   => 'valid_email'
							),array(
								'field'   => 'otroemail',
								'label'   => 'Otro Email Personal',
								'rules'   => 'valid_email'
							),array(
								'field'   => 'codigopais',
								'label'   => 'Código País',
								'rules'   => 'numeric'
							),array(
								'field'   => 'area',
								'label'   => 'Área/Lada',
								'rules'   => 'numeric'
							),array(
								'field'   => 'telefono',
								'label'   => 'Teléfono',
								'rules'   => 'numeric'
							),array(
								'field'   => 'ext',
								'label'   => 'Extensión',
								'rules'   => ''
							),array(
								'field'   => 'codigopaismovil',
								'label'   => 'Código País Móvil',
								'rules'   => 'numeric'
							),array(
								'field'   => 'areamovil',
								'label'   => 'Área/Lada Móvil',
								'rules'   => 'numeric'
							),array(
								'field'   => 'telefonomovil',
								'label'   => 'Teléfono Móvil',
								'rules'   => 'numeric'
							),array(
								'field'   => 'calle',
								'label'   => 'Calle',
								'rules'   => ''
							),array(
								'field'   => 'numext',
								'label'   => 'Número Exterior',
								'rules'   => ''
							),array(
								'field'   => 'numint',
								'label'   => 'Número Interior',
								'rules'   => ''
							),array(
								'field'   => 'colonia',
								'label'   => 'Colonia',
								'rules'   => ''
							),array(
								'field'   => 'delegacion',
								'label'   => 'Delegación o Municipio',
								'rules'   => ''
							),array(
								'field'   => 'codigo',
								'label'   => 'Código Postal',
								'rules'   => 'numeric'
							),array(
								'field'   => 'ciudad',
								'label'   => 'Ciudad',
								'rules'   => ''
							),array(
								'field'   => 'web',
								'label'   => 'Sitio Web',
								'rules'   => ''
							),array(
								'field'   => 'meses',
								'label'   => 'Mes',
								'rules'   => ''
							),array(
								'field'   => 'dias',
								'label'   => 'Día',
								'rules'   => ''
							),array(
								'field'   => 'estados',
								'label'   => 'Estado',
								'rules'   => ''
							),array(
								'field'   => 'paises',
								'label'   => 'País',
								'rules'   => ''
							)
					);
		break;
		case "editar_cliente_empresa":
			$rules =array(
							array(
								'field'   => 'empresa',
								'label'   => 'Empresa',
								'rules'   => 'required'
							),
							array(
								'field'   => 'emailt',
								'label'   => 'Email del Trabajo',
								'rules'   => 'required|valid_email|callback_checkClient'
							),
							array(
								'field'   => 'codigopaistf',
								'label'   => 'Código del País del Teléfono',
								'rules'   => 'numeric'
							),array(
								'field'   => 'areatf',
								'label'   => 'Área del País del Teléfono',
								'rules'   => 'required|numeric'
							),array(
								'field'   => 'telof',
								'label'   => 'Teléfono',
								'rules'   => 'required|numeric'
							),array(
								'field'   => 'calle',
								'label'   => 'Calle',
								'rules'   => 'required'
							),array(
								'field'   => 'numext',
								'label'   => 'Número Exterior',
								'rules'   => 'required'
							),array(
								'field'   => 'numint',
								'label'   => 'Número Interior',
								'rules'   => 'required'
							),array(
								'field'   => 'colonia',
								'label'   => 'Colonia',
								'rules'   => 'required'
							),array(
								'field'   => 'delegacion',
								'label'   => 'Delegación',
								'rules'   => 'required'
							),array(
								'field'   => 'codigo',
								'label'   => 'Código Postal',
								'rules'   => 'required|numeric'
							),array(
								'field'   => 'estados',
								'label'   => 'Estado',
								'rules'   => 'required'
							),array(
								'field'   => 'paises',
								'label'   => 'País',
								'rules'   => 'required'
							),array(
								'field'   => 'cargo',
								'label'   => 'Cargo',
								'rules'   => ''
							),array(
								'field'   => 'oemailt',
								'label'   => 'Otro Email del Trabajo',
								'rules'   => 'valid_email'
							),array(
								'field'   => 'exttf',
								'label'   => 'Extensión',
								'rules'   => 'numeric'
							),array(
								'field'   => 'codigopaistm',
								'label'   => 'Código del País del Teléfono Móvil',
								'rules'   => 'numeric'
							),array(
								'field'   => 'areatm',
								'label'   => 'Área del País del Teléfono Móvil',
								'rules'   => 'numeric'
							),array(
								'field'   => 'telmof',
								'label'   => 'Teléfono Móvil',
								'rules'   => 'numeric'
							),array(
								'field'   => 'fax',
								'label'   => 'Fax',
								'rules'   => 'numeric'
							),array(
								'field'   => 'webt',
								'label'   => 'Sitio Web',
								'rules'   => ''
							),array(
								'field'   => 'ciudad',
								'label'   => 'Ciudad',
								'rules'   => 'required'
							)
					);
		break;
		case "editar_cliente_nota":
			$rules =array(
							array(
								'field'   => 'nota',
								'label'   => 'Nota',
								'rules'   => ''
							)
					);
		break;
		case "editar_cliente_password":
			$rules =array(
							array(
								'field'   => 'contrasena',
								'label'   => 'Contraseña',
								'rules'   => ''
							),array(
								'field'   => 'contrasena1',
								'label'   => 'Confirmar Contraseña',
								'rules'   => 'matches[contrasena]'
							)
					);
		break;
		case "editar_categoria":
		case "alta_categoria":
			$rules =array(
							array(
								'field'   => 'nombre',
								'label'   => 'Nombre',
								'rules'   => 'required'
							),array(
								'field'   => 'nombre_en',
								'label'   => 'Nombre Inglés',
								'rules'   => ''
							)
					);
		break;
		case "editar_subcategoria":
		case "alta_subcategoria":
			$rules =array(
							array(
								'field'   => 'nombre',
								'label'   => 'Nombre',
								'rules'   => 'required'
							),array(
								'field'   => 'categoria',
								'label'   => 'Categoria',
								'rules'   => 'required|greater_than[0]'
							),array(
								'field'   => 'nombre_en',
								'label'   => 'Nombre',
								'rules'   => ''
							)
					);
		break;
		case "editar_producto":
		case "alta_producto":
			$rules =array(
							array(
								'field'   => 'nombre',
								'label'   => 'Nombre Producto',
								'rules'   => 'required'
							),array(
								'field'   => 'uso',
								'label'   => 'Información de principales ingredientes',
								'rules'   => 'required'
							),array(
								'field'   => 'experto',
								'label'   => 'Opinión de Expertos',
								'rules'   => ''
							),array(
								'field'   => 'testimonio',
								'label'   => 'Comentarios al Producto',
								'rules'   => ''
							),array(
								'field'   => 'categoria',
								'label'   => 'Subcategoria',
								'rules'   => 'required|greater_than[0]'
							),array(
								'field'   => 'uso_en',
								'label'   => 'Información de principales ingredientes Inglés',
								'rules'   => ''
							),array(
								'field'   => 'experto_en',
								'label'   => 'Opinión de Experto Inglés',
								'rules'   => ''
							)
					);
		break;
		case "editar_presentacion_admin":
		case "alta_presentacion_admin":
			$rules =array(
							array(
								'field'   => 'producto',
								'label'   => 'Nombre Producto',
								'rules'   => 'required|greater_than[0]'
							),array(
								'field'   => 'clave',
								'label'   => 'Clave',
								'rules'   => 'required'
							),array(
								'field'   => 'estado',
								'label'   => 'Estado Físico',
								'rules'   => ''
							),array(
								'field'   => 'contenido',
								'label'   => 'Contenido Neto',
								'rules'   => ''
							),array(
								'field'   => 'grupo',
								'label'   => 'Grupo',
								'rules'   => ''
							),array(
								'field'   => 'ingredientes',
								'label'   => 'Ingredientes',
								'rules'   => ''
							),array(
								'field'   => 'precio',
								'label'   => 'Precio Público',
								'rules'   => 'numeric'
							),array(
								'field'   => 'iva[]',
								'label'   => 'I.V.A.(16%)',
								'rules'   => ''
							),array(
								'field'   => 'video',
								'label'   => 'Vídeo',
								'rules'   => ''
							),array(
								'field'   => 'estado_en',
								'label'   => 'Estado Físico Inglés',
								'rules'   => ''
							),array(
								'field'   => 'contenido_en',
								'label'   => 'Contenido Neto Inglés',
								'rules'   => ''
							),array(
								'field'   => 'video_en',
								'label'   => 'Video Inglés',
								'rules'   => ''
							)
					);
		break;
		case "editar_presentacion_info":
		case "alta_presentacion_info":
			$rules =array(
							array(
								'field'   => 'producto',
								'label'   => 'Nombre Producto',
								'rules'   => 'required|greater_than[0]'
							),array(
								'field'   => 'clave',
								'label'   => 'Clave',
								'rules'   => 'required'
							),array(
								'field'   => 'estado',
								'label'   => 'Estado Físico',
								'rules'   => ''
							),array(
								'field'   => 'contenido',
								'label'   => 'Contenido Neto',
								'rules'   => ''
							),array(
								'field'   => 'grupo',
								'label'   => 'Grupo',
								'rules'   => ''
							),array(
								'field'   => 'estado_en',
								'label'   => 'Estado Físico Inglés',
								'rules'   => ''
							),array(
								'field'   => 'contenido_en',
								'label'   => 'Contenido Neto Inglés',
								'rules'   => ''
							)
					);
		break;
		case "editar_presentacion_info_ingredientes":
			$rules =array(
							array(
								'field'   => 'ingredientes',
								'label'   => 'Ingredientes',
								'rules'   => ''
							)
					);
		break;
		case "editar_presentacion_precio":
			$rules =array(
							array(
								'field'   => 'precio',
								'label'   => 'Precio Público',
								'rules'   => 'required|numeric'
							),array(
								'field'   => 'iva[]',
								'label'   => 'I.V.A.(16%)',
								'rules'   => ''
							)
					);
		break;
		case "editar_presentacion_video":
			$rules =array(
							array(
								'field'   => 'video',
								'label'   => 'Vídeo',
								'rules'   => 'required'
							),array(
								'field'   => 'video_en',
								'label'   => 'Video Inglés',
								'rules'   => ''
							)
					);
		break;
		case "editar_reporte":
			$rules =array(
							array(
								'field'   => 'persona_uno',
								'label'   => 'Persona Uno',
								'rules'   => 'required'
							),array(
								'field'   => 'persona_dos',
								'label'   => 'Persona Dos',
								'rules'   => 'required'
							),array(
								'field'   => 'fecha',
								'label'   => 'Fecha',
								'rules'   => 'required'
							),array(
								'field'   => 'hora',
								'label'   => 'Hora',
								'rules'   => 'required'
							),array(
								'field'   => 'observaciones',
								'label'   => 'Observaciones',
								'rules'   => 'required'
							),array(
								'field'   => 'numero',
								'label'   => 'Número',
								'rules'   => 'required'
							),array(
								'field'   => 'hechos',
								'label'   => 'Hechos',
								'rules'   => 'required'
							),array(
								'field'   => 'localizacion',
								'label'   => 'Localización',
								'rules'   => 'required'
							),array(
								'field'   => 'acciones',
								'label'   => 'Acciones',
								'rules'   => 'required'
							),array(
								'field'   => 'idestado',
								'label'   => 'Id Estado',
								'rules'   => 'required'
							),array(
								'field'   => 'idpedido',
								'label'   => 'Id Pedido',
								'rules'   => 'required'
							),array(
								'field'   => 'numero2',
								'label'   => 'Número Dos',
								'rules'   => 'required'
							),array(
								'field'   => 'fajos2',
								'label'   => 'Fajos atados con 2',
								'rules'   => 'required'
							),array(
								'field'   => 'fajos3',
								'label'   => 'Fajos atados con 3',
								'rules'   => 'required'
							),array(
								'field'   => 'bultos',
								'label'   => 'Bultos',
								'rules'   => 'required'
							),array(
								'field'   => 'seguro',
								'label'   => 'Seguro',
								'rules'   => 'required'
							),array(
								'field'   => 'cajas',
								'label'   => 'Cajas',
								'rules'   => 'required'
							)
					);
		break;
		case "editar_tipo_cambio":
			$rules =array(
							array(
								'field'   => 'valor',
								'label'   => 'Valor del Tipo de Cambio',
								'rules'   => 'required|numeric'
							)
					);
		break;
		default:
			$rules = "none";
		break;
	}
	return $rules;
}

function datosInsertar($formulario,$tienda_id,$idioma = true){
	switch($formulario){
		case "promocion":
			$Presentacion_idPresentacion = $_POST['id'];
			$precio_promocion = set_value(precio_promocion);
			$fecha_inicio = set_value(fecha_inicio);
			$fecha_final = set_value(fecha_final);
			$insert = array(
				'Presentacion_idPresentacion' => $Presentacion_idPresentacion ,
				'precio' => $precio_promocion ,
				'date_start' => $fecha_inicio,
				'date_end' => $fecha_final
			);
		break;
		case "editar_reporte":
			$Pedido_idPedido = set_value('idpedido');
			$Estado_idEstado = set_value('idestado');
			$persona_uno = set_value('persona_uno');
			$persona_dos = set_value('persona_dos');
			$fecha = set_value('fecha');
			$hora = set_value('hora');
			$observaciones = '<b style="font-size:9px;">'.date('d/m/Y H:i:s').'</b><br/>'.$_POST['observaciones'];
			$numero = set_value('numero');
			$hechos = set_value('hechos');
			$localizacion = set_value('localizacion');
			$acciones = $_POST['acciones'];
			$fajos2 = set_value('fajos2');
			$fajos3 = set_value('fajos3');
			$bultos = set_value('bultos');
			$numero2 = set_value('numero2');
			$seguro = set_value('seguro');
			$cajas = set_value('cajas');
			$insert = array(
				'Pedido_idPedido' => $Pedido_idPedido ,
				'Estado_idEstado' => $Estado_idEstado ,
				'persona_uno' => $persona_uno,
				'persona_dos' => $persona_dos,
				'fecha' => $fecha,
				'hora' => $hora,
				'observaciones' => $observaciones,
				'numero' => $numero,
				'hechos' => $hechos,
				'localizacion' => $localizacion,
				'acciones' => $acciones,
				'fajos2' => $fajos2,
				'fajos3' => $fajos3,
				'bultos' => $bultos,
				'numero2' => $numero2,
				'seguro' => $seguro,
				'cajas' => $cajas
			);
		break;
		case "editar_tipo_cliente":
		case "tipo_cliente":
			$nombre = set_value('nombre');
			$descripcion = $_POST['descripcion'];
			$descuento = set_value('descuento');
			$promocion = set_value('promocion');
			$abreviatura = set_value('abreviatura');
			if($idioma){
				$nombre_en = set_value('nombre_en');
				$descripcion_en = $_POST['descripcion_en'];
			}else{
				$nombre_en = 'none';
				$descripcion_en = 'none';
			}

			$insert = array(
				'nombre' => $nombre ,
				'descripcion' => $descripcion ,
				'precio_cliente' => $descuento,
				'promocion' => $promocion,
				'nombre_en' => $nombre_en,
				'descripcion_en' => $descripcion_en,
				'abreviatura' => $abreviatura,
				'Tienda_idTienda' => $tienda_id
			);
		break;
		case "usuario":
			$correo = set_value('correo');
			$password = (set_value('password1'));
			$permiso = set_value('permiso');
			$insert = array(
				'correo' => $correo ,
				'pass' => $password ,
				'Permiso_idPermiso' => $permiso,
				'Tienda_idTienda' => $tienda_id
			);
		break;
		case "editar_usuario":
			$correo = set_value('actualiza_correo');
			if(!empty($_POST['actualiza_password1'])){
			$password = (set_value('actualiza_password1'));
			$insert = array(
				'correo' => $correo ,
				'pass' => $password ,
				'Tienda_idTienda' => $tienda_id
			);
			}else{
			$insert = array(
				'correo' => $correo ,
				'Tienda_idTienda' => $tienda_id
			);
			}
			
		break;
		case "alta_cliente_general":
			if(empty($_POST['codigopais'])){$codigopais = "none";}else{$codigopais = set_value('codigopais');}
			if(empty($_POST['area'])){$area = "none";}else{$area = set_value('area');}
			if(empty($_POST['telefono'])){$telefono = "none";}else{$telefono = set_value('telefono');}
			if(empty($_POST['ext'])){$ext = "none";}else{$ext = set_value('ext');}
			if(empty($_POST['codigopaismovil'])){$codigopaismovil = "none";}else{$codigopaismovil = set_value('codigopaismovil');}
			if(empty($_POST['areamovil'])){$areamovil = "none";}else{$areamovil = set_value('areamovil');}
			if(empty($_POST['telefonomovil'])){$telefonomovil = "none";}else{$telefonomovil = set_value('telefonomovil');}
			$tipoCliente = set_value('claveletra');
			$titulo = set_value('titulo');
			$nombre = set_value('nombres');
			$apellido = set_value('apellidos');
			$nacimiento = set_value('dias')." de ".set_value('meses');
			$email_personal = set_value('email');
			$otro_email_personal = set_value('otroemail');
			$telefono_casa = "+".$codigopais." ".$area." ".$telefono." ext:".$ext;
			$telefono_movil = "+".$codigopaismovil." ".$areamovil." ".$telefonomovil;
			$sitio_web = set_value('web');
			$insert = array(
				'TipoCliente_idTipoCliente' => $tipoCliente,
				'titulo' => $titulo,
				'nombre' => $nombre,
				'apellido' => $apellido,
				'fecha_nacimiento' => $nacimiento,
				'correo' => $email_personal,
				'correo_otro' => $otro_email_personal,
				'telefono' => $telefono_casa,
				'telefono_celular' => $telefono_movil,
				'sitio_web' => $sitio_web,
				'Tienda_idTienda' => $tienda_id,
				'Empresa_idEmpresa' => 2,
				'Direccion_idDireccion' => 1
			);
			
		break;
		case "edicion_cliente_general":
			if(empty($_POST['codigopais'])){$codigopais = "none";}else{$codigopais = set_value('codigopais');}
			if(empty($_POST['area'])){$area = "none";}else{$area = set_value('area');}
			if(empty($_POST['telefono'])){$telefono = "none";}else{$telefono = set_value('telefono');}
			if(empty($_POST['ext'])){$ext = "none";}else{$ext = set_value('ext');}
			if(empty($_POST['codigopaismovil'])){$codigopaismovil = "none";}else{$codigopaismovil = set_value('codigopaismovil');}
			if(empty($_POST['areamovil'])){$areamovil = "none";}else{$areamovil = set_value('areamovil');}
			if(empty($_POST['telefonomovil'])){$telefonomovil = "none";}else{$telefonomovil = set_value('telefonomovil');}
			$tipoCliente = set_value('claveletra');
			$titulo = set_value('titulo');
			$nombre = set_value('nombres');
			$apellido = set_value('apellidos');
			$nacimiento = set_value('dias')." de ".set_value('meses');
			$email_personal = set_value('email');
			$otro_email_personal = set_value('otroemail');
			$telefono_casa = "+".$codigopais." ".$area." ".$telefono." ext:".$ext;
			$telefono_movil = "+".$codigopaismovil." ".$areamovil." ".$telefonomovil;
			$sitio_web = set_value('web');
			$insert = array(
				'TipoCliente_idTipoCliente' => $tipoCliente,
				'titulo' => $titulo,
				'nombre' => $nombre,
				'apellido' => $apellido,
				'fecha_nacimiento' => $nacimiento,
				'correo' => $email_personal,
				'correo_otro' => $otro_email_personal,
				'telefono' => $telefono_casa,
				'telefono_celular' => $telefono_movil,
				'sitio_web' => $sitio_web,
				'Tienda_idTienda' => $tienda_id
			);
		break;
		case "edicion_cliente_empresa":
			if(empty($_POST['codigopaistf'])){$codigopais = "none";}else{$codigopais = set_value('codigopaistf');}
			if(empty($_POST['areatf'])){$area = "none";}else{$area = set_value('areatf');}
			if(empty($_POST['telof'])){$telefono = "none";}else{$telefono = set_value('telof');}
			if(empty($_POST['exttf'])){$ext = "none";}else{$ext = set_value('exttf');}
			if(empty($_POST['codigopaistm'])){$codigopaismovil = "none";}else{$codigopaismovil = set_value('codigopaistm');}
			if(empty($_POST['areatm'])){$areamovil = "none";}else{$areamovil = set_value('areatm');}
			if(empty($_POST['telmof'])){$telefonomovil = "none";}else{$telefonomovil = set_value('telmof');}
			$razon_social = set_value('empresa');
			$cargo = set_value('cargo');
			$correo = set_value('emailt');
			$correo_otro = set_value('oemailt');
			$fax = set_value('fax');
			$sitio_web = set_value('webt');
			$telefono_oficina = "+".$codigopais." ".$area." ".$telefono." ext:".$ext;
			$telefono_celular = "+".$codigopaismovil." ".$areamovil." ".$telefonomovil;
			
			$insert = array(
				'razon_social' => $razon_social,
				'cargo' => $cargo,
				'correo' => $correo,
				'correo_otro' => $correo_otro,
				'fax' => $fax,
				'telefono' => $telefono_oficina,
				'telefono_celular' => $telefono_celular,
				'sitio_web' => $sitio_web,
				'Direccion_idDireccion' => 1
			);
			
		break;
		case "edicion_cliente_empresa_direccion":
		case "edicion_cliente_general_direccion":
		case 'alta_cliente_general_direccion':
			$calle = set_value('calle');
			$numero_exterior = set_value('numext');
			$numero_interior = set_value('numint');
			$colonia = set_value('colonia');
			$delegacion = set_value('delegacion');
			$codigo_postal = set_value('codigo');
			$ciudad = set_value('ciudad');
			$estado = set_value('estados');
			$pais = set_value('paises');
			$insert = array(
				'calle' => $calle,
				'numero_exterior' => $numero_exterior,
				'numero_interior' => $numero_interior,
				'colonia' => $colonia,
				'delegacion' => $delegacion,
				'codigo_postal' => $codigo_postal,
				'ciudad' => $ciudad,
				'estado' => $estado,
				'pais' => $pais
			);
		break;
		case "edicion_cliente_nota":
			$nota = trim($_POST['nota']);
			$insert = array(
				'nota' => $nota
			);
		break;
		case "edicion_cliente_password":
			$contrasena = (set_value('contrasena'));
			$insert = array(
				'contrasena' => $contrasena,
                                'activo' => 'SI'
			);
		break;
		case "editar_categoria":
			$nombre = set_value('nombre');
			if($idioma){
				$nombre_en = set_value('nombre_en');
			}else{
				$nombre_en = 'none';
			}
			
			$insert = array(
				'nombre' => $nombre,
				'nombre_en' => $nombre_en
			);
		break;
		case "alta_categoria":
			$nombre = set_value('nombre');
			if($idioma){
				$nombre_en = set_value('nombre_en');
			}else{
				$nombre_en = 'none';
			}
			$insert = array(
				'nombre' => $nombre,
				'nombre_en' => $nombre_en,
				'Tienda_idTienda' => $tienda_id
			);
		break;
		case "editar_subcategoria":
		case "alta_subcategoria":
			$nombre = set_value('nombre');
			$categoria = set_value('categoria');
			if($idioma){
				$nombre_en = set_value('nombre_en');
			}else{
				$nombre_en = 'none';
			}
			$insert = array(
				'nombre' => $nombre,
				'nombre_en' => $nombre_en,
				'Categoria_idCategoria' => $categoria
			);
		break;
		case "editar_producto":
		case "alta_producto":
			$nombre = set_value('nombre');
			$uso = $_POST['uso'];
			$experto = $_POST['experto'];
			$testimonio = $_POST['testimonio'];
			$subcategoria = set_value('categoria');
			$imagen = $_POST['newimagen'];
			if($idioma){
				$uso_en = $_POST['uso_en'];
				$experto_en = $_POST['experto_en'];
			}else{
				$uso_en = 'none';
				$experto_en = 'none';
			}
			$insert = array(
				'nombre' => $nombre ,
				'uso' => $uso ,
				'experto' => $experto ,
				'testimonio' => $testimonio ,
				'uso_en' => $uso_en,
				'experto_en' => $experto_en,
				'Subcategoria_idSubcategoria' => $subcategoria,
				'imagen' => $imagen
			);
		break;
		case "editar_presentacion_admin":
		case "alta_presentacion_admin":
			if(empty($_POST['iva'])){$iva = 'NO';}else{$iva = set_value('iva[]');}
			
			$producto = set_value('producto');
			$clave = set_value('clave');
			$estado = set_value('estado');
			$contenido = set_value('contenido');
			$grupo = set_value('grupo');
			$ingredientes = $_POST['ingredientes'];
			$precio = set_value('precio');
			$video = set_value('video');
			$imagen = $_POST['newimagen'];
			if($idioma){
				$estado_en = set_value('estado_en');
				$contenido_en = set_value('contenido_en');
				$video_en = set_value('video_en');
			}else{
				$estado_en = 'none';
				$contenido_en = 'none';
				$video_en = 'none';
			}
			$insert = array(
				'Producto_idProducto' => $producto ,
				'clave' => $clave ,
				'estado_fisico' => $estado,
				'contenido_neto' => $contenido,
				'grupo' => $grupo,
				'ingredientes' => $ingredientes,
				'iva' => $iva,
				'precio_publico' => $precio,
				'video' => $video,
				'estado_fisico_en' => $estado_en,
				'contenido_neto_en' => $contenido_en,
				'video_en' => $video_en,
				'imagen' => $imagen
			);
		break;
		case "editar_presentacion_info":
		case "alta_presentacion_info":
			
			
			$producto = set_value('producto');
			$clave = set_value('clave');
			$estado = set_value('estado');
			$contenido = set_value('contenido');
			$grupo = set_value('grupo');
			
			$imagen = $_POST['newimagen'];
			if($idioma){
				$estado_en = set_value('estado_en');
				$contenido_en = set_value('contenido_en');
			}else{
				$estado_en = 'none';
				$contenido_en = 'none';
			}
			$insert = array(
				'Producto_idProducto' => $producto ,
				'clave' => $clave ,
				'estado_fisico' => $estado,
				'contenido_neto' => $contenido,
				'grupo' => $grupo,
				'ingredientes' => $ingredientes,
				'imagen' => $imagen,
				'contenido_neto_en' => $contenido_en,
				'estado_fisico_en' => $estado_en
			);
		break;
		case "editar_presentacion_info_ingredientes":
			
			
			$producto = set_value('producto');
			$ingredientes = $_POST['ingredientes'];
			

			$insert = array(
				'ingredientes' => $ingredientes,
			);
		break;
		case "editar_presentacion_precio":
			if(empty($_POST['iva'])){$iva = 'NO';}else{$iva = set_value('iva[]');}
			
			$precio = set_value('precio');
			$insert = array(
				'iva' => $iva,
				'precio_publico' => $precio
			);
		break;
		case "editar_presentacion_video":
			
			
			$video = set_value('video');
			if($idioma){
				$video_en = set_value('video_en');
			}else{
				$video_en = 'none';
			}
			$insert = array(
				'video' => $video,
				'video_en' => $video_en
			);
		break;
		case "editar_tipo_cambio":
			
			
			$valor = set_value('valor');
			$insert = array(
				'valor' => $valor,
				'fecha' => date("d/m/Y H:i:s")
			);
		break;
		default:
			$insert = "none";
		break;
	}
	return $insert;
}

function calcula_dias($fecha_uno,$fecha_dos){

	//echo $fecha_uno."\n";
	//echo $fecha_dos."\n";
	$total = strtotime($fecha_dos) - strtotime($fecha_uno);
	$uno = explode('-',$fecha_uno);
	$dos = explode('-',$fecha_dos);

	$dia1 = explode(' ',$uno[2]);
	$dia2 = explode(' ',$dos[2]);
	$coincidencia = 0;
	for($i = $uno[0]; $i <= $dos[0]; $i++){

		
		$bisiesto = date('L',strtotime($dos[0]));

		for($j = $uno[1]; $j <= $dos[1]; $j++){

			
			$limit = ($j == 2 && $bisiesto == 1) ? 29 : ( ($j == 2) ? 28 : ( ($j == 1 || $j == 3 || $j == 5 || $j == 7 || $j == 8 || $j == 10 || $j == 12) ? 31 : 30 ) );

			for($k = 1; $k <= $limit; $k++){

					if( ($dia1[0] == $dia2[0]) && ($uno[1] == $dos[1])  ){
						//echo 'zero if ';
						if(($k == $dia1[0])){
							$dias[] = $i.'-'.$j.'-'.$k;
						}
						
						$coincidencia = 1;
						
					}elseif( ($dia1[0] != $dia2[0]) && ($uno[1] == $dos[1]) ){

						if( ($k >= $dia1[0]) && ($k <= $dia2[0]) ){
							$dias[] = $i.'-'.$j.'-'.$k;
						}
						
					
					}elseif( ($j == $uno[1]) && ($k>=$dia1[0]) ){
						//echo 'primer if ';
						$dias[] = $i.'-'.$j.'-'.$k;
					}elseif( ($j == $dos[1]) && ($k<=$dia2[0])  ){
						//echo 'segundo if ';
						$dias[] = $i.'-'.$j.'-'.$k;
					}elseif( ($j > $uno[1]) && ($j < $dos[1]) ){
						//echo 'ultimo if';
						$dias[] = $i.'-'.$j.'-'.$k;
					}
					
				
				

			}

		}

	}

	/*echo '<pre>';
	print_r($dias);*/

	//$dias_diferencia = abs($total / (60 * 60 * 24));
	

	$verdadera_resta = $total;
	/*echo '<pre>';
	print_r($dias);*/

	//echo "$verdadera_resta \n";
	$domingos = 0;
	foreach($dias as $dia){
			/*echo strtotime($dia);
			echo "\n";
			echo date('Y-m-d',strtotime($dia));
			echo "\n";
			echo date('D',strtotime($dia));/*/
			$day = date('D',strtotime($dia));
			
			if( $day == 'Sun'){
				//echo "\nSUN".date('Y-m-d',$dia);
				$domingos++;
				$verdadera_resta = $verdadera_resta -(86400);
			}
		}

	//$verdadera_resta = $total; 
	//echo "\n $verdadera_resta";
	
	$dias = ($verdadera_resta / (60 * 60 * 24));
	$dia = number_format($dias);

	$dia_seg = $dia * (24 * 60 * 60);

	$horas = ( (($verdadera_resta) - $dia_seg) / (60 * 60));
	$hora = number_format($horas);

	$hora_seg = $hora * (60 * 60);
	
	$minutos = ( (($verdadera_resta) - $dia_seg - $hora_seg) / (60));
	//$minutos = intval($verdadera_resta/60);
	$minuto = number_format($minutos);

	$minuto_seg = $minuto * (60);

	$segundos = (($verdadera_resta) - $dia_seg - $hora_seg - $minuto_seg); 
	
	$last = ($dia).' Días '.abs($hora).' Horas '.abs($minuto).' Minutos y '.abs($segundos).' Segundos';
	//$last = abs($verdadera_resta).' Días '.(abs($verdadera_resta) - $dia_seg).' Horas '.(abs($verdadera_resta) - $dia_seg - $hora_seg).' Minutos y '.(abs($verdadera_resta) - $dia_seg - $hora_seg - $minuto_seg).' Segundos';
	return $last;

}

function construyeMenu($rol){
	switch("$rol"){
		case 'ADMINISTRADOR':?>
		<!--
		<div id="smoothmenu" class="ddsmoothmenu">
					<ul >
						<li><a href="<?php echo base_url('admin');?>/dashboard/inicio/">Administrador</a>
							<ul>
								<li><a href="<?php echo base_url('admin');?>/dashboard/usuario">Usuarios</a></li>
								<li><a href="<?php echo site_url('admin/dashboard/tipo_cambio');?>">Tipo de Cambio</a></li>
								<li><a href="<?php echo base_url('admin');?>/dashboard/tipo_cliente">Tipos de Cliente</a></li>
							</ul>
						</li>
						<li><a href="<?php echo base_url('admin');?>/tienda/inicio/"> Tienda</a>
							<ul>
								<li><a href="<?php echo base_url('admin');?>/tienda/categoria/">Categorias</a></li>
								<li><a href="<?php echo base_url('admin');?>/tienda/producto/">Productos</a></li>
								<li><a href="<?php echo base_url('admin');?>/tienda/cliente/">Clientes</a></li>
							</ul>
						</li>
						<li><a href="<?php echo site_url('admin/pedido/inicio');?>">Pedidos</a>
							<ul>
								<li><a href="<?php echo site_url('admin/pedido/recibido');?>">Recibidos</a></li>
								<li><a href="<?php echo site_url('admin/pedido/proceso');?>">En proceso</a></li>
								<li><a href="<?php echo site_url('admin/pedido/surtido');?>">Surtidos</a></li>
								<li><a href="<?php echo site_url('admin/pedido/antiguo');?>">Históricos</a></li>
							</ul>
						</li>
						<li><a href="#N">Reportes</a>
						</li>
						<li><a href="#N">Herramientas</a>
						</li>
					</ul>
		</div>
		-->
		<ul id="nav">
			<li><a href="<?php echo base_url('admin');?>/dashboard/inicio/">Administrador</a>
				<ul>
					<li><a href="<?php echo base_url('admin');?>/dashboard/usuario">Usuarios</a></li>
					<li><a href="<?php echo site_url('admin/dashboard/tipo_cambio');?>">Tipo de Cambio</a></li>
					<li><a href="<?php echo base_url('admin');?>/dashboard/tipo_cliente">Tipos de Cliente</a></li>
					<li><a href="<?php echo site_url('admin/surtidor/editar');?>">Surtidores</a></li>
					<li><a href="<?php echo site_url('admin/correo/alta');?>">Correos</a></li>
				</ul>
			</li>
			<li><a href="<?php echo base_url('admin');?>/tienda/inicio/"> Tienda</a>
				<ul>
					<li><a href="<?php echo base_url('admin');?>/tienda/categoria/">Categorias</a></li>
					<li><a href="<?php echo base_url('admin');?>/tienda/producto/">Productos</a></li>
					<li><a href="<?php echo site_url('admin/cliente');?>">Clientes</a></li>
				</ul>
			</li>
			<li><a href="<?php echo site_url('admin/pedido/inicio');?>">Pedidos</a>
				<ul>
					<li><a href="<?php echo site_url('admin/pedido/recibido');?>">Recibidos</a></li>
					<li><a href="<?php echo site_url('admin/pedido/proceso');?>">En proceso</a></li>
					<li><a href="<?php echo site_url('admin/pedido/surtido');?>">Surtidos</a></li>
					<li><a href="<?php echo site_url('admin/pedido/antiguo');?>">Históricos</a></li>
				</ul>
			</li>
			<li><a href="#N">Reportes</a>
				<ul>
					<li><a href="<?php echo site_url('admin/reporte/surtir');?>">Surtidores</a></li>
					<li><a href="<?php echo site_url('admin/reporte/nosurtido');?>">No Surtido</a></li>
				</ul>
			</li>
			<li><a href="#N">Herramientas</a>
			</li>
		</ul>
		<?php
		break;
		
		case 'PRODUCTO_INFORMACION_GENERAL':
		case 'PRODUCTO_INFORMACION_INGREDIENTES':
		case 'PRODUCTO_PRECIO':
		case 'PRODUCTO_VIDEO':?>
		<!--<div id="smoothmenu" class="ddsmoothmenu">
					<ul >
						<li><a href="<?php echo base_url('admin');?>/dashboard/inicio/">Inicio</a>
						</li>
						<li><a href="<?php echo base_url('admin');?>/tienda/inicio/"> Tienda</a>
							<ul>
								<li><a href="<?php echo base_url('admin');?>/tienda/producto/">Productos</a></li>
							</ul>
						</li>
					</ul>
		</div> -->  
		<ul id="nav">
			<li><a href="<?php echo base_url('admin');?>/dashboard/inicio/">Inicio</a>
			</li>
			<li><a href="<?php echo base_url('admin');?>/tienda/inicio/"> Tienda</a>
				<ul>
					<li><a href="<?php echo base_url('admin');?>/tienda/producto/">Productos</a></li>
				</ul>
			</li>
		</ul>
		<?php
		break;
		case 'PEDIDOS_REPRESENTANTE_VENTAS':
		case 'PEDIDOS_CATALOGO':
		case 'PEDIDOS_REPRESENTANTE_EMBARQUES':?>
		<!--div id="smoothmenu" class="ddsmoothmenu"-->
					<ul id="nav">
						<li><a href="<?php echo base_url('admin');?>/dashboard/inicio/">Inicio</a>
						</li>
						<li><a href="<?php echo base_url('admin');?>/tienda/inicio/"> Pedidos</a>
							<ul>
								<li><a href="<?php echo site_url('admin/pedido/recibido');?>">Recibidos</a></li>
								<li><a href="<?php echo site_url('admin/pedido/proceso');?>">En proceso</a></li>
								<li><a href="<?php echo site_url('admin/pedido/surtido');?>">Surtidos</a></li>
							</ul>
						</li>
					</ul>
		<!--/div--> 
		<?php 
		break;

		default:
		break;
	}
}


function construyeMenuAltas($seccion,$rol){
	switch ($seccion){
		case "tienda_all":
		switch ($rol){
			case 'ADMINISTRADOR':?>
			<h2>Submenús</h2>
			<p>Puedes dar de alta y modificar categorías, productos, presentaciones, clientes.</p>
			<table align="center" width="70%">
				<tr>
					<td width="33">Categorías</td>
					<td width="34">Productos</td>
					<td width="33">Clientes</td>
				</tr>
				<tr>
					<td><ul>
							<li><a href="#N">Alta de Categorías.</a></li>
							<li><a href="#N">Alta de Subcategorías.</a></li>
							<li><a href="#N">Consulta & Modificación de Categorías.</a></li>
							<li><a href="#N">Consulta & Modificación de Subcategorías.</a></li>
						</ul>
					</td>
					<td><ul>
							<li><a href="#N">Alta de Productos.</a></li>
							<li><a href="#N">Alta de Presentaciones.</a></li>
							<li><a href="#N">Consulta & Modificación de Productos.</a></li>
							<li><a href="#N">Consulta & Modificación de Presentaciones.</a></li>
						</ul>
					</td>
					<td><ul>
							<li><a href="#N">Alta de Clientes.</a></li>
							<li><a href="#N">Consulta & Modificación de Clientes.</a></li>
						</ul>
					</td>
				</tr>
			</table>
			<?php
			break;
			case 'PRODUCTO_INFORMACION_GENERAL':?>
			<h2>Submenús</h2>
			<table align="center" width="70%">
				<tr>
					<td width="34">Productos</td>
				</tr>
				<tr>
					<td><ul>
							<li><a href="#N">Alta de Productos.</a></li>
							<li><a href="#N">Alta de Presentaciones.</a></li>
							<li><a href="#N">Consulta & Modificación de Productos.</a></li>
							<li><a href="#N">Consulta & Modificación de Presentaciones.</a></li>
						</ul>
					</td>
				</tr>
			</table>
			<?php
			break;
			case 'PRODUCTO_PRECIO':?>
			<h2>Submenús</h2>
			<table align="center" width="70%">
				<tr>
					<td width="34">Productos</td>
				</tr>
				<tr>
					<td><ul>
							<li><a href="#N">Consulta & Captura de Precios.</a></li>
						</ul>
					</td>
				</tr>
			</table>
			<?php
			break;
			case 'PRODUCTO_VIDEO':?>
			<h2>Submenús</h2>
			<table align="center" width="70%">
				<tr>
					<td width="34">Productos</td>
				</tr>
				<tr>
					<td><ul>
							<li><a href="#N">Consulta & Captura de Videos.</a></li>
						</ul>
					</td>
				</tr>
			</table>
			<?php
			break;
			default:
			break;
		}
		break;
		case "pedido_all":
		switch ($rol){
			case 'ADMINISTRADOR':?>
			<h2>Submenús</h2>
			<p>Puedes checar los pedidos de catálogo y los de representantes.</p>
			<table align="center" width="70%">
				<tr>
					<td width="33">Pedidos Actuales</td>
					<td width="34">Historial de Pedidos</td>
				</tr>
				<tr>
					<td><ul>
							<li><a href="#N">Consulta & Modificación de Pedidos Catálogo.</a></li>
							<li><a href="#N">Consulta & Modificación de Pedidos Representante.</a></li>
						</ul>
					</td>
					<td><ul>
							<li><a href="#N">Consulta de Pedidos Catálogo.</a></li>
							<li><a href="#N">Consulta de Pedidos Representante.</a></li>
						</ul>
					</td>
					
				</tr>
			</table>
			<?php
			break;
			
			default:
			break;
		}
		break;
		case "categoria":
		switch ($rol){
			case 'ADMINISTRADOR':
			case 'PRODUCTO_INFORMACION_GENERAL':?>
			<h2>Altas</h2>
			<table align="center" width="70%">
				<tr>
					<td><a href="<?php echo base_url('admin');?>/tienda/categoria/alta"><img src="<?php echo base_url();?>/img/icons/icono-categoria-nuevo.jpg" /></a></td>
					<td><a href="<?php echo base_url('admin');?>/tienda/subcategoria/alta"><img src="<?php echo base_url();?>/img/icons/icono-subcategoria-nuevo.jpg" /></a></td>
				</tr>
			</table>
			<?php
			break;
			default:
			break;
		}
		break;
		
		case "producto":
		switch ($rol){
			case 'ADMINISTRADOR':
			case 'PRODUCTO_INFORMACION_GENERAL':
			case 'PRODUCTO_INFORMACION':?>
			<h2>Altas</h2>
			<table align="center" width="70%">
				<tr>
					<td><a href="<?php echo base_url('admin');?>/tienda/producto/alta"><img src="<?php echo base_url();?>/img/icons/icono-producto-nuevo.jpg" /></a></td>
					<td><a href="<?php echo base_url('admin');?>/tienda/presentacion/alta"><img src="<?php echo base_url();?>/img/icons/icono-presentacion-nuevo.jpg" /></a></td>
				</tr>
			</table>
			<?php
			break;
			default:
			break;
		}
		break;
		
		case "cliente":
		switch ($rol){
			case 'ADMINISTRADOR':?>
			<h2>Altas</h2>
			<table align="center" width="70%">
				<tr>
					<td><a href="<?php echo base_url('admin');?>/tienda/cliente/alta"><img src="<?php echo base_url();?>/img/icons/icono-cliente-nuevo.jpg" /></a></td>
				</tr>
			</table>
			<?php
			break;
			default:
			break;
		}
		break;
		case "tipo_cliente":
		switch ($rol){
			case 'ADMINISTRADOR':?>
			<h2>Altas</h2>
			<table align="center" width="70%">
				<tr>
					<td><a href="<?php echo base_url('admin');?>/dashboard/tipo_cliente/alta"><img src="<?php echo base_url();?>/img/icons/icono-tipo_cliente-nuevo.jpg" /></a></td>
				</tr>
			</table>
			<?php
			break;
			default:
			break;
		}
		break;
		case "usuario":
		switch ($rol){
			case 'ADMINISTRADOR': ?>
			<h2>Altas</h2>
			<table align="center" width="70%">
				<tr>
					<td><a href="<?php echo base_url('admin');?>/dashboard/usuario/alta"><img src="<?php echo base_url();?>/img/icons/icono-usuario-nuevo.jpg" /></a></td>
				</tr>
			</table>
			<?php
			break;
			default:
			break;
		}
		break;
		
		default:
		break;
	}


}
function construyeMenuConsultas($seccion,$rol){
	switch ($seccion){
		case "all":
		break;
		case "categoria":
		switch ($rol){
			case 'ADMINISTRADOR':?>
			<h2>Consultas & Actualizaciones</h2>
			<table align="center" width="70%">
				<tr>
					<td><a href="<?php echo base_url('admin');?>/tienda/categoria/consulta"><img src="<?php echo base_url();?>/img/icons/icono-categoria.jpg" /></a></td>
					<td><a href="<?php echo base_url('admin');?>/tienda/subcategoria/consulta"><img src="<?php echo base_url();?>/img/icons/icono-subcategoria.jpg" /></a></td>
				</tr>
			</table>
			<?php
			break;
			default:
			break;
		}
		break;
		case "producto":
		switch ($rol){
			
			case 'ADMINISTRADOR':?>
                            <h2>Consultas & Actualizaciones</h2>
                            <table align="center" width="70%">
                                    <tr>
                                            <td><a href="<?php echo base_url('admin');?>/tienda/producto/consulta"><img src="<?php echo base_url();?>/img/icons/icono-producto.jpg" /></a></td>
                                            <td><a href="<?php echo base_url('admin');?>/tienda/presentacion/consulta"><img src="<?php echo base_url();?>/img/icons/icono-presentacion.jpg" /></a></td>
                                            <td><a class="btn btn-small btn-primary" href="<?php echo base_url('admin');?>/producto/lista">Actualizar precios de presentaciones</a></td>
                                    </tr>
                            </table>
			<?php
                        break;
                        
                        case 'PRODUCTO_PRECIO':
			case 'PRODUCTO_VIDEO':
			case 'PRODUCTO_INFORMACION_GENERAL':
			case 'PRODUCTO_INFORMACION_INGREDIENTES':?>
			<h2>Consultas & Actualizaciones</h2>
			<table align="center" width="70%">
				<tr>
					<td><a href="<?php echo base_url('admin');?>/tienda/producto/consulta"><img src="<?php echo base_url();?>/img/icons/icono-producto.jpg" /></a></td>
					<td><a href="<?php echo base_url('admin');?>/tienda/presentacion/consulta"><img src="<?php echo base_url();?>/img/icons/icono-presentacion.jpg" /></a></td>
					
				</tr>
			</table>
			<?php
			break;
			
			default:
			break;
		}
		break;
		case "cliente":
		switch ($rol){
			case 'ADMINISTRADOR':?>
			<h2>Consultas & Actualizaciones</h2>
			<table align="center" width="70%">
				<tr>
					<td><a href="<?php echo base_url('admin');?>/tienda/cliente/consulta"><img src="<?php echo base_url();?>/img/icons/icono-cliente.jpg" /></a></td>
				</tr>
			</table>
			<?php
			break;
			default:
			break;
		}
		break;
		case "tipo_cliente":
		switch ($rol){
			case 'ADMINISTRADOR':?>
			<h2>Consultas & Actualizaciones</h2>
			<table align="center" width="70%">
				<tr>
					<td><a href="<?php echo base_url('admin');?>/dashboard/tipo_cliente/consulta"><img src="<?php echo base_url();?>/img/icons/icono-tipo_cliente.jpg" /></a></td>
				</tr>
			</table>
			<?php
			break;
			default:
			break;
		}
		break;
		case "usuario":
		switch ($rol){
			case 'ADMINISTRADOR':?>
			<h2>Consultas & Actualizaciones</h2>
			<table align="center" width="70%">
				<tr>
					<td><a href="<?php echo base_url('admin');?>/dashboard/usuario/consulta"><img src="<?php echo base_url();?>/img/icons/icono-usuario.jpg" /></a></td>
				</tr>
			</table>
			<?php
			break;
			default:
			break;
		}
		
		break;
		case "pedido_recibido":
		switch ($rol){
			case 'ADMINISTRADOR': ?>
			<h2>Consultas & Actualizaciones | Pedidos Recibidos</h2>
			<table align="center" width="70%">
				<tr>
					<td><a href="<?php echo base_url('admin');?>/pedido/todos"><img src="<?php echo base_url();?>/img/icons/icono-pedido_todos.jpg" alt="TODOS"/></a></td>
					<td><a href="<?php echo base_url('admin');?>/pedido/recibido/catalogo"><img src="<?php echo base_url();?>/img/icons/icono-pedido_catalogo.jpg" /></a></td>
					<td><a href="<?php echo base_url('admin');?>/pedido/recibido/representante"><img src="<?php echo base_url();?>/img/icons/icono-pedido_representantes.jpg" /></a></td>
				</tr>
			</table>
			<?php
			break;
			case 'PEDIDOS_CATALOGO': ?>
			<h2>Consultas & Actualizaciones | Pedidos Recibidos</h2>
			<table align="center" width="70%">
				<tr>
					<td><a href="<?php echo base_url('admin');?>/pedido/recibido/catalogo"><img src="<?php echo base_url();?>/img/icons/icono-pedido_catalogo.jpg" /></a></td>
				</tr>
			</table>
			<?php
			break;
			case 'PEDIDOS_REPRESENTANTE_VENTAS':
			case 'PEDIDOS_REPRESENTANTE_EMBARQUES': ?>
			<h2>Consultas & Actualizaciones | Pedidos Recibidos</h2>
			<table align="center" width="70%">
				<tr>
					<td><a href="<?php echo base_url('admin');?>/pedido/recibido/representante"><img src="<?php echo base_url();?>/img/icons/icono-pedido_representantes.jpg" /></a></td>
				</tr>
			</table>
			<?php
			break;
			default:
			break;
		}
		break;
		default:
		break;
		case "pedido_proceso":
		switch ($rol){
			case 'ADMINISTRADOR': ?>
			<h2>Consultas & Actualizaciones | Pedidos en Proceso</h2>
			<table align="center" width="70%">
				<tr>
					<td><a href="<?php echo base_url('admin');?>/pedido/todos"><img src="<?php echo base_url();?>/img/icons/icono-pedido_todos.jpg" alt="TODOS"/></a></td>
					<td><a href="<?php echo base_url('admin');?>/pedido/proceso/catalogo"><img src="<?php echo base_url();?>/img/icons/icono-pedido_catalogo.jpg" /></a></td>
					<td><a href="<?php echo base_url('admin');?>/pedido/proceso/representante"><img src="<?php echo base_url();?>/img/icons/icono-pedido_representantes.jpg" /></a></td>
				</tr>
			</table>
			<?php
			break;
			case 'PEDIDOS_CATALOGO': ?>
			<h2>Consultas & Actualizaciones | Pedidos Recibidos</h2>
			<table align="center" width="70%">
				<tr>
					<td><a href="<?php echo base_url('admin');?>/pedido/proceso/catalogo"><img src="<?php echo base_url();?>/img/icons/icono-pedido_catalogo.jpg" /></a></td>
				</tr>
			</table>
			<?php
			break;
			case 'PEDIDOS_REPRESENTANTE_VENTAS':
			case 'PEDIDOS_REPRESENTANTE_EMBARQUES': ?>
			<h2>Consultas & Actualizaciones | Pedidos Recibidos</h2>
			<table align="center" width="70%">
				<tr>
					<td><a href="<?php echo base_url('admin');?>/pedido/proceso/representante"><img src="<?php echo base_url();?>/img/icons/icono-pedido_representantes.jpg" /></a></td>
				</tr>
			</table>
			<?php
			break;
			default:
			break;
		}
		break;
		case "pedido_surtido":
		switch ($rol){
			case 'ADMINISTRADOR': ?>
			<h2>Consultas & Actualizaciones | Pedidos Surtidos</h2>
			<table align="center" width="70%">
				<tr>
					<td><a href="<?php echo base_url('admin');?>/pedido/todos"><img src="<?php echo base_url();?>/img/icons/icono-pedido_todos.jpg" alt="TODOS"/></a></td>
					<td><a href="<?php echo base_url('admin');?>/pedido/surtido/catalogo"><img src="<?php echo base_url();?>/img/icons/icono-pedido_catalogo.jpg" /></a></td>
					<td><a href="<?php echo base_url('admin');?>/pedido/surtido/representante"><img src="<?php echo base_url();?>/img/icons/icono-pedido_representantes.jpg" /></a></td>
				</tr>
			</table>
			<?php
			break;
			case 'PEDIDOS_CATALOGO': ?>
			<h2>Consultas & Actualizaciones | Pedidos Recibidos</h2>
			<table align="center" width="70%">
				<tr>
					<td><a href="<?php echo base_url('admin');?>/pedido/surtido/catalogo"><img src="<?php echo base_url();?>/img/icons/icono-pedido_catalogo.jpg" /></a></td>
				</tr>
			</table>
			<?php
			break;
			case 'PEDIDOS_REPRESENTANTE_VENTAS':
			case 'PEDIDOS_REPRESENTANTE_EMBARQUES': ?>
			<h2>Consultas & Actualizaciones | Pedidos Recibidos</h2>
			<table align="center" width="70%">
				<tr>
					<td><a href="<?php echo base_url('admin');?>/pedido/surtido/representante"><img src="<?php echo base_url();?>/img/icons/icono-pedido_representantes.jpg" /></a></td>
				</tr>
			</table>
			<?php
			break;
			default:
			break;
		}
		break;
		default:
		break;
	}
}

function construyeFormularioAltas($seccion,$rol,$consulta = "none",$idioma = false){
	switch($seccion){
		default:
		break;
		case "alta_tipo_cliente":
			switch($rol){
				case "ADMINISTRADOR":?>
					<h2>Captura de Tipo de Clientes</h2>
					<?php echo form_open(current_url());?>
					<table align="center" class="modificar">
						<tr>
							<td>Nombre:</td>
							<td><input type="text" value="<?php echo set_value('nombre')?>" name="nombre" size="50"/></td>
						</tr>
						<tr>
							<td>Abreviatura TC:</td>
							<td><input type="text" value="<?php echo set_value('abreviatura')?>" name="abreviatura" size="50"/></td>
						</tr>
						<?php if ($idioma){?>
						<tr>
							<td>Nombre(Inglés):</td>
							<td><input type="text" value="<?php echo set_value('nombre_en')?>" name="nombre_en" size="50"/></td>
						</tr>
						<?php } ?>
						<tr>
							<td>Descripción:</td>
							<td><textarea name="descripcion" rows="5" cols="37"><?php echo set_value('descripcion')?></textarea></td>
						</tr>
						<?php if ($idioma){?>
						<tr>
							<td>Descripción(Inglés):</td>
							<td><textarea name="descripcion_en" rows="5" cols="37"><?php echo set_value('descripcion_en')?></textarea></td>
						</tr>
						<?php } ?>
						<tr>
							<td>Descuento:</td>
							<td><input type="text" value="<?php echo set_value('descuento')?>" name="descuento" size="10"/>%</td>
						</tr>
						<tr>
							<td>Promoción:</td>
							<td><input type="checkbox" value="2+1" <?php echo set_checkbox('promocion','2+1');?> name="promocion[]"/>dos más uno</td>
						</tr>
						<tr>
							<td align="center" colspan="2"><input type="submit" value="Guardar" /></td>
						</tr>
					</table>
					<?php echo form_close();?>
				<?php
				break;
			}
		break;
		case "alta_usuario":
			switch($rol){
				case "ADMINISTRADOR":?>
					<h2>Captura de Usuarios</h2>
					<?php echo form_open(current_url());?>
					<table align="center" class="modificar">
						<tr>
							<td>Correo:</td>
							<td><input type="text" value="<?php echo set_value('correo')?>" name="correo" size="50"/></td>
						</tr>
						<tr>
							<td>Contraseña:</td>
							<td><input type="password" value="<?php echo set_value('password1')?>" name="password1" size="50"/></td>
						</tr>
						<tr>
							<td>Confirmar contraseña:</td>
							<td><input type="password" value="<?php echo set_value('password2')?>" name="password2" size="50"/></td>
						</tr>
						<tr>
							<td>Permisos:</td>
							<td><select name="permiso">
									<option value="0" <?php echo set_select('permiso', '0', TRUE); ?> > --- </option>
									<?php foreach($consulta->result() as $permiso){?>
									<option value="<?php echo $permiso->idPermiso;?>" <?php echo set_select('permiso', $permiso->idPermiso); ?>><?php echo $permiso->descripcion;?></option>
									<?php } ?>
								</select>
							</td>
						</tr>
						<tr>
							<td align="center" colspan="2"><input type="submit" value="Guardar" /></td>
						</tr>
					</table>
					<?php echo form_close();?>
				<?php
				break;
			}
		break;
		case "alta_categoria":
			switch($rol){
				case "ADMINISTRADOR":?>
					<h2>Captura de Categorías</h2>
					<?php echo form_open(current_url());?>
					<table align="center" class="modificar">
						<tr>
							<td>Nombre:</td>
							<td><input type="text" value="<?php echo set_value('nombre')?>" name="nombre" size="50"/></td>
						</tr>
						<?php if($idioma){ ?>
						<tr>
							<td>Nombre en Inglés:</td>
							<td><input type="text" value="<?php echo set_value('nombre_en')?>" name="nombre_en" size="50"/></td>
						</tr>
						<?php } ?>
						<tr>
							<td align="center" colspan="2"><input type="submit" value="Guardar" /></td>
						</tr>
					</table>
					<?php echo form_close();?>
				<?php
				break;
			}
		break;
		case "alta_subcategoria":
			switch($rol){
				case "ADMINISTRADOR":?>
					<h2>Captura de Subcategorías</h2>
					<?php echo form_open(current_url());?>
					<table align="center" class="modificar">
						<tr>
							<td>Nombre:</td>
							<td><input type="text" value="<?php echo set_value('nombre')?>" name="nombre" size="50"/></td>
						</tr>
						<?php if($idioma){ ?>
						<tr>
							<td>Nombre en Inglés:</td>
							<td><input type="text" value="<?php echo set_value('nombre_en')?>" name="nombre_en" size="50"/></td>
						</tr>
						<?php } ?>
						<tr>
							<td>Categoría:</td>
							<td><select name="categoria">
								<option value="0" <?php echo set_select('categoria', '0', TRUE); ?>>---</option>
							<?php foreach($consulta->result() as $categoria){ ?>
								<option value="<?php echo $categoria->idCategoria;?>"  <?php echo set_select('categoria', $categoria->idCategoria); ?>><?php echo $categoria->nombre;?></option>
							<?php } ?>
							</select>
						</tr>
						<tr>
							<td align="center" colspan="2"><input type="submit" value="Guardar" /></td>
						</tr>
					</table>
					<?php echo form_close();?>
				<?php
				break;
			}
		break;
		case "alta_producto":
			switch($rol){
				case "PRODUCTO_INFORMACION_GENERAL":
				case "ADMINISTRADOR":?>
					<h2>Captura de Productos</h2>
					<?php echo form_open_multipart(current_url());?>
					<table align="center" class="modificar">
						<tr>
							<td>Nombre Producto:</td>
							<td><input type="text" value="<?php echo set_value('nombre')?>" name="nombre" size="50"/></td>
						</tr>
						<tr>
							<td>Información de ingredientes principales:</td>
							<td><textarea name="uso" rows="10" cols="40"><?php echo set_value('uso')?></textarea></td>
						</tr>
						<tr>
							<td>Opinión de Expertos:</td>
							<td><textarea name="experto" rows="10" cols="40"><?php echo set_value('experto')?></textarea></td>
						</tr>
						<?php if($idioma){ ?>
						<tr>
							<td>Información de ingredientes principales(Inglés):</td>
							<td><textarea name="uso_en" rows="10" cols="40"><?php echo set_value('uso_en')?></textarea></td>
						</tr>
						<tr>
							<td>Opinión de Experto(Inglés):</td>
							<td><textarea name="experto_en" rows="10" cols="40"><?php echo set_value('experto_en')?></textarea></td>
						</tr>
						<?php } ?>
						<tr>
							<td>Subcategoría:</td>
							<td>
								<select name="categoria">
									<option value="0" <?php echo set_select('categoria','0',true);?>> --- </option>
									<?php foreach($consulta as $option){
									$optgroup = $option['nombre'];?>
									<optgroup label="<?php echo $optgroup;?>">
									<?php
									foreach($option as $otro){
									if($otro != $optgroup){?>
										<option value="<?php echo $otro['value'];?>" <?php echo set_select('categoria',$otro['value']);?>><?php echo $otro['nombre'];?></option>
									<?php }
									}
									}?>
								</select>
							</td>
						</tr>
						<tr>
							<td>Imágen: <div style="font-size: 10px;"><b>(La imágen debe tener un tamaño de 175px por 175px.)</b></div></td>
							<td><input type="file" name="userfile" size="20"/></td>
						</tr>
						<tr>
							<td align="center" colspan="2"><input type="submit" value="Guardar" /></td>
						</tr>
					</table>
					<?php echo form_close();?>
				<?php
				break; 
			}
		break;
		case "alta_presentacion":
			switch($rol){
				case "ADMINISTRADOR":?>
					<h2>Captura de Presentaciones</h2>
					<?php echo form_open_multipart(current_url());?>
					
					<table align="center" class="modificar">
						<tr>
							<td>Nombre Producto:</td>
							<td><select name="producto">
									<option value="0" <?php echo set_select('producto','0',true);?>> --- </option>
									<?php foreach($consulta as $option){
									$optgroup = $option['nombre'];?>
									<optgroup label="<?php echo $optgroup;?>">
									<?php
									foreach($option as $otro){
									if($otro != $optgroup){?>
										<option value="<?php echo $otro['value'];?>" <?php echo set_select('categoria',$otro['value']);?>><?php echo $otro['nombre'];?></option>
									<?php }
									}
									}?>
								</select></td>
						</tr>
						<tr>
							<td>Clave:</td>
							<td><input type="text" value="<?php echo set_value('clave')?>" name="clave" size="50"/></td>
						</tr>
						<tr>
							<td>Estado Físico:</td>
							<td><input type="text" value="<?php echo set_value('estado')?>" name="estado" size="50"/></td>
						</tr>
						<tr>
							<td>Contenido Neto:</td>
							<td><input type="text" value="<?php echo set_value('contenido')?>" name="contenido" size="50"/></td>
						</tr>
						<tr>
							<td>Grupo:</td>
							<td><input type="text" value="<?php echo set_value('grupo')?>" name="grupo" size="50"/></td>
						</tr>
						<tr>
							<td>Ingredientes:</td>
							<td><textarea name="ingredientes" rows="10" cols="40"><?php echo set_value('ingredientes')?></textarea></td>
						</tr>
						<?php if($idioma){ ?>
						<tr>
							<td>Estado Físico(Inglés):</td>
							<td><input type="text" value="<?php echo set_value('estado_en')?>" name="estado_en" size="50"/></td>
						</tr>
						<tr>
							<td>Contenido Neto(Inglés):</td>
							<td><input type="text" value="<?php echo set_value('contenido')?>" name="contenido_en" size="50"/></td>
						</tr>
						<?php } ?>
						<tr>
							<td>Imágen: <div style="font-size: 10px;"><b>(La imágen debe tener un tamaño de 175px por 175px.)</b></div></td>
							<td><input type="file" name="userfile" size="20"/></td>
						</tr>
						<tr>
							<td>Precio Público:</td>
							<td><input type="text" value="<?php echo set_value('precio')?>" name="precio" size="35"/>
								<input type="checkbox" value="SI" name="iva[]" <?php echo set_checkbox('iva[]', 'SI'); ?> />I.V.A.(16%)
							</td>
						</tr>
						<tr>
							<td>Vídeo(Link):</td>
							<td><input type="text" value='<?php echo set_value('video')?>' name="video" size="50"/></td>
						</tr>
						<?php if($idioma){ ?>
						<tr>
							<td>Vídeo(Inglés):</td>
							<td><input type="text" value='<?php echo set_value('video_en')?>' name="video_en" size="50"/></td>
						</tr>
						<?php } ?>
						<tr>
							<td align="center" colspan="2"><input type="submit" value="Guardar" /></td>
						</tr>
					</table>
					<?php echo form_close();?>
				<?php
				break;
				case "PRODUCTO_INFORMACION_GENERAL":?>
					<h2>Captura de Presentaciones</h2>
					<?php echo form_open_multipart(current_url());?>
					
					<table align="center" class="modificar">
						<tr>
							<td>Nombre Producto:</td>
							<td><select name="producto">
									<option value="0" <?php echo set_select('producto','0',true);?>> --- </option>
									<?php foreach($consulta as $option){
									$optgroup = $option['nombre'];?>
									<optgroup label="<?php echo $optgroup;?>">
									<?php
									foreach($option as $otro){
									if($otro != $optgroup){?>
										<option value="<?php echo $otro['value'];?>" <?php echo set_select('categoria',$otro['value']);?>><?php echo $otro['nombre'];?></option>
									<?php }
									}
									}?>
								</select></td>
						</tr>
						<tr>
							<td>Clave:</td>
							<td><input type="text" value="<?php echo set_value('clave')?>" name="clave" size="50"/></td>
						</tr>
						<tr>
							<td>Estado Físico:</td>
							<td><input type="text" value="<?php echo set_value('estado')?>" name="estado" size="50"/></td>
						</tr>
						<tr>
							<td>Contenido Neto:</td>
							<td><input type="text" value="<?php echo set_value('contenido')?>" name="contenido" size="50"/></td>
						</tr>
						<tr>
							<td>Grupo:</td>
							<td><input type="text" value="<?php echo set_value('grupo')?>" name="grupo" size="50"/></td>
						</tr>
						
						<?php if($idioma){ ?>
						<tr>
							<td>Estado Físico(Inglés):</td>
							<td><input type="text" value="<?php echo set_value('estado_en')?>" name="estado_en" size="50"/></td>
						</tr>
						<tr>
							<td>Contenido Neto(Inglés):</td>
							<td><input type="text" value="<?php echo set_value('contenido')?>" name="contenido_en" size="50"/></td>
						</tr>
						<?php } ?>
						<tr>
							<td>Imágen: <div style="font-size: 10px;"><b>(La imágen debe tener un tamaño de 175px por 175px.)</b></div></td>
							<td><input type="file" name="userfile" size="20"/></td>
						</tr>
						<tr>
							<td align="center" colspan="2"><input type="submit" value="Guardar" /></td>
						</tr>
					</table>
					<?php echo form_close();?>
				<?php
				break;
				
			}
		break;
		case "alta_cliente_general":
			switch($rol){
				case "ADMINISTRADOR":?>
					<h2>Captura de Clientes || Datos Generales</h2>
					<?php echo form_open(current_url());?>
					<table width="70%%" align="center" class="modificar">
						<tbody>
						<tr>
							<th colspan="4"><br></th>
						</tr>
						<tr>
							<td colspan="4"><b>(*) Campos obligatorios</b><br></td> 
						</tr>
						<tr>
							<td width="25%" valign="top"><b>Tipo Cliente*</b></td>
							<td width="25%">
								<select id="claveletra" name="claveletra">
									<option value="0" <?php echo set_select('claveletra', '0', TRUE); ?>>  -  </option>
									<?php foreach($consulta->result() as $tipoCliente){ ?>
									<option value="<?php echo $tipoCliente->idTipoCliente;?>" <?php echo set_select('claveletra', $tipoCliente->idTipoCliente);?>><?php echo $tipoCliente->nombre;?></option>
									<?php } ?>
								</select>
							</td>
							<td width="20%" valign="top"><b>Título o profesión:</b></td>
							<td width="20%" valign="top">
								<input type="text" value="<?php echo set_value('titulo');?>" name="titulo">
							</td>
						</tr>
						<tr>
							<td width="20%" valign="top"><b>Nombre*</b></td>
							<td width="20%" valign="top">
								<input type="text" value="<?php echo set_value('nombres');?>" name="nombres"> 
							</td>	
							<td width="20%" valign="top"><b>Apellidos*</b></td>
							<td width="20%" valign="top">
								<input type="text" value="<?php echo set_value('apellidos');?>" name="apellidos"> 
							</td>
						</tr>
						<tr>
							<td width="20%" valign="top"><b>Cumpleaños</b></td>
							<td width="20%" valign="top">
								<b>Mes</b> <?php construyeSelect($seccion,'mes','meses');?>
							</td>
							<td>
								<b>Día</b> <?php construyeSelect($seccion,'dia','dias'); ?>
							</td>
							<td></td>
						</tr>
						<tr>
							<td width="20%" valign="top"><b>Email personal</b></td>
							<td width="20%" valign="top">
								<input type="text" value="<?php echo set_value('email');?>" name="email"> 
							</td>
							<td width="20%" valign="top"><b>Otro email personal</b></td>
							<td width="20%" valign="top">
								<input type="text" value="<?php echo set_value('otroemail');?>" name="otroemail"> 
							</td>
						</tr>	
						<tr>
							<td width="20%" valign="top"><b>Teléfono casa</b></td>
							<td width="20%" valign="top" colspan="3">
								<table width="98%" align="center">	
									<tbody>
									<tr>
										<td width="20%" valign="top">Código país</td>
										<td width="20%" valign="top">Área/Lada</td>
										<td width="20%" valign="top">Teléfono</td>
										<td width="20%" valign="top">Extensión</td>
									</tr>
									<tr>
										<td width="20%">
											+ <input type="text" maxlength="7" size="4" value="52" name="codigopais"> 
										</td>
										<td width="20%">
											<input type="text" maxlength="5" size="4" value="<?php echo set_value('area');?>" name="area"> 
										</td>
										<td width="20%">
											<input type="text" maxlength="15" size="14" value="<?php echo set_value('telefono');?>" name="telefono"> 
										</td>
										<td width="20%">
											<input type="text" size="10" value="<?php echo set_value('ext');?>" name="ext"> 
										</td>
									</tr>
									</tbody>
								</table>				
							</td>
						</tr>
						<tr>
							<td width="20%" valign="top"><b>Teléfono móvil personal</b></td>
							<td width="20%" valign="top" colspan="3">
								<table width="98%" align="left">
									<tbody>
									<tr>
										<td width="20%" valign="top">Código país</td>
										<td width="20%" valign="top">Área/Lada</td>
										<td width="20%" valign="top">Teléfono</td>						
										<td width="20%" valign="top">&nbsp;</td>						
									</tr>
									<tr>
										<td>
											+ <input type="text" maxlength="7" size="4" value="52" name="codigopaismovil"> 
										</td>
										<td>
											<input type="text" maxlength="5" size="4" value="<?php echo set_value('areamovil');?>" name="areamovil"> 
										</td>
										<td>
											<input type="text" maxlength="15" size="14" value="<?php echo set_value('telefonomovil');?>" name="telefonomovil"> 
										</td>
										<td></td>
									</tr>
									</tbody>
								</table>					
							</td>						
						</tr>
						<tr>
							<td width="20%" valign="top"><b>Calle</b></td>
							<td width="20%" valign="top">
								<input type="text" value="<?php echo set_value('calle');?>" name="calle"> 
							</td>
							<td width="20%" valign="top"><b>Num. Ext.</b></td>
							<td width="20%" valign="top">
								<input type="text" value="<?php echo set_value('numext');?>" name="numext"> 
							</td>
						</tr>
						<tr>
							<td width="20%" valign="top"><b>Num. Int.</b></td>
							<td width="20%" valign="top">
								<input type="text" value="<?php echo set_value('numint');?>" name="numint"> 
							</td>			
							<td width="20%" valign="top"><b>Colonia</b></td>
							<td width="20%" valign="top">
								<input type="text" value="<?php echo set_value('colonia');?>" name="colonia"> 
							</td>
						</tr>
						<tr>
							<td width="20%" valign="top"><b>Delegación o municipio</b></td>
							<td width="20%" valign="top">
								<input type="text" value="<?php echo set_value('delegacion');?>" name="delegacion"> 
							</td>
							<td width="20%" valign="top"><b>Código postal</b></td>
							<td width="20%" valign="top">
								<input type="text" value="<?php echo set_value('codigo');?>" name="codigo"> 
							</td>
						</tr>
						<tr>
							<td width="20%" valign="top"><b>Ciudad</b></td>
							<td width="20%" valign="top">
								<input type="text" value="<?php echo set_value('ciudad');?>" name="ciudad"> 
							</td>
							<td width="20%" valign="top"><b>Estado</b></td>
							<td width="20%" valign="top">
								<?php construyeSelect($seccion,'estado','estados'); ?>
							</td>
						</tr>
						<tr>
							<td width="20%" valign="top"><b>País</b></td>
							<td width="20%" valign="top">
								<!-- <input type="text" name="pais" value="México" />  -->
								<?php construyeSelect($seccion,'pais','paises'); ?>			
							</td>
							<td width="20%" valign="top"><b>Sitio web</b></td>
							<td width="20%" valign="top">
								<input type="text" value="<?php echo set_value('web');?>" name="web"> 
							</td>
						</tr>
						<tr>
							<td width="20%" valign="top"></td>
							<td width="20%" valign="top" align="right">
								<input type="submit" value="Siguiente" name="siguiente"> 
								<input type="hidden" value="alta1" name="formhid">
							</td>
							<td width="20%" valign="top" align="left">
								<input type="button" value="Borrar" onClick="window.location.href=window.location.href"/> 
							</td>
							<td width="20%" valign="top"></td>
						</tr>
						</tbody>
					</table>
					<?php echo form_close();?>
				<?php
				break;
				default:
				break;
			}
		break;
	}
}

function construyeFormularioEdicion($seccion,$rol,$consulta,$idioma = false){
	switch($seccion){
		default:
		break;
		case "editar_tipo_cambio":
			switch($rol){
				case "ADMINISTRADOR":
				foreach($consulta->result() as $tipo_cambio){
				?>
				<h2>Edición de Tipo de Cambio</h2>
				<?php echo form_open(current_url());?>
				<table align="center" class="modificar">
					<tr>
						<td>Valor actual:</td>
						<td><?php echo $tipo_cambio->valor;?></td>
					</tr>
					<tr>
						<td>Última actualización:</td>
						<td><?php echo $tipo_cambio->fecha;?></td>
					</tr>
					<tr>
						<td>Valor nuevo:</td>
						<td><input type="text" name="valor" value="<?php set_value('valor');?>" /></td>
					</tr>
					<tr>
						<td align="center" colspan="2"><input type="submit" value="Guardar" /></td>
					</tr>
				</table>
				<?php
				}
				break;
			}
		break;
		case "editar_tipo_cliente":
			switch($rol){
				case "ADMINISTRADOR":
				foreach($consulta->result() as $tipo_cliente){
				?>
				<h2>Edición de <?php echo $tipo_cliente->nombre;?></h2>
				<?php echo form_open(current_url());?>
				<table align="center" class="modificar">
					<tr>
						<td>Nombre:</td>
						<td><input type="text" name="nombre" value="<?php repoblar('nombre',$tipo_cliente->nombre);?>" /></td>
					</tr>
					<tr>
						<td>Abreviatura TC:</td>
						<td><input type="text" value="<?php repoblar('abreviatura',$tipo_cliente->abreviatura);?>" name="abreviatura" /></td>
					</tr>
					<?php if ($idioma){?>
					<tr>
						<td>Nombre(Inglés):</td>
						<td><input type="text" name="nombre_en" value="<?php repoblar('nombre_en',$tipo_cliente->nombre_en);?>" /></td>
					</tr>
					<?php } ?>
					<tr>
						<td>Descripción:</td>
						<td><textarea cols="35" rows="5" name="descripcion"><?php repoblar('decripcion',$tipo_cliente->descripcion);?> </textarea></td>
					</tr>
					<?php if ($idioma){?>
					<tr>
						<td>Descripción(Inglés):</td>
						<td><textarea cols="35" rows="5" name="descripcion_en"><?php repoblar('descripcion_en',$tipo_cliente->descripcion_en);?> </textarea></td>
					</tr>
					<?php } ?>
					<?php $descuento = ($tipo_cliente->idTipoCliente == 3) ? 'Incremento:' : 'Descuento:'; ?>
					<tr>
						<td><?php echo $descuento;?></td>
						<td><input type="text" name="descuento" value="<?php repoblar('precio_cliente',$tipo_cliente->precio_cliente);?>" />%</td>
					</tr>
					<?php if($tipo_cliente->idTipoCliente == 3){?>
					<tr>
						<td colspan="2">**Nota: En el caso de Cliente Catálogo (default) el Descuento es en realidad un Incremento al precio público.</td>
					</tr>
					<?php } ?>
					<tr>
						<td>Promoción:</td>
						<?php if(!empty($tipo_cliente->promocion)){$value = "checked";}else{$value = $tipo_cliente->promocion;}?>
						<td><input type="checkbox" value="2+1" <?php repoblar('promocion',$value,false,true);?> name="promocion[]"/>dos más uno</td>
					</tr>
					<tr>
						<td align="center" colspan="2"><input type="submit" value="Guardar" /></td>
					</tr>
				</table>
				<input type="hidden" value="<?php echo $tipo_cliente->idTipoCliente;?>" name="actualiza_id" />
				<?php echo form_close();?>
				<center><a href="<?php echo base_url('admin');?>//dashboard/tipo_cliente/consulta">Regresar</a></center>
				<?php
				}
				break;
			}
		break;
		case "editar_categoria":
			switch($rol){
				case "ADMINISTRADOR":
				foreach($consulta->result() as $categoria){
				?>
					<h2>Edición de Categorías</h2>
					<?php echo form_open(current_url());?>
					<table align="center" class="modificar">
						<tr>
							<td>Nombre:</td>
							<td><input type="text" value="<?php repoblar('nombre',$categoria->nombre);?>" name="nombre" size="50"/></td>
						</tr>
						<?php if($idioma){ ?>
						<tr>
							<td>Nombre en Inglés:</td>
							<td><input type="text" value="<?php repoblar('nombre_en',$categoria->nombre_en);?>" name="nombre_en" size="50"/></td>
						</tr>
						<?php } ?>
						<tr>
							<td align="center" colspan="2"><input type="submit" value="Guardar" /></td>
						</tr>
					</table>
					<?php echo form_close();?>
					<center><a href="<?php echo base_url('admin');?>//tienda/categoria/consulta">Regresar</a></center>
				<?php
				}
				break;
			}
		break;
		
		case "editar_usuario":
			switch($rol){
				case "ADMINISTRADOR":
				foreach($consulta->result() as $usuario){
				?>
				<h2>Edición de <?php echo $usuario->correo;?></h2>
				<?php echo form_open(current_url());?>
				<table align="center" class="modificar">
					<tr>
						<td>Correo:</td>
						<td><input type="text" name="actualiza_correo" value="<?php echo $usuario->correo;?>" size="50" /></td>
					</tr>
					<tr>
						<td>Contraseña:</td>
						<td><input type="password" name="actualiza_password1" value="" size="50" /></td>
					</tr>
					<tr>
						<td>Confirmar contraseña:</td>
						<td><input type="password" name="actualiza_password2" value="" size="50" /></td>
					</tr>
					<tr>
						<td align="center" colspan="2"><input type="submit" value="Guardar"  /></td>
					</tr>
				</table>
				<input type="hidden" value="<?php echo $usuario->idUsuario;?>" name="actualiza_id" />
				<?php echo form_close();?>
				<center><a href="<?php echo base_url('admin');?>//dashboard/usuario/consulta">Regresar</a></center>
				<?php
				}
				break;
			}
		break;
	}
}

function consultaInformacion($seccion,$rol,$consulta,$idioma=false){
	switch ($seccion){
		default:
		break;
		case "consulta_representante_recibido":
		case "consulta_catalogo_recibido":?>
			
			<h2>Consulta de Pedidos Recibidos</h2>
			<center><?php echo form_open("busqueda/pedido");?><input type="text" size="50" name="token" /><input type="submit" value="Buscar" /><? echo form_close();?><br />
					<button onclick="window.open('<?php echo site_url('admin/pedido/excel_todos/'.$seccion);?>','newwindow','width=400,height=200');">Exportar Todos</button>
			</center>
			<table align="center" width="70%" class="consulta">
				<tr>
					<th>Número de Pedido</th>
					<th>Cliente</th>
					<th>Fecha de Pedido</th>
					<th>Información</th>
					<th>Estado</th>
					<th>Exportar a Excel</th>
				</tr>
				<?php foreach ($consulta->result() as $pedido){
					/*if($pedido->activo == "SI"){
					$activo_accion = "desactivar";
					}else{
					$activo_accion = "activar";
					}*/
					$estado = ($pedido->Estado_idEstado == 9) ? "Histórico" : $pedido->estado;
				?>
				<tr>
					<td><?php echo $pedido->idPedido;?></td>
					<td><?php echo $pedido->nombre;?> <?php echo $pedido->apellido;?></td>
					<td><?php echo $pedido->fecha_pedido;?></td>			
					<td><a href="<?php echo base_url('admin');?>/pedido/recibido/ver/<?php echo $pedido->idPedido;?>">Ver</a></td>
					<td><a href="<?php echo site_url('admin/pedido/recibido/estado');?>/<?php echo $pedido->idPedido;?>"><?php echo $estado;?></a></td>
					<td><button onclick="window.open('<?php echo site_url('admin/pedido/excel/'.$pedido->idPedido);?>','newwindow','width=400,height=200');">Exportar</button></td>
				</tr>
				<?php } ?>
			</table>
		<?php
		break;
		case "consulta_representante_proceso":
		case "consulta_catalogo_proceso":?>
			
			<h2>Consulta de Pedidos Proceso</h2>
			<center><?php echo form_open("busqueda/pedido");?><input type="text" size="50" name="token" /><input type="submit" value="Buscar" /><? echo form_close();?><br />
					<button onclick="window.open('<?php echo site_url('admin/pedido/excel_todos/'.$seccion);?>','newwindow','width=400,height=200');">Exportar Todos</button>
			</center>
			<table align="center" width="70%" class="consulta">
				<tr>
					<th>Número de Pedido</th>
					<th>Cliente</th>
					<th>Fecha de Pedido</th>
					<th>Información</th>
					<th>Estado</th>
					<th>Exportar a Excel</th>
				</tr>
				<?php foreach ($consulta->result() as $pedido){
					/*if($pedido->activo == "SI"){
					$activo_accion = "desactivar";
					}else{
					$activo_accion = "activar";
					}*/
					$estado = ($pedido->Estado_idEstado == 9) ? "Histórico" : $pedido->estado;
				?>
				<tr>
					<td><?php echo $pedido->idPedido;?></td>
					<td><?php echo $pedido->nombre;?> <?php echo $pedido->apellido;?></td>
					<td><?php echo $pedido->fecha_pedido;?></td>			
					<td><a href="<?php echo base_url('admin');?>/pedido/proceso/ver/<?php echo $pedido->idPedido;?>">Ver</a></td>
					<td><a href="<?php echo site_url('admin/pedido/proceso/estado');?>/<?php echo $pedido->idPedido;?>"><?php echo $estado;?></a></td>
					<td><button onclick="window.open('<?php echo site_url('admin/pedido/excel/'.$pedido->idPedido);?>','newwindow','width=400,height=200');">Exportar</button></td>
				</tr>
				<?php } ?>
			</table>
		<?php
		break;
		case "consulta_antiguo":?>
			
			<h2>Consulta de Pedidos Pertenecientes al Sistema Anterior</h2>
			
			<table align="center" width="70%" class="consulta">
				<tr>
					<th>Número de Pedido</th>
					<th>Cliente</th>
					<th>Fecha de Pedido</th>
					<th>Información</th>
				</tr>
				<?php foreach ($consulta->result() as $pedido){
					/*if($pedido->activo == "SI"){
					$activo_accion = "desactivar";
					}else{
					$activo_accion = "activar";
					}*/
				?>
				<tr>
					<td><?php echo $pedido->idPedido;?></td>
					<td><?php echo $pedido->nombre;?> <?php echo $pedido->apellido;?></td>
					<td><?php echo $pedido->fecha_pedido;?></td>			
					<td><a href="<?php echo base_url('admin');?>/pedido/antiguo/ver/<?php echo $pedido->idPedido;?>">Ver</a></td>
				</tr>
				<?php } ?>
			</table>
		<?php
		break;
		case "consulta_representante_surtido":
		case "consulta_catalogo_surtido":?>
			
			<h2>Consulta de Pedidos Surtidos</h2>
			<center><?php echo form_open("busqueda/pedido");?><input type="text" size="50" name="token" /><input type="submit" value="Buscar" /><? echo form_close();?><br />
					<button onclick="window.open('<?php echo site_url('admin/pedido/excel_todos/'.$seccion);?>','newwindow','width=400,height=200');">Exportar Todos</button>
			</center>
			<table align="center" width="70%" class="consulta">
				<tr>
					<th>Número de Pedido</th>
					<th>Cliente</th>
					<th>Fecha de Pedido</th>
					<th>Información</th>
					<th>Estado</th>
					<th>Exportar a Excel</th>
				</tr>
				<?php foreach ($consulta->result() as $pedido){
					/*if($pedido->activo == "SI"){
					$activo_accion = "desactivar";
					}else{
					$activo_accion = "activar";
					}*/
					$estado = ($pedido->Estado_idEstado == 9) ? "Histórico" : $pedido->estado;
				?>
				<tr>
					<td><?php echo $pedido->idPedido;?></td>
					<td><?php echo $pedido->nombre;?> <?php echo $pedido->apellido;?></td>
					<td><?php echo $pedido->fecha_pedido;?></td>			
					<td><a href="<?php echo base_url('admin');?>/pedido/surtido/ver/<?php echo $pedido->idPedido;?>">Ver</a></td>
					<td><a href="<?php echo site_url('admin/pedido/surtido/estado');?>/<?php echo $pedido->idPedido;?>"><?php echo $estado;?></a></td>
					<td><button onclick="window.open('<?php echo site_url('admin/pedido/excel/'.$pedido->idPedido);?>','newwindow','width=400,height=200');">Exportar</button></td>
				</tr>
				<?php } ?>
			</table>
		<?php
		break;
		case "consulta_todos":?>
			
			<h2>Consulta de Todos los Pedidos</h2>
			<center><?php echo form_open("busqueda/pedido");?><input type="text" size="50" name="token" /><input type="submit" value="Buscar" /><? echo form_close();?><br />
					<button onclick="window.open('<?php echo site_url('admin/pedido/excel_todos/'.$seccion);?>','newwindow','width=400,height=200');">Exportar Todos</button>
			</center>
			<table align="center" width="70%" class="consulta">
				<tr>
					<th>Número de Pedido</th>
					<th>Cliente</th>
					<th>Fecha de Pedido</th>
					<th>Información</th>
					<th>Estado</th>
					<th>Exportar a Excel</th>
				</tr>
				<?php foreach ($consulta->result() as $pedido){
					/*if($pedido->activo == "SI"){
					$activo_accion = "desactivar";
					}else{
					$activo_accion = "activar";
					}*/
					$estado = ($pedido->Estado_idEstado == 9) ? "Histórico" : $pedido->estado;
				?>
				<tr>
					<td><?php echo $pedido->idPedido;?></td>
					<td><?php echo $pedido->nombre;?> <?php echo $pedido->apellido;?></td>
					<td><?php echo $pedido->fecha_pedido;?></td>			
					<td><a href="<?php echo base_url('admin');?>/pedido/surtido/ver/<?php echo $pedido->idPedido;?>">Ver</a></td>
					<td><a href="<?php echo site_url('admin/pedido/surtido/estado');?>/<?php echo $pedido->idPedido;?>"><?php echo $estado;?></a></td>
					<td><button onclick="window.open('<?php echo site_url('admin/pedido/excel/'.$pedido->idPedido);?>','newwindow','width=400,height=200');">Exportar</button></td>
				</tr>
				<?php } ?>
			</table>
		<?php
		break;
		case "consulta_tipo_cliente":?>

			<h2>Consulta de Tipos de Cliente</h2>
			<center><?php echo form_open("busqueda/$seccion");?><input type="text" size="50" name="token" /><input type="submit" value="Buscar" /><? echo form_close();?></center>
			<table align="center" width="70%" class="consulta">
				<tr>
					<th>Tipo Cliente</th>
					<th>Abreviatura TC</th>
					<th>Descripcion</th>
					<th>Descuento</th>
					<th>Información</th>
					<th>Activo</th>
				</tr>
				<?php foreach ($consulta->result() as $tipoCliente){
					if($tipoCliente->activo == "SI"){
					$activo_accion = "desactivar";
					}else{
					$activo_accion = "activar";
					}
				?>
				<tr>
				<td><?php echo $tipoCliente->nombre;?></td>
				<td><?php echo $tipoCliente->abreviatura;?></td>
				<td><?php echo $tipoCliente->descripcion;?></td>
				<td><?php if($tipoCliente->precio_cliente == 0){
								echo ($tipoCliente->promocion == '2+1') ? 'Dos más uno' : 'N.A.';
							}else{
								echo ($tipoCliente->promocion == '2+1') ? 'Dos más uno' : (($tipoCliente->idTipoCliente == 3) ? '+'.$tipoCliente->precio_cliente : $tipoCliente->precio_cliente );
								//echo $tipoCliente->precio_cliente;
							}?></td>
							<?php $url_nombre = url_title($tipoCliente->nombre, 'underscore', TRUE); ?>
				<td><a href="<?php echo base_url('admin');?>/dashboard/tipo_cliente/ver/<?php echo $tipoCliente->idTipoCliente;?>">Ver</a>|<a href="<?php echo base_url('admin');?>/dashboard/tipo_cliente/editar/<?php echo $tipoCliente->idTipoCliente;?>">Editar</a></td>
				<?php if($tipoCliente->idTipoCliente == 3){?>
				<td><?php echo $tipoCliente->activo;?></td>
				<?php
				}else{?>
				<td><a href="<?php echo base_url('admin');?>/dashboard/tipo_cliente/<?php echo $activo_accion;?>/<?php echo $tipoCliente->idTipoCliente;?>"><?php echo $tipoCliente->activo;?></a></td>
				<?php
				}?>
				
				</tr>
				<?php } ?>
			</table>
		<?php
		break;
		case "consulta_usuario":?>
			<h2>Consulta de Usuarios</h2>
			<center><?php echo form_open("busqueda/$seccion");?><input type="text" size="50" name="token" /><input type="submit" value="Buscar" /><? echo form_close();?></center>
			<table align="center" width="70%" class="consulta">
				<tr>
					<th>Correo</th>
					<th>Permiso</th>
					<th>Contraseña</th>
					<th>Sesión</th>
					<th>Información</th>
					<th>Activo</th>
				</tr>
				<?php foreach ($consulta->result() as $usuario){
					if($usuario->activo == "SI"){
					$activo_accion = "desactivar";
					}else{
					$activo_accion = "activar";
					}
				?>
				<tr>
				<td><?php echo $usuario->correo;?></td>
				<td><?php echo $usuario->descripcion;?></td>
				<td><?php echo $usuario->pass;?></td>
				<?php if(($usuario->secure_number != NULL)){?>
						<td style="border: #00A619 solid 1px;"><a href="<?php echo base_url('admin');?>/dashboard/terminar_sesion/<?php echo $usuario->secure_number;?>">Iniciada</a></td>
						<?php
						}else{ ?>
							<td>Sin iniciar</td>
						<?php }
				?>
				<td><a href="<?php echo base_url('admin');?>/dashboard/usuario/ver/<?php echo $usuario->idUsuario;?>">Ver</a>|<a href="<?php echo base_url('admin');?>/dashboard/usuario/editar/<?php echo $usuario->idUsuario;?>">Editar</a></td>
				<td><a href="<?php echo base_url('admin');?>/dashboard/usuario/<?php echo $activo_accion;?>/<?php echo $usuario->idUsuario;?>"><?php echo $usuario->activo;?></a></td>
				</tr>
				<?php } ?>
			</table>
		<?php
		break;
		case 'consulta_cliente':?>
			
			<center><button onclick="window.open('<?php echo site_url('admin/tienda/cliente/excel/');?>','newwindow','width=400,height=200');">Exportar Listado de Clientes</button></center>
			
			<h2>Consulta de Cliente</h2>
			<center><?php echo form_open("busqueda/$seccion");?><input type="text" size="50" name="token" /><input type="submit" value="Buscar" /><? echo form_close();?></center>

			<table align="center" width="70%" class="consulta">
				<tr>
					<th>Nombre</th>
					<th>Tipo de Cliente</th>
					<th>Clave de Cliente</th>
					<th>Contraseña</th>
					<th>Sesión</th>
					<th>Fecha Alta</th>
					<th>Información</th>
					<th>Activo</th>
				</tr>
				<?php foreach ($consulta->result() as $cliente){
					if($cliente->activo == "SI"){
					$activo_accion = "desactivar";
					}else{
					$activo_accion = "activar";
					}
				?>
				<tr>
					<td style="text-align:left;"><?php echo $cliente->nombre_cliente;?> <?php echo $cliente->apellido;?></td>
					<td><?php echo $cliente->nombre;?></td>
					<td><?php echo $cliente->abreviatura.''.$cliente->idCliente;?></td>
					<td><?php echo $cliente->contrasena;?></td>
					<?php if(($cliente->secure_number != NULL)){?>
							<td style="border: #00A619 solid 1px;"><a href="<?php echo base_url('admin');?>/tienda/terminar_sesion/<?php echo $cliente->secure_number;?>">Iniciada</a></td>
							<?php
							}else{ ?>
								<td>Sin iniciar</td>
							<?php }
					?>
					<td><?php echo $cliente->fecha;?></td>
					<td><a href="<?php echo base_url('admin');?>/tienda/cliente/ver/<?php echo $cliente->idCliente;?>">Ver</a>|<a href="<?php echo base_url('admin');?>/tienda/cliente/editar_general/<?php echo $cliente->idCliente;?>">Editar</a></td>
					<td><a href="<?php echo base_url('admin');?>/tienda/cliente/<?php echo $activo_accion;?>/<?php echo $cliente->idCliente;?>"><?php echo $cliente->activo;?></a></td>
				</tr>
				<?php } ?>
			</table>
		<?php
		break;
		case "consulta_categoria":?>
			<h2>Consulta de Categorías</h2>
			<table align="center" width="70%" class="consulta">
				<tr>
					<th>Nombre</th>
					<th>Subcategorias</th>
					<th>Información</th>
					<th>Activo</td>
				</tr>
				<?php foreach ($consulta->result() as $categoria){
					if($categoria->activo == "SI"){
					$activo_accion = "desactivar";
					}else{
					$activo_accion = "activar";
					}
				?>
				<tr>
				<td><?php echo $categoria->nombre;?></td>
				<td><a href="<?php echo base_url('admin');?>/tienda/subcategoria/consulta/<?php echo $categoria->idCategoria;?>">Ver</a></td>
				<td><a href="<?php echo base_url('admin');?>/tienda/categoria/editar/<?php echo $categoria->idCategoria;?>">Editar</a></td>
				<td><a href="<?php echo base_url('admin');?>/tienda/categoria/<?php echo $activo_accion;?>/<?php echo $categoria->idCategoria;?>"><?php echo $categoria->activo;?></a></td>
				</tr>
				<?php } ?>
			</table>
		<?php
		break;
		case "consulta_subcategoria":?>
			<h2>Consulta de Subcategorías</h2>
			<table align="center" width="70%" class="consulta">
				<tr>
					<th>Nombre</th>
					<?php if($idioma){ ?>
					<th>Nombre Inglés</th>
					<?php } ?>
					<th>Información</th>
					<th>Activo</th>
				</tr>
				<?php foreach ($consulta->result() as $subcategoria){
					if($subcategoria->activo == "SI"){
					$activo_accion = "desactivar";
					}else{
					$activo_accion = "activar";
					}
				?>
				<tr>
				<td><?php echo $subcategoria->nombre;?></td>
				<?php if ($idioma){ ?>
				<td><?php echo $subcategoria->nombre_en;?></td>
				<?php } ?>
				<td><a href="<?php echo base_url('admin');?>/tienda/subcategoria/editar/<?php echo $subcategoria->idSubcategoria;?>">Editar</a></td>
				
				<?php if($subcategoria->catactivo == 'SI'){ ?>
				<td><a href="<?php echo base_url('admin');?>/tienda/subcategoria/<?php echo $activo_accion;?>/<?php echo $subcategoria->idSubcategoria;?>"><?php echo $subcategoria->activo;?></a></td>
				<?php }else{ ?>
				<td><?php echo $subcategoria->activo;?></td>
				<?php } ?>
				</tr>
				<?php } ?>
			</table>
		<?php
		break;
		case "consulta_producto":
			switch($rol){
				case 'PRODUCTO_INFORMACION_GENERAL':
				case 'ADMINISTRADOR':?>
					<center><button onclick="window.open('<?php echo site_url('admin/tienda/producto/excel/');?>','newwindow','width=400,height=200');">Exportar Listado de Producto</button></center>
					<h2>Consulta de Productos</h2>
					<center><?php echo form_open("busqueda/$seccion");?><input type="text" size="50" name="token" /><input type="submit" value="Buscar" /><? echo form_close();?></center>
					<table align="center" width="70%" class="consulta">
						<tr>
							<th>Categoria</th>
							<th>Subcategoria</th>
							<th>Nombre del Producto</th>
							<th>Presentaciones del Producto</th>
							<th>Información</th>
							<th>Activo</td>
						</tr>
						<?php foreach ($consulta->result() as $producto){
							if($producto->produactivo == "SI"){
							$activo_accion = "desactivar";
							}else{
							$activo_accion = "activar";
							}
						?>
						<tr>
						<td><?php echo $producto->catnombre;?></td>
						<td><?php echo $producto->subcatnombre;?></td>
						<td><?php echo $producto->nombre;?></td>
						<td><a href="<?php echo base_url('admin');?>/tienda/presentacion/consulta/<?php echo $producto->idProducto;?>">Ver</a></td>
						<td><a href="<?php echo base_url('admin');?>/tienda/producto/ver/<?php echo $producto->idProducto;?>">Ver</a>|<a href="<?php echo base_url('admin');?>/tienda/producto/editar/<?php echo $producto->idProducto;?>">Editar</a></td>
						<td><a href="<?php echo base_url('admin');?>/tienda/producto/<?php echo $activo_accion;?>/<?php echo $producto->idProducto;?>"><?php echo $producto->produactivo;?></a></td>
						</tr>
						<?php } ?>
					</table>
				<?php
				break;
				case 'PRODUCTO_PRECIO':
				case 'PRODUCTO_INFORMACION_INGREDIENTES':
				case 'PRODUCTO_VIDEO':?>
					<center><button onclick="window.open('<?php echo site_url('admin/tienda/producto/excel/');?>','newwindow','width=400,height=200');">Exportar Listado de Producto</button></center>
					<h2>Consulta de Productos</h2>
					<center><?php echo form_open("busqueda/$seccion");?><input type="text" size="50" name="token" /><input type="submit" value="Buscar" /><? echo form_close();?></center>
					<table align="center" width="70%" class="consulta">
						<tr>
							<th>Categoria</th>
							<th>Subcategoria</th>
							<th>Nombre del Producto</th>
							<th>Presentaciones del Producto</th>
							<th>Información</th>
						</tr>
						<?php foreach ($consulta->result() as $producto){
							if($producto->produactivo == "SI"){
							$activo_accion = "desactivar";
							}else{
							$activo_accion = "activar";
							}
						?>
						<tr>
						<td><?php echo $producto->catnombre;?></td>
						<td><?php echo $producto->subcatnombre;?></td>
						<td><?php echo $producto->nombre;?></td>
						<td><a href="<?php echo base_url('admin');?>/tienda/presentacion/consulta/<?php echo $producto->idProducto;?>">Ver</a></td>
						<td><a href="<?php echo base_url('admin');?>/tienda/producto/ver/<?php echo $producto->idProducto;?>">Ver</a></td>
						<?php } ?>
					</table>
				<?php
				break;
				
			}
		break;
		case "consulta_presentacion":
		switch($rol){
				case 'PRODUCTO_INFORMACION_GENERAL':
				case 'ADMINISTRADOR':
		?>
			<center><button onclick="window.open('<?php echo site_url('admin/tienda/producto/excel/');?>','newwindow','width=400,height=200');">Exportar Listado de Producto</button></center>
			<h2>Consulta de Presentaciones</h2>
			<center><?php echo form_open("busqueda/$seccion");?><input type="text" size="50" name="token" /><input type="submit" value="Buscar" /><? echo form_close();?></center>
			<table align="center" width="70%" class="consulta">
				<tr>
					<th>Clave</th>
					<th>Nombre Producto</th>
					<th>Estado Físico</th>
					<th>Contenido Neto</th>
					<th>I.V.A.</th>
					<th>Precio</th>
					<th>Promociones</th>
					<th>Información</th>
					<th>Activo</th>
				</tr>
				<?php foreach ($consulta->result() as $presentacion){
					if($presentacion->activo == "SI"){
					$activo_accion = "desactivar";
					}else{
					$activo_accion = "activar";
					}

					if($presentacion->iva == "SI"){
					$iva_mostrar = "16%";
					}else{
					$iva_mostrar = "N.A.";
					}

					if(presentacionCompleta($presentacion,$rol)){
						$clase="";
					}else{
						$clase = "red";
					}

				?>
				<tr class="<?php echo $clase?>">
				<td><?php echo $presentacion->clave;?></td>
				<td><?php echo $presentacion->nombre_producto;?></td>
				<td><?php echo $presentacion->estado_fisico;?></td>
				<td><?php echo $presentacion->contenido_neto;?></td>
				<td><?php echo $iva_mostrar;?></td>
				<td><?php echo $presentacion->precio_publico;?></td>
				<td><a href="<?php echo base_url('admin');?>/tienda/presentacion/promocion/<?php echo $presentacion->idPresentacion;?>">Ver</a></td>
				<td><a href="<?php echo base_url('admin');?>/tienda/presentacion/ver/<?php echo $presentacion->idPresentacion;?>">Ver</a>|<a href="<?php echo base_url('admin');?>/tienda/presentacion/editar/<?php echo $presentacion->idPresentacion;?>">Editar</a></td>
				<td><a href="<?php echo base_url('admin');?>/tienda/presentacion/<?php echo $activo_accion;?>/<?php echo $presentacion->idPresentacion;?>"><?php echo $presentacion->activo;?></a></td>
				</tr>
				<?php } ?>
			</table>
		<?php
				break;
				case 'PRODUCTO_PRECIO':
				case 'PRODUCTO_VIDEO':				
				case 'PRODUCTO_INFORMACION_INGREDIENTES':?>
				<center><button onclick="window.open('<?php echo site_url('admin/tienda/producto/excel/');?>','newwindow','width=400,height=200');">Exportar Listado de Producto</button></center>
				<h2>Consulta de Presentaciones</h2>
			<center><?php echo form_open("busqueda/$seccion");?><input type="text" size="50" name="token" /><input type="submit" value="Buscar" /><? echo form_close();?></center>
			<table align="center" width="70%" class="consulta">
				<tr>
					<th>Clave</th>
					<th>Nombre Producto</th>
					<th>Estado Físico</th>
					<th>Contenido Neto</th>
					<th>I.V.A.</th>
					<th>Precio</th>
					<th>Promociones</th>
					<th>Información</th>
					
				</tr>
				<?php foreach ($consulta->result() as $presentacion){
					if($presentacion->activo == "SI"){
					$activo_accion = "desactivar";
					}else{
					$activo_accion = "activar";
					}

					if($presentacion->iva == "SI"){
					$iva_mostrar = "16%";
					}else{
					$iva_mostrar = "N.A.";
					}

					if(presentacionCompleta($presentacion,$rol)){
						$clase="";
					}else{
						$clase = "red";
					}

				?>
				<tr class="<?php echo $clase?>">
				<td><?php echo $presentacion->clave;?></td>
				<td><?php echo $presentacion->nombre_producto;?></td>
				<td><?php echo $presentacion->estado_fisico;?></td>
				<td><?php echo $presentacion->contenido_neto;?></td>
				<td><?php echo $iva_mostrar;?></td>
				<td><?php echo $presentacion->precio_publico;?></td>
				<td><a href="<?php echo base_url('admin');?>/tienda/promocion/consulta/<?php echo $presentacion->idPresentacion;?>">Ver</a></td>
				<td><a href="<?php echo base_url('admin');?>/tienda/presentacion/ver/<?php echo $presentacion->idPresentacion;?>">Ver</a>|<a href="<?php echo base_url('admin');?>/tienda/presentacion/editar/<?php echo $presentacion->idPresentacion;?>">Editar</a></td>
				</tr>
				<?php } ?>
			</table>
			<?php
				break;
			}
		break;
		case 'consulta_promocion': ?>
			<h2>Consulta de Promociones</h2>
			
			<table align="center" width="70%" class="consulta">
				<tr>
					<th>Clave</th>
					<th>Nombre Producto</th>
					<th>Estado Físico</th>
					<th>Precio de Promoción</th>
					<th>Fecha Inicio</th>
					<th>Fecha Final</th>
					
				</tr>
				<?php foreach ($consulta->result() as $presentacion){ ?>
				<tr class="<?php echo $clase?>">
				<td><?php echo $presentacion->clave;?></td>
				<td><?php echo $presentacion->nombre_producto;?></td>
				<td><?php echo $presentacion->estado_fisico;?></td>
				<td><?php echo $presentacion->precio;?></td>
				<td><?php echo $presentacion->date_start;?></td>
				<td><?php echo $presentacion->date_end;?></td>
				</tr>
				<?php 
				} ?>
			</table>
			<h2>Dar de alta una nueva promoción</h2>
			<?php echo form_open_multipart(current_url());?>
			<?php
				$string = uri_string();
				$pieces = explode('/',$string);
			?>
				<input type="hidden" value="<?php echo $pieces[3];?>" name="id" />
				<table align="center" class="consulta">
					<tr>
						<th>Precio de Promoción</th>
						<th>Fecha de Inicio</th>
						<th>Fecha de Finalización</th>
					</tr>
					<tr>
						<td><input type="text" value="<?echo set_value('precio_promocion');?>" name="precio_promocion" /></td>
						<td><input type="text" value="<?echo set_value('fecha_inicio');?>" name="fecha_inicio" id="inicio"/></td>
						<td><input type="text" value="<?echo set_value('fecha_final');?>" name="fecha_final" id="final"/></td>
						<td><input type="submit" value="Guardar"/></td>
					</tr>
				</table>
			<?php echo form_close();?>



		<?php
		break;
	}
}
 function verInformacion($seccion,$rol,$consulta,$idioma = false){
	switch($seccion){
		default:
		break;
		
		
		case "ver_tipo_cliente":
		foreach($consulta->result() as $tipo_cliente){
		?>
			<h2><?php echo $tipo_cliente->nombre;?></h2>
			<table align="center" class="consulta">
				<tr>
					<th>Abreviatura TC:</th>
					<td><?php echo $tipo_cliente->abreviatura;?></td>
				</tr>
				<?php if ($idioma){?>
				<tr>
					<th>Nombre(Inglés):</th>
					<td><?php echo $tipo_cliente->nombre_en;?></td>
				</tr>
				<?php } ?>
				<tr>
					<th>Descripción:</th>
					<td><?php echo $tipo_cliente->descripcion;?></td>
				</tr>
				<?php if ($idioma){?>
				<tr>
					<th>Descripción(Inglés):</th>
					<td><?php echo $tipo_cliente->descripcion_en;?></td>
				</tr>
				<?php } ?>
				<tr>
					<th>Descuento:</th>
					<td><?php echo $tipo_cliente->precio_cliente;?>%</td>
				</tr>
				<tr>
					<th>Promoción:</th>
					<td><?php echo $tipo_cliente->promocion;?></td>
				</tr>
			</table>
			<center>
			<?php $url_nombre = url_title($tipo_cliente->nombre, 'underscore', TRUE); ?>
			<a href="<?php echo base_url('admin');?>//dashboard/tipo_cliente/consulta">Regresar</a> | <a href="<?php echo base_url('admin');?>/dashboard/tipo_cliente/editar/<?php echo $tipo_cliente->idTipoCliente;?>">Editar</a> 
			</center>
		<?php
		}
		break;
		case "ver_usuario":
		foreach($consulta->result() as $usuario){
		?>
			<h2><?php echo $usuario->correo;?>::<?php echo $usuario->descripcion;?></h2>
			<table align="center" class="consulta">
				<tr>
					<th>Correo:</th>
					<td><?php echo $usuario->correo;?></td>
				</tr>
				<tr>
					<th>Permiso:</th>
					<td><?php echo $usuario->descripcion;?></td>
				</tr>
				<tr>
					<th>Número de Seguridad (Sesión):</th>
					<td><?php echo $usuario->secure_number;?></td>
				</tr>
				<tr>
					<th>Activo:</th>
					<td><?php echo $usuario->activo;?></td>
				</tr>
			</table>
			<center>
			<a href="<?php echo base_url('admin');?>//dashboard/usuario/consulta">Regresar</a> | <a href="<?php echo base_url('admin');?>/dashboard/usuario/editar/<?php echo $usuario->idUsuario;?>">Editar</a> 
			</center>
		<?php
		}
		break;
		case "ver_producto":
			foreach($consulta->result() as $producto){
		?>
			<h2>Producto :: <?php echo $producto->nombre;?></h2>
			<table align="center" class="consulta1">
				<tr>
					<th>Categoria:</th>
					<td><?php echo $producto->catnombre;?></td>
				</tr>
				<tr>
					<th>Subcategoria:</th>
					<td><?php echo $producto->subcatnombre;?></td>
				</tr>
				<tr>
					<th>Información de ingredientes principales:</th>
					<td><?php echo nl2br($producto->uso);?></td>
				</tr>
				<tr>
					<th>Opinión de Expertos:</th>
					<td><?php echo nl2br($producto->experto);?></td>
				</tr>
				<tr>
					<th>Comentarios al Producto:</th>
					<td><?php echo nl2br($producto->testimonio);?></td>
				</tr>
				<?php if($idioma){ ?>
				<tr>
					<th>Información de ingredientes principales(Inglés):</th>
					<td><?php echo $producto->uso_ingles;?></td>
				</tr>
				<tr>
					<th>Opinión de Expertos(Inglés):</th>
					<td><?php echo $producto->experto_en;?></td>
				</tr>
				<?php } ?>
				<tr>
					<th>Imágen: </th>
					<td><img src="<?php echo base_url();?>/productos_img/<?php echo $producto->imagen;?>" alt="<?php echo $producto->nombre;?>" /></td>
				</tr>
				<tr>
					<th>Activo:</th>
					<td><?php echo $producto->produactivo;?></td>
				</tr>
			</table>
			<center>
			<?php switch($rol){ 
				case 'PRODUCTO_INFORMACION_GENERAL':
				case 'ADMINISTRADOR':?>
			
			<a href="<?php echo base_url('admin');?>//tienda/producto/consulta">Regresar</a> | <a href="<?php echo base_url('admin');?>/tienda/producto/editar/<?php echo $producto->idProducto;?>">Editar</a> 
			
			<?php break;
				default:?>
					<a href="<?php echo base_url('admin');?>//tienda/producto/consulta">Regresar</a>
				<?php
				break;
			} ?>
			</center>
		<?php
		}
		break;

		
	}
 
}

function construyeFormularioEdicion2($seccion,$rol,$consultaUno,$consultaDos,$consultaTres,$idioma = false){
	switch($seccion){
			default:
			break;
			case "dos_ver_pedido":
				switch ($rol){
				default:
				break;
				case 'ADMINISTRADOR':
				case 'PEDIDOS_CATALOGO':
				case 'PEDIDOS_REPRESENTANTE_EMBARQUES':
				case 'PEDIDOS_REPRESENTANTE_VENTAS':
					$valores = $consultaTres;
					foreach($consultaUno->result() as $pedido){
					?>
					<h2>Pedido No. <?php echo $pedido->idPedido;?> </h2>
					<table align="center" class="consulta">
						<tr>
							<th>Cliente número: </th>
							<td> <a target="_blank" href="<?php echo site_url('admin/tienda/cliente/ver/'.$pedido->idCliente);?>"><?php echo $pedido->abreviatura.''.$pedido->idCliente;?></a></td>
						</tr>
						<tr>
							<th>Fecha de recepción: </th>
							<td> <?php echo $pedido->fecha_pedido;?></td>
						</tr>
						<tr>
							<th>Estado: </th>
							<td> <?php echo $pedido->estado;?></td>
						</tr>
						<tr>
							<td>
								<h3>Datos Generales</h3>
								<table align="center" width="70%" class="consulta">
									<tr>
										<th>Nombre:</th>
										<td><?php echo $pedido->nombre_gen;?></td>
									</tr>
									<tr>
										<th>Correo:</tH>
										<td><?php echo $pedido->correo_gen;?></td>
									</tr>
									<tr>
										<th>Teléfono:</tH>
										<td><?php echo $pedido->cliente_telefono;?></td>
									</tr>
									<tr>
										<th>Calle:</th>
										<td><?php echo $pedido->calle_gen;?></td>
									</tr>
									<tr>
										<th>Colonia:</th>
										<td><?php echo $pedido->colonia_gen;?></td>
									</tr>
									<tr>
										<th>Código postal:</th>
										<td><?php echo $pedido->postal_gen;?></td>
									</tr>
									<tr>
										<th>Delegación o Municipio:</th>
										<td><?php echo $pedido->del_gen;?></td>
									</tr>
									<tr>
										<th>Estado:</th>
										<td><?php echo $pedido->estado_gen;?></td>
									</tr>
									<tr>
										<th>País:</th>
										<td><?php echo $pedido->pais_gen;?></td>
									</tr>
								</table>
							</td>
							<td>
								<h3>Datos Fiscales</h3>
								<table align="center" width="70%" class="consulta">
									<tr>
										<th>Nombre o Razón social:</th>
										<td><?php echo $pedido->razon_social;?></td>
									</tr>
									<tr>
										<th>RFC:</tH>
										<td><?php echo $pedido->rfc;?></td>
									</tr>
									<tr>
										<th>Calle:</th>
										<td><?php echo $pedido->calle_fact;?></td>
									</tr>
									<tr>
										<th>Colonia:</th>
										<td><?php echo $pedido->colonia_fact;?></td>
									</tr>
									<tr>
										<th>Código postal:</th>
										<td><?php echo $pedido->postal_fact;?></td>
									</tr>
									<tr>
										<th>Delegación o Municipio:</th>
										<td><?php echo $pedido->del_fact;?></td>
									</tr>
									<tr>
										<th>Estado:</th>
										<td><?php echo $pedido->estado_fact;?></td>
									</tr>
									<tr>
										<th>País:</th>
										<td><?php echo $pedido->pais_fact;?></td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<h3>Datos Envío</h3>
								<table align="center" width="70%" class="consulta">
									<tr>
										<th>Nombre de la persona que recibe:</th>
										<td><?php echo $pedido->persona_recibe;?></td>
										
									</tr>
									<tr>
										<th>Calle:</th>
										
										<td><?php echo $pedido->calle_env;?></td>
										
									</tr>
									<tr>
										<th>Colonia:</th>
										<td><?php echo $pedido->colonia_env;?></td>
										
									</tr>
									<tr>
										<th>Código postal:</th>
										<td><?php echo $pedido->postal_env;?></td>
										
									</tr>
									<tr>
										<th>Delegación o Municipio:</th>
										<td><?php echo $pedido->del_env;?></td>
										
										
									</tr>
									<tr>
										<th>Estado:</th>
										<td><?php echo $pedido->estado_env;?></td>
										
									</tr>
									<tr>
										<th>País:</th>
										<td><?php echo $pedido->pais_env;?></td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
					
					<?php echo form_open('pedido/contenido_nosurtido/'.$pedido->idPedido);?>
						<h2>Contenido del Pedido</h2>
						<table align="center" class="consulta">
							<tr>
								<?php if($pedido->promocion == '2+1'){?>
								<th>Total de piezas</th>
								<?php } ?>
								<th>Cantidad</th>
								<?php if($pedido->promocion == '2+1'){?>
								<th>Piezas Extra</th>
								<?php } ?>
								<th>Código</th>
								<th>Producto</th>
								<th>Estado Físico</th>
								<th>Contenido Neto</th>
								<th>Grupo</th>
								<th>I.V.A.</th>
								<th>Precio <?php echo $pedido->tipo_cliente;?></th>
								<th>Importe</th>
								<th>Cantidad No Surtida</th>
								<th>Importe No Surtido</th>
							</tr>
							<?php 
							$subtotal = 0;
							$subtotal_iva = 0;
							$total = 0;
							$totalno1 = 0;
							foreach ($consultaDos->result() as $contenido){

								//print_r($contenido);
								
								?>
							<tr>
								<?php if($pedido->promocion == '2+1'){?>
								<td><?php echo ($contenido->cantidad + floor($contenido->cantidad/2));?></td>
								<?php } ?>
								<td><?php echo $contenido->cantidad;?></td>
								<?php if($pedido->promocion == '2+1'){?>
								<td><?php echo floor($contenido->cantidad/2);?></td>
								<?php } ?>
								<td><?php echo $contenido->clave;?></td>
								<td><?php echo $contenido->nombre;?></td>
								<td><?php echo $contenido->estado_fisico;?></td>
								<td><?php echo $contenido->contenido_neto;?></td>
								<td><?php echo $contenido->grupo;?></td>
								<td><?php echo ($contenido->iva == 'NO') ? 'N.A.': '16%';?></td>
	                            <td><?php echo number_format($contenido->precio,2);?></td>
	                            <td><?php echo number_format($contenido->cantidad * $contenido->precio,2);?></td>
	                            
	                            <?php
	                            if(isset($valores[$contenido->idContenidoPedido])){ 
	                            	$value = $valores[$contenido->idContenidoPedido];
	                            	$totalno = $value * $contenido->precio;
	                            }else{
	                            	$value = 0.00;
	                            	$totalno = $value * $contenido->precio;
	                            }
	                            ?>
	                            <td><input type="text" name="nosurtido[<?php echo $contenido->idContenidoPedido;?>]" value="<?php echo $value;?>" class="input-mini numerico"/> </td>
	                            <td><?php echo number_format($totalno,2);?></td>

	                            <?php 
	                            $totalno1 += $totalno;
	                            ?>
								
								
							</tr>
							
							<?php 
								$subtotal += $contenido->cantidad * $contenido->precio;
								$subtotal_iva += ($contenido->iva == 'NO') ? 0 : ( $contenido->cantidad * (($contenido->precio * 16)/100) );
								$total = $subtotal + $subtotal_iva;
								}//foreach contenido ?>
							<tr>
								<td style="text-align:right;" colspan="<?php echo ($pedido->promocion != '2+1') ? '7' : '9' ;?>" align="right"></td>
								<td>Subtotal:</td> 
								<td><?php echo number_format($subtotal,2);?></td>
								<td>Importe no Surtido:</td>
								<td><?php echo number_format($totalno1,2);?></td>
							</tr>
							<tr>
								<td style="text-align:right;" colspan="<?php echo ($pedido->promocion != '2+1') ? '7' : '9' ;?>" align="right"></td>
								<td>IVA:</td>
								<td><?php echo number_format($subtotal_iva,2);?></td>
								<td></td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td style="text-align:right;" colspan="<?php echo ($pedido->promocion != '2+1') ? '7' : '9' ;?>" align="right"></td>
								<td>Total:</td>
								<td><?php echo number_format($total,2);?></td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
						</table>
						<center>
							<SCRIPT LANGUAGE="JavaScript"> 
							if (window.print) {
							document.write('<input type=button name=print value="Imprimir" onClick="window.print()">');
							}
							</script>
							<input type="submit" name="Guardar" value="Guardar" />
						</center>
					<?php echo form_close();?>
				<?php
				 }//foreach pedido		
					
				break;
				}
			break;
			case "dos_editar_presentacion":
			switch ($rol){
				default:
				break;
				case 'ADMINISTRADOR':
					foreach($consultaUno->result() as $presentacion){
					?>
					<h2>Editar Presentación</h2>
					<?php echo form_open_multipart(current_url());?>
					
					<table align="center" class="modificar">
						<tr>
							<td>Nombre Producto:</td>
							<td><select name="producto">
									
									<?php foreach($consultaTres->result() as $option){
										if($option->idProducto == $presentacion->Producto_idProducto){$selected = "selected";}else{$selected ="";}
										?>
										<option value="<?php echo $option->idProducto;?>" <?php repoblar('producto',$selected,true);?>><?php echo $option->nombre;?></option>
									<?php } ?>
								</select></td>
						</tr>
						<tr>
							<td>Clave:</td>
							<td><input type="text" value="<?php repoblar('clave',$presentacion->clave);?>" name="clave" size="50"/></td>
						</tr>
						<tr>
							<td>Estado Físico:</td>
							<td><input type="text" value="<?php repoblar('estado',$presentacion->estado_fisico);?>" name="estado" size="50"/></td>
						</tr>
						<tr>
							<td>Contenido Neto:</td>
							<td><input type="text" value="<?php repoblar('contenido',$presentacion->contenido_neto);?>" name="contenido" size="50"/></td>
						</tr>
						<tr>
							<td>Grupo:</td>
							<td><input type="text" value="<?php repoblar('grupo',$presentacion->grupo);?>" name="grupo" size="50"/></td>
						</tr>
						<tr>
							<td>Ingredientes:</td>
							<td><textarea name="ingredientes" rows="10" cols="40"><?php repoblar('ingredientes',$presentacion->ingredientes);?></textarea></td>
						</tr>
						<?php if($idioma){ ?>
						<tr>
							<td>Estado Físico(Inglés):</td>
							<td><input type="text" value='<?php repoblar('estado_en',$presentacion->estado_fisico_en);?>' name="estado_en" size="50"/></td>
						</tr>
						<tr>
							<td>Contenido Neto(Inglés):</td>
							<td><input type="text" value='<?php repoblar('estado_en',$presentacion->contenido_neto_en);?>' name="contenido_en" size="50"/></td>
						</tr>
						<?php } ?>
						<tr>
							<td>Imágen: <div style="font-size: 10px;"><b>(La imágen debe tener un tamaño de 175px por 175px.)</b></div></td>
							<td>
								<img src="<?php echo base_url();?>/productos_img/<?php echo $presentacion->imagen;?>" alt="<?php echo $presentacion->nombre_producto;?> | <?php echo $presentacion->estado_fisico;?>"/><br />
								<input type="file" name="userfile" size="20"/>
							</td>
						</tr>
						<tr>
							<td>Precio Público:</td>
							<?php 
							$arreglo = "[";
							$cont = $consultaDos->num_rows();
							$cont1 = 1; 
							foreach($consultaDos->result() as $tipocliente){
									if($tipocliente->idTipoCliente == 3){
										$par2 = $tipocliente->precio_cliente;
									}
									$arreglo .= "'".$tipocliente->precio_cliente."'";
									if($cont1 < $cont){
										$arreglo .= ",";
										$cont1++;
									}
							 }
							 $arreglo .= "]";
							 ?>
							
							<td><input type="text" value="<?php repoblar('precio',$presentacion->precio_publico);?>" name="precio" size="35" id="precio"/>
								<?php if($presentacion->iva == 'SI'){$checked = "checked";}else{$checked = "";}?>
								<input type="checkbox" value="SI" name="iva[]" <?php echo $checked;//echo set_checkbox('iva[]', 'SI'); ?> />I.V.A.(16%)
							</td>
						</tr>
						<tr>
							<td colspan="2"><input type="button" value="Calcular Precios" onclick="calculaPrecio(document.getElementById('precio').value,<?php echo $arreglo;?>,<?php echo $par2;?>);" /></td>
						</tr>
						<?php 
						$contid=0;
						foreach($consultaDos->result() as $tipocliente){
							$contid++;?>
						<tr>
							<td><?php echo $tipocliente->nombre;?>:</th>
							<td>
								<?php if(!empty($presentacion->precio_publico)){
										if($tipocliente->idTipoCliente == 3){
											$price = ((($presentacion->precio_publico * $tipocliente->precio_cliente)/100));	
										}
											else{
												$price = ($presentacion->precio_publico - (($presentacion->precio_publico * $tipocliente->precio_cliente)/100));
											}
										}else{
											$price = 0;
										} ?>
									<span id="<?php echo 'ID_'.$contid;?>"><?php echo number_format($price,2);?></span>
							</td>
						</tr>
					<?php } ?>
						<tr>
							<td>Vídeo(Link):</td>
							<td><input type="text" value='<?php repoblar('video',$presentacion->video);?>' name="video" size="50"/></td>
						</tr>
						<?php if($idioma){ ?>
						<tr>
							<td>Vídeo(Inglés):</td>
							<td><input type="text" value="<?php repoblar('video_en',$presentacion->video_en)?>" name="video_en" size="50"/></td>
						</tr>
						<?php } ?>
						<tr>
							<td align="center" colspan="2"><input type="submit" value="Guardar" /></td>
						</tr>
					</table>
					<?php echo form_close();?>
					<center><a href="<?php echo base_url('admin');?>/tienda/presentacion/consulta">Regresar</a></center>
				<?php
					}
				break;
				case 'PRODUCTO_INFORMACION_GENERAL':
					foreach($consultaUno->result() as $presentacion){
					?>
					<h2>Editar Presentación</h2>
					<?php echo form_open_multipart(current_url());?>
					
					<table align="center" class="modificar">
						<tr>
							<td>Nombre Producto:</td>
							<td><select name="producto">
									
									<?php foreach($consultaTres->result() as $option){
										if($option->idProducto == $presentacion->Producto_idProducto){$selected = "selected";}else{$selected ="";}
										?>
										<option value="<?php echo $option->idProducto;?>" <?php repoblar('producto',$selected,true);?>><?php echo $option->nombre;?></option>
									<?php } ?>
								</select></td>
						</tr>
						<tr>
							<td>Clave:</td>
							<td><input type="text" value="<?php repoblar('clave',$presentacion->clave);?>" name="clave" size="50"/></td>
						</tr>
						<tr>
							<td>Estado Físico:</td>
							<td><input type="text" value="<?php repoblar('estado',$presentacion->estado_fisico);?>" name="estado" size="50"/></td>
						</tr>
						<tr>
							<td>Contenido Neto:</td>
							<td><input type="text" value="<?php repoblar('contenido',$presentacion->contenido_neto);?>" name="contenido" size="50"/></td>
						</tr>
						<tr>
							<td>Grupo:</td>
							<td><input type="text" value="<?php repoblar('grupo',$presentacion->grupo);?>" name="grupo" size="50"/></td>
						</tr>
						<?php if($idioma){ ?>
						<tr>
							<td>Estado Físico(Inglés):</td>
							<td><input type="text" value="<?php repoblar('estado_en',$presentacion->estado_fisico_en);?>" name="estado_en" size="50"/></td>
						</tr>
						<tr>
							<td>Contenido Neto(Inglés):</td>
							<td><input type="text" value="<?php repoblar('estado_en',$presentacion->contenido_neto_en);?>" name="contenido_en" size="50"/></td>
						</tr>
						<?php } ?>
						<tr>
							<td>Imágen: <div style="font-size: 10px;"><b>(La imágen debe tener un tamaño de 175px por 175px.)</b></div></td>
							<td>
								<img src="<?php echo base_url();?>/productos_img/<?php echo $presentacion->imagen;?>" alt="<?php echo $presentacion->nombre_producto;?> | <?php echo $presentacion->estado_fisico;?>"/><br />
								<input type="file" name="userfile" size="20"/>
							</td>
						</tr>
						<tr>
							<td align="center" colspan="2"><input type="submit" value="Guardar" /></td>
						</tr>
					</table>
					<?php echo form_close();?>
					<center><a href="<?php echo base_url('admin');?>/tienda/presentacion/consulta">Regresar</a></center>
				<?php
					}
				break;
				case 'PRODUCTO_INFORMACION_INGREDIENTES':
					foreach($consultaUno->result() as $presentacion){
					?>
					<h2>Editar Presentación</h2>
					<?php echo form_open_multipart(current_url());?>
					
					<table align="center" class="modificar">
						<tr>
							<td>Ingredientes:</td>
							<td><textarea name="ingredientes" rows="10" cols="40"><?php repoblar('ingredientes',$presentacion->ingredientes);?></textarea></td>
						</tr>
						<tr>
							<td align="center" colspan="2"><input type="submit" value="Guardar" /></td>
						</tr>
					</table>
					<?php echo form_close();?>
					<center><a href="<?php echo base_url('admin');?>/tienda/presentacion/consulta">Regresar</a></center>
				<?php
					}
				break;
				case 'PRODUCTO_PRECIO':
					foreach($consultaUno->result() as $presentacion){
					?>
					<h2>Editar Presentación</h2>
					<?php echo form_open_multipart(current_url());?>
					
					<table align="center" class="modificar">
						<tr>
							<td>Nombre Producto:</td>
							<td>
									
									<?php 
									foreach($consultaTres->result() as $option){
										if($option->idProducto == $presentacion->Producto_idProducto){
										?>
										<?php echo $option->nombre;?>
									<?php 
										}
									} ?>
								</td>
						</tr>
						<tr>
							<td>Clave:</td>
							<td><?php echo $presentacion->clave;?></td>
						</tr>
						<tr>
							<td>Estado Físico:</td>
							<td><?php echo $presentacion->estado_fisico;?></td>
						</tr>
						<tr>
							<td>Precio Público:</td>
							<?php 
							$arreglo = "[";
							$cont = $consultaDos->num_rows();
							$cont1 = 1; 
							foreach($consultaDos->result() as $tipocliente){
									if($tipocliente->idTipoCliente == 3){
										$par2 = $tipocliente->precio_cliente;
									}
									$arreglo .= "'".$tipocliente->precio_cliente."'";
									if($cont1 < $cont){
										$arreglo .= ",";
										$cont1++;
									}
							 }
							 $arreglo .= "]";
							 ?>
							
							<td><input type="text" value="<?php repoblar('precio',$presentacion->precio_publico);?>" name="precio" size="35" id="precio"/>
								<?php if($presentacion->iva == 'SI'){$checked = "checked";}else{$checked = "";}?>
								<input type="checkbox" value="SI" name="iva[]" <?php echo $checked;//echo set_checkbox('iva[]', 'SI'); ?> />I.V.A.(16%)
							</td>
						</tr>
						<tr>
							<td colspan="2"><input type="button" value="Calcular Precios" onclick="calculaPrecio(document.getElementById('precio').value,<?php echo $arreglo;?>,<?php echo $par2;?>);" /></td>
						</tr>
						<?php foreach($consultaDos->result() as $tipocliente){?>
						<tr>
							<td><?php echo $tipocliente->nombre;?>:</th>
							<td>
								<?php if(!empty($presentacion->precio_publico)){
										if($tipocliente->idTipoCliente == 3){
											$price = ((($presentacion->precio_publico * $tipocliente->precio_cliente)/100));	
										}
											else{
												$price = ($presentacion->precio_publico - (($presentacion->precio_publico * $tipocliente->precio_cliente)/100));
											}
										?>
									<span id="<?php echo $tipocliente->precio_cliente;?>"><?php echo number_format($price,2);?></span>
								<?php } ?>
							</td>
						</tr>
					<?php } ?>
						<tr>
							<td align="center" colspan="2"><input type="submit" value="Guardar" /></td>
						</tr>
					</table>
					<?php echo form_close();?>
					<center><a href="<?php echo base_url('admin');?>/tienda/presentacion/consulta">Regresar</a></center>
				<?php
					}
				break;
				case 'PRODUCTO_VIDEO':
					foreach($consultaUno->result() as $presentacion){
					?>
					<h2>Editar Presentación</h2>
					<?php echo form_open_multipart(current_url());?>
					
					<table align="center" class="modificar">
						<tr>
							<td>Nombre Producto:</td>
							<td>
									
									<?php 
									foreach($consultaTres->result() as $option){
										if($option->idProducto == $presentacion->Producto_idProducto){
										?>
										<?php echo $option->nombre;?>
									<?php 
										}
									} ?>
								</td>
						</tr>
						<tr>
							<td>Clave:</td>
							<td><?php echo $presentacion->clave;?></td>
						</tr>
						<tr>
							<td>Estado Físico:</td>
							<td><?php echo $presentacion->estado_fisico;?></td>
						</tr>
						<tr>
							<td>Vídeo(Link):</td>
							<td><input type="text" value='<?php repoblar('video',$presentacion->video);?>' name="video" size="50"/></td>
						</tr>
						<?php if($idioma){ ?>
						<tr>
							<td>Vídeo(Inglés):</td>
							<td><input type="text" value='<?php repoblar('video_en',$presentacion->video_en);?>' name="video_en" size="50"/></td>
						</tr>
						<?php } ?>s
						<tr>
							<td align="center" colspan="2"><input type="submit" value="Guardar" /></td>
						</tr>
					</table>
					<?php echo form_close();?>
					<center><a href="<?php echo base_url('admin');?>/tienda/presentacion/consulta">Regresar</a></center>
				<?php
					}
				break;
			}
			break;
			case "dos_ver_presentacion":
			switch ($rol){
				default:
				break;
				case "PRODUCTO_INFORMACION_GENERAL":
				case "PRODUCTO_INFORMACION_INGREDIENTES":
				case 'PRODUCTO_VIDEO':
				case 'PRODUCTO_PRECIO':
				case 'ADMINISTRADOR':
					foreach($consultaUno->result() as $presentacion){
					?>
					<h2>Presentación :: <?php echo $presentacion->nombre_producto;?> | <?php echo $presentacion->estado_fisico;?></h2>
					<table align="center" class="consulta">
					<tr>
						<th>Clave:</th>
						<td><?php echo $presentacion->clave;?></td>
					</tr>
					<?php if($idioma){ ?>
					<tr>
						<th>Estado Físico(Inglés):</th>
						<td><?php echo $presentacion->estado_fisico_en;?></td>
					</tr>
					<?php } ?>
					<tr>
						<th>Contenido Neto:</th>
						<td><?php echo $presentacion->contenido_neto;?></td>
					</tr>
					<?php if($idioma){ ?>
					<tr>
						<th>Contenido Neto(Inglés):</th>
						<td><?php echo $presentacion->contenido_neto_en;?></td>
					</tr>
					<?php } ?>
					<tr>
						<th>Grupo:</th>
						<td><?php echo $presentacion->grupo;?></td>
					</tr>
					<tr>
						<th>Ingredientes:</th>
						<td><?php echo nl2br($presentacion->ingredientes);?></td>
					</tr>
					<tr>
						<th>Imágen:</th>
						<td><img src="<?php echo base_url();?>/productos_img/<?php echo $presentacion->imagen;?>" alt="<?php echo $presentacion->nombre_producto;?> | <?php echo $presentacion->estado_fisico;?>" /></td>
					</tr>
					<tr>
						<th>I.V.A.:</th>
						<td><?php if($presentacion->iva == 'SI'){ echo "16%";}else{ echo "N.A.";}?></td>
					</tr>
					<tr>
						<th>Precio Público:</th>
						<td><?php if(!empty($presentacion->precio_publico)) echo number_format($presentacion->precio_publico,2);?></td>
					</tr>
					<?php foreach($consultaDos->result() as $tipocliente){?>
					<tr>
						<th><?php echo $tipocliente->nombre;?>:</th>
						<td>
							<?php if(!empty($presentacion->precio_publico)){
								$price = ($tipocliente->idTipoCliente == 3) ? (($presentacion->precio_publico * $tipocliente->precio_cliente)/100) : ($presentacion->precio_publico - (($presentacion->precio_publico * $tipocliente->precio_cliente)/100));
								echo number_format($price,2);
							}?>
						</td>
					</tr>
					<?php } ?>
					<tr>
						<th>Video:</th>
						<td><?php echo ($presentacion->video);?></td>
					</tr>
					<?php if($idioma){ ?>
					<tr>
						<th>Video(Inglés):</th>
						<td><?php echo $presentacion->video_en;?></td>
					</tr>
					<?php } ?>
					<tr>
						<th>Activo:</th>
						<td><?php echo $presentacion->activo;?></td>
					</tr>
				</table>
				<center>
					<a href="<?php echo base_url('admin');?>//tienda/presentacion/consulta">Regresar</a> | <a href="<?php echo base_url('admin');?>/tienda/presentacion/editar/<?php echo $presentacion->idPresentacion;?>">Editar</a> 
				</center>
				<?php
					}
				break;
			}
			break;
			case "dos_editar_producto":
					foreach($consultaUno->result() as $producto){
				?>
				<?php echo form_open_multipart(current_url());?>
					<h2>Edición de Producto</h2>
					<table align="center" class="modificar">
						<tr>
							<td>Nombre Producto:</td>
							<td><input type="text" value="<?php repoblar('nombre',$producto->nombre);?>" name="nombre" size="50"/></td>
						</tr>
						<tr>
							<td>Información de ingredientes principales:</td>
							<td><textarea name="uso" rows="10" cols="40"><?php repoblar('uso',$producto->uso);?></textarea></td>
						</tr>
						<tr>
							<td>Opinión de Experto:</td>
							<td><textarea name="experto" rows="10" cols="40"><?php repoblar('experto',$producto->experto);?></textarea></td>
						</tr>
						<tr>
							<td>Comentarios al Producto:</td>
							<td><textarea name="testimonio" rows="10" cols="40"><?php repoblar('testimonio',$producto->testimonio);?></textarea></td>
						</tr>
						<?php if($idioma){ ?>
						<tr>
							<td>Información de ingredientes principales(Inglés):</td>
							<td><textarea name="uso_en" rows="10" cols="40"><?php repoblar('uso_en',$producto->uso_en);?></textarea></td>
						</tr>
						<tr>
							<td>Opinión de Experto(Inglés):</td>
							<td><textarea name="experto_en" rows="10" cols="40"><?php repoblar('experto_en',$producto->experto_en);?></textarea></td>
						</tr>
						<?php } ?>
						<tr>
							<td>Subcategoría:</td>
							<td>
								<select name="categoria">
									<option value="0" <?php echo set_select('categoria','0',true);?>> --- </option>
									<?php foreach($consultaDos as $option){
									$optgroup = $option['nombre'];?>
									<optgroup label="<?php echo $optgroup;?>">
									<?php
									foreach($option as $otro){
									if($otro != $optgroup){
											if($otro['value'] == $producto->Subcategoria_idSubcategoria){$selected = "selected";}else{$selected = $producto->Subcategoria_idSubcategoria;}
										?>
										<option value="<?php echo $otro['value'];?>" <?php repoblar('categoria',$selected,true);?>><?php echo $otro['nombre'];?></option>
									<?php }
									}
									}?>
								</select>
							</td>
						</tr>
						<tr>
							<td>Imágen: <div style="font-size: 10px;"><b>(La imágen debe tener un tamaño de 175px por 175px.)</b></div></td>
							<td><img src="<?php echo base_url();?>/productos_img/<?php echo $producto->imagen;?>" alt="<?php echo $producto->nombre;?>" />
								<br /><input type="file" name="userfile" size="20"/></td>
						</tr>
						<tr>
							<td align="center" colspan="2"><input type="submit" value="Guardar" /></td>
						</tr>
					</table>	
				<?php echo form_close();?>
					<center><a href="<?php echo base_url('admin');?>/tienda/producto/consulta">Regresar</a></center>
				<?php 

				} 
				?>
			<?php
			break;
			case "dos_editar_subcategoria":
				foreach($consultaUno->result() as $subcategoria){
				?>
					<h2>Edición de Categorías</h2>
					<?php echo form_open(current_url());?>
					<table align="center" class="modificar">
						<tr>
							<td>Nombre:</td>
							<td><input type="text" value="<?php repoblar('nombre',$subcategoria->nombre);?>" name="nombre" size="50"/></td>
						</tr>
						<?php if($idioma){ ?>
						<tr>
							<td>Nombre en Inglés:</td>
							<td><input type="text" value="<?php repoblar('nombre_en',$subcategoria->nombre_en);?>" name="nombre_en" size="50"/></td>
						</tr>
						<?php } ?>
						<tr>
							<td>Categoría:</td>
							<td>
							<select name="categoria">
								<option value="0" <?php echo set_select('categoria', '0', TRUE); ?>>---</option>
								<?php foreach($consultaDos->result() as $categoriaTipo) {
								if($subcategoria->Categoria_idCategoria == $categoriaTipo->idCategoria){
										$selected = "selected";
										}else{
											$selected = "";
											}
								?>
								<option value="<?php echo $categoriaTipo->idCategoria;?>" <?php echo $selected; ?>><?php echo $categoriaTipo->nombre;?></option>
								<?php } ?>
							</select>
						</tr>
						<tr>
							<td align="center" colspan="2"><input type="submit" value="Guardar" /></td>
						</tr>
					</table>
					<?php echo form_close();?>
					<center><a href="<?php echo base_url('admin');?>//tienda/categoria/consulta">Regresar</a></center>
				<?php
				}
			break;
			case "cliente_ver":?>
				<?php foreach($consultaUno->result() as $cliente_info){ ?>
					<h2>Datos Generales</h2>
					<table width="70%%" align="center" class="consulta">
						<tr>
							<th>Tipo de Cliente:</th>
							<td><?php echo $cliente_info->tipo_cliente;?></td>
							<th>Título o Profesión:</th>
							<td><?php echo $cliente_info->titulo;?></td>
						</tr>
						<tr>
							<th>Nombre:</th>
							<td><?php echo $cliente_info->nombre;?></td>
							<th>Apellidos:</th>
							<td><?php echo $cliente_info->apellido;?></td>
						</tr>
						<tr>
							<th>Fecha de Nacimiento:</th>
							<td><?php echo $cliente_info->fecha_nacimiento;?></td>
							<th>Sitio Web:</th>
							<td><?php echo $cliente_info->sitio_web;?></td>
						</tr>
						<tr>
							<th>Email:</th>
							<td><?php echo $cliente_info->correo;?></td>
							<th>Otro Email:</th>
							<td><?php echo $cliente_info->correo_otro;?></td>
						</tr>
						<tr>
							<th>Teléfono:</th>
							<td><?php echo $cliente_info->telefono;?></td>
							<th>Teléfono Celular:</th>
							<td><?php echo $cliente_info->telefono_celular;?></td>
						</tr>
						<tr>
							<th>Calle:</th>
							<td><?php echo $cliente_info->calle;?></td>
							<th>Número Exterior:</th>
							<td><?php echo $cliente_info->numero_exterior;?></td>
						</tr>
						<tr>
							<th>Número Interior:</th>
							<td><?php echo $cliente_info->numero_interior;?></td>
							<th>Colonia:</th>
							<td><?php echo $cliente_info->colonia;?></td>
						</tr>
						<tr>
							<th>Delegación::</th>
							<td><?php echo $cliente_info->delegacion;?></td>
							<th>Código Postal:</th>
							<td><?php echo $cliente_info->codigo_postal;?></td>
						</tr>
						<tr>
							<th>Ciudad:</th>
							<td><?php echo $cliente_info->ciudad;?></td>
							<th>Estado:</th>
							<td><?php echo $cliente_info->estado;?></td>
						</tr>
						<tr>
							<th colspan="2">País:</th>
							
							<td colspan="2"><?php echo $cliente_info->pais;?></td>
							
						</tr>
					</table>
				<?php } ?>
				<?php foreach($consultaDos->result() as $cliente_info){ ?>
					<h2>Datos Empresa</h2>
					<table width="70%%" align="center" class="consulta">
						<tr>
							<th>Razón Social:</th>
							<td><?php echo $cliente_info->razon_social;?></td>
							<th>Cargo:</th>
							<td><?php echo $cliente_info->cargo;?></td>
						</tr>
						<tr>
							<th>Teléfono:</th>
							<td><?php echo $cliente_info->telefono;?></td>
							<th>Fax:</th>
							<td><?php echo $cliente_info->fax;?></td>
						</tr>
						<tr>
							<th>Teléfono Celular:</th>
							<td><?php echo $cliente_info->telefono_celular;?></td>
							<th>Email(s):</th>
							<td><?php echo $cliente_info->correo;?><br /><?php echo $cliente_info->correo_otro;?></td>
							
						</tr>
						<tr>
							<th>Calle:</th>
							<td><?php echo $cliente_info->calle;?></td>
							<th>Número Exterior:</th>
							<td><?php echo $cliente_info->numero_exterior;?></td>
						</tr>
						<tr>
							<th>Número Interior:</th>
							<td><?php echo $cliente_info->numero_interior;?></td>
							<th>Colonia:</th>
							<td><?php echo $cliente_info->colonia;?></td>
						</tr>
						<tr>
							<th>Delegación::</th>
							<td><?php echo $cliente_info->delegacion;?></td>
							<th>Código Postal:</th>
							<td><?php echo $cliente_info->codigo_postal;?></td>
						</tr>
						<tr>
							<th>Ciudad:</th>
							<td><?php echo $cliente_info->ciudad;?></td>
							<th>Estado:</th>
							<td><?php echo $cliente_info->estado;?></td>
						</tr>
						<tr>
							<th colspan="2">País:</th>
							
							<td colspan="2"><?php echo $cliente_info->pais;?></td>
							
						</tr>
					</table>
				<?php } ?>
				<center>
				<a href="<?php echo base_url('admin');?>//tienda/cliente/consulta">Regresar</a> | <a href="<?php echo base_url('admin');?>/tienda/cliente/editar_general/<?php echo $consultaTres;?>">Editar</a> 
				</center>
			<?php
			break;
			case "cliente_edicion_general":?>
            	<h2>Captura de Clientes || Datos Generales</h2>
                <?php echo form_open(current_url());?>
					<?php foreach($consultaUno->result() as $cliente_info){?>
                    <table width="70%%" align="center" class="modificar">
						<tbody>
						<tr>
							<th colspan="4"><br></th>
						</tr>
						<tr>
							<td colspan="4"><b>(*) Campos obligatorios</b><br></td> 
						</tr>
						<tr>
							<td width="25%" valign="top"><b>* Tipo Cliente </b></td>
							<td width="25%">
								<select id="claveletra" name="claveletra">
									<?php foreach($consultaDos->result() as $tipoCliente){ 
									if($tipoCliente->idTipoCliente == $cliente_info->TipoCliente_idTipoCliente){
										$selected = "selected";
										}else{
											$selected = "";
											}
									?>
									<option value="<?php echo $tipoCliente->idTipoCliente;?>" <?php echo $selected;?>><?php echo $tipoCliente->nombre;?></option>
									<?php } ?>
								</select> 
							</td>
							<td width="20%" valign="top"><b>Título o profesión:</b></td>
							<td width="20%" valign="top">
								<input type="text" value="<?php echo $cliente_info->titulo;?>" name="titulo">
							</td>
						</tr>
						<tr>
							<td width="20%" valign="top"><b>* Nombre </b></td>
							<td width="20%" valign="top">
								<input type="text" value="<?php echo $cliente_info->nombre;?>" name="nombres"> 
							</td>	
							<td width="20%" valign="top"><b>* Apellidos </b></td>
							<td width="20%" valign="top">
								<input type="text" value="<?php echo $cliente_info->apellido;?>" name="apellidos">
							</td>
						</tr>
						<tr>
							<td width="20%" valign="top"><b>Cumpleaños</b></td>
							<td width="20%" valign="top">
                            	<?php $pieces = explode(' ',$cliente_info->fecha_nacimiento);
										$mes = $pieces[2];
										$dia = $pieces[0];
								?>
								<b>Mes</b> <?php construyeSelect($seccion,'mes','meses',$mes);?>
							</td>
							<td>
								<b>Día</b> <?php construyeSelect($seccion,'dia','dias',$dia); ?>
							</td>
							<td></td>
						</tr>
						<tr>
							<td width="20%" valign="top"><b>Email personal</b></td>
							<td width="20%" valign="top">
								<input type="text" value="<?php echo $cliente_info->correo;?>" name="email"> 
							</td>
							<td width="20%" valign="top"><b>Otro email personal</b></td>
							<td width="20%" valign="top">
								<input type="text" value="<?php echo $cliente_info->correo_otro;?>" name="otroemail"> 
							</td>
						</tr>	
						<tr>
							<td width="20%" valign="top"><b>Teléfono casa</b></td>
							<td width="20%" valign="top" colspan="3">
								<table width="98%" align="center">	
									<tbody>
									<tr>
										<td width="20%" valign="top">Código país</td>
										<td width="20%" valign="top">Área/Lada</td>
										<td width="20%" valign="top">Teléfono</td>
										<td width="20%" valign="top">Extensión</td>
									</tr>
									<tr>
                                    	<?php $pieces_phone = explode(' ',$cliente_info->telefono);
										$codigo_temp = explode('+',$pieces_phone[0]);
										if($codigo_temp[1] != "none"){$codigo = $codigo_temp[1];}else{$codigo = "";}
										if($pieces_phone[1] != "none"){$area = $pieces_phone[1];}else{$area = "";}
										if($pieces_phone[2] != "none"){$telefono = $pieces_phone[2];}else{$telefono = "";}
										$ext_temp = explode(':',$pieces_phone[3]);
										if($ext_temp[1] != "none"){$ext = $ext_temp[1];}else{$ext = "";}
										?>
                                        <td width="20%">
											+ <input type="text" maxlength="7" size="4" value="<?php echo $codigo;?>" name="codigopais"> 
										</td>
										<td width="20%">
											<input type="text" maxlength="5" size="4" value="<?php echo $area;?>" name="area"> 
										</td>
										<td width="20%">
											<input type="text" maxlength="15" size="14" value="<?php echo $telefono;?>" name="telefono"> 
										</td>
										<td width="20%">
											<input type="text" size="10" value="<?php echo $ext;?>" name="ext"> 
										</td>
									</tr>
									</tbody>
								</table>				
							</td>
						</tr>
						<tr>
							<td width="20%" valign="top"><b>Teléfono móvil personal</b></td>
							<td width="20%" valign="top" colspan="3">
								<table width="98%" align="left">
									<tbody>
									<tr>
										<td width="20%" valign="top">Código país</td>
										<td width="20%" valign="top">Área/Lada</td>
										<td width="20%" valign="top">Teléfono</td>						
										<td width="20%" valign="top">&nbsp;</td>						
									</tr>
									<tr>
	                                    <?php $pieces_cellphone = explode(' ',$cliente_info->telefono_celular);
										$codigo_temp = explode('+',$pieces_cellphone[0]);
										if($codigo_temp[1] != "none"){$codigomovil = $codigo_temp[1];}else{$codigomovil = "";}
										if($pieces_cellphone[1] != "none"){$areamovil = $pieces_cellphone[1];}else{$areamovil = "";}
										if($pieces_cellphone[2] != "none"){$telefonomovil = $pieces_cellphone[2];}else{$telefonomovil = "";}
										?>
										<td>
											+ <input type="text" maxlength="7" size="4" value="<?php echo $codigomovil;?>" name="codigopaismovil"> 
										</td>
										<td>
											<input type="text" maxlength="5" size="4" value="<?php echo $areamovil;?>" name="areamovil"> 
										</td>
										<td>
											<input type="text" maxlength="15" size="14" value="<?php echo $telefonomovil;?>" name="telefonomovil"> 
										</td>
										<td></td>
									</tr>
									</tbody>
								</table>					
							</td>						
						</tr>
                        <?php foreach($consultaTres->result() as $cliente_direccion){?>
						<tr>
							<td width="20%" valign="top"><b>Calle</b></td>
							<td width="20%" valign="top">
								<input type="text" value="<?php echo $cliente_direccion->calle;?>" name="calle"> 
							</td>
							<td width="20%" valign="top"><b>Num. Ext.</b></td>
							<td width="20%" valign="top">
								<input type="text" value="<?php echo $cliente_direccion->numero_exterior;?>" name="numext"> 
							</td>
						</tr>
						<tr>
							<td width="20%" valign="top"><b>Num. Int.</b></td>
							<td width="20%" valign="top">
								<input type="text" value="<?php echo $cliente_direccion->numero_interior;?>" name="numint"> 
							</td>			
							<td width="20%" valign="top"><b>Colonia</b></td>
							<td width="20%" valign="top">
								<input type="text" value="<?php echo $cliente_direccion->colonia;?>" name="colonia"> 
							</td>
						</tr>
						<tr>
							<td width="20%" valign="top"><b>Delegación o municipio</b></td>
							<td width="20%" valign="top">
								<input type="text" value="<?php echo $cliente_direccion->delegacion;?>" name="delegacion"> 
							</td>
							<td width="20%" valign="top"><b>Código postal</b></td>
							<td width="20%" valign="top">
								<input type="text" value="<?php echo $cliente_direccion->codigo_postal;?>" name="codigo"> 
							</td>
						</tr>
						<tr>
							<td width="20%" valign="top"><b>Ciudad</b></td>
							<td width="20%" valign="top">
								<input type="text" value="<?php echo $cliente_direccion->ciudad;?>" name="ciudad"> 
							</td>
							<td width="20%" valign="top"><b>Estado</b></td>
							<td width="20%" valign="top">
								<?php construyeSelect($seccion,'estado','estados',$cliente_direccion->estado); ?>
							</td>
						</tr>
						<tr>
							<td width="20%" valign="top"><b>País</b></td>
							<td width="20%" valign="top">
								<!-- <input type="text" name="pais" value="México" />  -->
								<?php construyeSelect($seccion,'pais','paises',$cliente_direccion->pais); ?>			
							</td>
                         <?php } ?>
							<td width="20%" valign="top"><b>Sitio web</b></td>
							<td width="20%" valign="top">
								<input type="text" value="<?php echo $cliente_info->sitio_web;?>" name="web"> 
							</td>
						</tr>
						<tr>
							<td width="20%" valign="top"></td>
							<td width="20%" valign="top" align="right">
								<input type="button" value="Borrar" onClick="window.location.href=window.location.href"/> 
							</td>
							<td width="20%" valign="top" align="left">
								<input type="submit" value="Siguiente" name="siguiente"> 
								<input type="hidden" value="alta1" name="formhid">
							</td>
							<td width="20%" valign="top"></td>
						</tr>
						</tbody>
					</table>
                    <?php } ?>
					<?php echo form_close();?>
                <center>
                <a href="<?php echo base_url('admin');?>//tienda/cliente/consulta">Regresar a Consultas</a>
                </center>
			<?php
			break;
			case "cliente_edicion_empresa":?>
            	<h2>Captura de Clientes || Datos de Empresa</h2>
				<?php echo form_open(current_url());?>
					<?php foreach($consultaDos->result() as $cliente_info){?>
					<input type="hidden" value="<?php echo $cliente_info->idEmpresa;?>" name="id" />
				<table align="center" width="70%" class="modificar">
				<tbody>
				<tr>
							<th colspan="4"><br></th>
				</tr>
				<tr>
					<td colspan="4"><b>(*) Campos obligatorios.</b><br></td> 
				</tr>		
				<tr>
					<td valign="top" width="20%"><b>* Razón Social o Nombre comercial</b></td>
					<td width="20%">
						<input name="empresa" value="<?php repoblar('empresa',$cliente_info->razon_social);?>" type="text"> 
					</td>	
					<td valign="top" width="20%"><b>Cargo o puesto que ocupa</b></td>
					<td valign="top" width="20%">
						<input name="cargo" value="<?php repoblar('cargo',$cliente_info->cargo);?>" type="text"> 
					</td>
				</tr>
				<tr>
					<td valign="top" width="20%"><b>* Email del trabajo</b></td>
					<td valign="top" width="20%">
						<input name="emailt" value="<?php repoblar('emailt',$cliente_info->correo);?>" type="text"> 
					</td>	
					<td valign="top" width="20%"><b>Otro email del trabajo</b></td>
					<td valign="top" width="20%">
						<input name="oemailt" value="<?php repoblar('oemailt',$cliente_info->correo_otro);?>" type="text"> 
					</td>
				</tr>
				<tr>
					<td valign="top" width="20%"><b>Teléfono del trabajo</b></td>
					<td colspan="3" valign="top" width="80%">
						<table align="center" width="98%">	
						<tbody>
							<tr>
								<td valign="top" width="20%">* Código país</td>
								<td valign="top" width="20%">* Área/Lada</td>
								<td valign="top" width="20%">* Teléfono</td>
								<td valign="top" width="20%">Extensión</td>
							</tr>
							<tr>
							<?php $pieces_phone = explode(' ',$cliente_info->telefono);
										$codigo_temp = explode('+',$pieces_phone[0]);
										if($codigo_temp[1] != "none"){$codigo = $codigo_temp[1];}else{$codigo = "";}
										if($pieces_phone[1] != "none"){$area = $pieces_phone[1];}else{$area = "";}
										if($pieces_phone[2] != "none"){$telefono = $pieces_phone[2];}else{$telefono = "";}
										$ext_temp = explode(':',$pieces_phone[3]);
										if($ext_temp[1] != "none"){$ext = $ext_temp[1];}else{$ext = "";}
										?>
								<td width="20%">
									+ <input name="codigopaistf" value="<?php echo repoblar('codigopaistf',$codigo);?>" size="4" maxlength="7" type="text">  
								</td>
								<td width="20%">
									<input name="areatf" value="<?php echo repoblar('areatf',$area);?>" size="4" maxlength="5" type="text"> 
								</td>
								<td width="20%">
									<input name="telof" value="<?php echo repoblar('telof',$telefono);?>" size="14" maxlength="15" type="text"> 							
								</td>
								<td width="20%">
									<input name="exttf" value="<?php echo repoblar('exttf',$ext);?>" size="10" type="text"> 
								</td>
							</tr>
						</tbody>
						</table>				
					</td>				
				</tr>
				<tr>
					<td valign="top" width="20%"><b>Teléfono Móvil del trabajo</b></td>
					<td colspan="3" valign="top" width="80%">				
						<table align="left" width="98%">	
						<tbody>
							<tr>
								<td valign="top" width="20%">Código país</td>
								<td valign="top" width="20%">Área/Lada</td>
								<td valign="top" width="20%">Teléfono</td>
								<td valign="top" width="20%">&nbsp;</td>
							</tr>
							<tr>
							<?php $pieces_cellphone = explode(' ',$cliente_info->telefono_celular);
										$codigo_temp = explode('+',$pieces_cellphone[0]);
										if($codigo_temp[1] != "none"){$codigomovil = $codigo_temp[1];}else{$codigomovil = "";}
										if($pieces_cellphone[1] != "none"){$areamovil = $pieces_cellphone[1];}else{$areamovil = "";}
										if($pieces_cellphone[2] != "none"){$telefonomovil = $pieces_cellphone[2];}else{$telefonomovil = "";}
										?>
								<td width="20%">
									+ <input name="codigopaistm" value="<?php repoblar('codigopaistm',$codigomovil);?>" size="4" maxlength="7" type="text"> 
								</td>
								<td width="20%">
									<input name="areatm" value="<?php repoblar('areatm',$areamovil);?>" size="4" maxlength="5" type="text"> 
								</td>
								<td width="20%">
									<input name="telmof" value="<?php repoblar('telmof',$telefonomovil);?>" size="14" maxlength="15" type="text"> 
								</td>
								<td width="20%"></td>
							</tr>
						</tbody>
						</table>	
					</td>
				</tr>
				<tr>
					<td valign="top" width="20%"><b>Fax</b></td>
					<td valign="top" width="20%">
						<input name="fax" value="<?php repoblar('fax',$cliente_info->fax);?>" type="text"> 
					</td>
					<?php foreach($consultaTres->result() as $direccion_empresa){ ?>
					<td valign="top" width="20%"><b>*Calle</b></td>
					<td valign="top" width="20%">
						<input name="calle" value="<?php repoblar('calle',$direccion_empresa->calle);?>" type="text"> 
					</td>
				</tr>	
				<tr>				
					<td valign="top" width="20%"><b>* Num. Ext.</b></td>
					<td valign="top" width="20%">
						<input name="numext" value="<?php repoblar('numext',$direccion_empresa->numero_exterior);?>" type="text"> 
					</td>
					<td valign="top" width="20%"><b>* Num. Int. </b></td>
					<td valign="top" width="20%">
						<input name="numint" value="<?php repoblar('numint',$direccion_empresa->numero_interior);?>" type="text"> 
					</td>
				</tr>	
				<tr>
					<td valign="top" width="20%"><b>* Colonia</b></td>
					<td valign="top" width="20%">
						<input name="colonia" value="<?php repoblar('colonia',$direccion_empresa->colonia);?>" type="text"> 
					</td>	
					<td valign="top" width="20%"><b>* Delegación o municipio</b></td>
					<td valign="top" width="20%">
						<input name="delegacion" value="<?php repoblar('delegacion',$direccion_empresa->delegacion);?>" type="text"> 
					</td>
				</tr>	
				<tr>
					<td valign="top" width="20%"><b>* Código postal</b></td>
					<td valign="top" width="20%">
						<input name="codigo" value="<?php repoblar('codigo',$direccion_empresa->codigo_postal);?>" type="text"> 
					</td>	
					<td valign="top" width="20%"><b>* Ciudad</b></td>
					<td valign="top" width="20%">
						<input name="ciudad" value="<?php repoblar('ciudad',$direccion_empresa->ciudad);?>" type="text"> 
					</td>
				</tr>	
					<tr>
						<td valign="top" width="20%"><b>* Estado</b></td>
						<td valign="top" width="20%">
							<?php construyeSelect($seccion,'estado','estados',$direccion_empresa->estado); ?>
						</td>	
						<td valign="top" width="20%"><b>* Pais</b></td>
						<td valign="top" width="20%">
							<!-- <input type="text" name="paist" value="" /> * -->
							<?php construyeSelect($seccion,'pais','paises',$direccion_empresa->pais); ?>
							</td>
					</tr>	
					<?php } ?>
					<tr>
						<td valign="top" width="20%"><b>Sitio Web</b></td>
						<td valign="top" width="20%">
							<input name="webt" value="<?php repoblar('webt',$cliente_info->sitio_web);?>" type="text"> 
						</td>	
						<td valign="top" width="20%"></td>
						<td valign="top" width="20%"></td>
						</tr>			
						<tr>
							<td width="20%" valign="top"></td>
							<td width="20%" valign="top" align="right">
								<?php foreach($consultaUno->result() as $cliente_info1){?>
								<input type="button" value="Anterior" onClick="window.location.href='<?php echo base_url('admin');?>/tienda/cliente/editar_general/<?php echo $cliente_info1->idCliente;?>'"/> 
								<?php } ?>
							</td>
							<td width="20%" valign="top" align="left">
								<input type="submit" value="Siguiente" name="siguiente"> 
								<input type="hidden" value="alta1" name="formhid">
							</td>
							
							<td width="20%" valign="top"></td>
						</tr>
					</tbody>
				</table>
				<?php } 
				echo form_close(); ?>
				<center>
				<a href="<?php echo base_url('admin');?>//tienda/cliente/consulta">Regresar a Consultas</a>
				</center>
			<?php
			break;
			case "cliente_edicion_notas":?>
            	<h2>Captura de Clientes || Notas</h2>
				<?php echo form_open(current_url());?>
					<?php foreach($consultaUno->result() as $cliente_info){?>
						<table align="center" width="40%" class="modificar">
							<tr>
								<td  colspan="2" width="100%" align="center">
									<textarea name="nota" rows="10" cols="40"><?php repoblar('nota',$cliente_info->nota); ?></textarea>
								</td>
							</tr>
							<tr>
								<td width="50%" valign="top" align="right">
									<input type="button" value="Anterior" onClick="window.location.href='<?php echo base_url('admin');?>/tienda/cliente/editar_empresa/<?php echo $cliente_info->idCliente;?>'"/> 
								</td>
								<td width="50%" valign="top" align="left">
									<input type="submit" value="Siguiente" name="siguiente"> 
									<input type="hidden" value="alta1" name="formhid">
								</td>
							</tr>
						</table>
					<?php }
					echo form_close();?>
                <center>
                <a href="<?php echo base_url('admin');?>//tienda/cliente/consulta">Regresar a Consultas</a>
                </center>
			<?php
			break;
			case "cliente_edicion_password":?>
            	<h2>Captura de Clientes || Generar Contraseña</h2>
                <?php echo form_open(current_url());?>
					<?php foreach($consultaUno->result() as $cliente_info){?>
						<table align="center" width="40%" class="modificar">
							<tr>
								<td>Generar Contraseña:</td>
								<td><input type="password" name ="contrasena" value="<?php repoblar('contrasena',''); ?>" /></td>
							</tr>
							<tr>
								<td>Confirmar Contraseña:</td>
								<td><input type="password" name ="contrasena1" value="<?php repoblar('contrasena1',''); ?>" /></td>
							</tr>
							<tr>
								<td width="50%" valign="top" align="right">
									<input type="button" value="Anterior" onClick="window.location.href='<?php echo base_url('admin');?>/tienda/cliente/editar_nota/<?php echo $cliente_info->idCliente;?>'"/> 
								</td>
								<td width="50%" valign="top" align="left">
									<input type="submit" value="Guardar" name="siguiente"> 
									<input type="hidden" value="alta1" name="formhid">
								</td>
							</tr>
						</table>
					<?php }
					echo form_close();?>
				<center>
                <a href="<?php echo base_url('admin');?>//tienda/cliente/consulta">Regresar a Consultas</a>
                </center>
			<?php
			break;
		}
}

function securityNumber($correo){
	$pieces = explode('@',$correo);
	$texto = str_shuffle(strtoupper($pieces[0]));
	$first = $texto[0]."".$texto[1];
	$second = rand(1000,9999);
	$number = $first."".$second;
	return $number;
}

function checkWord($palabra,$accion){
	$pieces = explode('_',$palabra);
	if($pieces[0] == $accion){
		return true;
	}else{
		return false;
	}
}

function construyeSelect($form,$select,$id,$selected = '0',$consulta = "none",$idioma = false){
	switch ($form){
	case "cliente_edicion_empresa":
	case "cliente_edicion_general":
	case "alta_cliente_general":
		switch($select){
			default:
			break;
			case "pais":
				$arrayPaises = array('Afganistán' , 'Albania' , 'Alemania' , 'Andorra', 'Angola', 'Anguila', 'Antártica',
				'Antigua y Barbuda' , 'Antillas Holandesas' , 'Arabia Saudí' , 'Argelia' , 'Argentina' , 
				'Armenia' , 'Aruba' , 'Australia' , 'Austria' , 'Azerbaiyán' , 'Bahamas' , 'Bahrein' , 
				'Bangladesh' , 'Barbados' , 'Bélgica' , 'Belice' , 'Benín' , 'Bermudas' , 'Bielorrusia' , 
				'Bolivia' , 'Botswana' , 'Bosnia y Herzegovina' , 'Brasil' , 'Brunei' , 'Bulgaria' , 'BurkinaFaso', 
				'Burundi' , 'Bután' , 'Cabo Verde' , 'Camboya' , 'Camerún' , 'Canadá' , 'Chad' , 'Chile' , 
				'China' , 'Chipre' , 'Colombia' , 'Comoras' , 'Congo' , 'Corea del Norte' , 'Corea del Sur' , 
				'Costa de Marfil' , 'Costa Rica' , 'Croacia' , 'Cuba' , 'Dinamarca' , 'Dominica' , 'Dubai' , 
				'Ecuador' , 'Egipto' , 'El Salvador' , 'Emiratos Árabes Unidos' , 'Eritrea' , 'Eslovaquia' , 
				'Eslovenia' , 'España' , 'Estados Unidos de América' , 'Estonia' , 'Etiopía' , 'Fiyi' , 
				'Filipinas' , 'Finlandia' , 'Francia' , 'Gabón' , 'Gambia' , 'Georgia' , 'Ghana' , 'Grecia' , 
				'Guam' , 'Guatemala' , 'Guayana Francesa' , 'Guinea-Bissau' , 'Guinea Ecuatorial' , 'Guinea' , 
				'Guyana' , 'Granada' , 'Haití' , 'Honduras' , 'HongKong' , 'Hungría' , 'Holanda' , 'India' , 
				'Indonesia' , 'Irak' , 'Irán' , 'Irlanda' , 'Islandia' , 'Islas Caimán' , 'Islas Marshall' , 
				'Islas Pitcairn' , 'Islas Salomón' , 'Israel' , 'Italia' , 'Jamaica' , 'Japón' , 'Jordania' , 
				'Kazajstán' , 'Kenia' , 'Kirguistán' , 'Kiribati' , 'Kósovo' , 'Kuwait' , 'Laos' , 'Lesotho' , 
				'Letonia' , 'Líbano' , 'Liberia' , 'Libia' , 'Liechtenstein' , 'Lituania' , 'Luxemburgo' , 
				'Macedonia' , 'Madagascar' , 'Malasia' , 'Malawi' , 'Maldivas' , 'Malí' , 'Malta' , 
				'Marianas del Norte' , 'Marruecos' , 'Mauricio' , 'Mauritania' , 'México' , 'Micronesia' , 
				'Mónaco' , 'Moldavia' , 'Mongolia' , 'Montenegro' , 'Mozambique' , 'Myanmar' , 'Namibia' , 
				'Nauru' , 'Nepal' , 'Nicaragua' , 'Níger' , 'Nigeria' , 'Noruega' , 'NuevaZelanda' , 'Omán' , 
				'OrdendeMalta' , 'Países Bajos' , 'Pakistán' , 'Palestina' , 'Palau' , 'Panamá' , 
				'Papúa Nueva Guinea' , 'Paraguay' , 'Perú' , 'Polonia' , 'Portugal' , 'Puerto Rico' , 'Qatar' , 
				'Reino Unido' , 'República Centro africana' , 'República Checa' , 'República del Congo' , 
				'República Democrática del Congo' , 'República Dominicana' , 'Ruanda' , 'Rumania' , 'Rusia' , 
				'Sáhara Occidental' , 'SaintKitts-Nevis' , 'Samoa Americana' , 'Samoa' , 'San Marino' , 
				'Santa Lucía' , 'Santo Tomé y Príncipe' , 'San Vicente y las Granadinas' , 'Senegal' , 
				'Serbia' , 'Seychelles' , 'SierraLeona' , 'Singapur' , 'Siria' , 'Somalia' , 'SriLanka' , 
				'Sudáfrica' , 'Sudán' , 'Suecia' , 'Suiza' , 'Suazilandia' , 'Tailandia' , 'Taiwán' , 
				'Tanzania' , 'Tayikistán' , 'Tíbet' , 'TimorOriental' , 'Togo' , 'Tonga' , 'Trinidad y Tobago' , 
				'Túnez' , 'Turkmenistán' , 'Turquía' , 'Tuvalu' , 'Ucrania' , 'Uganda' , 'Uruguay' , 'Uzbequistán' , 
				'Vanuatu' , 'Vaticano' , 'Venezuela' , 'Vietnam' , 'WallisyFutuna' , 'Yemen' , 'Yibuti' , 
				'Zambia' , 'Zaire' , 'Zimbabue');?>
				<select id="<?php echo $id;?>" name="<?php echo $id;?>" >
				<option value="none" <?php echo set_select($id, '0', TRUE); ?>> --- </option>
				<?php
				foreach($arrayPaises as $pais){
					if($selected == $pais){$default = "selected";}else{$default = "";}
					?>
					<option value="<?php echo $pais;?>" <?php echo set_select($id, $pais); ?><?php echo $default;?>><?php echo $pais;?></option>
				<?php }
				?>
				</select>
				<?php
			break;
			case "mes":
				$arrayMeses = array('Enero' , 'Febrero' , 'Marzo' , 'Abril', 'Mayo', 'Junio', 'Julio',
				'Agosto' , 'Septiembre' , 'Octubre' , 'Noviembre' , 'Diciembre');?>
				<select id="<?php echo $id;?>" name="<?php echo $id;?>" >
				<option value="none" <?php echo set_select($id, '0', TRUE); ?>> --- </option>
				<?php
				foreach($arrayMeses as $mes){
					if($selected == $mes){$default = "selected";}else{$default = "";}?>
					<option value="<?php echo $mes;?>" <?php echo set_select($id, $mes); ?> <?php echo $default;?>><?php echo $mes;?></option>
				<?php }
				?>
				</select>
				<?php
			break;
			case "estado":
				$mxEstados = array(         
				array('id' => 'MEX-AGS','value' => 'AGS', 'label' => 'Aguascalientes'),
				array('id' => 'MEX-BCN','value' => 'BCN', 'label' => 'Baja California Norte'),
				array('id' => 'MEX-BCS','value' => 'BCS', 'label' => 'Baja California Sur'),
				array('id' => 'MEX-CAM','value' => 'CAM', 'label' => 'Campeche'),
				array('id' => 'MEX-CHIS','value' => 'CHIS', 'label' => 'Chiapas'),
				array('id' => 'MEX-CHIH','value' => 'CHIH', 'label' => 'Chihuahua'),
				array('id' => 'MEX-COAH','value' => 'COAH', 'label' => 'Coahuila'),
				array('id' => 'MEX-COL','value' => 'COL', 'label' => 'Colima'),
				array('id' => 'MEX-DF','value' => 'DF', 'label' => 'Distrito Federal'),
				array('id' => 'MEX-DGO','value' => 'DGO', 'label' => 'Durango'),
				array('id' => 'MEX-GTO','value' => 'GTO', 'label' => 'Guanajuato'),
				array('id' => 'MEX-GRO','value' => 'GRO', 'label' => 'Guerrero'),
				array('id' => 'MEX-HGO','value' => 'HGO', 'label' => 'Hidalgo'),
				array('id' => 'MEX-JAL','value' => 'JAL', 'label' => 'Jalisco'),
				array('id' => 'MEX-EDM','value' => 'EDM', 'label' => 'Estado de México'),
				array('id' => 'MEX-MICH','value' => 'MICH', 'label' => 'Michoacán'),
				array('id' => 'MEX-MOR','value' => 'MOR', 'label' => 'Morelos'),
				array('id' => 'MEX-NAY','value' => 'NAY', 'label' => 'Nayarit'),
				array('id' => 'MEX-NL','value' => 'NL', 'label' => 'Nuevo León'),
				array('id' => 'MEX-OAX','value' => 'OAX', 'label' => 'Oaxaca'),
				array('id' => 'MEX-PUE','value' => 'PUE', 'label' => 'Puebla'),
				array('id' => 'MEX-QRO','value' => 'QRO', 'label' => 'Querétaro'),
				array('id' => 'MEX-QROO','value' => 'QROO', 'label' => 'Quintana Roo'),
				array('id' => 'MEX-SLP','value' => 'SLP', 'label' => 'San Luis Potosí'),
				array('id' => 'MEX-SIN','value' => 'SIN', 'label' => 'Sinaloa'),
				array('id' => 'MEX-SON','value' => 'SON', 'label' => 'Sonora'),
				array('id' => 'MEX-TAB','value' => 'TAB', 'label' => 'Tabasco'),
				array('id' => 'MEX-TAMPS','value' => 'TAMPS', 'label' => 'Tamaulipas'),
				array('id' => 'MEX-TLAX','value' => 'TLAX', 'label' => 'Tlaxcala'),
				array('id' => 'MEX-VER','value' => 'VER', 'label' => 'Veracruz'),
				array('id' => 'MEX-YUC','value' => 'YUC', 'label' => 'Yucatán'),
				array('id' => 'MEX-ZAC','value' => 'ZAC', 'label' => 'Zacatecas'));?>
				<select id="<?php echo $id;?>" name="<?php echo $id;?>" >
				<option value="none" <?php echo set_select($id, '0', TRUE); ?>> --- </option>
				<?php
				foreach($mxEstados as $estado){
					if($selected == $estado['value']){$default = "selected";}else{$default = "";}?>
					<option value="<?php echo $estado['value'];?>" <?php echo set_select($id, $estado['value']); ?> <?php echo $default;?>><?php echo $estado['label'];?></option>
				<?php }
				?>
				</select>
				<?php
			break;
			case "dia":
				$contdia = 1;?>
				<select id="<?php echo $id;?>" name="<?php echo $id;?>" >
				<option value="none" <?php echo set_select($id, '0', TRUE); ?>> --- </option>
				<?php
				for($i = $contdia; $i<= 31; $i++){
					if($selected == $i){$default = "selected";}else{$default = "";}?>
					<option value="<?php echo $i;?>" <?php echo set_select($id, $i); ?> <?php echo $default;?>><?php echo $i;?></option>
				<?php  }
				?>
				</select>
				<?php
			break;
		}
	break;
	
	default:
	break;
	}
	
	
	
	
}

function repoblar($campo,$valor,$select=false,$checkbox = false)
	{
		if(empty($_POST["$campo"])){
			
			echo $valor;
			
			
		}else{
			if($select){
				echo set_select("$campo",$valor);
			}elseif($checkbox){
				echo set_checkbox("$campo",$valor);
			}else{
				echo set_value("$campo");
			}
			
		}
}

function presentacionCompleta($presentacion,$rol){
	switch($rol){
		default:
			return false;
		break;
		case 'ADMINISTRADOR':
			if(empty($presentacion->clave) || empty($presentacion->estado_fisico) || empty($presentacion->contenido_neto) || empty($presentacion->grupo) || empty($presentacion->ingredientes) || empty($presentacion->imagen) || empty($presentacion->iva) || empty($presentacion->precio_publico) || empty($presentacion->video)){
				return false;
			}else{
				return true;
			}
		break;
		case 'PRODUCTO_INFORMACION_GENERAL':
			if(empty($presentacion->clave) || empty($presentacion->estado_fisico) || empty($presentacion->contenido_neto) || empty($presentacion->grupo) || empty($presentacion->imagen)){
				return false;
			}else{
				return true;
			}
		break;
		case 'PRODUCTO_INFORMACION_INGREDIENTES':
			if(empty($presentacion->ingredientes)){
				return false;
			}else{
				return true;
			}
		break;
		case 'PRODUCTO_VIDEO':
			if(empty($presentacion->video)){
				return false;
			}else{
				return true;
			}
		break;
		case 'PRODUCTO_PRECIO':
			if(empty($presentacion->iva) || empty($presentacion->precio_publico) ){
				return false;
			}else{
				return true;
			}
		break;
	}
	
}

function pedidoFormulario($estado,$pedido,$nombre,$rol,$consulta='',$consultaDos=''){

	switch($estado){
		case 1:
			if($rol == 'ADMINISTRADOR' || $rol == 'PEDIDOS_CATALOGO'){
				?>
			<div style="clear:both;"></div>
			<h2><?php echo $nombre;?> <?php echo $pedido;?> </h2>
			<?php echo form_open(current_url());?>
			<table align="center" class="modificar">
				<tr>
					<td>Persona que recibe:</td>
					<td><input type="text" name="persona_uno" size="50" value="<?php echo set_value('persona_uno');?>" /></td>
				</tr>
				<!--tr>
					<td>Fecha:</td>
					<td><input type="text" name="fecha" size="50" value="<?php echo set_value('fecha');?>" /></td>
				</tr>
				<tr>
					<td>Hora:</td>
					<td><input type="text" name="hora" size="50" value="<?php echo set_value('hora');?>" /></td>
				</tr-->
				<tr>
					<td>Observaciones:</td>
					<td><textarea name="observaciones" rows="10" cols="35"><?php echo set_value('observaciones');?></textarea></td>
				</tr>
				<input type="hidden" name="idestado" value="<?php echo $estado;?>" />
				<input type="hidden" name="idpedido" value="<?php echo $pedido;?>" />
				<input type="hidden" name="persona_dos" value="N.A." />
				<input type="hidden" name="numero" value="N.A." />
				<input type="hidden" name="hechos" value="N.A." />
				<input type="hidden" name="localizacion" value="N.A." />
				<input type="hidden" name="acciones" value="N.A." />
				<input type="hidden" name="bultos" value="N.A." />
				<input type="hidden" name="fajos2" value="N.A." />
				<input type="hidden" name="fajos3" value="N.A." />
				<input type="hidden" name="numero2" value="N.A." />
				<input type="hidden" name="seguro" value="N.A." />
				<input type="hidden" name="fecha" value="N.A." />
				<input type="hidden" name="hora" value="N.A." />
				<input type="hidden" name="cajas" value="N.A." />
				<tr>
					<td align="center" colspan="2"><input type="submit" value="Guardar" /></td>
				</tr>

			</table>
			<?php echo form_close();?>
		<?php }
		break;
		case 2:
		if($rol == 'ADMINISTRADOR' || $rol == 'PEDIDOS_CATALOGO' || $rol=='PEDIDOS_REPRESENTANTE_EMBARQUES'){
			?>
			<div style="clear:both;"></div>
			<h2><?php echo $nombre;?></h2>
			<?php echo form_open(current_url());?>
			<input type="hidden" name="idestado" value="<?php echo $estado;?>" />
				<input type="hidden" name="idpedido" value="<?php echo $pedido;?>" />
				
				<input type="hidden" name="hechos" value="N.A." />
				<input type="hidden" name="localizacion" value="N.A." />
				<input type="hidden" name="acciones" value="N.A." />
				<input type="hidden" name="bultos" value="N.A." />
				<input type="hidden" name="fajos2" value="N.A." />
				<input type="hidden" name="fajos3" value="N.A." />
				<input type="hidden" name="numero2" value="N.A." />
				<input type="hidden" name="seguro" value="N.A." />
				<input type="hidden" name="fecha" value="N.A." />
				<input type="hidden" name="hora" value="N.A." />
				<input type="hidden" name="cajas" value="N.A." />
				<input type="hidden" id="cont_surt" value="0" />
			<table align="center" class="modificar">
				<tr>
					<td>Persona que recibe:</td>
					<td><input type="text" name="persona_uno" size="50" value="<?php echo set_value('persona_uno');?>" /></td>
				</tr>
				<tr>
					<td>Persona que surte:</td>
					<td>
                                                
						<select id="persona_dos">
							<?php 
							foreach ($consulta as $surtidor) {?>
								<option <?php echo set_select('persona_dos',$surtidor['nombre']);?> value="<?php echo $surtidor['nombre'];?>"><?php echo $surtidor['nombre'];?></option>
							<?php
							}
							?>
						</select>
                                                <input type="button" class="btn btn-mini" id="add_surtidor" value="Agregar" />
                                                <input type="button" class="btn btn-mini" id="sub_surtidor" value="Limpiar" /><br />
                                                <input type="hidden" id="text_surtidor" name="persona_dos" value="" />
                                                <div style="max-width:400px;" id="texto_surtidor"></div>
                                                <script type="text/javascript">
                                                    $(document).ready(function(){
                                                        $('#add_surtidor').click(function(){
                                                            //alert('clicked');
                                                            var surtidor = $("#persona_dos option:selected").val();
                                                            //alert (surtidor);
                                                            var pretexto = $("#text_surtidor").val();
                                                            var texto = pretexto + '' + surtidor + ', ';
                                                            $("#text_surtidor").val(texto);
                                                            $("#texto_surtidor").html(texto);
                                                        });
                                                        $('#sub_surtidor').click(function(){
                                                            $("#text_surtidor").val('');
                                                            $("#texto_surtidor").html('');
                                                        });
                                                    });
                                                </script>
						
					</td>
				</tr>
				<tr>
					<td>No Pedido SAE:</td>
					<td><input type="text" name="numero" size="50" value="<?php echo set_value('numero');?>" /></td>
				</tr>
				
				<tr>
					<td>Observaciones:</td>
					<td><textarea name="observaciones" rows="10" cols="35"><?php echo set_value('observaciones');?></textarea></td>
				</tr>
				<tr>
					<td align="center" colspan="2"><input type="submit" value="Guardar" /></td>
				</tr>
			</table>
			<?php echo form_close();?>
		<?php }
		break;
		case 3:
			if($rol == 'ADMINISTRADOR' || $rol == 'PEDIDOS_CATALOGO' || $rol=='PEDIDOS_REPRESENTANTE_VENTAS'){ ?>
			<div style="clear:both;"></div>
			<h2><?php echo $nombre;?></h2>
			<script type="text/javascript">
			function ValidNum(e) {
				var tecla= document.all ? tecla = e.keyCode : tecla = e.which;
				return ((tecla > 47 && tecla < 58) || tecla == 46 || tecla == 8);
				}
			</script>
			<?php echo form_open(current_url());?>
			<table align="center" class="modificar">
				<tr>
					<td>Persona que recibe:</td>
					<td><input type="text" name="persona_uno" size="50" value="<?php echo set_value('persona_uno');?>" /></td>
				</tr>
				<!--tr>
					<td>Fecha:</td>
					<td><input type="text" name="fecha" size="50" value="<?php echo set_value('fecha');?>" /></td>
				</tr>
				<tr>
					<td>Hora:</td>
					<td><input type="text" name="hora" size="50" value="<?php echo set_value('hora');?>" /></td>
				</tr-->
				<tr>
					<td>Persona que imprime remisión o factura:</td>
					<td><input type="text" name="persona_dos" size="50" value="<?php echo set_value('persona_dos');?>" /></td>
				</tr>
				<tr>
					<td>Número de Documento:</td>
					<td><input type="text" name="numero" size="50" value="<?php echo set_value('numero');?>" /></td>
				</tr>
				<tr>
					<td>Importe Surtido:</td>
					<td><input type="text" name="numero2" size="50" value="<?php echo set_value('numero2');?>" class="numerico"/>
				<tr>
					<td>Observaciones:</td>
					<td><textarea name="observaciones" rows="10" cols="35"><?php echo set_value('observaciones');?></textarea></td>
				</tr>
				<input type="hidden" name="idestado" value="<?php echo $estado;?>" />
				<input type="hidden" name="idpedido" value="<?php echo $pedido;?>" />
				
				<input type="hidden" name="hechos" value="N.A." />
				<input type="hidden" name="localizacion" value="N.A." />
				<input type="hidden" name="acciones" value="N.A." />
				<input type="hidden" name="bultos" value="N.A." />
				<input type="hidden" name="fajos2" value="N.A." />
				<input type="hidden" name="fajos3" value="N.A." />
				
				<input type="hidden" name="seguro" value="N.A." />
				<input type="hidden" name="fecha" value="N.A." />
				<input type="hidden" name="hora" value="N.A." />
				<input type="hidden" name="cajas" value="N.A." />
				<tr>
					<td align="center" colspan="2"><input type="submit" value="Guardar" /></td>
				</tr>

			</table>
			<?php echo form_close();?>
		<?php }
		break;
		case 4:
		if($rol == 'ADMINISTRADOR' || $rol == 'PEDIDOS_CATALOGO' || $rol=='PEDIDOS_REPRESENTANTE_EMBARQUES'){
			?>
			<div style="clear:both;"></div>
			<h2><?php echo $nombre;?></h2>
			<?php echo form_open(current_url());?>
			<table align="center" class="modificar">
				<tr>
					<td>Recibe remisión o factura número:</td>
					<td><input type="text" name="numero" size="50" value="<?php echo set_value('numero');?>" /></td>
				</tr>
				<tr>
					<td>Persona que audita el pedido:</td>
					<td><input type="text" name="persona_uno" size="50" value="<?php echo set_value('persona_uno');?>" /></td>
				</tr>
				<!--tr>
					<td>Fecha:</td>
					<td><input type="text" name="fecha" size="50" value="<?php echo set_value('fecha');?>" /></td>
				</tr>
				<tr>
					<td>Hora:</td>
					<td><input type="text" name="hora" size="50" value="<?php echo set_value('hora');?>" /></td>
				</tr-->
				<tr>
					<td>Observaciones:</td>
					<td><textarea name="observaciones" rows="10" cols="35"><?php echo set_value('observaciones');?></textarea></td>
				</tr>
				<input type="hidden" name="idestado" value="<?php echo $estado;?>" />
				<input type="hidden" name="idpedido" value="<?php echo $pedido;?>" />
				<input type="hidden" name="persona_dos" value="N.A." />
				<input type="hidden" name="hechos" value="N.A." />
				<input type="hidden" name="localizacion" value="N.A." />
				<input type="hidden" name="acciones" value="N.A." />
				<input type="hidden" name="bultos" value="N.A." />
				<input type="hidden" name="fajos2" value="N.A." />
				<input type="hidden" name="fajos3" value="N.A." />
				<input type="hidden" name="numero2" value="N.A." />
				<input type="hidden" name="seguro" value="N.A." />
				<input type="hidden" name="fecha" value="N.A." />
				<input type="hidden" name="hora" value="N.A." />
				<input type="hidden" name="cajas" value="N.A." />
				<tr>
					<td align="center" colspan="2"><input type="submit" value="Guardar" /></td>
				</tr>

			</table>
			<?php echo form_close();?>
		<?php }
		break;
		case 5:
		 if($rol == 'ADMINISTRADOR' || $rol == 'PEDIDOS_CATALOGO' || $rol=='PEDIDOS_REPRESENTANTE_VENTAS'){ ?>
			<div style="clear:both;"></div>
			<h2><?php echo $nombre;?></h2>
			<?php echo form_open(current_url());?>
			<table align="center" class="modificar">
				<tr>
					<td>Persona que autoriza:</td>
					<td><input type="text" name="persona_uno" size="50" value="<?php echo set_value('persona_uno');?>" /></td>
				</tr>
				<!--tr>
					<td>Fecha:</td>
					<td><input type="text" name="fecha" size="50" value="<?php echo set_value('fecha');?>" /></td>
				</tr>
				<tr>
					<td>Hora:</td>
					<td><input type="text" name="hora" size="50" value="<?php echo set_value('hora');?>" /></td>
				</tr-->
				<tr>
					<td>Observaciones:</td>
					<td><textarea name="observaciones" rows="10" cols="35"><?php echo set_value('observaciones');?></textarea></td>
				</tr>
				<input type="hidden" name="idestado" value="<?php echo $estado;?>" />
				<input type="hidden" name="idpedido" value="<?php echo $pedido;?>" />
				<input type="hidden" name="persona_dos" value="N.A." />
				<input type="hidden" name="numero" value="N.A." />
				<input type="hidden" name="hechos" value="N.A." />
				<input type="hidden" name="localizacion" value="N.A." />
				<input type="hidden" name="acciones" value="N.A." />
				<input type="hidden" name="bultos" value="N.A." />
				<input type="hidden" name="fajos2" value="N.A." />
				<input type="hidden" name="fajos3" value="N.A." />
				<input type="hidden" name="numero2" value="N.A." />
				<input type="hidden" name="seguro" value="N.A." />
				<input type="hidden" name="fecha" value="N.A." />
				<input type="hidden" name="hora" value="N.A." />
				<input type="hidden" name="cajas" value="N.A." />
				<tr>
					<td align="center" colspan="2"><input type="submit" value="Guardar" /></td>
				</tr>

			</table>
			<?php echo form_close();?>
		<?php }
		break;
		case 6: if($rol == 'ADMINISTRADOR' || $rol == 'PEDIDOS_CATALOGO' || $rol=='PEDIDOS_REPRESENTANTE_VENTAS'){ ?>
			<div style="clear:both;"></div>
			<h2><?php echo $nombre;?></h2>
			<?php echo form_open(current_url());?>
			<table align="center" class="modificar">
				<tr>
					<td>Persona que recibe:</td>
					<td><input type="text" name="persona_uno" size="50" value="<?php echo set_value('persona_uno');?>" /></td>
				</tr>
				<tr>
					<td>Número de Remisión de Transporte:</td>
					<td><input type="text" name="numero2" size="50" value="<?php echo set_value('numero2');?>" /></td>
				</tr>
				<tr>
					<td>Número de fajos atados con dos:</td>
					<td><input type="text" name="fajos2" size="50" value="<?php echo set_value('fajos2');?>" /></td>
				</tr>
				<tr>
					<td>Número de fajos atados con tres:</td>
					<td><input type="text" name="fajos3" size="50" value="<?php echo set_value('fajos3');?>" /></td>
				</tr>
				<tr>
					<td>Número de cajas:</td>
					<td><input type="text" name="cajas" size="50" value="<?php echo set_value('cajas');?>" /></td>
				</tr>
				<tr>
					<td>Número de bultos:</td>
					<td><input type="text" name="bultos" size="50" value="<?php echo set_value('bultos');?>" /></td>
				</tr>
				<tr>
					<td>Observaciones:</td>
					<td><textarea name="observaciones" rows="10" cols="35"><?php echo set_value('observaciones');?></textarea></td>
				</tr>
				<input type="hidden" name="idestado" value="<?php echo $estado;?>" />
				<input type="hidden" name="idpedido" value="<?php echo $pedido;?>" />
				<input type="hidden" name="persona_dos" value="N.A." />
				<input type="hidden" name="numero" value="N.A." />
				<input type="hidden" name="hechos" value="N.A." />
				<input type="hidden" name="localizacion" value="N.A." />
				<input type="hidden" name="acciones" value="N.A." />
				
				<input type="hidden" name="seguro" value="N.A." />
				<input type="hidden" name="fecha" value="N.A." />
				<input type="hidden" name="hora" value="N.A." />
				<tr>
					<td align="center" colspan="2"><input type="submit" value="Guardar" /></td>
				</tr>

			</table>
			<?php echo form_close();?>
		<?php }
		break;
		case 7:
		 if($rol == 'ADMINISTRADOR' || $rol == 'PEDIDOS_CATALOGO' || $rol=='PEDIDOS_REPRESENTANTE_VENTAS'){ ?>
			<div style="clear:both;"></div>
			<h2><?php echo $nombre;?></h2>
			<?php echo form_open(current_url());?>
			<table align="center" class="modificar">
				<tr>
					<td>Persona que recibe:</td>
					<td><input type="text" name="persona_uno" size="50" value="<?php echo set_value('persona_uno');?>" /></td>
				</tr>
				<tr>
					<td>Compañia:</td>
					<td><input type="text" name="persona_dos" size="50" value="<?php echo set_value('persona_dos');?>" /></td>
				</tr>
				<tr>
					<td>Fecha de recepción:</td>
					<td><input type="text" name="fecha" size="50" value="<?php echo set_value('fecha');?>" /></td>
				</tr>
				<tr>
					<td>Hora de recepción:</td>
					<td><input type="text" name="hora" size="50" value="<?php echo set_value('hora');?>" /></td>
				</tr>
				<tr>
					<td>Número de Guía:</td>
					<td><input type="text" name="numero" size="50" value="<?php echo set_value('numero');?>" /></td>
				</tr>
				
				<tr>
					<td>Con seguro:</td>
					<td>
						<input type="radio" name="seguro" value="SI" />SI<br />
						<input type="radio" name="seguro" value="NO" />NO
					</td>
				</tr>
				<tr>
					<td>Observaciones:</td>
					<td><textarea name="observaciones" rows="10" cols="35"><?php echo set_value('observaciones');?></textarea></td>
				</tr>
				<input type="hidden" name="idestado" value="<?php echo $estado;?>" />
				<input type="hidden" name="idpedido" value="<?php echo $pedido;?>" />
				<input type="hidden" name="hechos" value="N.A." />
				<input type="hidden" name="localizacion" value="N.A." />
				<input type="hidden" name="acciones" value="N.A." />
				<input type="hidden" name="bultos" value="N.A." />
				<input type="hidden" name="fajos2" value="N.A." />
				<input type="hidden" name="fajos3" value="N.A." />
				<input type="hidden" name="cajas" value="N.A." />
				<input type="hidden" name="numero2" value="N.A." />
				
				
				<tr>
					<td align="center" colspan="2"><input type="submit" value="Guardar" /></td>
				</tr>

			</table>
			<?php echo form_close();?>
		<?php }
		break;
		case 8: 
		if($rol == 'ADMINISTRADOR' || $rol == 'PEDIDOS_CATALOGO' || $rol=='PEDIDOS_REPRESENTANTE_VENTAS'){ ?>
			<div style="clear:both;"></div>
			<h2><?php echo $nombre;?></h2>
			<?php echo form_open(current_url());?>
			<table align="center" class="modificar">
				<tr>
					<td>Persona que recibe reporte:</td>
					<td><input type="text" name="persona_uno" size="50" value="<?php echo set_value('persona_uno');?>" /></td>
				</tr>
				<tr>
					<td>Hechos:</td>
					<td><input type="text" name="hechos" size="50" value="<?php echo set_value('hechos');?>" /></td>
				</tr>
				<!--tr>
					<td>Fecha:</td>
					<td><input type="text" name="fecha" size="50" value="<?php echo set_value('fecha');?>" /></td>
				</tr>
				<tr>
					<td>Hora:</td>
					<td><input type="text" name="hora" size="50" value="<?php echo set_value('hora');?>" /></td>
				</tr-->
				<tr>
					<td>Localización del Pedido:</td>
					<td><input type="text" name="localizacion" size="50" value="<?php echo set_value('localizacion');?>" /></td>
				</tr>
				<tr>
					<td>Acciones:</td>
					<td><textarea name="acciones" rows="10" cols="35"><?php echo set_value('acciones');?></textarea></td>
				</tr>
				<tr>
					<td>Observaciones:</td>
					<td><textarea name="observaciones" rows="10" cols="35"><?php echo set_value('observaciones');?></textarea></td>
				</tr>
				<input type="hidden" name="idestado" value="<?php echo $estado;?>" />
				<input type="hidden" name="idpedido" value="<?php echo $pedido;?>" />
				<input type="hidden" name="persona_dos" value="N.A." />
				<input type="hidden" name="numero" value="N.A." />
				<input type="hidden" name="bultos" value="N.A." />
				<input type="hidden" name="fajos2" value="N.A." />
				<input type="hidden" name="fajos3" value="N.A." />
				<input type="hidden" name="numero2" value="N.A." />
				<input type="hidden" name="seguro" value="N.A." />
				<input type="hidden" name="fecha" value="N.A." />
				<input type="hidden" name="hora" value="N.A." />
				<input type="hidden" name="cajas" value="N.A." />
				
				<tr>
					<td align="center" colspan="2"><input type="submit" value="Guardar" /></td>
				</tr>

			</table>
			<?php echo form_close();?>
		<?php }
		break;

	}

}
	
function pedidoVista($consulta,$consultaDos){
	
	foreach($consultaDos->result() as $q){
		$importe_pedido = $q->total;
	}
	$CI = get_instance();
	$CI->load->model('pedido_model','pedido');
	//$CI->pedido->dummie();
	
	foreach($consulta->result() as $estado){
		$id = $estado->idEstado;
		switch($id){
			case 1:

				$inicio = $estado->fecha_aut;
				?>
				<div style="clear:both;"></div>
				<h2><?php echo $estado->nombre;?> <?php echo $estado->Pedido_idPedido;?></h2>
				<table class="consulta left">
					<tr>
						<th>Persona que recibe</th>
						<th>Fecha</th>
						<th>Observaciones</th>
						<th>Importe del Pedido</th>
					</tr>
					<tr>
						<td><?php echo $estado->persona_uno;?></td>
						<td><?php echo $estado->fecha_aut;?></td>
						<td><?php echo ($estado->observaciones);?></td>
						<td><?php echo '$'.number_format($importe_pedido,2);?></td>
					</tr>
				</table>
			<?php
			break;
			case 2:
			//$inicio = $estado->fecha_aut;
			?>
				<div style="clear:both;"></div>
				<h2><?php echo $estado->nombre;?></h2>
				<table align="left" class="consulta left">
					<tr>
						<th>Persona que recibe</th>
						<th>Persona que surte</th>
						<th>No de Pedido de SAE</th>
						<th>Fecha</th>
						<th>Observaciones</th>
					</tr>
					<tr>
						<td><?php echo $estado->persona_uno;?></td>
						<td><?php echo $estado->persona_dos;?></td>
						<td><?php echo $estado->numero;?></td>
						<td><?php echo $estado->fecha_aut;?></td>
						<td>
							<div id="observar<?php echo $estado->idReporte;?>" style="display:block;"><?php echo ($estado->observaciones);?><button onclick="mostrar('observar<?php echo $estado->idReporte;?>','agregar<?php echo $estado->idReporte;?>')">Agregar Comentario</button></div>
							<div id="agregar<?php echo $estado->idReporte;?>" style="display:none;">
								<?php echo form_open('pedido/todos/observacion/'.$estado->idReporte);?>
								<textarea name="observacion" rows="10" cols="35"></textarea>
								<input type='hidden' value='<?php echo ($estado->observaciones);?>' name='original' />
								<input type="submit" value="Guardar">
								<?php echo form_close();?>
								<button onclick="mostrar('agregar<?php echo $estado->idReporte;?>','observar<?php echo $estado->idReporte;?>')">Cancelar</button>
							</div>
								
						</td>
					</tr>
				</table>
			<?php
			break;
			case 3:?>
				<div style="clear:both;"></div>
				<h2><?php echo $estado->nombre;?></h2>
				<table  class="consulta left">
					<tr>
						<th>Persona que recibe</th>
						<th>Fecha</th>
						<th>Persona que imprime remisión o factura</th>
						<th>Número de Documento</th>
						<th>Importe surtido</th>
						<th>Observaciones</th>
					</tr>
					<tr>
						<td><?php echo $estado->persona_uno;?></td>
						<td><?php echo $estado->fecha_aut;?></td>
						<td><?php echo $estado->persona_dos;?></td>
						<td><?php echo $estado->numero;?></td>
						<td><?php echo $estado->numero2;?></td>
						<td>
							<div id="observar<?php echo $estado->idReporte;?>" style="display:block;"><?php echo ($estado->observaciones);?><button onclick="mostrar('observar<?php echo $estado->idReporte;?>','agregar<?php echo $estado->idReporte;?>')">Agregar Comentario</button></div>
							<div id="agregar<?php echo $estado->idReporte;?>" style="display:none;">
								<?php echo form_open('pedido/todos/observacion/'.$estado->idReporte);?>
								<textarea name="observacion" rows="10" cols="35"></textarea>
								<input type='hidden' value='<?php echo ($estado->observaciones);?>' name='original' />
								<input type="submit" value="Guardar">
								<?php echo form_close();?>
								<button onclick="mostrar('agregar<?php echo $estado->idReporte;?>','observar<?php echo $estado->idReporte;?>')">Cancelar</button>
							</div>
								
						</td>
					</tr>
				</table>
			<?php
			break;
			case 4:?>
				<div style="clear:both;"></div>
				<h2><?php echo $estado->nombre;?></h2>
				<table  class="consulta left">
					<tr>
						<th>Factura o remisión número</th>
						<th>Persona que audita</th>
						<th>Fecha</th>
						<th>Observaciones</th>
					</tr>
					<tr>
						<td><?php echo $estado->numero;?></td>
						<td><?php echo $estado->persona_uno;?></td>
						<td><?php echo $estado->fecha_aut;?></td>
						<td>
							<div id="observar<?php echo $estado->idReporte;?>" style="display:block;"><?php echo ($estado->observaciones);?><button onclick="mostrar('observar<?php echo $estado->idReporte;?>','agregar<?php echo $estado->idReporte;?>')">Agregar Comentario</button></div>
							<div id="agregar<?php echo $estado->idReporte;?>" style="display:none;">
								<?php echo form_open('pedido/todos/observacion/'.$estado->idReporte);?>
								<textarea name="observacion" rows="10" cols="35"></textarea>
								<input type='hidden' value='<?php echo ($estado->observaciones);?>' name='original' />
								<input type="submit" value="Guardar">
								<?php echo form_close();?>
								<button onclick="mostrar('agregar<?php echo $estado->idReporte;?>','observar<?php echo $estado->idReporte;?>')">Cancelar</button>
							</div>
								
						</td>
					</tr>
				</table>
				<?php 
					$ultimo = $estado->fecha_aut;
					//echo $ultimo;
					//$inicio = '2012-05-20 23:00:34';
					$dia = $CI->pedido->get_diferencia($ultimo,$inicio);?>
					<div style="clear:both;"></div>
					<h2>Tiempo consumido en el surtido de este pedido.</h2>
					<table  class="consulta left">
						<tr>
							<th>Tiempo total del surtido</th>
						</tr>
						<tr>
							<td style="color:red;"><strong>Se han consumido <?php echo $dia;?> en el surtido de este pedido.</strong></td>
						</tr>
					</table>
			<?php
			break;
			case 5:?>
				<div style="clear:both;"></div>
				<h2><?php echo $estado->nombre;?></h2>
				<table  class="consulta left">
					<tr>
						<th>Persona que autoriza</th>
						<th>Fecha</th>
						<th>Observaciones</th>
					</tr>
					<tr>
						<td><?php echo $estado->persona_uno;?></td>
						<td><?php echo $estado->fecha_aut;?></td>
						<td>
							<div id="observar<?php echo $estado->idReporte;?>" style="display:block;"><?php echo ($estado->observaciones);?><button onclick="mostrar('observar<?php echo $estado->idReporte;?>','agregar<?php echo $estado->idReporte;?>')">Agregar Comentario</button></div>
							<div id="agregar<?php echo $estado->idReporte;?>" style="display:none;">
								<?php echo form_open('pedido/todos/observacion/'.$estado->idReporte);?>
								<textarea name="observacion" rows="10" cols="35"></textarea>
								<input type='hidden' value='<?php echo ($estado->observaciones);?>' name='original' />
								<input type="submit" value="Guardar">
								<?php echo form_close();?>
								<button onclick="mostrar('agregar<?php echo $estado->idReporte;?>','observar<?php echo $estado->idReporte;?>')">Cancelar</button>
							</div>
								
						</td>
					</tr>
				</table>
			<?php
			break;
			case 6:?>
				<div style="clear:both;"></div>
				<h2><?php echo $estado->nombre;?></h2>
				<table class="consulta left">
					<tr>
						<th>Persona que recibe</th>
						<th>Número de Remisión de Transporte</th>
						<th>Fecha</th>
						<th>Fajos con 2</th>
						<th>Fajos con 3</th>
						<th>Cajas</th>
						<th>Bultos</th>
						<th>Observaciones</th>
					</tr>
					<tr>
						<td><?php echo $estado->persona_uno;?></td>
						<td><?php echo $estado->numero2;?></td>
						<td><?php echo $estado->fecha_aut;?></td>
						<td><?php echo $estado->fajos2;?></td>
						<td><?php echo $estado->fajos3;?></td>
						<td><?php echo $estado->cajas;?></td>
						<td><?php echo $estado->bultos;?></td>
						<td>
							<div id="observar<?php echo $estado->idReporte;?>" style="display:block;"><?php echo ($estado->observaciones);?><button onclick="mostrar('observar<?php echo $estado->idReporte;?>','agregar<?php echo $estado->idReporte;?>')">Agregar Comentario</button></div>
							<div id="agregar<?php echo $estado->idReporte;?>" style="display:none;">
								<?php echo form_open('pedido/todos/observacion/'.$estado->idReporte);?>
								<textarea name="observacion" rows="10" cols="35"></textarea>
								<input type='hidden' value='<?php echo ($estado->observaciones);?>' name='original' />
								<input type="submit" value="Guardar">
								<?php echo form_close();?>
								<button onclick="mostrar('agregar<?php echo $estado->idReporte;?>','observar<?php echo $estado->idReporte;?>')">Cancelar</button>
							</div>
								
						</td>
					</tr>
				</table>
			<?php
			break;
			case 7:?>
				<div style="clear:both;"></div>
				<h2><?php echo $estado->nombre;?></h2>
				<table  class="consulta left">
					<tr>
						<th>Persona que recibe</th>
						<th>Compañia</th>
						<th>Fecha</th>
						<th>Fecha de Recepción</th>
						<th>Seguro</th>
						<th>Número de Guía</th>
						
						<th>Observaciones</th>
					</tr>
					<tr>
						<td><?php echo $estado->persona_uno;?></td>
						<td><?php echo $estado->persona_dos;?></td>
						<td><?php echo $estado->fecha_aut;?></td>
						<td><?php echo $estado->fecha.' '.$estado->hora;?></td>
						<td><?php echo $estado->seguro;?></td>
						<td><?php echo $estado->numero;?></td>
						<td>
							<div id="observar<?php echo $estado->idReporte;?>" style="display:block;"><?php echo ($estado->observaciones);?><button onclick="mostrar('observar<?php echo $estado->idReporte;?>','agregar<?php echo $estado->idReporte;?>')">Agregar Comentario</button></div>
							<div id="agregar<?php echo $estado->idReporte;?>" style="display:none;">
								<?php echo form_open('pedido/todos/observacion/'.$estado->idReporte);?>
								<textarea name="observacion" rows="10" cols="35"></textarea>
								<input type='hidden' value='<?php echo ($estado->observaciones);?>' name='original' />
								<input type="submit" value="Guardar">
								<?php echo form_close();?>
								<button onclick="mostrar('agregar<?php echo $estado->idReporte;?>','observar<?php echo $estado->idReporte;?>')">Cancelar</button>
							</div>
								
						</td>
					</tr>
				</table>
				<?php 
					$ultimo = $estado->fecha_aut;
					//echo $ultimo;
					//$inicio = '2012-05-20 23:00:34';
					$dia = $CI->pedido->get_diferencia($ultimo,$inicio);?>
					<div style="clear:both;"></div>
					<h2>Tiempo consumido en el proceso de este pedido.</h2>
					<table  class="consulta left">
						<tr>
							<th>Tiempo total del pedido</th>
						</tr>
						<tr>
							<td style="color:red;"><strong>Se han consumido <?php echo $dia;?> en el proceso de este pedido.</strong></td>
						</tr>
					</table>
			<?php
			break;
			case 8:?>
				<div style="clear:both;"></div>
				<h2><?php echo $estado->nombre;?></h2>
				<table class="consulta left">
					<tr>
						<th>Persona que recibe</th>
						<th>Fecha</th>
						<th>Hechos</th>
						<th>Localización del Pedido</th>
						<th>Acciones</th>
						<th>Observaciones</th>
					</tr>
					<tr>
						<td><?php echo $estado->persona_uno;?></td>
						<td><?php echo $estado->fecha_aut;?></td>
						<td><?php echo $estado->hechos;?></td>
						<td><?php echo $estado->localizacion;?></td>
						<td><?php echo ($estado->acciones);?></td>
						<td>
							<div id="observar<?php echo $estado->idReporte;?>" style="display:block;"><?php echo ($estado->observaciones);?><button onclick="mostrar('observar<?php echo $estado->idReporte;?>','agregar<?php echo $estado->idReporte;?>')">Agregar Comentario</button></div>
							<div id="agregar<?php echo $estado->idReporte;?>" style="display:none;">
								<?php echo form_open('pedido/todos/observacion/'.$estado->idReporte);?>
								<textarea name="observacion" rows="10" cols="35"></textarea>
								<input type='hidden' value='<?php echo ($estado->observaciones);?>' name='original' />
								<input type="submit" value="Guardar">
								<?php echo form_close();?>
								<button onclick="mostrar('agregar<?php echo $estado->idReporte;?>','observar<?php echo $estado->idReporte;?>')">Cancelar</button>
							</div>
								
						</td>
					</tr>
				</table>
				<div style="clear:both;"></div>
			<?php
			break;
			default:
			break;
		}
	}	
}

function configuraMail(){
	$config = Array(
	  'protocol' => 'smtp',
	  'smtp_host' => 'mail.tecnobotanicademexico.com.mx',
	  'smtp_port' => 25,
	  'smtp_user' => 'noresponder@tecnobotanicademexico.com.mx', // change it to yours
	  'smtp_pass' => 'letmein', // change it to yours
	  'mailtype' => 'html',
	  'charset' => 'iso-8859-1',
	  'wordwrap' => TRUE
	);
	return $config;
}

?>