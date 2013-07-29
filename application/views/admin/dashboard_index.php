<?php $this->load->view('admin/common/header');?>
	<div id="body">
		<?php if($logged == TRUE){
			?>
				<table align="center">
					<tr>
						<td>Hay una sesión iniciada ¿Acaso tu correo es <i><?php echo $last_user['correo'];?></i>?</td>
					</tr>
					<tr>
						<td><a href="<?php echo site_url('dashboard/inicio');?>">Sí, si lo es.</a> | <a href="<?php echo site_url('dashboard/salir');?>">No, no es mi correo</a></td>
					</tr>
				</table> 
		<?php 
				/*echo $usuario['correo'];
				echo '<pre>';
				print_r($usaurio);
				echo '</pre>';
				echo '<pre>';
				print_r($last_user);
				echo '</pre>';*/
			} ?>
		<p>Por favor ingresa tu cuenta.</p>
		<p>
			<?php echo form_open('admin/dashboard'); ?>			
			<table align="center">
			<tr>
			<td>Correo:</td> 
			<td><input type="text" name="username" value="<?php echo set_value('username');?>"/> </td>
			</tr>
			<tr>
			<td>Contraseña: </td> 
			<td><input type="password" name="password" value="<?php echo set_value('password');?>"  /></td>
			</tr>
			<tr>
			<td align="center" colspan="2"><input type="submit" name="enviar" value="Entrar"  /></td>
			</tr>
			</table>
			<?php echo form_close(); ?>	
		</p>
		<p><?php echo validation_errors(); ?></p>
		<p><?php $error_login = $this->phpsession->flashget('error_login');
			if(!empty($error_login)){
			echo $error_login;
			}
			?>
		</p>
		<?php  ?>
	</div>
<?php $this->load->view('admin/common/footer');?>