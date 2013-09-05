<?php 
$data['lateral_izquierdo'] = 1;
$this->load->view('common/header',$data); ?>
<div class='pull-left' style='width:50%;'>

    <div class="indice">
        <img src="http://www.tecnobotanicademexico.com.mx/admin/img/cont_heading_td.gif"> Déjame Entrar!
    </div>
    
    <div class='pull-left cuadro' style='width: 40%;'>
        <h4>Soy un cliente nuevo.</h4>
        <p>Al crear una cuenta en Guía del Consumidor Naturista, podrás realizar tus compras rápidamente, revisar el estado de tus pedidos y consultar tus operaciones anteriores.</p>
        <a href="<?php echo site_url('cuenta/crear'); ?>">Continuar</a>
    </div>
    <div class='pull-right cuadro' style='width: 40%;'>
        <h4>He comprado otras veces.</h4>
        <?php echo form_open('cuenta/entrar'); ?>						
        Dirección de E-Mail:<br>
        <input type="text" name="email" size="30" value="<?php echo set_value('email');?>" /><br />
        Contraseña:<br>
        <input type="password" name="pass" size="30" value="<?php echo set_value('pass');?>" /><br />
        <a href="<?php echo site_url('cuenta/reestablecer');?>">¿Has olvidado tu contraseña? Sigue este enlace y te la enviaremos.</a><br>
        <input type="submit" value="Entrar" class='pull-right btn btn-success' />
        <div class='clearfix'></div>
        <?php echo form_close(); ?>
    </div>
    
    


</div>
<?php 
$data['lateral_derecho'] = 1;
$this->load->view('common/footer',$data); ?>
