<?php $this->load->view('admin/common/header');?>
	<div class="menu"><?php construyeMenu($rol); ?></div>
	<div id="body">
		<?php $ingles = TRUE; ?>
		<?php construyeMenuAltas($seccion,$rol);?>
		<?php construyeMenuConsultas($seccion,$rol);?>
		<?php $insert_message = $this->phpsession->flashget('insert_message');
			if(!empty($insert_message)){
			echo "<p>";
			echo $insert_message;
			echo "</p>";
			}
			?>
		<?php $update_message = $this->phpsession->flashget('update_message');
			if(!empty($update_message)){
			echo "<p>";
			echo $update_message;
			echo "</p>";
			}
			?>
		<?php if($this->phpsession->flashget('error_upload')){
				$errores = $this->phpsession->flashget('error_upload');
				foreach ($errores as $error){
					
					echo "<p><strong>";				
					echo $error;
					echo "</strong></p>";
					
				}
			}
			?>
		<?php if(checkWord($seccion,'alta')){
					construyeFormularioAltas($seccion,$rol,$consulta,$ingles);
				}?>
		<?php if(checkWord($seccion,'consulta')){
					echo ($seccion == 'consulta_cliente' || $seccion == 'consulta_cliente' || $seccion == 'consulta_catalogo_recibido' || $seccion == 'consulta_representante_recibido' || $seccion=='consulta_todos') ? '<center>'.$this->pagination->create_links().'</center>' : '';
					consultaInformacion($seccion,$rol,$consulta,$ingles);
				}?>
		<?php if(checkWord($seccion,'ver')){
					verInformacion($seccion,$rol,$consulta,$ingles);
				}?>
		<?php if(checkWord($seccion,'editar')){
					construyeFormularioEdicion($seccion,$rol,$consulta,$ingles);
				}?>
        <?php if( ((checkWord($seccion,'cliente')) && ($seccion != 'cliente')) || (checkWord($seccion,'dos')) ){
					construyeFormularioEdicion2($seccion,$rol,$consultaUno,$consultaDos,$consultaTres,$ingles);
				}?>
		<p style="color: red;"><?php echo validation_errors(); ?></p>
	</div>
<?php $this->load->view('admin/common/footer');?>