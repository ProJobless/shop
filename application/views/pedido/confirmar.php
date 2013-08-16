<?php
$data['lateral_izquierdo'] = 0;
$this->load->view('common/header', $data);
?>
<div id='results'></div>
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

<?php $this->load->view('carro/usuario'); ?>

<span id='load_pedido' class='pull-right'></span>
<div class='clearfix'></div>
<div class='pull-right btn-group'>
    <a href="<?php echo site_url('tienda/vaciar_carro');?>" class='btn' type="button">Cancelar</a>
    <button id='terminar' class='btn btn-success'>Continuar</button>

</div>

<div class='clearfix'></div>

<script type='text/javascript'>

    $(document).ready(function() {

        $('#myTab a').click(function(e) {
            e.preventDefault();
            $(this).tab('show');
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
                url: "<?php echo site_url('pedido/colocar'); ?>",
                cache: false,
                data: formulario
            }).done(function(html) {
                $("#error_ajax").css('display', 'none');
                $("#load_pedido").html('');
                $("#results").html(html);
                $(document).scrollTop(0);
            }).fail(function(jqXHR, textStatus) {
                $("#error_ajax").html('Error al colocar el pedido. Contacte a su administrador.');
                $("#error_ajax").css('display', 'block');
                $("#load_pedido").html('');
                $(document).scrollTop(0);
                //alert( "Falla en el sistema. Contacte a su administrador.");
            });


        });
    });
</script>
<?php
$data['lateral_derecho'] = 0;
$this->load->view('common/footer', $data);
?>	