<?php 
$data['lateral_izquierdo'] = 1;
$this->load->view('common/header',$data); ?>

<div class='pull-left' style='width:50%;'>
    <div class="indice pull-left">
        <img src="http://www.tecnobotanicademexico.com.mx/admin/img/cont_heading_td.gif"> Panel de Cuenta
    </div>
    <p class='pull-right'><a class='btn btn-link' href="<?php echo site_url('cuenta/salir');?>">Salir de mi Cuenta</a></p>
    <div class='clearfix'></div>
    <?php
    $c = $cliente;
    
    ?>
    

<?php echo form_open('cuenta/perfil'); ?>
    <input type='hidden' value='<?php echo $c['idDireccion']; ?>' name='iddireccion' />
    <input type='hidden' value='<?php echo $c['idEmpresa']; ?>' name='idempresa' />
    <input type='hidden' value='<?php echo $c['TipoCliente_idTipoCliente']; ?>' name='tipo' />
    <table class='table table-bordered table-hover' style='width:95%;'>
        <tr>
            <td>Número de Cliente</td>
            <td>PC<?php echo $c['idCliente'];?></td>
        </tr>
        <tr>
            <td style='width:25%;'><span class='text-error'>*Nombre(s)</span></td>
            <td><input type='text' name='nombres' value='<?php echo $c['nombre']; ?>' style='width:100%;' /></td>
        </tr>
        <tr>
            <td><span class='text-error'>*Apellido(s)</span></td>
            <td><input type='text' name='apellidos' value='<?php echo $c['apellido']; ?>' style='width:100%;' /></td>
        </tr>
        <tr>
            <td><span class='text-error'>*Correo Electrónico</span></td>
            <td><input type='text' name='email' value='<?php echo $c['correo']; ?>' style='width:100%;' /></td>
        </tr>
        <tr>
            <td><span class='text-error'>*Confirme Correo Electrónico</span></td>
            <td><input type='text' name='email1' value='<?php echo $c['correo']; ?>' style='width:100%;' /></td>
        </tr>
        <tr>
            <td><span class='text-error'>*Teléfono</span></td>
            <td><input type='text' name='telefono' value='<?php echo $c['telefono']; ?>' style='width:100%;' /></td>
        </tr>
        <tr>
            <td><span class='text-error'>*Tipo de Teléfono</span></td>
            <td>
                <select name='tipo_telefono' style='width:100%;'>
                    <option value=''>Seleccione una opción</option>
                    <option value='casa' <?php echo ($c['tipo_telefono'] == 'casa') ? 'selected="selected"' : ''; ?> >Casa</option>
                    <option value='oficina' <?php echo ($c['tipo_telefono'] == 'oficina') ? 'selected="selected"' : ''; ?>>Oficina</option>
                    <option value='celular' <?php echo ($c['tipo_telefono'] == 'celular') ? 'selected="selected"' : ''; ?>>Celular</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Razón Social o Comercial</td>
            <td><input type='text' name='razon' value='<?php echo $c['razon_social']; ?>' style='width:100%;' /></td>
        </tr>
        <tr>
            <td><span class='text-error'>*Calle Número</span></td>
            <td><input type='text' name='calle' value='<?php echo $c['calle']; ?>' style='width:100%;' /></td>
        </tr>
        <tr>
            <td><span class='text-error'>*Colonia</span></td>
            <td><input type='text' name='colonia' value='<?php echo $c['colonia']; ?>' style='width:100%;' /></td>
        </tr>
        <tr>
            <td><span class='text-error'>*Delegación o Municipio</span></td>
            <td><input type='text' name='delegacion' value='<?php echo $c['delegacion']; ?>' style='width:100%;' /></td>
        </tr>
        <tr>
            <td><span class='text-error'>*Código Postal</span></td>
            <td><input type='text' name='cp' value='<?php echo $c['codigo_postal']; ?>' style='width:100%;' /></td>
        </tr>
        <tr>
            <td><span class='text-error'>*Ciudad</span></td>
            <td><input type='text' name='ciudad' value='<?php echo $c['ciudad']; ?>' style='width:100%;' /></td>
        </tr>
        <tr>
            <td><span class='text-error'>*Estado</span></td>
            <td><input type='text' name='estado' value='<?php echo $c['estado']; ?>' style='width:100%;' /></td>
        </tr>
        <tr>
            <td><span class='text-error'>*Contraseña</span></td>
            <td><input type='text' name='pass' value='<?php echo $c['contrasena']; ?>' style='width:100%;' /></td>
        </tr>
        <tr>
            <td><span class='text-error'>*Confirmar Contraseña</span></td>
            <td><input type='text' name='pass1' value='<?php echo $c['contrasena']; ?>' style='width:100%;' /></td>
        </tr>
        <tr>
            <td colspan='2'><input style='float:right;' type="submit" value='Guardar' class='pull-right btn btn-success' /></td>
        </tr>
    </table>
<?php echo form_close(); ?>
</div>


<?php 
$data['lateral_derecho'] = 1;
$this->load->view('common/footer',$data); ?>			