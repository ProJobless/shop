<?php $this->load->view('mayorista/header'); ?>

<br />
<div class="container" style="margin:auto;">
    <div id='results'></div>
    <div id='pedido'>
        <a href='#listaexcel' class='btn btn-info pull-right' role="button" data-toggle="modal" ><i class='icon icon-cloud-upload'></i>&nbsp;Subir Lista de Excel</a>
        <div class='clearfix'></div>
        <br />
        <table class='table table-bordered table-hover'>
            <tr>
                <th>Cantidad</th>
                <th>Código</th>
                <th>Estado Físico</th>
                <th>Descripción</th>
                <th>Presentación</th>
                <th>Grupo</th>
                <th>IVA</th>
                <th>Precio</th>
            </tr>
            <?php
            $mayor = $this->phpsession->get('datos', 'mayorista');
            foreach ($listado as $l) {
                $precio = $l['precio'] * ($mayor['descuento'] / 100);
                ?>
                <tr>
                    <td><input data-id="<?php echo $l['idPresentacion']; ?>" class='input-mini pedido-qty' type='text' name='qty' value='' /></td>
                    <td><?php echo $l['clave']; ?></td>
                    <td><?php echo $l['estado_fisico']; ?></td>
                    <td><?php echo $l['descripcion']; ?></td>
                    <td><?php echo $l['presentacion']; ?></td>
                    <td><?php echo $l['grupo']; ?></td>
                    <td><?php echo ($l['iva'] == 'SI') ? '16' : 'N.A.'; ?></td>
                    <td><?php echo number_format($precio, 2); ?></td>
                </tr>
                <?php
            }
            ?>
        </table>  
    </div>
    <div id='carro_pedido' class='hide'></div>
    <div id='direcciones_pedido' class='hide'>
        <form id='form_pedido'>
            <h4>Fecha de Pedido: <?php echo date('d-m-Y'); ?></h4>
            <ul class="nav nav-tabs">
                <li class='active'><a href="#home" data-toggle="tab" >Datos Generales</a></li>
                <li><a href="#profile" data-toggle="tab">Factura</a></li>
                <li><a href="#messages" data-toggle="tab">Envío</a></li>
                <li><a href="#settings" data-toggle="tab">Forma de Pago</a></li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane active" id="home">

                    <table class='table table-bordered table-hover'>
                        <tr>
                            <td style='width:15%;'>Nombre:</td>
                            <td><?php echo $general['nombre'] . ' ' . $general['apellido']; ?></td>
                        </tr>

                        <tr>
                            <td>Correo Electrónico: </td>
                            <td><?php echo $general['correo']; ?></td>
                        </tr>

                        <tr>
                            <td>Teléfono: </td>
                            <td><?php echo $general['telefono']; ?></td>
                        </tr>

                        <tr>
                            <td>Calle: </td>
                            <td><?php echo $general['calle']; ?></td>
                        </tr>

                        <tr>
                            <td>Colonia: </td>
                            <td><?php echo $general['colonia']; ?></td>
                        </tr>

                        <tr>
                            <td>Código Postal: </td>
                            <td><?php echo $general['codigo_postal']; ?></td>
                        </tr>

                        <tr>
                            <td>Delegación o Municipio: </td>
                            <td><?php echo $general['delegacion']; ?></td>
                        </tr>

                        <tr>
                            <td>Estado: </td>
                            <td><?php echo $general['estado']; ?></td>
                        </tr>

                        <tr>
                            <td>País: </td>
                            <td>México</td>
                        </tr>
                    </table>
                </div>
                <div class="tab-pane" id="profile">
                    <div class='alert alert-info'>
                        <p>Si no desea Factura deje los siguientes datos en blanco.</p>
                    </div>
                    <table class='table table-bordered table-hover'>
                        <tr>
                            <td style='width:15%;'>Nombre o Razón Social:</td>
                            <td><input type='text' style='width:95%;' name='f_razon' /></td>
                        </tr>

                        <tr>
                            <td>RFC: </td>
                            <td><input type='text' style='width:95%;' name='f_rfc' /></td>
                        </tr>

                        <tr>
                            <td>Calle: </td>
                            <td><input type='text' style='width:95%;' name='f_calle' /></td>
                        </tr>

                        <tr>
                            <td>Colonia: </td>
                            <td><input type='text' style='width:95%;' name='f_colonia' /></td>
                        </tr>

                        <tr>
                            <td>Código Postal: </td>
                            <td><input type='text' style='width:95%;' name='f_cp' /></td>
                        </tr>

                        <tr>
                            <td>Delegación o Municipio: </td>
                            <td><input type='text' style='width:95%;' name='f_delegacion' /></td>
                        </tr>

                        <tr>
                            <td>Estado: </td>
                            <td><input type='text' style='width:95%;' name='f_estado' /></td>
                        </tr>

                        <tr>
                            <td>País: </td>
                            <td><input type='text' style='width:95%;' name='f_pais' /></td>
                        </tr>
                    </table>
                </div>
                <div class="tab-pane" id="messages">
                    <div class='alert alert-info'>
                        <p>Si no tiene una dirección de envío diferente deje los siguientes datos en blanco.</p>
                    </div>
                    <table class='table table-bordered table-hover'>
                        <tr>
                            <td style='width:15%;'>Persona que recibe:</td>
                            <td><input type='text' style='width:95%;' name='e_persona' /></td>
                        </tr>

                        <tr>
                            <td>Calle: </td>
                            <td><input type='text' style='width:95%;' name='e_calle' /></td>
                        </tr>

                        <tr>
                            <td>Colonia: </td>
                            <td><input type='text' style='width:95%;' name='e_colonia' /></td>
                        </tr>

                        <tr>
                            <td>Código Postal: </td>
                            <td><input type='text' style='width:95%;' name='e_cp' /></td>
                        </tr>

                        <tr>
                            <td>Delegación o Municipio: </td>
                            <td><input type='text' style='width:95%;' name='e_delegacion' /></td>
                        </tr>

                        <tr>
                            <td>Estado: </td>
                            <td><input type='text' style='width:95%;' name='e_estado' /></td>
                        </tr>

                        <tr>
                            <td>País: </td>
                            <td><input type='text' style='width:95%;' name='e_pais' /></td>
                        </tr>
                    </table>
                </div>
                <div class="tab-pane" id="settings">
                    <p>Especifica tu forma de pago por favor:</p>

                    <input type="radio" value="transferencia" name="forma_pago">Transferencia Electrónica<br><br>
                    <input type="radio" value="deposito" name="forma_pago">Depósito<br><br>
                </div>
            </div>

        </form>

    </div>

    <span id='load_pedido' class='pull-right'></span>
    <div class='clearfix'></div>
    <div class='pull-right btn-group'>
        <button id='anterior_pedido' class='btn' disabled='disabled'>Anterior</button>
        <button id='seguir_pedido' class='btn btn-success'>Continuar</button>

    </div>

    <div class='clearfix'></div>
    
    
    <!-- Modal -->
    <?php echo form_open_multipart('mayorista/panel/lista_excel');?>
    <div id="listaexcel" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">Lista de Excel</h3>
        </div>
        <div class="modal-body">
            <div class='alert aler-warning'>
                <p>Sólo puedes subir archivos tipo CSV.</p>
            </div>
            <input type='file' name='lista' />
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
            <input type='submit' class="btn btn-primary" value='Subir' />
        </div>
    </div>
    <?php echo form_close();?>
    <script type='text/javascript'>

        $(document).ready(function() {
            <?php
            $tmp = $this->phpsession->flashget('mostrar_carro');
            if(!empty($tmp)){?>  
                    
            $("#error_ajax").css('display', 'none');
            $("#carro_pedido").html('Cargando').load('<?php echo site_url('mayorista/panel/carro');?>');
            $("#pedido").addClass('hide');
            $("#carro_pedido").removeClass('hide');
            $("#anterior_pedido").removeAttr('disabled');
            $("#load_pedido").html('');
            $("#seguir_pedido").html('Completar Información');
            $("#seguir_pedido").attr('id', 'seguir_direcciones');
        
            <?php
            }
            ?>
            $('#myTab a').click(function(e) {
                e.preventDefault();
                $(this).tab('show');
            });

            $('#seguir_pedido').live('click', function() {
                $("#load_pedido").html('<em>Procesando su carrito. Espere por favor</em> <img src="<?php echo base_url('img/cart-load-small.gif'); ?>" alt="Cargando..." />');


                var qty, json_produ, id;

                json_produ = '{ "productos": [';
                $('.pedido-qty').each(function() {
                    //alert('pedido');
                    id = $(this).attr('data-id');
                    qty = $(this).val();

                    if (qty != '') {
                        json_produ = json_produ + '{ "id":"' + id + '", "qty":"' + qty + '"},';
                    }
                });

                json_produ = json_produ.substring(0, json_produ.length - 1);
                json_produ = json_produ + "] }";
                //alert(json_produ);
                if (json_produ != '{ "productos": ] }') {
                    //alert('enviar');
                    $.ajax({
                        type: "POST",
                        url: "<?php echo site_url('mayorista/panel/agregar_carro'); ?>",
                        cache: false,
                        data: {pedido: json_produ}
                    }).done(function(html) {
                        $("#error_ajax").css('display', 'none');
                        $("#carro_pedido").html(html);
                        $("#pedido").addClass('hide');
                        $("#carro_pedido").removeClass('hide');
                        $("#anterior_pedido").removeAttr('disabled');
                        $("#load_pedido").html('');
                        $("#seguir_pedido").html('Completar Información');
                        $("#seguir_pedido").attr('id', 'seguir_direcciones');

                    }).fail(function(jqXHR, textStatus) {
                        $("#error_ajax").html('Error al agregar productos al pedido');
                        $("#error_ajax").css('display', 'block');
                        $("#load_pedido").html('');
                        //alert( "Falla en el sistema. Contacte a su administrador.");
                    });
                } else {
                    $("#load_pedido").html('');
                }

                //alert(json_produ);
                //$("#anterior_pedido").removeAttr('disabled');
                //$('#pedido').css('background-image','')
            });



            $('#seguir_direcciones').live('click', function() {
                //$("#error_ajax").css('display','none');
                //$("#carro_pedido").html(html);
                $("#carro_pedido").addClass('hide');
                $("#direcciones_pedido").removeClass('hide');
                $("#anterior_pedido").attr('id', 'anterior_direcciones');
                $("#seguir_direcciones").html('Colocar Pedido');
                $("#seguir_direcciones").attr('id', 'terminar');
            });

            $('#terminar').live('click', function() {
                //$("#error_ajax").css('display','none');
                //$("#carro_pedido").html(html);
                var formulario;
                formulario = $("#form_pedido").serialize();
                $("#load_pedido").html('<em>Procesando su pedido. Espere por favor</em> <img src="<?php echo base_url('img/cart-load-small.gif'); ?>" alt="Cargando..." />');
                //alert(formulario);
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('mayorista/panel/colocar'); ?>",
                    cache: false,
                    data: formulario
                }).done(function(html) {
                    $("#error_ajax").css('display', 'none');
                    $("#load_pedido").html('');
                    $("#results").html(html);
                    $(document).scrollTop(0);
                }).fail(function(jqXHR, textStatus) {
                    $("#error_ajax").html('Error al colocar el pedido');
                    $("#error_ajax").css('display', 'block');
                    $("#load_pedido").html('');
                    $(document).scrollTop(0);
                    //alert( "Falla en el sistema. Contacte a su administrador.");
                });


            });

            $('#anterior_pedido').live('click', function() {


                $("#carro_pedido").addClass('hide');
                $("#pedido").removeClass('hide');
                $(this).attr('disabled', 'disabled');
                $("#seguir_direcciones").html('Continuar');
                $("#seguir_direcciones").attr('id', 'seguir_pedido');

            });

            $('#anterior_direcciones').live('click', function() {


                $("#direcciones_pedido").addClass('hide');
                $("#carro_pedido").removeClass('hide');
                $(this).attr('id', 'anterior_pedido');
                $("#terminar").html('Completar Información');
                $("#terminar").attr('id', 'seguir_direcciones');

            });


        });
    </script>
</div>
<?php $this->load->view('mayorista/footer'); ?>