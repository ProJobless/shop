<?php 
$data['lateral_izquierdo'] = 1;
$this->load->view('common/header',$data); ?>

<div class='pull-left' style='width:75%;'>
    <div class="indice">
        <img src="http://www.tecnobotanicademexico.com.mx/admin/img/cont_heading_td.gif"> Crear Cuenta
    </div>
<?php echo form_open(current_url()); ?>
    <input type='hidden' name='tipo' value='3' />
    <table class='table table-bordered table-hover' style='width:95%;'>

        <tr>
            <td style='width: 25%;'><span class='text-error'>*Nombre(s)</span></td>
            <td><input type='text' name='nombres' value='<?php echo set_value('nombres'); ?>' style='width:95%;'/></td>
        </tr>
        <tr>
            <td><span class='text-error'>*Apellido(s)</span></td>
            <td><input type='text' name='apellidos' value='<?php echo set_value('apellidos'); ?>' style='width:95%;' /></td>
        </tr>
        <tr>
            <td><span class='text-error'>*Correo Electrónico</span></td>
            <td><input type='text' name='email' value='<?php echo set_value('email'); ?>' style='width:95%;' /></td>
        </tr>
        <tr>
            <td><span class='text-error'>*Confirme Correo Electrónico</span></td>
            <td><input type='text' name='email1' value='<?php echo set_value('email1'); ?>' style='width:95%;' /></td>
        </tr>
        <tr>
            <td><span class='text-error'>*Teléfono</span></td>
            <td><input type='text' name='telefono' value='<?php echo set_value('telefono'); ?>' style='width:95%;' /></td>
        </tr>
        <tr>
            <td><span class='text-error'>*Tipo de Teléfono</span></td>
            <td>
                <select name='tipo_telefono' style='width:95%;'>
                    <option value=''>Seleccione una opción</option>
                    <option value='casa' <?php echo set_select('tipo_telefono', 'casa'); ?> >Casa</option>
                    <option value='oficina' <?php echo set_select('tipo_telefono', 'oficina'); ?>>Oficina</option>
                    <option value='celular' <?php echo set_select('tipo_telefono', 'celular'); ?>>Celular</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Razón Social o Comercial</td>
            <td><input type='text' name='razon' value='<?php echo set_value('razon'); ?>' style='width:95%;' /></td>
        </tr>
        <tr>
            <td><span class='text-error'>*Calle Número</span></td>
            <td><input type='text' name='calle' value='<?php echo set_value('calle'); ?>' style='width:95%;' /></td>
        </tr>
        <tr>
            <td><span class='text-error'>*Colonia</span></td>
            <td><input type='text' name='colonia' value='<?php echo set_value('colonia'); ?>' style='width:95%;' /></td>
        </tr>
        <tr>
            <td><span class='text-error'>*Delegación o Municipio</span></td>
            <td><input type='text' name='delegacion' value='<?php echo set_value('delegacion'); ?>' style='width:95%;' /></td>
        </tr>
        <tr>
            <td><span class='text-error'>*Código Postal</span></td>
            <td><input type='text' name='cp' value='<?php echo set_value('cp'); ?>' style='width:95%;' /></td>
        </tr>
        <tr>
            <td><span class='text-error'>*Ciudad</span></td>
            <td><input type='text' name='ciudad' value='<?php echo set_value('ciudad'); ?>' style='width:95%;' /></td>
        </tr>
        <tr>
            <td><span class='text-error'>*Estado</span></td>
            <td><input type='text' name='estado' value='<?php echo set_value('estado'); ?>' style='width:95%;' /></td>
        </tr>
        <tr>
            <td><span class='text-error'>*Contraseña</span></td>
            <td><input type='text' name='pass' value='<?php echo set_value('pass'); ?>' style='width:95%;' /></td>
        </tr>
        <tr>
            <td><span class='text-error'>*Confirmar Contraseña</span></td>
            <td><input type='text' name='pass1' value='<?php echo set_value('pass1'); ?>' style='width:95%;' /></td>
        </tr>
        <tr>
            <td colspan='2'><input type="submit" value='Guardar' class='pull-right btn btn-success' style='float:right;' /></td>
        </tr>
    </table>
<?php echo form_close(); ?>
</div>

<?php 
$data['lateral_derecho'] = 1;
$this->load->view('common/footer',$data); ?>		