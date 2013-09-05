<?php $this->load->view('admin/common/header');?>

<div class="menu"><?php construyeMenu($rol); ?></div>
	<div id="body">
            <?php 
            $tmp = $this->phpsession->flashget('acierto');
            if(!empty($tmp)){ ?>
            <div class='alert alert-success'>
                <?php echo $tmp;?>
            </div>
            <?php
            }
            ?>
            
            <?php 
            $tmp = $this->phpsession->flashget('error');
            if(!empty($tmp)){ ?>
            <div class='alert alert-error'>
                <?php echo $tmp;?>
            </div>
            <?php
            }
            ?>
            
            <?php 
            $tmp = validation_errors();
            if(!empty($tmp)){ ?>
            <div class='alert alert-error'>
                <?php echo $tmp;?>
            </div>
            <?php
            }
            ?>
            
            <?php 
            if($seccion == 'lista'){?>
            
                <div class="alert alert-error" id="error_busqueda" style="display:none;">
                    <p>Error al ejecutar la búsqueda. Contacte a su administrador.</p>
                </div>
                <div class="alert alert-error" id="error_estado" style="display:none;">
                    <p>Ha ocurrido un problema al activar/desactivar el cliente. Contacte a su administrador.</p>
                </div>
				<center>
					<button onclick="window.open('<?php echo site_url('admin/tienda/cliente/excel');?>','newwindow','width=400,height=200');">Exportar Listado de Clientes</button>
					</center>
                <div class="input-append pull-right">
                    <input type="text" placeholder="Nombre" id="busqueda">
                    <button type="button" class="btn" id="buscar"><i class="icon icon-search"></i> Buscar </button>
                </div>
            <div class='clearfix'></div>
            <div id='results'>
                <table class='table table-bordered table-hover'>
                    <tr>
                        <th>Nombre</th>
                        <th>Tipo Cliente</th>
                        <th>Clave de Cliente</th>
                        <th>Contraseña</th>
                        <th>Fecha de Alta</th>
                        <th>Información</th>
                        <th>Activo</th>
                    </tr>

                    <?php
                    foreach($clientes as $c){?>
                    <tr>
                        <td><?php echo $c['nombre_cliente'].' '.$c['apellido'];?></td>
                        <td><?php echo $c['nombre'];?></td>
                        <td><?php echo $c['abreviatura'].''.$c['idCliente'];?></td>
                        <td><?php echo $c['contrasena'];?></td>
                        <td><?php echo $c['fecha'];?></td>
                        <td><a href='<?php echo site_url('admin/cliente/editar/'.$c['idCliente']);?>' >Editar</a></td>
                        <td>
                            <center>
                            <button class="btn btn-link estado" data-accion="<?php echo ($c['activo'] == 'SI') ? 'NO' : 'SI';?>" data-id="<?php echo $c['idCliente'];?>">
                                <span class="badge <?php echo ($c['activo'] =='SI') ? 'badge-success' : 'badge-important';?>" id="estado<?php echo $c['idCliente'];?>">
                                    <i class="icon icon-certificate icon-white"></i>
                                </span>
                            </button>
                            <span style="display:none;" id="load<?php echo $c['idCliente'];?>"><img src="<?php echo base_url('img/load_small.gif');?>"></span>
                            </center>
                        </td>
                    </tr>
                    <?php
                    }
                    ?>

                </table>
            </div>
            
                <script type="text/javascript">
                    $(document).ready(function(){

                        $('#buscar').click(function(){

                            $("#results").html('<center><img src="<?php echo base_url('img/cargando.gif');?>" alt="Cargando..." /><center>');
                            var busqueda = $('#busqueda').val();
                            if(busqueda != ''){

                                $.ajax({
                                    type: "POST",
                                    url: "<?php echo site_url('admin/cliente/buscar');?>",
                                    cache: false,
                                    data: {buscar: busqueda}
                                }).done(function( html ) {
                                    $("#error_busqueda").css('display','none');
                                    $("#results").html(html);
                                }).fail(function(jqXHR, textStatus) {
                                    $("#error_busqueda").css('display','block');
                                    $("#results").html('<h1>ERROR</h1>');
                                    //alert( "Falla en el sistema. Contacte a su administrador.");
                                });
                            }else{
                                document.location.replace('<?php echo current_url();?>');
                            }
                        }); 

                        $('#busqueda').keypress(function(event){
                            var keycode = (event.keyCode ? event.keyCode : event.which);
                            //alert(keycode);
                            if(keycode == '13'){
                                   $('#buscar').click();	
                            }

                        });

                        $('.estado').live('click',function(){
                            var btn = $(this);
                            var id = btn.attr('data-id');
                            var pr = btn.attr('data-accion');
                            var nombreid;
                            btn.css('display','none');
                            $("#load"+id).css('display','block');
                            $.ajax({
                                    type: "POST",
                                    url: "<?php echo site_url('admin/cliente/estado');?>",
                                    cache: false,
                                    data: {estado: pr, idcliente: id}
                                }).done(function() {

                                    $("#error_estado").css('display','none');
                                    nombreid = '#estado'+id;
                                    //alert(pr);
                                    if(pr == 'SI'){
                                        btn.attr('data-accion','NO');
                                        $(nombreid).removeClass('badge-important');
                                        $(nombreid).addClass('badge-success');


                                    }else{
                                        btn.attr('data-accion','SI');
                                        $(nombreid).removeClass('badge-success');
                                        $(nombreid).addClass('badge-important');

                                    }

                                    $("#load"+id).css('display','none');
                                    btn.css('display','block');





                                }).fail(function(jqXHR, textStatus) {
                                    $("#error_estado").css('display','block');
                                    //alert( "Falla en el sistema. Contacte a su administrador.");
                                    $("#load"+id).css('display','none');
                                    btn.css('display','block');
                                });

                        });

                    });
                </script>
            <?php    
            }elseif($seccion == 'alta'){?>
                <h1>Alta de Clientes</h1>
                <?php echo form_open(current_url());?>
                <table class='table table-bordered table-hover' style='width:900px;'>
                    <tr>
                        <td><span class='text-error'>*Tipo de Cliente</span></td>
                        <td>
                            <select name='tipo' class='span8' >
                                <option value=''>Seleccione una opción</option>
                                <?php
                                foreach($tipos as $t){?>
                                <option <?php echo set_select('tipo',$t['idTipoCliente']);?> value='<?php echo $t['idTipoCliente'];?>'><?php echo $t['nombre'];?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><span class='text-error'>*Nombre(s)</span></td>
                        <td><input type='text' name='nombres' value='<?php echo set_value('nombres');?>' class='span8' /></td>
                    </tr>
                    <tr>
                        <td><span class='text-error'>*Apellido(s)</span></td>
                        <td><input type='text' name='apellidos' value='<?php echo set_value('apellidos');?>' class='span8' /></td>
                    </tr>
                    <tr>
                        <td><span class='text-error'>*Correo Electrónico</span></td>
                        <td><input type='text' name='email' value='<?php echo set_value('email');?>' class='span8' /></td>
                    </tr>
                    <tr>
                        <td><span class='text-error'>*Confirme Correo Electrónico</span></td>
                        <td><input type='text' name='email1' value='<?php echo set_value('email1');?>' class='span8' /></td>
                    </tr>
                    <tr>
                        <td><span class='text-error'>*Teléfono</span></td>
                        <td><input type='text' name='telefono' value='<?php echo set_value('telefono');?>' class='span8' /></td>
                    </tr>
                    <tr>
                        <td><span class='text-error'>*Tipo de Teléfono</span></td>
                        <td>
                            <select name='tipo_telefono' class='span8' >
                                <option value=''>Seleccione una opción</option>
                                <option value='casa' <?php echo set_select('tipo_telefono','casa');?> >Casa</option>
                                <option value='oficina' <?php echo set_select('tipo_telefono','oficina');?>>Oficina</option>
                                <option value='celular' <?php echo set_select('tipo_telefono','celular');?>>Celular</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Razón Social o Comercial</td>
                        <td><input type='text' name='razon' value='<?php echo set_value('razon');?>' class='span8' /></td>
                    </tr>
                    <tr>
                        <td><span class='text-error'>*Calle Número</span></td>
                        <td><input type='text' name='calle' value='<?php echo set_value('calle');?>' class='span8' /></td>
                    </tr>
                    <tr>
                        <td><span class='text-error'>*Colonia</span></td>
                        <td><input type='text' name='colonia' value='<?php echo set_value('colonia');?>' class='span8' /></td>
                    </tr>
                    <tr>
                        <td><span class='text-error'>*Delegación o Municipio</span></td>
                        <td><input type='text' name='delegacion' value='<?php echo set_value('delegacion');?>' class='span8' /></td>
                    </tr>
                    <tr>
                        <td><span class='text-error'>*Código Postal</span></td>
                        <td><input type='text' name='cp' value='<?php echo set_value('cp');?>' class='span8' /></td>
                    </tr>
                    <tr>
                        <td><span class='text-error'>*Ciudad</span></td>
                        <td><input type='text' name='ciudad' value='<?php echo set_value('ciudad');?>' class='span8' /></td>
                    </tr>
                    <tr>
                        <td><span class='text-error'>*Estado</span></td>
                        <td><input type='text' name='estado' value='<?php echo set_value('estado');?>' class='span8' /></td>
                    </tr>
                    <tr>
                        <td><span class='text-error'>*Contraseña</span></td>
                        <td><input type='text' name='pass' value='<?php echo set_value('pass');?>' class='span8' /></td>
                    </tr>
                    <tr>
                        <td><span class='text-error'>*Confirmar Contraseña</span></td>
                        <td><input type='text' name='pass1' value='<?php echo set_value('pass1');?>' class='span8' /></td>
                    </tr>
                    <tr>
                        <td colspan='2'><input type="submit" value='Guardar' class='pull-right btn btn-success' /></td>
                    </tr>
                </table>
                <?php echo form_close();?>
            <?php
            }elseif($seccion == 'editar'){
                $c = $cliente;?>
                <a href="<?php echo site_url('admin/cliente/lista');?>" class='btn btn-small pull-left'> <i class='icon icon-chevron-left'></i> Regresar a Listado </a>
                <div class="clearfix"></div>
                <h1>Edición de Clientes</h1>
                <?php echo form_open(current_url());?>
                <input type='hidden' value='<?php echo $c['idDireccion'];?>' name='iddireccion' />
                <input type='hidden' value='<?php echo $c['idEmpresa'];?>' name='idempresa' />
                <table class='table table-bordered table-hover' style='width:900px;'>
                    <tr>
                        <td><span class='text-error'>*Tipo de Cliente</span></td>
                        <td>
                            <select name='tipo' class='span8'>
                                <option value=''>Seleccione una opción</option>
                                <?php
                                foreach($tipos as $t){?>
                                <option <?php echo ($t['idTipoCliente'] == $c['TipoCliente_idTipoCliente']) ? 'selected="selected"' : '';?> value='<?php echo $t['idTipoCliente'];?>'><?php echo $t['nombre'];?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><span class='text-error'>*Nombre(s)</span></td>
                        <td><input type='text' name='nombres' value='<?php echo $c['nombre'];?>' class='span8' /></td>
                    </tr>
                    <tr>
                        <td><span class='text-error'>*Apellido(s)</span></td>
                        <td><input type='text' name='apellidos' value='<?php echo $c['apellido'];?>' class='span8' /></td>
                    </tr>
                    <tr>
                        <td><span class='text-error'>*Correo Electrónico</span></td>
                        <td><input type='text' name='email' value='<?php echo $c['correo'];?>' class='span8' /></td>
                    </tr>
                    <tr>
                        <td><span class='text-error'>*Confirme Correo Electrónico</span></td>
                        <td><input type='text' name='email1' value='<?php echo $c['correo'];?>' class='span8' /></td>
                    </tr>
                    <tr>
                        <td><span class='text-error'>*Teléfono</span></td>
                        <td><input type='text' name='telefono' value='<?php echo $c['telefono'];?>' class='span8' /></td>
                    </tr>
                    <tr>
                        <td><span class='text-error'>*Tipo de Teléfono</span></td>
                        <td>
                            <select name='tipo_telefono' class='span8'>
                                <option value=''>Seleccione una opción</option>
                                <option value='casa' <?php echo ($c['tipo_telefono'] == 'casa') ? 'selected="selected"' : '';?> >Casa</option>
                                <option value='oficina' <?php echo ($c['tipo_telefono'] == 'oficina') ? 'selected="selected"' : '';?>>Oficina</option>
                                <option value='celular' <?php echo ($c['tipo_telefono'] == 'celular') ? 'selected="selected"' : '';?>>Celular</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Razón Social o Comercial</td>
                        <td><input type='text' name='razon' value='<?php echo $c['razon_social'];?>' class='span8' /></td>
                    </tr>
                    <tr>
                        <td><span class='text-error'>*Calle Número</span></td>
                        <td><input type='text' name='calle' value='<?php echo $c['calle'];?>' class='span8' /></td>
                    </tr>
                    <tr>
                        <td><span class='text-error'>*Colonia</span></td>
                        <td><input type='text' name='colonia' value='<?php echo $c['colonia'];?>' class='span8' /></td>
                    </tr>
                    <tr>
                        <td><span class='text-error'>*Delegación o Municipio</span></td>
                        <td><input type='text' name='delegacion' value='<?php echo $c['delegacion'];?>' class='span8' /></td>
                    </tr>
                    <tr>
                        <td><span class='text-error'>*Código Postal</span></td>
                        <td><input type='text' name='cp' value='<?php echo $c['codigo_postal'];?>' class='span8' /></td>
                    </tr>
                    <tr>
                        <td><span class='text-error'>*Ciudad</span></td>
                        <td><input type='text' name='ciudad' value='<?php echo $c['ciudad'];?>' class='span8' /></td>
                    </tr>
                    <tr>
                        <td><span class='text-error'>*Estado</span></td>
                        <td><input type='text' name='estado' value='<?php echo $c['estado'];?>' class='span8' /></td>
                    </tr>
                    <tr>
                        <td><span class='text-error'>*Contraseña</span></td>
                        <td><input type='text' name='pass' value='<?php echo $c['contrasena'];?>' class='span8' /></td>
                    </tr>
                    <tr>
                        <td><span class='text-error'>*Confirmar Contraseña</span></td>
                        <td><input type='text' name='pass1' value='<?php echo $c['contrasena'];?>' class='span8' /></td>
                    </tr>
                    <tr>
                        <td colspan='2'><input type="submit" value='Guardar' class='pull-right btn btn-success' /></td>
                    </tr>
                </table>
                <?php echo form_close();?>
            <?php
            }else{?>
                <h2>Altas</h2>
                    <table width="70%" align="center">
                        <tbody>
                            <tr>
                                <td>
                                    <a href="<?php echo site_url('admin/cliente/alta');?>">
                                        <img src="<?php echo base_url('img/icons/icono-cliente-nuevo.jpg');?>">
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <h2>Consultas &amp; Actualizaciones</h2>
                    <table width="70%" align="center">
                        <tbody>
                            <tr>
                                <td>
                                    <a href="<?php echo site_url('admin/cliente/lista');?>">
                                        <img src="<?php echo base_url('/img/icons/icono-cliente.jpg');?>">
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
            <?php
            }
            ?>
        </div>

<?php $this->load->view('admin/common/footer');?>
